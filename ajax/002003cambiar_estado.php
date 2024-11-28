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

      $sql_update = "UPDATE formas_de_pago
                     SET estado = CASE WHEN estado = 1 THEN 0
                                                     WHEN estado = 0 THEN 1
                                                     ELSE estado
                                                END
                     WHERE id_forma_pago = '$id'";

      $query_update = mysqli_query($con, $sql_update);

      if ($query_update) {
        
        $datos['exito'] = "El estado cambió con éxito.";

      }
      else{
        $datos['error'] = "Hubo un error en el proceso, por favor intente nuevamente.";
      }

    }



  }

  echo json_encode($datos);

?>