
  <?php
  if (isset($con)) {
  ?>
    <!-- Modal -->
    <div class="modal fade" id="nuevo_plan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar nuevo Plan</h4>
          </div>
          <div class="modal-body">
            <form class="form-horizontal" method="post" id="guardar_plan" name="guardar_plan">
              <div id="resultados_ajax"></div>

              <div class="form-group">
                <label for="nombre_plan" class="col-sm-3 control-label">Nombre Plan</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="nombre_plan" name="nombre_plan" placeholder="Ej: ABC123">
                </div>
                <span></span>
              </div>

              <div class="form-group">
                <label for="descripcion_plan" class="col-sm-3 control-label">Descripción</label>
                <div class="col-sm-8">
                <textarea class="form-control" rows="3" id="descripcion_plan" name="descripcion_plan" maxlength="100" style="resize:vertical;" placeholder="Ej: actividades"></textarea>
                </div>
                <span></span>
              </div>

              <div class="form-group">
                <label for="cantidad_meses_plan" class="col-sm-3 control-label">Cantidad Meses</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="cantidad_meses_plan" name="cantidad_meses_plan" placeholder="Ej: 40000">
                </div>
                <span></span>
              </div>

              <div class="form-group">
                <label for="precio_plan" class="col-sm-3 control-label">Precio</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="precio_plan" name="precio_plan" placeholder="Ej: DD/MM/AAAA">
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