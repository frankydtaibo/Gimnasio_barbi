<?php
  /*-------------------------
  Autor: Frank Taibo
  Cod Menu: 002
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
  $title="Planes";
  if (isset($title))
    {
      
      $user_perfil_id=$_SESSION['user_perfil_id'];
      $menu_cod='002';
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
        <button type='button' class="btn btn-success" data-toggle="modal" data-target="#nuevo_plan"><span class="glyphicon glyphicon-plus" ></span> Nuevo Plan</button>
      </div>
      <h4><i class='icon-validacion icono-titulo'></i> Planes</h4>
    </div>      
      <div class="panel-body">
      <?php
    
include("modal/002002registro_planes.php");
       
     include("modal/002002editar_plan.php");
     /* include("modal/001002ver_usuarios.php");
      
      require_once("modal/001002cambiar_password.php");
      
      */ ?>
      <form class="form-horizontal" role="form" id="datos_cotizacion">
        
            <div class="form-group row">
              <label for="q" class="col-md-1 control-label">Plan:</label>
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
  <script type="text/javascript" src="js/002002planes.js"></script>


  </body>
</html>