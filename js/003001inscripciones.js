$(document).ready(function () {

  var fechaActual = new Date(); // Obtenemos la fecha actual
  
  $("#fecha_inicio").datetimepicker({
    date: null,
    viewMode: "days",
    format: "DD/MM/YYYY",
    locale: "es",
    minDate: 'now'
  });


  $("#fecha_pago").datetimepicker({
    date: null,
    viewMode: "days",
    format: "DD/MM/YYYY",
    locale: "es",
     minDate: 'now'
  });

  $("#fecha_inicio_editar").datetimepicker({
    date: null,
    viewMode: "days",
    format: "DD/MM/YYYY",
    locale: "es",
    minDate: 'now'
  });


  $("#fecha_pago_editar").datetimepicker({
    date: null,
    viewMode: "days",
    format: "DD/MM/YYYY",
    locale: "es",
     minDate: 'now'
  });



  //________________________obtener datos
$('#registroPago').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal 
  var id_pago_inscripcion = button.data('id_inscripcion');
  var precio_plan = button.data('precio_plan');
  var alumno_pago = button.data('id_alumno');

  $("#id_inscripcion_pago").val(id_pago_inscripcion);
  $("#monto_inicial").val(precio_plan);
  $("#monto_final").val(precio_plan);
  $("#alumno_pago").selectpicker("val", alumno_pago);
})

   // Detectar cambios en el monto inicial o el descuento
   $('#monto_inicial, #descuento').on('input', function () {
    // Obtener valores de los campos
    let montoInicial = parseFloat($('#monto_inicial').val()) || 0; // Si está vacío, usar 0
    let porcentajeDescuento = parseFloat($('#descuento').val()) || 0; // Si está vacío, usar 0

    // Calcular el descuento y el monto final
    let descuento = (montoInicial * porcentajeDescuento) / 100;
    let montoFinal = montoInicial - descuento;

    // Mostrar los resultados en los campos correspondientes
    $('#monto_final').val(montoFinal.toFixed(2)); // Redondear a 2 decimales
});

  // Detectar cambios en el monto inicial o el descuento
  $('#monto_inicial_editar, #descuento_editar').on('input', function () {
    // Obtener valores de los campos
    let montoInicial_editar = parseFloat($('#monto_inicial_editar').val()) || 0; // Si está vacío, usar 0
    let porcentajeDescuento_editar = parseFloat($('#descuento_editar').val()) || 0; // Si está vacío, usar 0

    // Calcular el descuento y el monto final
    let descuento_editar = (montoInicial_editar * porcentajeDescuento_editar) / 100;
    let montoFinal_editar = montoInicial_editar - descuento_editar;

    // Mostrar los resultados en los campos correspondientes
    $('#monto_final_editar').val(montoFinal_editar.toFixed(2)); // Redondear a 2 decimales
});

 // Formatea la fecha en el formato 'DD/MM/YYYY'
 var fechaFormateada = ("0" + fechaActual.getDate()).slice(-2) + "/" + ("0" + (fechaActual.getMonth() + 1)).slice(-2) + "/" + fechaActual.getFullYear();

 // Establece la fecha formateada como valor del elemento con el id "fecha_declaracion"
 $('#fecha_inicio').val(fechaFormateada);
 $('#fecha_pago').val(fechaFormateada);

 
 $("#plan_editar").on("change", function () {
  var idPlan = $(this).val(); // Obtiene el ID del plan seleccionado

  // Realiza la solicitud AJAX
  $.ajax({
      url: "./ajax/003001buscar_monto.php", // Archivo PHP
      type: "POST",
      data: { id_plan: idPlan },
      dataType: "json", // Indica que esperas un JSON
      success: function (response) {
          if (response.precio_plan) {
              var montoInicial = parseInt(response.precio_plan);

              // Habilita el campo si está deshabilitado
              $("#monto_inicial_editar").prop("disabled", false);
              $("#monto_inicial_editar").val(montoInicial.toFixed(2)); // Actualiza el campo de monto inicial
              $("#monto_final_editar").val(montoInicial.toFixed(2)); // Opcional: Actualiza el monto final
          } else if (response.error) {
              alert(response.error); // Maneja el error
          }
      },
      error: function () {
          alert("Error al obtener los datos. Intenta nuevamente.");
      },
  });
});


   //Opciones input de subir fotografias
   $("#archivo_adjunto").fileinput({
    language: "es",
     browseClass: "btn btn-primary",
    allowedFileExtensions:["xlsx", "xls", "docx", "doc", "ppt", "pptx", "jpg", "jpeg", "png", "txt", "csv", "pdf"],
    maxFileCount: 5, // Establece el máximo número de archivos permitidos
    maxFileSize: 10000,
    removeFromPreviewOnError: true,

  });

  
    load(1);
});

function load(page) {
  var q = $("#q").val();
  $("#loader").fadeIn("slow");
  $.ajax({
    url:
      "./ajax/003001buscar_inscripciones.php?action=ajax&page=" +
      page +
      "&q=" +
      q,
    beforeSend: function (objeto) {
      $("#loader").html('<img src="./img/ajax-loader.gif"> Cargando...');
    },
    success: function (data) {
      $(".outer_div").html(data).fadeIn("slow");
      $("#loader").html("");
    },
  });
}

$("#guardar_inscripcion").submit(function (event) {
  $("#guardar_datos").attr("disabled", true);

  var alumno = $("#alumno").val();
  var plan = $("#plan").val();

  var action = "ajax";

  $.ajax({
    type: "POST",
    url: "ajax/003001nueva_inscripcion.php",
    data: {
      action: action,
      alumno: alumno,
      plan: plan
    },
    dataType: "json",
    beforeSend: function (objeto) {
      $("#resultados_ajax").html(
        '<img src="./img/ajax-loader.gif"> Cargando...'
      );
    },
    success: function (datos) {
      console.log(datos);
      var errores = '';
      var contenedor = '';
      var msg = '';
      var list_error = '';
      var class_contenedor_error = 'has-error has-feedback';
      var class_span_error = 'glyphicon glyphicon-remove form-control-feedback';
      var valores = ["alumno",
        "plan",
        'update'];

      if (datos.hasOwnProperty('errores')) {
        errores = datos['errores'];
      }
      else {
        msg = mensaje_retro('success', 'Bien hecho', datos['exito']);
        $("#resultados_ajax").html('');
        load(1);
      }

      for (var i = 0; i < valores.length; i++) {
        contenedor = $('#' + valores[i]).closest(".form-group ");
        if (valores[i] != 'alumno' && valores[i] != 'plan')
          span = $('#' + valores[i]).siblings();

        if (errores.hasOwnProperty(valores[i])) {
          list_error += '<li>' + errores[valores[i]] + '</li>';
          contenedor.addClass(class_contenedor_error);
          if (valores[i] != 'alumno' && valores[i] != 'plan')            
          span.addClass(class_span_error);
        }
        else {
          span.removeClass(class_span_error);
          span.removeClass(class_span_error);
          contenedor.removeClass(class_contenedor_error);
        }
      }
      if (list_error != '') {

        msg += '<p> El formulario cuenta con los siguientes errores: </p>';
        msg += '<ul>' + list_error + '</ul>';
        msg = mensaje_retro('danger', 'Error', msg);
      }
      $("#resultados_ajax").html(msg);
      $("#guardar_datos").attr("disabled", false);

    }
  }
);
event.preventDefault();
}
)

$("#editarInscripcion").on("show.bs.modal", function (event) {
  var button = $(event.relatedTarget);
  var id_inscripcion = button.data("id_inscripcion");
  var id_alumno = button.data("id_alumno");
  var id_forma_pago = button.data("id_forma_pago");
  var id_plan = button.data("id_plan");
  var fecha_inicio = button.data("fecha_inicio");
  var fecha_pago = button.data("fecha_pago");
  var precio_plan = button.data("precio_plan");
  var descuento = button.data("descuento");

  $("#id_inscripcion").val(id_inscripcion);
  $("#alumno_editar").selectpicker("val", id_alumno);
  $("#forma_pago_editar").selectpicker("val", id_forma_pago);
  $("#plan_editar").selectpicker("val", id_plan);
  $("#fecha_inicio_editar").val(fecha_inicio);
  $("#fecha_pago_editar").val(fecha_pago);
  $("#monto_inicial_editar").val(precio_plan);
  $("#descuento_editar").val(descuento);
  $("#monto_final_editar").val(precio_plan);
});

$("#editar_inscripcion").submit(function (event) {
  $("#editar_datos").attr("disabled", true);

  var id_inscripcion = $("#id_inscripcion").val();
  var forma_pago_editar = $("#forma_pago_editar").val();
  var plan_editar = $("#plan_editar").val();
  var fecha_inicio_editar = $("#fecha_inicio_editar").val();
  var fecha_pago_editar = $("#fecha_pago_editar").val();

  var action = "ajax";

  $.ajax({
    type: "POST",
    url: "ajax/003001editar_inscripcion.php",
    data: {
      action: action,
      id_inscripcion: id_inscripcion,
      forma_pago_editar: forma_pago_editar,
      plan_editar: plan_editar,
      fecha_inicio_editar: fecha_inicio_editar,
      fecha_pago_editar: fecha_pago_editar,
    },
    dataType: "json",
    beforeSend: function (objeto) {
      $("#resultados_ajax_ins").html(
        '<img src="./img/ajax-loader.gif"> Cargando...'
      );
    },
    success: function (datos) {
      console.log(datos);
      var errores = "";
      var contenedor = "";
      var msg = "";
      var list_error = "";
      var class_contenedor_error = "has-error has-feedback";
      var class_span_error = "glyphicon glyphicon-remove form-control-feedback";
      var valores = [
        "forma_pago_editar",
        "plan_editar",
        "fecha_inicio_editar",
        "fecha_pago_editar",
        "update"
      ];

      if (datos.hasOwnProperty("errores")) {
        errores = datos["errores"];
      } else {
        msg = mensaje_retro("success", "Bien hecho", datos["exito"]);
        $("#resultados_ajax_ins").html("");
        load(1);
      }

      for (var i = 0; i < valores.length; i++) {
        contenedor = $("#" + valores[i]).closest(".form-group ");

      
          span = $("#" + valores[i]).siblings();

        if (errores.hasOwnProperty(valores[i])) {
          list_error += "<li>" + errores[valores[i]] + "</li>";
          contenedor.addClass(class_contenedor_error);

        
            span.addClass(class_span_error);
        } else {
          span.removeClass(class_span_error);
          span.removeClass(class_span_error);
          contenedor.removeClass(class_contenedor_error);
        }
      }

      if (list_error != "") {
        msg += "<p> El formulario cuenta con los siguientes errores: </p>";
        msg += "<ul>" + list_error + "</ul>";
        msg = mensaje_retro("danger", "Error", msg);
      }

      $("#resultados_ajax_ins").html(msg);
      $("#editar_datos").attr("disabled", false);
    },
  });

  event.preventDefault();
});



$("#guardar_pago").submit(function (event) {
  $("#guardar_pagos").attr("disabled", true);

  var id_inscripcion_pago = $("#id_inscripcion_pago").val();  
  var forma_pago = $("#forma_pago").val();
  var fecha_inicio = $("#fecha_inicio").val();
  var fecha_pago = $("#fecha_pago").val();
  var monto_inicial = $("#monto_inicial").val();
  var descuento = $("#descuento").val();
  var monto_final = $("#monto_final").val();

  var action = "ajax";

  $.ajax({
    type: "POST",
    url: "ajax/003001nuevo_pago.php",
    data: {
      action: action,
      id_inscripcion_pago: id_inscripcion_pago,
      forma_pago: forma_pago,
      fecha_inicio: fecha_inicio,
      fecha_pago: fecha_pago,
      monto_inicial: monto_inicial,
      descuento: descuento,
      monto_final: monto_final

    },
    dataType: "json",
    beforeSend: function (objeto) {
      $("#resultados_ajax").html(
        '<img src="./img/ajax-loader.gif"> Cargando...'
      );
    },
    success: function (datos) {
      console.log(datos);
      var errores = "";
      var contenedor = "";
      var msg = "";
      var list_error = "";

      var class_contenedor_error = "has-error has-feedback";
      var class_span_error = "glyphicon glyphicon-remove form-control-feedback";

      var valores = [
        "id_inscripcion_pago",
        "forma_pago",
        "fecha_inicio",
        "fecha_pago",
        "monto_inicial",
        "insert"
      ];

      if (datos.hasOwnProperty("errores")) {
        errores = datos["errores"];
      } else {
        msg = mensaje_retro("success", "Bien hecho", datos["exito"]);
        $("#resultados_ajax").html("");
        load(1);
      }

      for (var i = 0; i < valores.length; i++) {
        contenedor = $("#" + valores[i]).closest(".form-group ");

       
          span = $("#" + valores[i]).siblings();

        if (errores.hasOwnProperty(valores[i])) {
          list_error += "<li>" + errores[valores[i]] + "</li>";
          contenedor.addClass(class_contenedor_error);

          
            span.addClass(class_span_error);
        } else {
          span.removeClass(class_span_error);
          span.removeClass(class_span_error);
          contenedor.removeClass(class_contenedor_error);
        }
      }

      if (list_error != "") {
        msg += "<p> El formulario cuenta con los siguientes errores: </p>";
        msg += "<ul>" + list_error + "</ul>";
        msg = mensaje_retro("danger", "Error", msg);
      }

      $("#resultados_ajax").html(msg);
      $("#guardar_pagos").attr("disabled", false);
    },
  });

  event.preventDefault();
});

function cambiar_estado(id,pagina,pago){

  var action = 'ajax';

  $.ajax({
    type: "POST",
    url:"./ajax/003001cambiar_estado.php",
    data: { action: action,
            id: id,
          pago:pago},
    dataType:"json",
    beforeSend: function(objeto){
      $('#resultados').html('<img src="./img/ajax-loader.gif"> Cargando...');
    },
    success:function(datos){

      var msg = '';

      if(datos.hasOwnProperty('advertencia')){
        msg = mensaje_retro('warning','Aadvertencia',datos['advertencia']); 

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


function eliminar (id)
{
if (confirm("Realmente deseas eliminar la inscripción")){	
$.ajax({
type: "GET",
url: "./ajax/003001eliminar_inscripcion.php",
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

$("#postergar").on("show.bs.modal", function (event) {
  var button = $(event.relatedTarget);
  var id_inscripcion = button.data("id_inscripcion");
  var id_alumno = button.data("id_alumno");
  var id_plan = button.data("id_plan");

  $("#id_inscripcion_postergar").val(id_inscripcion);
  $("#alumno_postergar").selectpicker("val", id_alumno);
  $("#plan_postergar").selectpicker("val", id_plan);

});

//Mensajes de retroalimentación
function mensaje_retro(tipo, titulo, texto) {
  var msg = "";

  msg +=
    '<div class="alert alert-' + tipo + ' alert-dismissible" role="alert">';
  msg +=
    '  <button type="button" class="close" data-dismiss="alert" aria-label="Close">';
  msg += '    <span aria-hidden="true">&times;</span>';
  msg += "  </button>";
  msg += '  <div class="row">';
  msg += '    <div class="col-md-2">';
  msg += "      <strong>¡" + titulo + "!</strong>";
  msg += "    </div>";
  msg += '    <div class="col-md-9">';
  msg += texto;
  msg += "    </div>";
  msg += "  </div>";
  msg += "</div>";

  return msg;
}
