<? session_start(); ?>
<html>
<head>
<title>Cuc Dos Cuerpos</title>
<meta name="generator" content="text/html">
<link href="SpryAssets/HojasEstilos.css" rel="stylesheet" type="text/css">
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php 
	$var_imagen = "../imagenes/".$_SESSION["var_organizacion"].".jpg";
?>
<?php
include ('head.php');
?>
<div align="center"><a href="MenuPrincipal.php">Menu Principal</a>
</div>
<table width="100%" border="0">
  <tr>
  	<?php 
	if (empty($_SESSION["var_web_organizacion"]))
	{
		?><td height="102"><div align="left"><img src="<?php echo $var_imagen; ?>" alt="" width="95" height="95" /></a></div></td><?php
	}
	else
	{
		echo '<td height="102"><div align="left"><a href="'.$_SESSION["var_web_organizacion"].'" target="_blank"><img src="'.$var_imagen.'" alt="" width="95" height="95" /></a></a></div></td>'; 
	}
	?>
    <td><div align="right"><a href="http://www.rfr.org.ec/" target="_blank"><img src="../imagenes/logo_rfr.jpg" alt="" width="95" height="95" /></a></div></td>
  </tr>
</table>
<p class="Mensajes">Mienbro: <?php echo strtoupper($_SESSION["var_nombre_organizacion"]); ?></p>
<p class="Mensajes">Periodo: <?php echo strtoupper($_SESSION["var_nombre_periodo"]); ?></p>
<br><br />
<form name="form1" method="post" action="ValidacionCuc.php">
  <table width="66%" border="0">
    <tr>
      <td width="17%" class="Etiquetas">Seleccione CUC 1:</td>
      <td width="83%" class="dr"><span id="sprytextfield1">
        <label>
        <input name="text1" type="file" id="text1">
        </label>
        <span class="textfieldRequiredMsg">Escoja el Archivo</span></span></td>
    </tr>
    <tr>
      <td class="Etiquetas">Seleccione CUC 2:</td>
      <td class="dr"><span id="sprytextfield2">
        <label>
        <input name="text2" type="file" id="text2">
        </label>
        <span class="textfieldRequiredMsg">Escoja el Archivo</span></span></td>
    </tr>
    <tr>
      <td colspan="2"><div align="left">
          <input type="submit" value="Enviar">
      </div></td>
    </tr>
      </table>
</form>
</br>
<table class="bd" width="100%"><tr><td class="hr"></td></tr></table>

<script type="text/javascript">
<!--
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
//-->
</script>
</body>
</html>
