<?php

include('is_logged.php'); //Archivo verifica que el usuario que intenta acceder a la URL esta logueado
header('Content-Type: application/json');

require_once("../config/db.php");
require_once("../config/conexion.php");
mysqli_set_charset($con, "utf8");

$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';
$datos = array();


if ($action == 'ajax') {

  $datos['post'] = $_POST;

  //Validar codigo_plan
  if (!isset($_POST['alumno']) || empty($_POST['alumno'])) {

    $datos['errores']['alumno'] = 'El campo de <b>Alumnos</b> esta en blanco.';
  } else {

    $alumno = trim($_POST['alumno']);

    
  }

 
        //Validar codigo_plan
        if (!isset($_POST['plan']) || empty($_POST['plan'])) {

          $datos['errores']['plan'] = 'El campo de <b>Plan</b> esta en blanco.';
        } else {
      
          $plan = trim($_POST['plan']);

      


        }

  

          //Si no existen errores se procede a guardar el registro.
  if (!(isset($datos['errores'])) || is_null($datos['errores'])) {

  

    $sql_insertar_plan = "INSERT INTO inscripcion( id_alumno,
                                              id_plan,
                                              fecha_creacion,
                                              fecha_edicion)
                                     VALUES ('$alumno',
                                             '$plan',
                                             CURRENT_TIMESTAMP(),
                                             CURRENT_TIMESTAMP()
                                             )";

    $query_insertar_plan = mysqli_query($con, $sql_insertar_plan);

    if ($query_insertar_plan) {
      $datos['exito'] = 'El plan se ha registrado en el sistema.';
    } else {
      $datos['errores']['insertar'] = 'Ha ocurrido un <b>error</b> en el proceso. Intente nuevamente.'.$sql_insertar_plan;
    }
  }



}

echo json_encode($datos);
