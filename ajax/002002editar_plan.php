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
    if( !isset($_POST['id_plan']) || empty($_POST['id_plan']) ){ 

      $datos['errores']['id_plan_editar'] = 'El identificador del plan no se incluido o está en blanco. Actualice la página e intente nuevamente.';

    }
    else{

      $id_plan = trim($_POST['id_plan']);

      $sql_validar_id = "SELECT * 
                         FROM planes
                         WHERE id_plan = '$id_plan'";

      $query_validar_id = mysqli_query($con, $sql_validar_id);

      if( mysqli_num_rows($query_validar_id) == 0 ){

        $datos['errores']['id_plan_editar'] = 'El plan que intenta editar ya no existe. Actualice la página para no visualizar este registro en pantalla';

      }

    }



    if (!isset($_POST['descripcion_plan_editar']) || empty($_POST['descripcion_plan_editar'])) {

        $datos['errores']['descripcion_plan_editar'] = 'El campo de <b>Descripción</b> esta en blanco.';
      } else {
    
        $descripcion_plan_editar = trim($_POST['descripcion_plan_editar']);
      }
    
    
    
      if (!isset($_POST['duracion_plan_editar']) || empty($_POST['duracion_plan_editar'])) {
    
        $datos['errores']['duracion_plan_editar'] = 'El campo de <b>duracion</b> esta en blanco.';
      } else {
    
        $duracion_plan_editar = trim($_POST['duracion_plan_editar']);
      }
    
    
      if (!isset($_POST['precio_plan_editar']) || empty($_POST['precio_plan_editar'])) {
    
        $datos['errores']['precio_plan_editar'] = 'El campo de <b>Cantidad Meses</b> esta en blanco.';
      } else {
    
        $precio_plan_editar = trim($_POST['precio_plan_editar']);
      }
    

    //Si no existen errores se procede a guardar el registro.
    if( !(isset($datos['errores'])) || is_null($datos['errores']) ){ 

      $sql_update_plan = "UPDATE planes
                                   SET descripcion_plan = '$descripcion_plan_editar',
                                       duracion_plan = '$duracion_plan_editar',
                                       precio_plan = '$precio_plan_editar',
                                       fecha_edicion = CURRENT_TIMESTAMP()
                                   WHERE id_plan = '$id_plan'";

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

