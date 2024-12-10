<?php 

require_once ("../config/db.php");
require_once ("../config/conexion.php");
    if (isset($_GET['id'])){
        $id=intval($_GET['id']);

        $sql_validacion = "SELECT * 
                           FROM inscripcion 
                           WHERE id_plan = $id";
        $query_validacion = mysqli_query($con, $sql_validacion);

        if (mysqli_num_rows($query_validacion) > 0) {
          // Si existen planes activos, no se debe permitir borrar.
          ?>
          <div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>¡Aviso!</strong> No se puede borrar porque existen planes asociados a un alumno activo.
          </div>
        <?php 
      } else {

        if ($delete1=mysqli_query($con,"DELETE FROM plan WHERE id_plan='".$id."'")){
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