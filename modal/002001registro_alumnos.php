  <?php
  if (isset($con)) {
  ?>
    <!-- Modal -->
    <div class="modal fade" id="nuevo_alumno" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar nuevo Alumno</h4>
          </div>
          <div class="modal-body">
            <form class="form-horizontal" method="post" id="guardar_alumno" name="guardar_alumno">
              <div id="resultados_ajax"></div>


              <div class="form-group">
                <label for="nombres" class="col-sm-3 control-label">Nombres</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="nombres" name="nombres" placeholder="Ej: Juan Carlos">
                </div>
                <span></span>
              </div>

              <div class="form-group">
                <label for="apellidos" class="col-sm-3 control-label">Apellidos</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Ej: Perez Soto">
                </div>
                <span></span>
              </div>

              <div class="form-group">
                <label for="rut_alumno" class="col-sm-3 control-label">Rut</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="rut_alumno" name="rut_alumno" placeholder="Ej: 18626432-k">
                </div>
                <span></span>
              </div>

              <div class="form-group">
                <label for="correo_1" class="col-sm-3 control-label">Correo 1</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="correo_1" name="correo_1" placeholder="Ej: correo@correo.cl">
                </div>
                <span></span>
              </div>

              <div class="form-group">
                <label for="correo_2" class="col-sm-3 control-label">Correo 2</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="correo_2" name="correo_2" placeholder="Ej: correo@correo.cl">
                </div>
                <span></span>
              </div>

              <div class="form-group">
                <label for="telefono_alumno" class="col-sm-3 control-label">Telefono</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="telefono_alumno" name="telefono_alumno" placeholder="Ej: 994466930">
                </div>
                <span></span>
              </div>

              <div class="form-group">
                <label for="fecha_nacimiento" class="col-sm-3 control-label">Fecha Nacimiento</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" placeholder="Ej: 18626432-k">
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