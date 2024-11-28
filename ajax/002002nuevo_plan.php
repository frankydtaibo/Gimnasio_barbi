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
  if (!isset($_POST['nombre_plan']) || empty($_POST['nombre_plan'])) {

    $datos['errores']['nombre_plan'] = 'El campo de <b>Código plan</b> esta en blanco.';
  } else {

    $nombre_plan = trim($_POST['nombre_plan']);
  }



  if (!isset($_POST['descripcion_plan']) || empty($_POST['descripcion_plan'])) {

    $datos['errores']['descripcion_plan'] = 'El campo de <b>Descripción</b> esta en blanco.';
  } else {

    $descripcion_plan = trim($_POST['descripcion_plan']);
  }



  if (!isset($_POST['duracion_plan']) || empty($_POST['duracion_plan'])) {

    $datos['errores']['duracion_plan'] = 'El campo de <b>duracion</b> esta en blanco.';
  } else {

    $duracion_plan = trim($_POST['duracion_plan']);
  }


  if (!isset($_POST['precio_plan']) || empty($_POST['precio_plan'])) {

    $datos['errores']['precio_plan'] = 'El campo de <b>Cantidad Meses</b> esta en blanco.';
  } else {

    $precio_plan = trim($_POST['precio_plan']);
  }


  //Si no existen errores se procede a guardar el registro.
  if (!(isset($datos['errores'])) || is_null($datos['errores'])) {

    $sql_insertar_plan = "INSERT INTO planes( nombre_plan,
                                              descripcion_plan,
                                              duracion_plan,
                                              precio_plan,
                                              estado_plan,
                                              fecha_creacion,
                                              fecha_edicion)
                                     VALUES ('$nombre_plan',
                                             '$descripcion_plan',
                                             '$duracion_plan',
                                             '$precio_plan',
                                             '1',
                                             CURRENT_TIMESTAMP(),
                                             CURRENT_TIMESTAMP())";

    $query_insertar_plan = mysqli_query($con, $sql_insertar_plan);

    if ($query_insertar_plan) {
      $datos['exito'] = 'El plan se ha registrado en el sistema.';
      $datos['id'] = mysqli_insert_id($con);
    } else {
      $datos['errores']['insertar'] = 'Ha ocurrido un <b>error</b> en el proceso. Intente nuevamente.';
    }
  }
}

echo json_encode($datos);
