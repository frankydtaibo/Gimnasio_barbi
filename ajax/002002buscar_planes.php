
<?php

  include('is_logged.php');
  require_once ("../config/db.php");
  require_once ("../config/conexion.php");
  
  $action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';

  if($action == 'ajax'){


     $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
     $aColumns = array('t1.descripcion_plan', 't1.nombre_plan');
     $sTable = "plan t1";
     $sWhere = "";

    if ( $_GET['q'] != "" ){
      $sWhere = "WHERE (";
      for ( $i=0 ; $i<count($aColumns) ; $i++ )
      {
          $sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";
      }
      $sWhere = substr_replace( $sWhere, "", -3 );
      $sWhere .= ')';
    }

    $sWhere.=" order by t1.id_plan";

    include 'pagination.php'; //include pagination file
    //pagination variables
    $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
    $per_page = 10; //how much records you want to show
    $adjacents  = 4; //gap between pages after number of adjacents
    $offset = ($page - 1) * $per_page;
    //Count the total number of row in your table*/
    $count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
    $row= mysqli_fetch_array($count_query);
    $numrows = $row['numrows'];
    $total_pages = ceil($numrows/$per_page);
    $reload = './002002planes.php';

    //main query to fetch the data
    $sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
    $query = mysqli_query($con, $sql);
   
    //loop through fetched data
    if ($numrows>0){
        
      ?>
      <div class="table-responsive">
        <table class="table">
          <tr  class="info">
          <th>Id</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Cantidad Meses</th>
            <th>Precio</th>
            <th>Estado</th>
            <th class='text-right'>Acciones</th>
              
          </tr>
          <?php
          while ($row=mysqli_fetch_array($query)){

            $id_plan = $row['id_plan'];
            $nombre_plan = $row['nombre_plan'];
            $descripcion_plan = $row['descripcion_plan'];
            $cantidad_meses_plan = $row['cantidad_meses_plan'];
            $precio_plan = $row['precio_plan'];
            $estado_plan = $row['estado_plan'];
			?>
            <tr>
                
                <td><?php echo $id_plan; ?></td>
                <td><?php echo $nombre_plan; ?></td>
                <td><?php echo $descripcion_plan; ?></td>
                <td><?php echo $cantidad_meses_plan; ?></td>
                <td><?php echo $precio_plan; ?></td>
                <td class="<?php echo $estado_plan == 1 ? 'text-success':'text-danger'; ?>" ><?php echo $estado_plan == 1 ? 'Habilitado': 'Desabilitado'; ?></td>
                
            <td class='text-right'>
               <a href="#" class="btn btn-default <?php echo $estado_plan == 1 ? 'btn-success':'btn-danger'; ?>" title="Activar/Desactivar" onclick="cambiar_estado('<?php echo $id_plan; ?>','<?php echo $page; ?>');"><i class="icon-switch"></i></a>
              <a href="#" class='btn btn-default' title='Editar Plan' data-toggle="modal" data-target="#editarPlan" data-id_plan="<?php echo $id_plan; ?>"  data-nombre_plan="<?php echo $nombre_plan; ?>" data-descripcion_plan="<?php echo $descripcion_plan; ?>" data-cantidad_meses_plan="<?php echo $cantidad_meses_plan; ?>" data-precio_plan="<?php echo $precio_plan; ?>" ><i class="glyphicon glyphicon-edit"></i></a> 
              <a href="#" class='btn btn-danger' title='Borrar Plan' onclick="eliminar('<?php echo $id_plan; ?>')"><i class="glyphicon glyphicon-trash"></i> </a>
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