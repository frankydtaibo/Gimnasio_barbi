		$(document).ready(function(){
			load(1);
		});

		function load(page){
			var q= $("#q").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/001002buscar_usuarios.php?action=ajax&page='+page+'&q='+q,
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');
					
				}
			})
		}

	
		
			function eliminar (id)
		{
			var q= $("#q").val();
		if (confirm("Realmente deseas eliminar el usuario")){	
		$.ajax({
        type: "GET",
        url: "./ajax/001002buscar_usuarios.php",
        data: "id="+id,"q":q,
		 beforeSend: function(objeto){
			$("#resultados").html("Mensaje: Cargando...");
		  },
        success: function(datos){
		$("#resultados").html(datos);
		load(1);
		}
			});
		}
		}
		

		function obtener_datos_copia(id){
			var nombres = $("#nombres"+id).val();
			var apellidos = $("#apellidos"+id).val();
			var usuario = $("#usuario"+id).val();
			var email = $("#email"+id).val();
			var consulta = $("#userconsulta"+id).val();
			var idperfil = $("#userperfilid"+id).val();
		
			$("#copia_id").val(id);
			$("#copia_firstname").val(nombres+' COPIA');
			$("#copia_lastname").val(apellidos+' COPIA');
			$("#copia_user_name").val(usuario+'copia');
			$("#copia_user_email").val(email+'');
			$("#copia_user_consulta").val(consulta);
			$("#copia_id_perfil").val(idperfil);
		  }

