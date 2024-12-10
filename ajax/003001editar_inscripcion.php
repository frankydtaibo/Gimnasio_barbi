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

     //Validar id_plan
     if( !isset($_POST['id_inscripcion']) || empty($_POST['id_inscripcion']) ){ 

        $datos['errores']['id_inscripcion'] = 'El identificador del plan no se incluido o está en blanco. Actualice la página e intente nuevamente.';
  
      }
      else{
  
        $id_inscripcion = trim($_POST['id_inscripcion']);
  
        $sql_validar_id = "SELECT * 
                           FROM alumno_plan
                           WHERE id_alumno_plan = '$id_inscripcion'";
  
        $query_validar_id = mysqli_query($con, $sql_validar_id);
  
        if( mysqli_num_rows($query_validar_id) == 0 ){
  
          $datos['errores']['id_inscripcion'] = 'El plan que intenta editar ya no existe. Actualice la página para no visualizar este registro en pantalla';
  
        }
  
      }
  


    //Validar codigo_plan
    if (!isset($_POST['forma_pago_editar']) || empty($_POST['forma_pago_editar'])) {

      $datos['errores']['forma_pago_editar'] = 'El campo de <b>Forma de Pago</b> esta en blanco.';
    } else {
  
      $forma_pago = trim($_POST['forma_pago_editar']);
    }
        //Validar codigo_plan
        if (!isset($_POST['plan_editar']) || empty($_POST['plan_editar'])) {

          $datos['errores']['plan_editar'] = 'El campo de <b>Plan</b> esta en blanco.';
        } else {
      
          $plan = trim($_POST['plan_editar']);

      


        }

        if (!isset($_POST['fecha_inicio_editar']) || empty($_POST['fecha_inicio_editar'])) {
          $datos['errores']['fecha_inicio_editar'] = 'El campo <b>fecha Inicio</b> esta en blanco.';
        } else {

          
          $fecha_inicio = trim($_POST['fecha_inicio_editar']);
          $valores = explode('/', $fecha_inicio);
          if (!(count($valores) == 3 && checkdate($valores[1], $valores[0], $valores[2]))) {
            $datos['errores']['fecha_inicio_editar'] = 'El campo <b>Fecha Inicio</b> es inválida.';
          } else {
            $fecha_inicio = $valores[2] . '-' . $valores[1] . '-' . $valores[0];
          }
        }


        if (!isset($_POST['fecha_pago_editar']) || empty($_POST['fecha_pago_editar'])) {
          $datos['errores']['fecha_pago_editar'] = 'El campo <b>fecha proximo pago</b> esta en blanco.';
        } else {

          
          $fecha_pago = trim($_POST['fecha_pago_editar']);
          $valores = explode('/', $fecha_pago);
          if (!(count($valores) == 3 && checkdate($valores[1], $valores[0], $valores[2]))) {
            $datos['errores']['fecha_pago_editar'] = 'El campo <b>Fecha Pago</b> es inválida.';
          } else {
            $fecha_pago = $valores[2] . '-' . $valores[1] . '-' . $valores[0];
          }
        }

    

    //Si no existen errores se procede a guardar el registro.
    if( !(isset($datos['errores'])) || is_null($datos['errores']) ){ 

        $select = "SELECT * FROM planes where id_plan = '$plan'";
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

      $sql_update_plan = "UPDATE alumno_plan
                                      set id_plan = '$plan',
                                       id_forma_pago = '$forma_pago',
                                       fecha_inicio = '$fecha_inicio',
                                       fecha_fin = '$fecha_fin'
                                   WHERE id_alumno_plan = '$id_inscripcion'";

      $query_update_plan = mysqli_query($con, $sql_update_plan);

      if ($query_update_plan) {
        $datos['exito'] = 'El plan se ha actualizado en el sistema.';
      }else{
        $datos['errores']['update'] = 'Ha ocurrido un <b>error</b> en el proceso de actualizar el registro. Intente nuevamente.'.$sql_update_plan;
      }

    }

  }

  echo json_encode($datos);

?>

