<?php
if (isset($con)) {
?>
  <!-- Modal -->
  <div class="modal fade" id="nueva_inscripcion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar Inscripción</h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" method="post" id="guardar_inscripcion" name="guardar_inscripcion">
            <div id="resultados_ajax"></div>


            <div class="form-group">
              <label for="alumno" class="col-sm-3 control-label">Alumno</label>
              <div class="col-sm-8">
                <select id="alumno" class="selectpicker form-control" data-live-search="true" title="Seleccione un alumno...">
                  <?php

                  $sql_alumno = "SELECT t1.id_alumno, t1.nombres_alumno, t1.apellidos_alumno 
                                 FROM alumno t1 
                                 LEFT JOIN inscripcion t2 ON t1.id_alumno = t2.id_alumno  
                                 WHERE t1.estado_alumno = 1 AND t2.id_alumno IS NULL";

                  $alumno_query = mysqli_query($con, $sql_alumno);

                  while ($fila_alumno = mysqli_fetch_array($alumno_query)) {

                    $id_alumno = $fila_alumno["id_alumno"];
                    $nombre_alumno = $fila_alumno["nombres_alumno"];
                    $apellido_alumno = $fila_alumno["apellidos_alumno"];

                  ?>

                    <option value='<?php echo $id_alumno; ?>'><?php echo $nombre_alumno . ' ' . $apellido_alumno; ?></option>

                  <?php

                  }

                  ?>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label for="plan" class="col-sm-3 control-label">Plan</label>
              <div class="col-sm-8">
                <select id="plan" class="selectpicker form-control" data-live-search="true" title="Seleccione un plan...">
                  <?php

                  $sql_plan = "SELECT *
                                   FROM plan
                                   WHERE estado_plan = 1";

                  $plan_query = mysqli_query($con, $sql_plan);

                  while ($fila_plan = mysqli_fetch_array($plan_query)) {

                    $id_plan = $fila_plan["id_plan"];
                    $nombre_plan = $fila_plan["nombre_plan"];

                  ?>

                    <option value='<?php echo $id_plan; ?>'><?php echo $nombre_plan; ?></option>

                  <?php

                  }

                  ?>
                </select>
              </div>
            </div>

            

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary" id="guardar_datos">Guardar datos</button>
        </div>

        </form>
      </div>
    </div>
  </div>
<?php
}
?>