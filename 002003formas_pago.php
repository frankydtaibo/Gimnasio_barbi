<?php
  /*-------------------------
  Autor: Frank Taibo
  Cod Menu: 002
  Cod Item Menu:003
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
  $title="Formas de Pagos";
  if (isset($title))
    {
      
      $user_perfil_id=$_SESSION['user_perfil_id'];
      $menu_cod='002';
      $menu_item_cod='003';
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
       
      <h4><i class='icon-validacion icono-titulo'></i> Formas de Pagos</h4>
    </div>      
      <div class="panel-body">
     
      <span id="loader"></span>
        <div id="resultados"></div><!-- Carga los datos ajax -->
        <div class='outer_div'></div><!-- Carga los datos ajax -->
            
      </div>
    </div>

  </div>
  <hr>
  <?php
  include("footer.php");
  ?>
  <script type="text/javascript" src="js/002003formas_pago.js"></script>


  </body>
</html>