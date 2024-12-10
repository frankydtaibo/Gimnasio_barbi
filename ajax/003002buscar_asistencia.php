<?php

  include('is_logged.php');
  require_once ("../config/db.php");
  require_once ("../config/conexion.php");
  
  $action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';

  if ($action == 'ajax') {

    $q = mysqli_real_escape_string($con, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
    $aColumns = array('t1.nombres_alumno', 't1.apellidos_alumnos', 't1.rut_alumno');
    $sTable = "alumno t1
                LEFT JOIN inscripcion t2 ON t1.id_alumno = t2.id_alumno
                LEFT JOIN pago t3 ON t2.id_pago = t3.id_pago";
    $sWhere = "";

    if ($_GET['q'] != "") {
        $sWhere = "WHERE (";
        for ($i = 0; $i < count($aColumns); $i++) {
            $sWhere .= $aColumns[$i] . " LIKE '%" . $q . "%' OR ";
        }
        $sWhere = substr_replace($sWhere, "", -3);
        $sWhere .= ') AND t2.id_alumno IS NOT NULL AND t2.id_pago <> 0 AND t1.estado_alumno = 1';
    } else {
        $sWhere = "WHERE t2.id_alumno IS NOT NULL AND t2.id_pago <> 0 AND t1.estado_alumno = 1";
    }

    $sWhere .= " ORDER BY t1.id_alumno";

    include 'pagination.php'; //include pagination file
    //pagination variables
    $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
    $per_page = 10; //how much records you want to show
    $adjacents  = 4; //gap between pages after number of adjacents
    $offset = ($page - 1) * $per_page;
    //Count the total number of rows in your table
    $count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
    $row = mysqli_fetch_array($count_query);
    $numrows = $row['numrows'];
    $total_pages = ceil($numrows / $per_page);
    $reload = './003002alumnos.php';

    //main query to fetch the data
    $sql = "SELECT * FROM  $sTable $sWhere LIMIT $offset, $per_page";
    $query = mysqli_query($con, $sql);
    //loop through fetched data

    if ($numrows > 0) {
      ?>
      <div class="table-responsive">
        <table class="table">
          <tr class="info">
            <th>Id</th>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>Rut</th>
            <th>Fecha Fin</th>
            <th class='text-right'>Acciones</th>
          </tr>
          <?php
          while ($row = mysqli_fetch_array($query)) {

            $id_alumno = $row['id_alumno'];
            $nombres_alumno = $row['nombres_alumno'];
            $apellidos_alumno = $row['apellidos_alumno'];
            $rut_alumno = $row['rut_alumno'];
            $fecha_fin = $row['fecha_fin'];
            $fecha_fin_formateada = date('d/m/Y', strtotime($fecha_fin));

            // Comparar fecha fin con la fecha actual
            $clase_fila = (strtotime($fecha_fin) < strtotime(date('Y-m-d'))) ? "danger" : "";

            ?>
            <tr class="<?php echo $clase_fila; ?>">
              <td><?php echo $id_alumno; ?></td>
              <td><?php echo $nombres_alumno; ?></td>
              <td><?php echo $apellidos_alumno; ?></td>
              <td><?php echo $rut_alumno; ?></td>
              <td><?php echo $fecha_fin_formateada == '01/01/1970'? '-': $fecha_fin_formateada; ?></td>
              <td class='text-right'>
                <a href="#" class='btn btn-default' title='Editar alumno' data-toggle="modal" data-target="#editaralumno" data-id_alumno="<?php echo $id_alumno; ?>" data-nombre_alumno="<?php echo $nombres_alumno; ?>" data-descripcion_alumno="<?php echo $apellidos_alumno; ?>" ><i class="icon-contrato icono-titulo"></i></a>
              </td>
            </tr>
            <?php
          }
          ?>
          <tr>
            <td colspan=8>
              <span class="pull-right">
                <?php
                echo paginate($reload, $page, $total_pages, $adjacents);
                ?>
              </span>
            </td>
          </tr>
        </table>
      </div>
      <?php
    }
  }
?>
