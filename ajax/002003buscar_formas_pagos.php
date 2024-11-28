
<?php

  include('is_logged.php');
  require_once ("../config/db.php");
  require_once ("../config/conexion.php");
  
  $action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';

  if($action == 'ajax'){

    //main query to fetch the data
    $sql="SELECT * FROM  formas_de_pago order by id_forma_pago ASC";
    $query = mysqli_query($con, $sql);
   
        
      ?>
      <div class="table-responsive">
        <table class="table">
          <tr  class="info">
          <th>Id</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Comisión</th>
            <th>moneda</th>
            <th>disponible_online</th>
            <th>Estado</th>
            <th class='text-right'>Acciones</th>
              
          </tr>
          <?php
          while ($row=mysqli_fetch_array($query)){

            $id_forma_pago = $row['id_forma_pago'];
            $nombre_pago = $row['nombre_pago'];
            $descripcion_pago = $row['descripcion_pago'];
            $comision = $row['comision'];
            $moneda = $row['moneda'];
            $disponible_online = $row['disponible_online'];
            $estado = $row['estado'];
			?>
            <tr>
                <td><?php echo $id_forma_pago; ?></td>
                <td><?php echo $nombre_pago; ?></td>
                <td><?php echo $descripcion_pago; ?></td>
                <td><?php echo $comision; ?></td>
                <td><?php echo $moneda; ?></td>
                <td><?php echo $disponible_online == 0 ? 'No Disponible' : 'Disponible'; ?></td>                <td class="<?php echo $estado == 1 ? 'text-success':'text-danger'; ?>" ><?php echo $estado == 1 ? 'Habilitado': 'Desabilitado'; ?></td>
                
            <td class='text-right'>
               <a href="#" class="btn btn-default <?php echo $estado == 1 ? 'btn-success':'btn-danger'; ?>" title="Activar/Desactivar" onclick="cambiar_estado('<?php echo $id_forma_pago; ?>');"><i class="icon-switch"></i></a>
              <a href="#" class='btn btn-default' title='Editar Forma de Pago' data-toggle="modal" data-target="#editarPago" data-id_forma_pago="<?php echo $id_forma_pago; ?>"  data-nombre_pago="<?php echo $nombre_pago; ?>" data-descripcion_pago="<?php echo $descripcion_pago; ?>" data-comision="<?php echo $comision; ?>" data-moneda="<?php echo $moneda; ?>" data-disponible_online="<?php echo $disponible_online; ?>"><i class="glyphicon glyphicon-edit"></i></a> 
              <a href="#" class='btn btn-danger' title='Borrar Forma de Pago' onclick="eliminar('<?php echo $id_forma_pago; ?>')"><i class="glyphicon glyphicon-trash"></i> </a>
            </td>
                
            </tr>

            <?php
          }
          ?>
          
        </table>
      </div>
      <?php
    
  }
?>