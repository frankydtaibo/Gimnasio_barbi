<?php
require_once("../config/db.php");
require_once("../config/conexion.php");

if (isset($_POST['id_plan'])) {
    $id_plan = intval($_POST['id_plan']);

    $sql_validacion = "SELECT precio_plan FROM plan WHERE id_plan = '$id_plan' AND estado_plan = '1'";
    $query_validacion = mysqli_query($con, $sql_validacion);

    if ($row = mysqli_fetch_array($query_validacion)) {
        echo json_encode(['precio_plan' => $row['precio_plan']]);
    } else {
        echo json_encode(['error' => 'No se encontró el plan.']);
    }
}
