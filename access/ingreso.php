<?php
include('funciones/include.php');

$id = base64_decode($_GET['v']);
$base = '';

head($title);
Conectar();
$infoAcceso = infoAcceso($id);
$title = 'RFD On-line: '.$infoAcceso[0];
$nombre_ingreso = $infoAcceso[0];
$redirect = $infoAcceso[1];
$_SESSION['principal'] = $redirect;
Desconectar();
if ($id !== '1') {
	$base = "C_USUARIO_GENERAL";//default
}else {
	$base = "C_USUARIO_ORGANIZACION";//para monitoreo
}
require('funciones/valida_usuario.php');
?>
<body>
	<div class="content_main">
		<?php include('menu.php'); ?>
		<div class="cont_r">
			<?php
      if ($error != '') {
        echo "<div class='alert alert-danger' role='alert'><p>$error</p></div>";
      }
      ?>
		<?php	login($nombre_ingreso);?>
		<?php
		if ($id == '1') {
			include('funciones/dias_p.php');
		?>
		<div class="alert alert-warning" role="alert"><?php echo $var_descripcion; echo $var_msg; echo "";?></div>
		<?php } ?>
		</div>
		<div class="clr"></div>
	</div>
	<script type="text/javascript">
	var clave = new Spry.Widget.ValidationTextField("clave", "none", {validateOn:["blur"]});
	var nombre = new Spry.Widget.ValidationTextField("nombre", "integer", {allowNegative:false, validateOn:["blur"],useCharacterMasking:true, minChars:10, maxChars:10});
	</script>
	<?php
	footer();
	?>
