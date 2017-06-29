<? session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Ingreso Periodo y Organizaci&oacute;n</title>
<link href="SpryAssets/HojasEstilos.css" rel="stylesheet" type="text/css">
<meta name="generator" content="text/html">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<body>
<form action="MenuPrincipal.php" method="post">
    <?php
      include("../librerias/libs_sql.php");
      Conectar();
    ?>
    <?php
    include ('head.php');
    ?>
	<div align="center"><a href="MenuPrincipal.php" class="btn_menu">Menu Principal</a></div>
    <table width="100%" border="0">
      <tr>
        <?php
        $var_imagen = "../imagenes/".$_SESSION["var_organizacion"].".jpg";
        $var_titulo = "PARÁMETROS";
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
  	<p class="Mensajes">Ingrese Sus Datos:</p>
    <table class="tbl" border="0" cellspacing="1" cellpadding="5"width="100%">
    <tr>
    <td width="6%" class="hr">PERIODO:</td>
    <td width="94%" class="dr"><select name="PERIODO_ID">
    <?
      $sql = "select PERIODO_ID, NOMBRE_PERIODO from dbo.C_PERIODO ORDER BY PERIODO_ID DESC";
      $res = mssql_query($sql, $conn);

      while ($lp_row = mssql_fetch_assoc($res)){
      $val = $lp_row["PERIODO_ID"];
      $caption = $lp_row["NOMBRE_PERIODO"];
      if ($row["PERIODO_ID"] == $lp_row["PERIODO_ID"]) {$selstr = " selected"; } else {$selstr = ""; }
     ?><option value="<? echo $val ?>"<? echo $selstr ?>><? echo $caption ?></option>
    <? } ?></select>    </td>
    </tr>
    <tr>
    <td class="hr">MIEMBRO:</td>
    <td class="dr"><select name="ORGANIZACION_ID">
    <?
      $sql = "select ORGANIZACION_ID, NOMBRE_ORGANIZACION from dbo.C_ORGANIZACION ORDER BY NOMBRE_ORGANIZACION";
      $res = mssql_query($sql, $conn);

      while ($lp_row = mssql_fetch_assoc($res)){
      $val = $lp_row["ORGANIZACION_ID"];
      $caption = $lp_row["NOMBRE_ORGANIZACION"];
     ?><option value="<? echo $val ?>"<? echo $selstr ?>><? echo $caption ?></option>
    <? } ?></select>    </td>
    </tr>
    <tr>
      <td colspan="2"><label>
        <br></br>
        <input class="btn new blue2" type="submit" name="button" id="button" value="Cambiar">
      </label></td>
      </tr>
    </table>
  <?php mssql_close($conn); ?>
    <br></br>
    <table class="bd" width="100%"><tr><td class="hr"></td></tr></table>
</form>
</body>
</html>
