$(document).ready(function(){

      load(1);
  
  });

  function load(page){
    
    $("#loader").fadeIn('slow');
    $.ajax({
        url:'./ajax/002003buscar_formas_pagos.php?action=ajax&page='+page,
         beforeSend: function(objeto){
         $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
      },
        success:function(data){
            $(".outer_div").html(data).fadeIn('slow');
            $('#loader').html('');
            
        }
    })
}


function cambiar_estado(id){

    var action = 'ajax';
  
    $.ajax({
      type: "POST",
      url:"./ajax/002003cambiar_estado.php",
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
          load(1);
        }
  
        $('#resultados').html(msg);
      }
    })
  
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