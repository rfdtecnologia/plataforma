<? session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Validacion Clave</title>
<link href="SpryAssets/HojasEstilos.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
	include('../librerias/libs_sql.php');
	Conectar();
	$var_nombre_usuario = $_SESSION["nombre_usuario"];
	$fecha = fecha();
	$var_usuario = $_SESSION['usuario_id'];
	$var_organizacion =$_SESSION['usuario_organizacion'];
	$var_periodo = $_SESSION["var_periodo"];
	$var_imagen = "../imagenes/".$_SESSION["var_organizacion"].".jpg";
	$var_cla = strtoupper(trim($_SESSION["clave_usuario"]));
	$var_cla_ant = strtoupper(trim($_POST['cla_ant']));
	$var_cla_nue = strtoupper(trim($_POST['cla_nue']));
	$var_cla_con_nue = strtoupper(trim($_POST['cla_con_nue']));
	$var_perfil = $_SESSION["perfil_usuario"];
	settype($var_cla,'string');
	settype($var_cla_ant,'string');
	settype($var_cla_nue,'string');
	settype($var_cla_con_nue,'string');
?>
<table class="bd" width="100%"><tr><td class="hr"><h2>RFD-ONLINE</h2></td></tr></table>
<div align="center"><a href="MenuPrincipal.php" class="btn_menu">Menu Principal</a></div>
<table width="100%" border="0">
  <tr>
  	<?php
	$var_imagen = "../imagenes/".$_SESSION["var_organizacion"].".jpg";
	$var_titulo = "CAMBIO DE CLAVE";
		$var_logo_ancho = $_SESSION["var_logo_ancho"];
		$var_logo_alto = $_SESSION["var_logo_alto"];
		if (empty($_SESSION["var_web_organizacion"]))
		{
			?><td width="50%" height="102"><div align="left"><img src="<?php echo $var_imagen; ?>" alt="" width="<?php echo $var_logo_ancho?>" height="<?php echo $var_logo_alto?>" /></a></div></td><?php
		}
		else
		{
			echo '<td width="50%" height="102"><div align="left"><a href="'.$_SESSION["var_web_organizacion"].'" target="_blank"><img src="'.$var_imagen.'" alt="" width="'.$var_logo_ancho.'" height="'.$var_logo_alto.'" /></a></a></div></td>';
		}
		?>
		<td width="0%">
		  <p align="center" class="Mensajes"><?php echo $var_titulo; ?></p>
		</td>
		<td width="50%"><div align="right"><a href="http://www.rfr.org.ec/" target="_blank"><img src="../imagenes/logo_rfr.jpg" alt="" width="95" height="95" /></a></div></td>
	  </tr>
	</table>
	<p class="Mensajes">Miembro: <?php echo strtoupper($_SESSION["var_nombre_organizacion"]); ?></p>
	<p class="Mensajes">Periodo: <?php echo strtoupper($_SESSION["var_nombre_periodo"]); ?></p>
    <br></br>
<?
/* 	echo $var_cla;
	echo $var_cla_ant;
	echo $var_cla_nue;
	echo $var_cla_con_nue; */
	$var_graba = "SU CLAVE NO SE CAMBIO EXISTIERON ERRORES AL INGRESAR SUS DATOS";
	$sw = false;
	if ($var_cla == $var_cla_ant)
	{
 		if($var_cla_nue == $var_cla_con_nue)
		{
			$sw = true;
			$var_graba = "SU CLAVE SE CAMBIO CON ÉXITO";
		}
 	}
	if ($sw)
	{
		if ($var_perfil == 1)
		{
			$query="update C_USUARIO_ORGANIZACION SET CLAVE_USUARIO = '$var_cla_con_nue' WHERE USUARIO_ID = '$var_usuario'";
		}
		else
		{
			$query="update C_USUARIO_ORGANIZACION SET CLAVE_USUARIO = '$var_cla_con_nue' WHERE USUARIO_ID = '$var_usuario' AND ORGANIZACION_ID = $var_organizacion";
		}
		Actualizar($query);
		?>
			<span class="Bien"><?php echo $var_graba;?></span>
            <!--<a href="Login.php">Login</a>-->
		<?php
        header( "refresh:2;url=cerrar_sesion.php" );
	}
	else
	{
		?>
			<span class="Mal"><?php echo $var_graba;?></span>
            <!--<a href="CambioClave.php">Cambio de Clave</a>-->
		<?php
        header( "refresh:2;url=CambioClave.php" );
	}
	Desconectar();
?>
<br>
<br />
<table class="bd" width="100%"><tr><td class="hr"></td></tr></table>
</body>
</html>
