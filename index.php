<?php
session_start();
include('core/class/usuario.php');
$usuario = new Usuario();
?>
<DOCTYPE html>
<html lang="es_VE">
<head>
	<title><?php echo $usuario->tituloVentana; ?></title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="core/css/estilo.css">
</head>
<body>
	<header>
      <?php
      $usuario->accesoUsuario();   
      ?>
	</header>
	<section>
		<?php
		$usuario->contenidoUsuario();
		?>
	</section>
	<footer></footer>
</body>
</html>