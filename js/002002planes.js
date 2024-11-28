$(document).ready(function(){

    $('#vigencia_plan').datetimepicker({
        date: null,
        viewMode: 'days',
        format: 'DD/MM/YYYY',
        locale: 'es'
      });

      $('#vigencia_plan_editar').datetimepicker({
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
          url:'./ajax/002002buscar_planes.php?action=ajax&page='+page+'&q='+q,
           beforeSend: function(objeto){
           $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
        },
          success:function(data){
              $(".outer_div").html(data).fadeIn('slow');
              $('#loader').html('');
              
          }
      })
  }
  
     
$( "#guardar_plan" ).submit(function( event ) {

    $('#guardar_datos').attr("disabled", true);
    
    var nombre_plan = $("#nombre_plan").val();
    var descripcion_plan = $("#descripcion_plan").val();
    var duracion_plan = $("#duracion_plan").val();
    var precio_plan = $("#precio_plan").val();
 
    var action = 'ajax';
  
    $.ajax({
      type: "POST",
      url: "ajax/002002nuevo_plan.php",
      data: { action: action,
              nombre_plan: nombre_plan,
              descripcion_plan: descripcion_plan,
              duracion_plan: duracion_plan,
              precio_plan: precio_plan},
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
  
        var valores = ['nombre_plan',
                       'descripcion_plan',
                       'duracion_plan',
                      'precio_plan'
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


  function cambiar_estado(id,pagina){

    var action = 'ajax';
  
    $.ajax({
      type: "POST",
      url:"./ajax/002002cambiar_estado.php",
      data: { action: action,
              id: id},
      dataType:"json",
      beforeSend: function(objeto){
        $('#resultados').html('<img src="./img/ajax-loader.gif"> Cargando...');
      },
      success:function(datos){
  
        var msg = '';
  
        if(datos.hasOwnProperty('error')){
          msg = mensaje_retro('danger','Error',datos['error']); 
        }
        else{
          msg = mensaje_retro('success','Bien hecho',datos['exito']);
          load(pagina);
        }
  
        $('#resultados').html(msg);
      }
    })
  
  }


  
$('#editarPlan').on('show.bs.modal', function (event) {

  var button = $(event.relatedTarget);
  var id_plan = button.data('id_plan');
  var nombre_plan = button.data('nombre_plan');
  var descripcion_plan = button.data('descripcion_plan');
  var duracion_plan = button.data('duracion_plan');
  var precio_plan = button.data('precio_plan');

  $("#id_plan").val(id_plan);
  $("#nombre_plan_editar").val(nombre_plan);
  $("#descripcion_plan_editar").val(descripcion_plan);
  $("#duracion_plan_editar").val(duracion_plan);
  $("#precio_plan_editar").val(precio_plan);

});


$( "#editar_plan" ).submit(function( event ) {

  $('#editar_datos').attr("disabled", true);
  
  var id_plan = $("#id_plan").val();
  var descripcion_plan_editar = $("#descripcion_plan_editar").val();
  var duracion_plan_editar = $("#duracion_plan_editar").val();
  var precio_plan_editar = $("#precio_plan_editar").val();
  var action = 'ajax';

  $.ajax({
    type: "POST",
    url: "ajax/002002editar_plan.php",
    data: { action: action,
            id_plan: id_plan,
            descripcion_plan_editar: descripcion_plan_editar,
            duracion_plan_editar: duracion_plan_editar,
            precio_plan_editar: precio_plan_editar
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

      var valores = ['id_plan_editar',
        'descripcion_plan_editar',
                     'duracion_plan_editar',
                     'precio_plan_editar'];

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


function eliminar (id)
{
if (confirm("Realmente deseas eliminar el plan")){	
$.ajax({
type: "GET",
url: "./ajax/002002eliminar_plan.php",
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