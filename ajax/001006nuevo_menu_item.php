<?php
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
// checking for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
  exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
  // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
  // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
  require_once("../libraries/password_compatibility_library.php");
}   
  if (empty($_POST['descripcion_i'])){
    $errors[] = "Descripcion vacíos";
  } elseif (
    !empty($_POST['descripcion_i'])
    && strlen($_POST['descripcion_i']) >= 2
    && strlen($_POST['descripcion_i']) <= 40
    //&& !empty($_POST['user_consulta'])
  ) {
    require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	  require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	
		// escaping, additionally removing everything that could be (html/javascript-) code
    $menu_item_descripcion = mysqli_real_escape_string($con,(strip_tags($_POST["descripcion_i"],ENT_QUOTES)));
    $menu_id = mysqli_real_escape_string($con,(strip_tags($_POST["menu_i"],ENT_QUOTES)));
    $menu_item_url = mysqli_real_escape_string($con,(strip_tags($_POST["url_i"],ENT_QUOTES)));
    $menu_item_tipo = isset($_POST['tipo_i']) ? 1 : 0;
    $menu_item_estado = isset($_POST['estado_i']) ? 1 : 0;
    $menu_item_interno = isset($_POST['interno_i']) ? 1 : 0;
    $menu_item_cod = mysqli_real_escape_string($con,(strip_tags($_POST["codigo_i"],ENT_QUOTES)));
    $menu_item_orden = mysqli_real_escape_string($con,(strip_tags($_POST["orden_i"],ENT_QUOTES)));
    $menu_item_icono = mysqli_real_escape_string($con,(strip_tags($_POST["icono_i"],ENT_QUOTES)));

    $sql_icono = mysqli_query($con,"select icono from icono where icono_id ='".$menu_item_icono."';");
    $row_icon=mysqli_fetch_array($sql_icono);

    $sql_val = "SELECT m.menu_descripcion
                FROM menu_item AS mi
                JOIN menu AS m ON mi.menu_id = m.menu_id
                WHERE mi.menu_id = $menu_id
                AND mi.menu_item_cod = $menu_item_cod";

    $query_val = mysqli_query($con,$sql_val);

    if($query_val){

      $count_query = mysqli_num_rows($query_val);

      if($count_query == 0){

        $sql_list = "SELECT *
                     FROM menu_item
                     WHERE menu_id = $menu_id
                     ORDER BY menu_item_orden ASC";

        //Obtengo los menus items ordenados segun su orden designado
        $query_list = mysqli_query($con, $sql_list);

        $orden_item_menus = array();

        //Almaceno los ids en un arreglo
        while( $fila = mysqli_fetch_array ($query_list) )
          array_push( $orden_item_menus, $fila['menu_item_id'] );


        //Añado un ids "0" en su futura posición en el arreglo
        array_splice( $orden_item_menus, $menu_item_orden-1, 0, 0 );

        //Actualizo los ids que se desplazaran por el ingreso del nuevo valor
        foreach ($orden_item_menus as $key) {
          
          $pos = array_search($key, $orden_item_menus);

          if($key != 0){
            $sql_update = "UPDATE menu_item SET menu_item_orden='".($pos+1)."' WHERE menu_item_id='".$key."'";
            $query_update = mysqli_query($con,$sql_update);
          }
          else{
            $menu_item_orden = $pos+1;
          }

        }

        $sql_insert = "INSERT INTO menu_item (menu_id, menu_item_descripcion, menu_item_tipo, menu_item_url, menu_item_interno, menu_item_estado, menu_item_cod,menu_item_icono, menu_item_orden)
            VALUES('".$menu_id."','".$menu_item_descripcion."','" . $menu_item_tipo."','" . $menu_item_url . "', '" . $menu_item_interno . "','".$menu_item_estado."','".$menu_item_cod."','".$row_icon['icono']."','".$menu_item_orden."');";
        $query_new_user_insert = mysqli_query($con,$sql_insert);

        if ($query_new_user_insert) {
            $messages[] = "El menú ítem ha sido creado con éxito.";
        } else {
          $errors[] = "Lo sentimos, el registro falló. Por favor, regrese y vuelva a intentarlo.";
        }

      }else{

        $fila_val = mysqli_fetch_array($query_val);
        $nombre_menu = $fila_val['menu_descripcion'];

        $errors[] ="Lo sentimos, ya existe un menú item con el código '$menu_item_cod' para el menú '$nombre_menu'.";
      }


    }else{
      $errors[] = "Lo sentimos, no ha elegido un menú para el menú ítem.";
    }
            
        
  } else {
    $errors[] = "Un error desconocido ocurrió.";
  }

if (isset($errors)){
	
	?>
	<div class="alert alert-danger" role="alert">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong>¡Error!</strong> 
			<?php
				foreach ($errors as $error) {
						echo $error;
					}
				?>
	</div>
	<?php
	}
	if (isset($messages)){
		
		?>
		<div class="alert alert-success" role="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>¡Bien hecho!</strong>
				<?php
					foreach ($messages as $message) {
							echo $message;
						}
					?>
		</div>
		<?php
	}

?>