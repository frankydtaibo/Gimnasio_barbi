<?php

  include('is_logged.php');//Archivo verifica que el usuario que intenta acceder a la URL esta logueado

  header('Content-Type: application/json');

  require_once ("../config/db.php");
  require_once ("../config/conexion.php");
  mysqli_set_charset($con, "utf8");

  $action = (isset($_REQUEST['action']) && $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
  $datos = array();

  if($action == 'ajax'){

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

    //Validar id_alumno
    if( !isset($_POST['id_alumno']) || empty($_POST['id_alumno']) ){ 

      $datos['errores']['id_alumno_editar'] = 'El identificador del alumno no se incluido o está en blanco. Actualice la página e intente nuevamente.';

    }
    else{

      $id_alumno = trim($_POST['id_alumno']);

      $sql_validar_id = "SELECT * 
                         FROM alumnos
                         WHERE id_alumno = '$id_alumno'";

      $query_validar_id = mysqli_query($con, $sql_validar_id);

      if( mysqli_num_rows($query_validar_id) == 0 ){

        $datos['errores']['id_alumno_editar'] = 'El alumno que intenta editar ya no existe. Actualice la página para no visualizar este registro en pantalla';

      }

    }


  //Validar nombres
  if (!isset($_POST['nombres_editar']) || empty($_POST['nombres_editar'])) {

    $datos['errores']['nombres_editar'] = 'El campo de <b>Nombres</b> esta en blanco.';
  } else {

    $nombres = trim($_POST['nombres_editar']);

    if (strlen($nombres) <= 2) {

      $datos['errores']['nombres_editar'] = 'El campo <b>Nombre</b> es demasiado corto.';
    }
  }

  //Validar apellicos
  if (!isset($_POST['apellidos_editar']) || empty($_POST['apellidos_editar'])) {

    $datos['errores']['apellidos_editar'] = 'El campo de <b>Apellidos</b> esta en blanco.';
  } else {

    $apellidos = trim($_POST['apellidos_editar']);

    if (strlen($apellidos) <= 2) {

      $datos['errores']['apellidos_editar'] = 'El campo <b>Apellido</b> es demasiado corto.';
    }
  }


  $rut_alumno = $_POST['rut_alumno_editar'];

  if (!empty($rut_alumno)) {
    // Elimina puntos y guiones del RUT para facilitar la validación
    $rut_alumno = preg_replace('/[^k0-9]/i', '', $rut_alumno);

    if (!validar($rut_alumno)) {
      $datos['errores']['rut_alumno_editar'] = 'El campo <strong>"RUT "</strong> no es válido.';
    }
  }

  $correo_1 = $_POST['correo_1_editar'];

  //Validacion email
  if ($correo_1 == '')
    $datos['errores']['correo_1_editar'] = 'El campo <strong>"Correo 1"</strong> no ha sido llenado.';
  else {

    $patron = '/^([A-Z|a-z|0-9](\.|_){0,1})+[A-Z|a-z|0-9]\@([A-Z|a-z|0-9]|-)+((\.){0,1}[A-Z|a-z|0-9]|-){1}(\.[a-z]{2,3}){1,2}$/i';

    if (preg_match($patron, $correo_1) == 0)
      $datos['errores']['correo_1_editar'] = 'El campo <strong>"Correo 1"</strong> no es válido.';
  }

  $correo_2 = $_POST['correo_2_editar'];

  if (!empty($correo_2)) {

    $patron = '/^([A-Z|a-z|0-9](\.|_){0,1})+[A-Z|a-z|0-9]\@([A-Z|a-z|0-9]|-)+((\.){0,1}[A-Z|a-z|0-9]|-){1}(\.[a-z]{2,3}){1,2}$/i';

    if (preg_match($patron, $correo_2) == 0)
      $datos['errores']['correo_2_editar'] = 'El campo <strong>"Correo 2"</strong> no es válido.';
  }

  $telefono_alumno = $_POST['telefono_alumno_editar'];
  //Validacion fono
  if ($telefono_alumno == '')
    $datos['errores']['telefono_alumno_editar']  = 'El campo <strong>"Telefono"</strong> no ha sido llenado.';
  else if (strlen($telefono_alumno) < 7)
    $datos['errores']['telefono_alumno_editar']  = 'El campo <strong>"Telefono"</strong> no cuenta con suficientes dígitos.';




  if (!isset($_POST['fecha_proximo_pago_editar']) || empty($_POST['fecha_proximo_pago_editar'])) {
    $datos['errores']['fecha_proximo_pago_editar'] = 'El campo <b>fecha proximo pago</b> esta en blanco.';
  } else {
    $fecha_proximo_pago = trim($_POST['fecha_proximo_pago_editar']);
    $valores = explode('/', $fecha_proximo_pago);
    if (!(count($valores) == 3 && checkdate($valores[1], $valores[0], $valores[2]))) {
      $datos['errores']['fecha_proximo_pago_editar'] = 'El campo <b>Fecha proximo pago</b> es inválida.';
    } else {
      $fecha_proximo_pago = $valores[2] . '-' . $valores[1] . '-' . $valores[0];
    }
  }

    //Si no existen errores se procede a guardar el registro.
    if( !(isset($datos['errores'])) || is_null($datos['errores']) ){ 

      $sql_update_alumno = "UPDATE alumnos
                                   SET nombres_alumno = '$nombres',
                                       apellidos_alumno = '$apellidos',
                                       rut_alumno = '$rut_alumno',
                                       correo_1 = '$correo_1',
                                       correo_2 = '$correo_2',
                                       telefono_alumno = '$telefono_alumno',
                                       fecha_pago = '$fecha_proximo_pago',
                                       fecha_edicion_alumno = CURRENT_TIMESTAMP()
                                   WHERE id_alumno = '$id_alumno'";

      $query_update_alumno = mysqli_query($con, $sql_update_alumno);

      if ($query_update_alumno) {
        $datos['exito'] = 'El alumno se ha actualizado en el sistema.';
      }else{
        $datos['errores']['update'] = 'Ha ocurrido un <b>error</b> en el proceso de actualizar el registro. Intente nuevamente.'.$sql_update_alumno;
      }

    }

  }

  echo json_encode($datos);

?>

