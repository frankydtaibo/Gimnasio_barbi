	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Editar perfil</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="editar_perfiles" name="editar_perfiles">

			<div id="resultados_ajax2"></div>

			 <div class="form-group">
				<label for="perfil2" class="col-sm-3 control-label">Perfil Decripcion</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="perfil2" name="perfil2" placeholder="Perfil Decripcion" required maxlength="50">
				</div>
			  </div>

			  <input type="hidden" name="mod_id" id="mod_id">

			  

		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="actualizar_datos">Actualizar datos</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>