<?php

  header('Content-Type: application/json');

  include('is_logged.php');//Archivo verifica que el usuario que intenta acceder a la URL esta logueado

  require_once ("../config/db.php"); // Archivos y variables para conexion a db
  require_once ("../config/conexion.php");

  $action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
  $datos = array();

  if($action == 'ajax'){ //Para Validar Chasis

    if (isset($_POST['id'])) {
    
      $id = intval($_POST['id']);

      $sql_update = "UPDATE plan
                     SET estado_plan = CASE WHEN estado_plan = 1 THEN 0
                                                     WHEN estado_plan = 0 THEN 1
                                                     ELSE estado_plan
                                                END
                     WHERE id_plan = '$id'";

      $query_update = mysqli_query($con, $sql_update);

      if ($query_update) {
        
        $datos['exito'] = "El estado del plan cambió con éxito.";

      }
      else{
        $datos['error'] = "Hubo un error en el proceso, por favor intente nuevamente.";
      }

    }



  }

  echo json_encode($datos);

?>