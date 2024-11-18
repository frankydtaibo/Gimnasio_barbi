
<?php

  include('is_logged.php');
  require_once ("../config/db.php");
  require_once ("../config/conexion.php");
  
  $action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';

  if($action == 'ajax'){

     $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
     $aColumns = array('t1.nombres_alumno','t1.apellidos_alumno');
     $sTable = "alumnos t1";
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

    $sWhere.=" order by t1.id_alumno";

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
    $reload = './002001alumnos.php';

    //main query to fetch the data
    $sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
    $query = mysqli_query($con, $sql);
   
    //loop through fetched data
    if ($numrows>0){
        
      ?>
      <div class="table-responsive">
        <table class="table">
          <tr  class="success">
          <th>Id</th>
            <th>Nombre Alumno</th>
            <th>Correo 1</th>
            <th>Telefono</th>
            <th>Fecha Proximo Pago</th>
            <th>Estado</th>
            <th class='text-right'>Acciones</th>
              
          </tr>
          <?php
          while ($row=mysqli_fetch_array($query)){

            $id_alumno = $row['id_alumno'];
            $nombres_alumno = $row['nombres_alumno'];
            $apellidos_alumno = $row['apellidos_alumno'];
            $estado_alumno = $row['estado_alumno'];
            $correo_1 = $row['correo_1'];
            $telefono = $row['telefono_alumno'];
            ?>
            <tr>
                
                <td><?php echo $id_alumno; ?></td>
                <td><?php echo $nombres_alumno.' '.$apellidos_alumno; ?></td>
                <td><?php echo $correo_1; ?></td>
                <td><?php echo $telefono; ?></td>
                <td class="<?php echo $estado_alumno == 1 ? 'text-success':'text-danger'; ?>" ><?php echo $estado_alumno == 1 ? 'Habilitado': 'Desabilitado'; ?></td>
                
            <td class='text-right'>
              <a href="#" class="btn btn-default <?php echo $estado_alumno == 1 ? 'btn-success':'btn-danger'; ?>" title="Activar/Desactivar" onclick="cambiar_estado('<?php echo $id_recepcionista; ?>','<?php echo $page; ?>');"><i class="icon-switch"></i></a>
<!--               <a href="#" class='btn btn-default' title='Editar Recepcionista' data-toggle="modal" data-target="#editarRecepcionista" data-id="<?php echo $id_recepcionista; ?>" data-id_stellantis="<?php echo $id_stellantis; ?>" data-nombres_recepcionista="<?php echo $nombres_recepcionista; ?>" data-apellidos_recepcionista="<?php echo $apellidos_recepcionista; ?>" data-id_ce="<?php echo $id_ce; ?>"><i class="glyphicon glyphicon-edit"></i></a> 
 -->            </td>
                
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