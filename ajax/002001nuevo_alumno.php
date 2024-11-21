<?php

include('is_logged.php'); //Archivo verifica que el usuario que intenta acceder a la URL esta logueado
header('Content-Type: application/json');

require_once("../config/db.php");
require_once("../config/conexion.php");
mysqli_set_charset($con, "utf8");

$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';
$datos = array();


if ($action == 'ajax') {

  // Función para validar RUT chileno
  function validar($rut)
  {
    // Extrae el cuerpo y el dígito verificador
    $cuerpo = substr($rut, 0, -1);
    $dv = strtoupper(substr($rut, -1));

    // El cuerpo del RUT debe tener entre 6 y 8 dígitos
    if (!preg_match('/^[0-9]+$/', $cuerpo) || strlen($cuerpo) < 6) {
      return false;
    }

    // Calcula el dígito verificador
    $suma = 0;
    $multiplo = 2;

    for ($i = strlen($cuerpo) - 1; $i >= 0; $i--) {
      $suma += $cuerpo[$i] * $multiplo;
      $multiplo = $multiplo == 7 ? 2 : $multiplo + 1;
    }

    $dv_calculado = 11 - ($suma % 11);

    if ($dv_calculado == 11) {
      $dv_calculado = '0';
    } elseif ($dv_calculado == 10) {
      $dv_calculado = 'K';
    } else {
      $dv_calculado = (string) $dv_calculado;
    }

    // Compara el dígito verificador calculado con el ingresado
    return $dv_calculado === $dv;
  }


  $datos['post'] = $_POST;


  //Validar nombres
  if (!isset($_POST['nombres']) || empty($_POST['nombres'])) {

    $datos['errores']['nombres'] = 'El campo de <b>Nombres</b> esta en blanco.';
  } else {

    $nombres = trim($_POST['nombres']);

    if (strlen($nombres) <= 2) {

      $datos['errores']['nombres'] = 'El campo <b>Nombre</b> es demasiado corto.';
    }
  }

  //Validar apellicos
  if (!isset($_POST['apellidos']) || empty($_POST['apellidos'])) {

    $datos['errores']['apellidos'] = 'El campo de <b>Apellidos</b> esta en blanco.';
  } else {

    $apellidos = trim($_POST['apellidos']);

    if (strlen($apellidos) <= 2) {

      $datos['errores']['apellidos'] = 'El campo <b>Apellido</b> es demasiado corto.';
    }
  }


  $rut_alumno = $_POST['rut_alumno'];

  if (!empty($rut_alumno)) {
    // Elimina puntos y guiones del RUT para facilitar la validación
    $rut_alumno = preg_replace('/[^k0-9]/i', '', $rut_alumno);

    if (!validar($rut_alumno)) {
      $datos['errores']['rut_alumno'] = 'El campo <strong>"RUT "</strong> no es válido.';
    }
  }

  $correo_1 = $_POST['correo_1'];

  //Validacion email
  if ($correo_1 == '')
    $datos['errores']['correo_1'] = 'El campo <strong>"Correo 1"</strong> no ha sido llenado.';
  else {

    $patron = '/^([A-Z|a-z|0-9](\.|_){0,1})+[A-Z|a-z|0-9]\@([A-Z|a-z|0-9]|-)+((\.){0,1}[A-Z|a-z|0-9]|-){1}(\.[a-z]{2,3}){1,2}$/i';

    if (preg_match($patron, $correo_1) == 0)
      $datos['errores']['correo_1'] = 'El campo <strong>"Correo 1"</strong> no es válido.';
  }

  $correo_2 = $_POST['correo_2'];

  if (!empty($correo_2)) {

    $patron = '/^([A-Z|a-z|0-9](\.|_){0,1})+[A-Z|a-z|0-9]\@([A-Z|a-z|0-9]|-)+((\.){0,1}[A-Z|a-z|0-9]|-){1}(\.[a-z]{2,3}){1,2}$/i';

    if (preg_match($patron, $correo_2) == 0)
      $datos['errores']['correo_2'] = 'El campo <strong>"Correo 2"</strong> no es válido.';
  }

  $telefono_alumno = $_POST['telefono_alumno'];
  //Validacion fono
  if ($telefono_alumno == '')
    $datos['errores']['telefono_alumno']  = 'El campo <strong>"Telefono"</strong> no ha sido llenado.';
  else if (strlen($telefono_alumno) < 7)
    $datos['errores']['telefono_alumno']  = 'El campo <strong>"Telefono"</strong> no cuenta con suficientes dígitos.';




  if (!isset($_POST['fecha_proximo_pago']) || empty($_POST['fecha_proximo_pago'])) {
    $datos['errores']['fecha_proximo_pago'] = 'El campo <b>fecha proximo pago</b> esta en blanco.';
  } else {
    $fecha_proximo_pago = trim($_POST['fecha_proximo_pago']);
    $valores = explode('/', $fecha_proximo_pago);
    if (!(count($valores) == 3 && checkdate($valores[1], $valores[0], $valores[2]))) {
      $datos['errores']['fecha_proximo_pago'] = 'El campo <b>fecha_proximo_pago</b> es inválida.';
    } else {
      $fecha_proximo_pago = $valores[2] . '-' . $valores[1] . '-' . $valores[0];
    }
  }



  //Si no existen errores se procede a guardar el registro.
  if (!(isset($datos['errores'])) || is_null($datos['errores'])) {

    $sql_insertar_alumno = "INSERT INTO alumnos( nombres_alumno,
                                                                apellidos_alumno,
                                                                rut_alumno,
                                                                correo_1,
                                                                correo_2,
                                                                telefono_alumno,
                                                                fecha_pago,
                                                                fecha_creacion_alumno,
                                                                fecha_edicion_aumno,
                                                                estado_alumno)
                                     VALUES ('$nombres',
                                             '$apellidos',
                                             '$rut_alumno',
                                             '$correo_1',
                                             '$correo_2',
                                             '$telefono_alumno',
                                             '$fecha_proximo_pago',
                                              CURRENT_TIMESTAMP(),
                                              CURRENT_TIMESTAMP(),
                                             '1')";

    $query_insertar_alumno = mysqli_query($con, $sql_insertar_alumno);

    if ($query_insertar_alumno) {
      $datos['exito'] = 'El alumno se ha registrado en el sistema.';
      $datos['id'] = mysqli_insert_id($con);
    } else {
      $datos['errores']['insertar'] = 'Ha ocurrido un <b>error</b> en el proceso. Intente nuevamente.';
    }
  }
}

echo json_encode($datos);
