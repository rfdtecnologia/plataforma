<? session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Cambio de Clave</title>
<link href="SpryAssets/HojasEstilos.css" rel="stylesheet" type="text/css">
<meta name="generator" content="text/html">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<body>
<form action="ValidaClave.php" method="post">
    <?php
      include("../librerias/libs_sql.php");
      Conectar();
    include ('head.php');
      ?>

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
    <br></br>
    <p align="left" class="Mensajes">Ingrese Su Clave:</p>
    <table class="tbl" border="0" cellspacing="1" cellpadding="5"width="100%">
    <tr>
    <td width="13%" class="hr">CLAVE ANTERIOR:</td>
    <td class="dr">
    <span id="sprytextfield1">
      <input type="password" name="cla_ant">
    <span class="textfieldRequiredMsg">Obligatorio ingresar algun dato</span></span>
    </td>
    </tr>
    <tr>
    <td class="hr">CLAVE NUEVA:</td>
    <td class="dr">
    <span id="sprytextfield2">
      <input type="password" name="cla_nue">
    <span class="textfieldRequiredMsg">Obligatorio ingresar algun dato</span></span>
    </td>
    </tr>
    <tr>
      <td class="hr">CONFIRME SU CLAVE NUEVA:</td>
    <td class="dr">
    <span id="sprytextfield3">
      <input type="password" name="cla_con_nue">
    <span class="textfieldRequiredMsg">Obligatorio ingresar algun dato</span></span>
    </td>
    </tr>
    <tr>
      <td colspan="2"><label><input type="submit" name="button" id="button" value="Grabar"></label></td>
      </tr>
    </table>
    <br></br>
    <table class="bd" width="100%"><tr><td class="hr"></td></tr></table>
</form>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["blur"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["blur"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "none", {validateOn:["blur"]});
//-->
</script>
</body>
</html>
