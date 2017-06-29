<? session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Validacion CUC</title>
<link href="SpryAssets/HojasEstilos.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
	include('../librerias/libs_sql.php');
	Conectar();
	$var_nombre_usuario = $_SESSION["nombre_usuario"];
	$fecha = fecha();
	$var_usuario = $_SESSION['usuario_id'];
	$var_organizacion = $_SESSION["var_organizacion"];
	$var_periodo = $_SESSION["var_periodo"];
	$var_imagen = "../imagenes/".$_SESSION["var_organizacion"].".jpg";
	$var_cuc = $_POST['var_cuc'];
	if ($var_cuc == 1)
	{
		$var_rubro = 4;
	}
	else
	{
		$var_rubro = 5;
	}
	$consultar="SELECT *
				FROM dbo.C_ORGANIZACION
				WHERE
				ORGANIZACION_ID = $var_organizacion";
	$resultado=ConsultarTabla($consultar);
	$var_estatuto = mssql_result($resultado,$i,"TIPO_ORGANIZACION_ID");
?>
<?php
include ('head.php');
?>
<div align="center"><a href="MenuPrincipal.php" class="btn_menu">Menu Principal</a></div>
<table width="100%" border="0">
  <tr>
  	<?php
	$var_imagen = "../imagenes/".$_SESSION["var_organizacion"].".jpg";
	switch($var_cuc)
	{
		case 1:
			$var_titulo = "CUC UN CUERPO";
			break;
		case 2:
			$var_titulo = "CUC DOS CUERPOS";
			break;
	}
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
<br><br />
<?
	Ftp();
	$ip = $_SESSION['ip'];
	$puerto = $_SESSION['puerto'];
	$usuario = $_SESSION['usuario'];
	$clave = $_SESSION['clave'];
//	$var_file_org = "00000".$_SESSION['var_organizacion'];
	$local =  $_FILES['file']['tmp_name'];
	//nombre del archivo escogido para subir... el cual vamos a utlizarlo para nombrar el archivo que quedará en el server FTP
	//$remoto = $_FILES['file']['name'];
	if($var_estatuto <> 11)
	{
		$remoto = "E_".substr("00000".$_SESSION['var_organizacion'],-5)."_".$_SESSION['var_periodo']."_cuc".$var_cuc.".xls";
	}
	else
	{
		$remoto = "E_".substr("00000".$_SESSION['var_organizacion'],-5)."_".$_SESSION['var_periodo']."_cucrfr.xls";
	}
	$carpetaFtp="/";


	$id_ftp = ftp_connect($ip,$puerto);
	ftp_login ($id_ftp, $usuario, $clave);
	ftp_pasv ($id_ftp, false);

	//carpeta donde vamos a dejar el archivo
	ftp_chdir ($id_ftp,$carpetaFtp);
	if (@ftp_put($id_ftp,$remoto,$local,FTP_BINARY))
	{
		$var_graba = "SUS DATOS SE ENVIARON CON ÉXITO";
		?>
			<span class="Bien"><?php echo $var_graba;?></span>
		<?php
		$query="update C_NOVEDAD SET
				ESTADO_ID = 1, USUARIO_ID = $var_usuario, HORA_NOVEDAD = '$fecha', DESCRIPCION_NOVEDAD = '$var_graba', NOMBRE_USUARIO = '$var_nombre_usuario'
				WHERE
				PERIODO_ID = $var_periodo AND
				ORGANIZACION_ID = $var_organizacion AND
				MENU_ID = $var_rubro";
	}
	else
	{
		$var_graba = "SUS DATOS NO SE ENVIARON";
		?>
			<span class="Mal"><?php echo $var_graba;?></span>
		<?php
		$query="update C_NOVEDAD SET
				ESTADO_ID = 2, USUARIO_ID = $var_usuario, HORA_NOVEDAD = '$fecha', DESCRIPCION_NOVEDAD = '$var_graba', NOMBRE_USUARIO = '$var_nombre_usuario'
				WHERE
				PERIODO_ID = $var_periodo AND
				ORGANIZACION_ID = $var_organizacion AND
				MENU_ID = $var_rubro";
	}
	Actualizar($query);
	Desconectar();
	ftp_quit($id_ftp);
?>
<br><br />
<table class="bd" width="100%"><tr><td class="hr"></td></tr></table>
</body>
</html>
