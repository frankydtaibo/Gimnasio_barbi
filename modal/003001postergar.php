<?php
if (isset($con)) {
?>
  <!-- Modal -->
  <div class="modal fade" id="postergar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Postergar</h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" method="post" id="guardar_inscripcion" name="guardar_inscripcion">
            <div id="resultados_ajax"></div>

            <input type="hidden" name="id_inscripcion_postergar" id="id_inscripcion_postergar">

            <div class="form-group">
              <label for="alumno_postergar" class="col-sm-3 control-label">Alumno</label>
              <div class="col-sm-8">
                <select id="alumno_postergar" class="selectpicker form-control" data-live-search="true" title="Seleccione un alumno..."disabled>
                  <?php

                  $sql_alumno = "SELECT * 
                                 FROM alumno t1 
                                 LEFT JOIN inscripcion t2 ON t1.id_alumno = t2.id_alumno  
                                 WHERE t1.estado_alumno = 1 ";

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
              <label for="plan_postergar" class="col-sm-3 control-label">Plan</label>
              <div class="col-sm-8">
                <select id="plan_postergar" class="selectpicker form-control" data-live-search="true" title="Seleccione un plan..." disabled>
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

            <div class="form-group">
                <label for="nombre_plan" class="col-sm-3 control-label">Motivo</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="nombre_plan" name="nombre_plan" placeholder="Ej: ABC123">
                </div>
                <span></span>
              </div>

              <div class="form-group">
                <label for="descripcion_plan" class="col-sm-3 control-label">Observación</label>
                <div class="col-sm-8">
                <textarea class="form-control" rows="3" id="descripcion_plan" name="descripcion_plan" maxlength="100" style="resize:vertical;" placeholder="Ej: actividades"></textarea>
                </div>
                <span></span>
              </div>


              <div class="form-group">
                <label for="descripcion_plan" class="col-sm-3 control-label">Subir</label>
                <div class="col-sm-8">
                <input id="archivo_adjunto" name="archivo_adjunto[]" type="file" data-show-upload="false" data-show-caption="true" multiple="" accept=".xlsx, .xls, .docx, .doc, .ppt, .pptx, .jpg, .jpeg, .png, .txt, .csv, .pdf" placeholder="Nombre del archivo">
                </div>
                <span></span>
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