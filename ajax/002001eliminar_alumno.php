<?php 

require_once ("../config/db.php");
require_once ("../config/conexion.php");
    if (isset($_GET['id'])){
        $id=intval($_GET['id']);
  
      if ($delete1=mysqli_query($con,"DELETE FROM alumno WHERE id_alumno='".$id."'")){
        ?>
          <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>¡Aviso!</strong> Datos eliminados exitosamente..
          </div>
        <?php 
        }else {
        ?>
          <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>¡Error!</strong> Lo siento algo ha salido mal intenta nuevamente.
          </div>
        <?php
        
      }
    }else{
        ?>
          <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>¡Error!</strong> Lo siento algo ha salido mal intenta nuevamente.
          </div>
        <?php
    }


?>