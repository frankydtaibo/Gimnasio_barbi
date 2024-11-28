  <?php
  if (isset($con)) {
  ?>
    <!-- Modal -->
    <div class="modal fade" id="editarAlumno" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Editar Alumno</h4>
          </div>
          <div class="modal-body">
            <form class="form-horizontal" method="post" id="editar_alumno" name="editar_alumno">
              <div id="resultados_ajax_editar"></div>

              <input type="hidden" name="id_alumno" id="id_alumno">

              <div class="form-group">
                <label for="nombres_editar" class="col-sm-3 control-label">Nombres</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="nombres_editar" name="nombres_editar" placeholder="Ej: Juan Carlos">
                </div>
                <span></span>
              </div>

              <div class="form-group">
                <label for="apellidos_editar" class="col-sm-3 control-label">Apellidos</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="apellidos_editar" name="apellidos_editar" placeholder="Ej: Perez Soto">
                </div>
                <span></span>
              </div>

              <div class="form-group">
                <label for="rut_alumno_editar" class="col-sm-3 control-label">Rut</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="rut_alumno_editar" name="rut_alumno_editar" placeholder="Ej: 18626432-k">
                </div>
                <span></span>
              </div>

              <div class="form-group">
                <label for="correo_1_editar" class="col-sm-3 control-label">Correo 1</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="correo_1_editar" name="correo_1_editar" placeholder="Ej: correo@correo.cl">
                </div>
                <span></span>
              </div>

              <div class="form-group">
                <label for="correo_2_editar" class="col-sm-3 control-label">Correo 2</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="correo_2_editar" name="correo_2_editar" placeholder="Ej: correo@correo.cl">
                </div>
                <span></span>
              </div>

              <div class="form-group">
                <label for="telefono_alumno_editar" class="col-sm-3 control-label">Telefono</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="telefono_alumno_editar" name="telefono_alumno_editar" placeholder="Ej: 994466930">
                </div>
                <span></span>
              </div>

              <div class="form-group">
                <label for="fecha_nacimiento_editar" class="col-sm-3 control-label">Fecha Nacimiento</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="fecha_nacimiento_editar" name="fecha_nacimiento_editar" placeholder="Ej: 18626432-k">
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