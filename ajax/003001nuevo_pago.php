<?php

  include('is_logged.php');//Archivo verifica que el usuario que intenta acceder a la URL esta logueado

  header('Content-Type: application/json');

  require_once ("../config/db.php");
  require_once ("../config/conexion.php");
  mysqli_set_charset($con, "utf8");

  $action = (isset($_REQUEST['action']) && $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
  $datos = array();

  if($action == 'ajax'){

    $datos['post'] = $_POST;

    $descuento = '';

     //Validar id_plan
     if( !isset($_POST['id_inscripcion_pago']) || empty($_POST['id_inscripcion_pago']) ){ 

        $datos['errores']['id_inscripcion_pago'] = 'El identificador del plan no se incluido o está en blanco. Actualice la página e intente nuevamente.';
  
      }
      else{
  
        $id_inscripcion_pago = trim($_POST['id_inscripcion_pago']);
  
        $sql_validar_id = "SELECT * 
                           FROM inscripcion
                           WHERE id_inscripcion = '$id_inscripcion_pago'";
  
        $query_validar_id = mysqli_query($con, $sql_validar_id);
  
        if( mysqli_num_rows($query_validar_id) == 0 ){
  
          $datos['errores']['id_inscripcion_pago'] = 'La Inscripción que intenta editar ya no existe. Actualice la página para no visualizar este registro en pantalla';
  
        }
  
      }
  


    //Validar codigo_plan
    if (!isset($_POST['forma_pago']) || empty($_POST['forma_pago'])) {

      $datos['errores']['forma_pago'] = 'El campo de <b>Forma de Pago</b> esta en blanco.';
    } else {
  
      $forma_pago = trim($_POST['forma_pago']);
    }



        if (!isset($_POST['fecha_inicio']) || empty($_POST['fecha_inicio'])) {
          $datos['errores']['fecha_inicio'] = 'El campo <b>fecha Inicio</b> esta en blanco.';
        } else {

          
          $fecha_inicio = trim($_POST['fecha_inicio']);
          $valores = explode('/', $fecha_inicio);
          if (!(count($valores) == 3 && checkdate($valores[1], $valores[0], $valores[2]))) {
            $datos['errores']['fecha_inicio'] = 'El campo <b>Fecha Inicio</b> es inválida.';
          } else {
            $fecha_inicio = $valores[2] . '-' . $valores[1] . '-' . $valores[0];
            $fecha_fin = '';
          }
        }


        if (!isset($_POST['fecha_pago']) || empty($_POST['fecha_pago'])) {
          $datos['errores']['fecha_pago'] = 'El campo <b>fecha proximo pago</b> esta en blanco.';
        } else {

          
          $fecha_pago = trim($_POST['fecha_pago']);
          $valores = explode('/', $fecha_pago);
          if (!(count($valores) == 3 && checkdate($valores[1], $valores[0], $valores[2]))) {
            $datos['errores']['fecha_pago'] = 'El campo <b>Fecha Pago</b> es inválida.';
          } else {
            $fecha_pago = $valores[2] . '-' . $valores[1] . '-' . $valores[0];
          }
        }


  //monto inicial
  if (!isset($_POST['monto_inicial']) && empty($_POST['monto_inicial'])) {
    $datos['errores']['monto_inicial'] = 'El campo <b>fecha proximo pago</b> esta en blanco.';

}else{
    $monto_inicial = $_POST['monto_inicial'];
    $descuento = $_POST['descuento'];
    $monto_final = $_POST['monto_final'];

}


    



    
    //Si no existen errores se procede a guardar el registro.
    if( !(isset($datos['errores'])) || is_null($datos['errores']) ){ 

        $select = "SELECT * FROM inscripcion t1 
                           left join plan t2 on t1.id_plan = t2.id_plan where t1.id_inscripcion = '$id_inscripcion_pago'";
        $query_plan = mysqli_query($con, $select);
    
        if($row = mysqli_fetch_array($query_plan)) {
          // Devolver el precio_plan al cliente
          $duracion =  $row['cantidad_meses_plan'];
          
  // Crear un objeto DateTime con la fecha de inicio
  $fecha_inicio_obj = new DateTime($fecha_inicio);

  // Sumar la duración del plan en meses
  $fecha_inicio_obj->modify("+$duracion months");

  // Obtener la fecha fin como string
  $fecha_fin = $fecha_inicio_obj->format('Y-m-d');
    
        }

      $sql_insert_plan = "INSERT INTO pago (
                        id_forma_pago, 
                        fecha_inicio, 
                        fecha_fin, 
                        fecha_pago, 
                        monto_inicial, 
                        descuento, 
                        monto_final, 
                        estado_pago
                    ) VALUES ('$forma_pago',
                                                               '$fecha_inicio',
                                                               '$fecha_fin',
                                                               '$fecha_pago',
                                                                '$monto_inicial',
                                                               '$descuento',
                                                               '$monto_final',
                                                              '1')";

      $query_insert_plan = mysqli_query($con, $sql_insert_plan);

      if ($query_insert_plan) {


        $id_pago = mysqli_insert_id($con);
        $update = "UPDATE inscripcion 
                  SET id_pago = '$id_pago' 
                  WHERE id_inscripcion = '$id_inscripcion_pago'";
        $query_update = mysqli_query($con, $update);

        if ($query_update) {
          $datos['exito'] = 'El pago se ha actualizado en el sistema.'.$sql_insert_plan;


        }else{
          
          $datos['errores']['insert'] = 'Ha ocurrido un <b>error</b> en el proceso de actualizar el registro. Intente nuevamente.'.$sql_update_plan;


        }


      }else{
        $datos['errores']['insert'] = 'Ha ocurrido un <b>error</b> en el proceso de actualizar el registro. Intente nuevamente.'.$sql_update_plan;
      }

    }

  }

  echo json_encode($datos);

?>

