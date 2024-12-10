<?php
if (isset($con)) {
?>
<!-- Modal -->
<div class="modal fade" id="editarInscripcion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">
          <i class='glyphicon glyphicon-edit'></i> Editar Inscripción
        </h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" method="post" id="editar_inscripcion" name="editar_inscripcion">
          <div id="resultados_ajax_ins"></div>

          <input type="hidden" name="id_inscripcion" id="id_inscripcion">

          <!-- Alumno -->
          <div class="form-group">
            <label for="alumno_editar" class="col-sm-3 control-label">Alumno</label>
            <div class="col-sm-8">
              <select id="alumno_editar" class="selectpicker form-control" data-live-search="true" title="Seleccione un alumno..." disabled>
                <?php
                $sql_alumno = "SELECT * FROM alumno WHERE estado_alumno = 1";
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

          <!-- Plan -->
          <div class="form-group">
            <label for="plan_editar" class="col-sm-3 control-label">Plan</label>
            <div class="col-sm-8">
              <select id="plan_editar" class="selectpicker form-control" data-live-search="true" title="Seleccione un plan...">
                <?php
                $sql_plan = "SELECT * FROM plan WHERE estado_plan = 1";
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

          <!-- Forma de Pago -->
          <div class="form-group">
            <label for="forma_pago_editar" class="col-sm-3 control-label">Forma de Pago</label>
            <div class="col-sm-8">
              <select id="forma_pago_editar" class="selectpicker form-control" data-live-search="true" title="Seleccione una forma de pago...">
                <?php
                $sql_pago = "SELECT * FROM forma_pago WHERE estado_pago = 1";
                $pago_query = mysqli_query($con, $sql_pago);

                while ($fila_pago = mysqli_fetch_array($pago_query)) {
                  $id_pago = $fila_pago["id_forma_pago"];
                  $nombre_pago = $fila_pago["nombre_pago"];
                ?>
                  <option value='<?php echo $id_pago; ?>'><?php echo $nombre_pago; ?></option>
                <?php
                }
                ?>
              </select>
            </div>
          </div>

          <!-- Fecha Inicio -->
          <div class="form-group">
            <label for="fecha_inicio_editar" class="col-sm-3 control-label">Fecha Inicio</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="fecha_inicio_editar" name="fecha_inicio" placeholder="Ej: DD/MM/AAAA">
            </div>
          </div>

          <!-- Fecha Pago -->
          <div class="form-group">
            <label for="fecha_pago_editar" class="col-sm-3 control-label">Fecha Pago</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="fecha_pago_editar" name="fecha_pago" placeholder="Ej: DD/MM/AAAA">
            </div>
          </div>

          <!-- Monto Inicial -->
          <div class="form-group">
            <label for="monto_inicial_editor" class="col-sm-3 control-label">Monto Inicial</label>
            <div class="col-sm-8">
            <input type="number" class="form-control" id="monto_inicial_editar" name="monto_inicial_editar" placeholder="Ej: 1000"disabled>
            </div>
          </div>

          <!-- Descuento -->
          <div class="form-group">
            <label for="descuento_editar" class="col-sm-3 control-label">Descuento (%)</label>
            <div class="col-sm-8">
              <input type="number" class="form-control" id="descuento_editar" name="descuento_editar" placeholder="Ej: 10 (porcentaje)">
            </div>
          </div>

          <!-- Monto Final -->
          <div class="form-group">
            <label for="monto_final_editar" class="col-sm-3 control-label">Monto Final</label>
            <div class="col-sm-8">
              <input type="number" class="form-control" id="monto_final_editar" name="monto_final_editar" readonly>
            </div>
          </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary" id="editar_datos">Guardar datos</button>
      </div>
    </div>
  </div>
</div>
<?php
}
?>
