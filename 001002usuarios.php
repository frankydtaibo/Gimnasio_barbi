<?php
  /*-------------------------
  Autor: Frank Taibo
  Cod Menu: 001
  Cod Item Menu:002
  ---------------------------*/
  session_start();
  if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
    exit;
        }

  /* Connect To Database*/ 
  require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
  require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
    $active_usuarios="active";  
  $title="Usuarios";
  if (isset($title))
    {
      
      $user_perfil_id=$_SESSION['user_perfil_id'];
      $menu_cod='001';
      $menu_item_cod='002';
    }
    include("modal/valida_permiso.php");
  
?>
<!DOCTYPE html>
<html lang="en">
  <head>
  <?php include("head.php");?>
  </head>
  <body>
  <?php
  include("navbar.php");
  ?> 
    <div class="container">
    <div class="panel panel-primary">
    <div class="panel-heading">
        <div class="btn-group pull-right">
        <button type='button' class="btn btn-success" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-plus" ></span> Nuevo Usuario</button>
      </div>
      <h4><i class='icon-usuarios icono-titulo'></i> Usuarios</h4>
    </div>      
      <div class="panel-body">
      <?php
      include("modal/001002editar_usuarios.php");
      include("modal/001002registro_usuarios.php");
      include("modal/001002ver_usuarios.php");
     /*  
      
      
      require_once("modal/001002cambiar_password.php");
      
      */ ?>
      <form class="form-horizontal" role="form" id="datos_cotizacion">
        
            <div class="form-group row">
              <label for="q" class="col-md-1 control-label">Nombres:</label>
              <div class="col-md-5">
                <input type="text" class="form-control" id="q" placeholder="Nombre" onkeyup='load(1);'>
              </div>
              
              
              
              <div class="col-md-3">
                <button type="button" class="btn btn-default" onclick='load(1);'>
                  <span class="glyphicon glyphicon-search" ></span> Buscar</button>
                <span id="loader"></span>
              </div>
              
            </div>
        
        
        
      </form>
        <div id="resultados"></div><!-- Carga los datos ajax -->
        <div class='outer_div'></div><!-- Carga los datos ajax -->
            
      </div>
    </div>

  </div>
  <hr>
  <?php
  include("footer.php");
  ?>
  <script type="text/javascript" src="js/001002usuarios.js"></script>

  
  


  </body>
</html>
<script>
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

  function obtener_datos(id){

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




    
</script>

