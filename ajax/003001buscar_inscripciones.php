<?php

include('is_logged.php');
require_once("../config/db.php");
require_once("../config/conexion.php");

$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';

if ($action == 'ajax') {


  $q = mysqli_real_escape_string($con, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
  $aColumns = array('t1.descripcion_plan', 't1.nombre_plan');
  $sTable = "inscripcion t1
                LEFT JOIN alumno t2 on t1.id_alumno = t2.id_alumno
                LEFT JOIN plan t3 on t1.id_plan = t3.id_plan
                LEFT JOIN pago t4 on t1.id_pago = t4.id_pago
                                LEFT JOIN forma_pago t5 ON t4.id_forma_pago = t5.id_forma_pago";
  $sWhere = "";

  if ($_GET['q'] != "") {
    $sWhere = "WHERE (";
    for ($i = 0; $i < count($aColumns); $i++) {
      $sWhere .= $aColumns[$i] . " LIKE '%" . $q . "%' OR ";
    }
    $sWhere = substr_replace($sWhere, "", -3);
    $sWhere .= ')';
  }

  $sWhere .= " order by t1.id_inscripcion";

  include 'pagination.php'; //include pagination file
  //pagination variables
  $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
  $per_page = 10; //how much records you want to show
  $adjacents  = 4; //gap between pages after number of adjacents
  $offset = ($page - 1) * $per_page;
  //Count the total number of row in your table*/
  $count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");

  $row = mysqli_fetch_array($count_query);
  $numrows = $row['numrows'];
  $total_pages = ceil($numrows / $per_page);
  $reload = './002002planes.php';

  //main query to fetch the data
  $sql = "SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
  $query = mysqli_query($con, $sql);

  //loop through fetched data
  if ($numrows > 0) {

?>
    <div class="table-responsive">
      <table class="table">
        <tr class="info">
          <th>Id</th>
          <th>Nombre Alumno</th>
          <th>Nombre Plan</th>
          <th>Cantidad Meses</th>
          <th>Precio</th>
          <th>Forma Pago</th>
          <th>Fecha inicio</th>
          <th>Fecha fin</th>
          <th>Fecha Pago</th>
          <th>Estado</th>
          <th class='text-right'>Acciones</th>

        </tr>
        <?php
        while ($row = mysqli_fetch_array($query)) {

          $id_inscripcion = $row['id_inscripcion'];
          $nombre_alumno = $row['nombres_alumno'];
          $id_alumno = $row['id_alumno'];
          $id_plan = $row['id_plan'];
          $id_pago = $row['id_pago'];
          $id_forma_pago = $row['id_forma_pago'];

          $apellido_alumno = $row['apellidos_alumno'];
          $nombre_plan = $row['nombre_plan'];
          $cantidad_meses_plan = $row['cantidad_meses_plan'];
          $precio_plan = $row['precio_plan'];
          $nombre_pago = $row['nombre_pago'];
          $fecha_inicio = date('d/m/Y', strtotime($row['fecha_inicio']));
          $fecha_fin = date('d/m/Y', strtotime($row['fecha_fin']));
          $fecha_pago = date('d/m/Y', strtotime($row['fecha_pago']));

          $estado_pago = $row['estado_pago'];

        ?>
          <tr>

            <td><?php echo $id_inscripcion; ?></td>
            <td><?php echo $nombre_alumno . ' ' . $apellido_alumno; ?></td>
            <td><?php echo $nombre_plan; ?></td>
            <td><?php echo $cantidad_meses_plan; ?></td>
            <td><?php echo $precio_plan; ?></td>
            <td><?php echo $id_forma_pago == 0 ? '-' : $nombre_pago; ?></td>
            <td><?php echo $id_forma_pago == 0  ? '-' : $fecha_inicio; ?></td>
            <td><?php echo $id_forma_pago == 0 ? '-' : $fecha_fin; ?></td>
            <td><?php echo $id_forma_pago == 0  ? '-' : $fecha_pago; ?></td>
            <td class="<?php echo $estado_pago == 1 ? 'text-success' : 'text-danger'; ?>"><?php echo $estado_pago == 1 ? 'Habilitado' : 'Desabilitado'; ?></td>

            <td class='text-right'>
              <?php if ($estado_pago == 0){ ?>

                <a href="#" class='btn btn-default' title='Registrar Pago' data-toggle="modal" data-target="#registroPago" data-id_inscripcion="<?php echo $id_inscripcion; ?>" data-precio_plan="<?php echo $precio_plan; ?>" data-id_alumno="<?php echo $id_alumno; ?>"><i class="glyphicon glyphicon-usd"></i></a>


                <?php }?> 
              <?php if ($estado_pago == 1) { ?>

                <a href="#" class='btn btn-default' title='Editar Inscripción' data-toggle="modal" data-target="#editarInscripcion" data-id_inscripcion="<?php echo $id_inscripcion; ?>" data-id_alumno="<?php echo $id_alumno; ?>" data-id_plan="<?php echo $id_plan; ?>" data-id_forma_pago="<?php echo $id_forma_pago; ?>" data-fecha_inicio="<?php echo $fecha_inicio; ?>" data-fecha_pago="<?php echo $fecha_pago; ?>" data-precio_plan="<?php echo $precio_plan; ?>" data-descuento="<?php echo $descuento; ?>"><i class="glyphicon glyphicon-edit"></i></a>
                <a href="#" class='btn btn-default' title='Postergar' data-toggle="modal" data-target="#postergar" data-id_inscripcion="<?php echo $id_inscripcion; ?>" data-id_plan="<?php echo $id_plan; ?>" data-id_alumno="<?php echo $id_alumno; ?>"><i class="glyphicon glyphicon-log-out"></i></a>
                <a href="#" class='btn btn-danger' title='Borrar Incripción' onclick="eliminar('<?php echo $id_inscripcion; ?>')"><i class="glyphicon glyphicon-trash"></i> </a>
              
                <?php }?> 
            </td>

          </tr>

        <?php
        }
        ?>
        <tr>
          <td colspan=12>
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