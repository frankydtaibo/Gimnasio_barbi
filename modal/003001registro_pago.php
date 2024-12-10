<?php
if (isset($con)) {
?>
  <!-- Modal -->
  <div class="modal fade" id="registroPago" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Registrar Pago</h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" method="post" id="guardar_pago" name="guardar_pago">
            <div id="resultados_ajax"></div>

            <!-- Campo oculto para el ID del plan -->
            <input type="hidden" name="id_inscripcion_pago" id="id_inscripcion_pago">
           
            <div class="form-group">
              <label for="alumno_pago" class="col-sm-3 control-label">Alumno</label>
              <div class="col-sm-8">
                <select id="alumno_pago" class="selectpicker form-control" data-live-search="true" title="Seleccione un _editar..." disabled>
                  <?php

                  $sql_alumno = "SELECT *
                                   FROM alumno
                                   WHERE estado_alumno = 1";

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
            
            <!-- Forma de Pago -->
            <div class="form-group">
              <label for="forma_pago" class="col-sm-3 control-label">Forma de Pago</label>
              <div class="col-sm-8">
                <select id="forma_pago" name="forma_pago" class="selectpicker form-control" data-live-search="true" title="Seleccione una forma de pago..." required>
                  <?php
                  $sql_inscripcion = "SELECT * FROM forma_pago WHERE estado_pago = 1";
                  $inscripcion_query = mysqli_query($con, $sql_inscripcion);

                  while ($fila_inscripcion = mysqli_fetch_array($inscripcion_query)) {
                    $id_pago = $fila_inscripcion["id_forma_pago"];
                    $nombre_pago = $fila_inscripcion["nombre_pago"];
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
              <label for="fecha_inicio" class="col-sm-3 control-label">Fecha Inicio</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="fecha_inicio" name="fecha_inicio" placeholder="Ej: DD/MM/AAAA" required>
              </div>
            </div>

            <!-- Fecha Pago -->
            <div class="form-group">
              <label for="fecha_pago" class="col-sm-3 control-label">Fecha Pago</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="fecha_pago" name="fecha_pago" placeholder="Ej: DD/MM/AAAA" required>
              </div>
            </div>

            <!-- Monto Inicial -->
            <div class="form-group">
              <label for="monto_inicial" class="col-sm-3 control-label">Monto Inicial</label>
              <div class="col-sm-8">
                <input type="number" class="form-control" id="monto_inicial" name="monto_inicial" placeholder="Ej: 1000" required>
              </div>
            </div>

            <!-- Descuento -->
            <div class="form-group">
              <label for="descuento" class="col-sm-3 control-label">Descuento (%)</label>
              <div class="col-sm-8">
                <input type="number" class="form-control" id="descuento" name="descuento" placeholder="Ej: 10 (porcentaje)" >
              </div>
            </div>

            <!-- Monto Final (calculado automáticamente con JavaScript) -->
            <div class="form-group">
              <label for="monto_final" class="col-sm-3 control-label">Monto Final</label>
              <div class="col-sm-8">
                <input type="number" class="form-control" id="monto_final" name="monto_final" readonly>
              </div>
            </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary" id="guardar_pagos">Guardar datos</button>
        </div>

        </form>
      </div>
    </div>
  </div>
<?php
}
?>
