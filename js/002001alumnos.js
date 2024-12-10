$(document).ready(function(){

  $('#fecha_nacimiento').datetimepicker({
    date: null,
    viewMode: 'days',
    format: 'DD/MM/YYYY',
    locale: 'es'
  });

  $('#fecha_nacimiento_editar').datetimepicker({
    date: null,
    viewMode: 'days',
    format: 'DD/MM/YYYY',
    locale: 'es'
  });

    load(1);

});

function load(page){
    var q= $("#q").val();
    $("#loader").fadeIn('slow');
    $.ajax({
        url:'./ajax/002001buscar_alumnos.php?action=ajax&page='+page+'&q='+q,
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
if (confirm("Realmente deseas eliminar el usuario")){	
$.ajax({
type: "GET",
url: "./ajax/002001eliminar_alumno.php",
data: "id="+id,
 beforeSend: function(objeto){
    $("#resultados").html("Mensaje: Cargando...");
  },
success: function(datos){ 
  console.log(datos);
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

  $( "#guardar_usuario" ).submit(function( event ) {
    $('#guardar_datos').attr("disabled", true);
    
   var parametros = $(this).serialize();
     $.ajax({
        type: "POST",
        url: "ajax/001002nuevo_usuario.php",
        data: parametros,
         beforeSend: function(objeto){
          $("#resultados_ajax").html("Mensaje: Cargando...");
          },
        success: function(datos){
        $("#resultados_ajax").html(datos);
        $('#guardar_datos').attr("disabled", false);
        load(1);
        }
    });
    event.preventDefault();
  }) 
  
  $( "#editar_usuario" ).submit(function( event ) {
    $('#actualizar_datos2').attr("disabled", true);
    
   var parametros = $(this).serialize();
  
     $.ajax({
        type: "POST",
        url: "ajax/001002editar_usuario.php",
        data: parametros,
         beforeSend: function(objeto){
          $("#resultados_ajax2").html("Mensaje: Cargando...");
          },
        success: function(datos){
        $("#resultados_ajax2").html(datos);
        $('#actualizar_datos2').attr("disabled", false);
        load(1);
        }
    });
    event.preventDefault();
  })
  
  $( "#editar_password" ).submit(function( event ) {
    $('#actualizar_datos3').attr("disabled", true);
    
   var parametros = $(this).serialize();
     $.ajax({
        type: "POST",
        url: "ajax/001002editar_password.php",
        data: parametros,
         beforeSend: function(objeto){
          $("#resultados_ajax3").html("Mensaje: Cargando...");
          },
        success: function(datos){
        $("#resultados_ajax3").html(datos);
        $('#actualizar_datos3').attr("disabled", false);
        load(1);
        }
    });
    event.preventDefault();
  })
    function get_user_id(id){
      $("#user_id_mod").val(id);
    }
  
/*     function obtener_datos(id){
  
      var nombres = $("#nombres"+id).val();
      var apellidos = $("#apellidos"+id).val();
      var usuario = $("#usuario"+id).val();
      var email = $("#email"+id).val();
      var consulta = $("#userconsulta"+id).val();
      var user_password_set = $("#user_password_set"+id).val();
      var idperfil = $("#userperfilid"+id).val();
      var userrut = $("#userrut"+id).val();
  
      if( consulta == 1)
        $('#user_consulta2').prop('checked', true);
      else
        $('#user_consulta2').prop('checked', false);
  
      if( user_password_set == 1)
        $('#user_password_set2').prop('checked', true);
      else
        $('#user_password_set2').prop('checked', false);
  
      $("#mod_id").val(id);
      $("#firstname2").val(nombres);
      $("#lastname2").val(apellidos);
      $("#user_name2").val(usuario);
      $("#user_rut2").val(userrut);
      $("#user_email2").val(email);
      $("#user_idperfil2").val(idperfil);
   
        
    }
       */
  
      
    $('#myModal4').on('show.bs.modal', function (event) {
  
      var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('id');
        var perfil = button.data('perfil');
        var name = button.data('name');
        var des_perfil = button.data('des_perfil');
  
       $.ajax({
        type: "GET",
        url: 'ajax/001002ver_usuario.php',
        data: { id:id, 
                perfil:perfil, 
                name:name, 
                des_perfil:des_perfil},
        success: function(data){
        $('#ver_ajax_usuario').html(data);
        $('#name').html(name);
        }
  
       });
  
    })

    function cambiar_estado(id,pagina){

      var action = 'ajax';
    
      $.ajax({
        type: "POST",
        url:"./ajax/002001cambiar_estado.php",
        data: { action: action,
                id: id},
        dataType:"json",
        beforeSend: function(objeto){
          $('#resultados').html('<img src="./img/ajax-loader.gif"> Cargando...');
        },
        success:function(datos){
    
          var msg = '';
          if(datos.hasOwnProperty('advertencia')){
            msg = mensaje_retro('warning','Advertencia',datos['advertencia']); 
          }else{
            if(datos.hasOwnProperty('error')){
              msg = mensaje_retro('danger','Error',datos['error']); 
            }
            else{
              msg = mensaje_retro('success','Bien hecho',datos['exito']);
              load(pagina);
            }

          }
         
    
          $('#resultados').html(msg);
        }
      })
    
    }


    
$( "#guardar_alumno" ).submit(function( event ) {

  $('#guardar_datos').attr("disabled", true);
  
  var nombres = $("#nombres").val();
  var apellidos = $("#apellidos").val();
  var rut_alumno = $("#rut_alumno").val();
  var fecha_nacimiento = $("#fecha_nacimiento").val();
  var correo_1 = $("#correo_1").val();
  var correo_2 = $("#correo_2").val();
  var telefono_alumno = $("#telefono_alumno").val();
  
  var action = 'ajax';

  $.ajax({
    type: "POST",
    url: "ajax/002001nuevo_alumno.php",
    data: { action: action,
            nombres: nombres,
            apellidos: apellidos,
            rut_alumno: rut_alumno,
            fecha_nacimiento: fecha_nacimiento,
            correo_1: correo_1,
            correo_2: correo_2,
            telefono_alumno: telefono_alumno},
    dataType:"json",
    beforeSend: function(objeto){
      $("#resultados_ajax").html('<img src="./img/ajax-loader.gif"> Cargando...');
    },
    success: function(datos){
      console.log(datos);

      var errores = '';
      var contenedor = '';
      var msg = '';
      var list_error = '';

      var class_contenedor_error = 'has-error has-feedback';
      var class_span_error = 'glyphicon glyphicon-remove form-control-feedback';

      var valores = ['nombres',
                     'apellidos',
                     'rut_alumno',
                     'fecha_nacimiento',
                    'correo_1',
                    'correo_2',
                'telefono_alumno'
              ];

      if(datos.hasOwnProperty('errores')){
        errores = datos['errores'];
      }
      else{

        msg = mensaje_retro('success','Bien hecho',datos['exito']);
        $("#resultados_ajax").html('');
        load(1);

      }

      for (var i = 0; i < valores.length; i++) {

        contenedor = $('#'+valores[i]).closest( ".form-group " );

   
          span = $('#'+valores[i]).siblings();

        if(errores.hasOwnProperty(valores[i])){
          list_error += '<li>'+errores[valores[i]]+'</li>';
          contenedor.addClass(class_contenedor_error);

     
            span.addClass(class_span_error);
        }
        else{
          span.removeClass(class_span_error);
          span.removeClass(class_span_error);
          contenedor.removeClass(class_contenedor_error);
        }

      }

      if( list_error != ''){

        msg += '<p> El formulario cuenta con los siguientes errores: </p>';
        msg += '<ul>'+list_error+'</ul>';
        msg = mensaje_retro('danger','Error',msg);
      }

      $("#resultados_ajax").html(msg);
      $('#guardar_datos').attr("disabled", false);

    }

  });

  event.preventDefault();

});

$('#editarAlumno').on('show.bs.modal', function (event) {

  var button = $(event.relatedTarget);
  var id_alumno = button.data('id_alumno');
  var nombres_alumno = button.data('nombres_alumno');
  var apellidos_alumno = button.data('apellidos_alumno');
  var rut_alumno = button.data('rut_alumno');
  var fecha_nacimiento = button.data('fecha_nacimiento');
  var correo_1 = button.data('correo_1');
  var correo_2 = button.data('correo_2');
  var telefono = button.data('telefono');

  $("#id_alumno").val(id_alumno);
  $("#nombres_editar").val(nombres_alumno);
  $("#apellidos_editar").val(apellidos_alumno);
  $("#rut_alumno_editar").val(rut_alumno);
  $("#fecha_nacimiento_editar").val(fecha_nacimiento);
  $("#correo_1_editar").val(correo_1);
  $("#correo_2_editar").val(correo_2);
  $("#telefono_alumno_editar").val(telefono);

});

$( "#editar_alumno" ).submit(function( event ) {

  $('#editar_datos').attr("disabled", true);
  
  var id_alumno = $("#id_alumno").val();
  var nombres_editar = $("#nombres_editar").val();
  var apellidos_editar = $("#apellidos_editar").val();
  var rut_alumno_editar = $("#rut_alumno_editar").val();
  var fecha_nacimiento_editar = $("#fecha_nacimiento_editar").val();
  var correo_1_editar = $("#correo_1_editar").val();
  var correo_2_editar = $("#correo_2_editar").val();
  var telefono_alumno_editar = $("#telefono_alumno_editar").val();
  var action = 'ajax';

  $.ajax({
    type: "POST",
    url: "ajax/002001editar_alumno.php",
    data: { action: action,
            id_alumno: id_alumno,
            nombres_editar: nombres_editar,
            apellidos_editar: apellidos_editar,
            rut_alumno_editar: rut_alumno_editar,
            fecha_nacimiento_editar: fecha_nacimiento_editar,
            correo_1_editar: correo_1_editar,
            correo_2_editar:correo_2_editar,
            telefono_alumno_editar: telefono_alumno_editar
          },
    dataType:"json",
    beforeSend: function(objeto){
      $("#resultados_ajax_editar").html('<img src="./img/ajax-loader.gif"> Cargando...');
    },
    success: function(datos){
console.log(datos);
      var errores = '';
      var contenedor = '';
      var msg = '';
      var list_error = '';

      var class_contenedor_error = 'has-error has-feedback';
      var class_span_error = 'glyphicon glyphicon-remove form-control-feedback';

      var valores = ['id_alumno_editar',
        'nombres_editar',
                     'apellidos_editar',
                     'rut_alumno_editar',
                     'fecha_nacimiento_editar',
                     'correo_1_editar',
                     'correo_2_editar',
                     'telefono_alumno_editar'];

      if(datos.hasOwnProperty('errores')){
        errores = datos['errores'];
      }
      else{

        msg = mensaje_retro('success','Bien hecho',datos['exito']);
        $("#resultados_ajax_editar").html('');
        load(1);

      }

      for (var i = 0; i < valores.length; i++) {

        contenedor = $('#'+valores[i]).closest( ".form-group " );

          span = $('#'+valores[i]).siblings();

        if(errores.hasOwnProperty(valores[i])){
          list_error += '<li>'+errores[valores[i]]+'</li>';
          contenedor.addClass(class_contenedor_error);

              span.addClass(class_span_error);
        }
        else{
          span.removeClass(class_span_error);
          span.removeClass(class_span_error);
          contenedor.removeClass(class_contenedor_error);
        }

      }

      if( list_error != ''){

        msg += '<p> El formulario cuenta con los siguientes errores: </p>';
        msg += '<ul>'+list_error+'</ul>';
        msg = mensaje_retro('danger','Error',msg);
      }

      $("#resultados_ajax_editar").html(msg);
      $('#editar_datos').attr("disabled", false);

    }

  });

  event.preventDefault();

});
      

    //Mensajes de retroalimentación
function mensaje_retro( tipo, titulo, texto){

  var msg = '';

  msg += '<div class="alert alert-'+tipo+' alert-dismissible" role="alert">';
  msg += '  <button type="button" class="close" data-dismiss="alert" aria-label="Close">';
  msg += '    <span aria-hidden="true">&times;</span>';
  msg += '  </button>';
  msg += '  <div class="row">';
  msg += '    <div class="col-md-2">';
  msg += '      <strong>¡'+titulo+'!</strong>';
  msg += '    </div>';
  msg += '    <div class="col-md-9">';
  msg +=        texto;
  msg += '    </div>';
  msg += '  </div>';
  msg += '</div>';


  return msg;          
} 