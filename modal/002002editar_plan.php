<?php
  if (isset($con)) {
  ?>
    <!-- Modal -->
    <div class="modal fade" id="editarPlan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Editar Plan</h4>
          </div>
          <div class="modal-body">
            <form class="form-horizontal" method="post" id="editar_plan" name="editar_plan">
              <div id="resultados_ajax_editar"></div>

              <input type="text" name="id_plan" id="id_plan">

              <div class="form-group">
                <label for="nombre_plan_editar" class="col-sm-3 control-label">Nombre Plan</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="nombre_plan_editar" name="nombre_plan_editar" placeholder="Ej: ABC123">
                </div>
                <span></span>
              </div>

              <div class="form-group">
                <label for="descripcion_plan_editar" class="col-sm-3 control-label">Descripción</label>
                <div class="col-sm-8">
                <textarea class="form-control" rows="3" id="descripcion_plan_editar" name="descripcion_plan_editar" maxlength="100" style="resize:vertical;" placeholder="Ej: actividades"></textarea>
                </div>
                <span></span>
              </div>

              <div class="form-group">
                <label for="cantidad_meses_plan_editar" class="col-sm-3 control-label">Cantidad Meses</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="cantidad_meses_plan_editar" name="cantidad_meses_plan_editar" placeholder="Ej: 40000">
                </div>
                <span></span>
              </div>

              <div class="form-group">
                <label for="precio_plan_editar" class="col-sm-3 control-label">precio</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="precio_plan_editar" name="precio_plan_editar" placeholder="Ej: DD/MM/AAAA">
                </div>
                <span></span>
              </div>



          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary" id="editar_datos">Guardar datos</button>
          </div>

          </form>
        </div>
      </div>
    </div>
  <?php
  }
  ?>