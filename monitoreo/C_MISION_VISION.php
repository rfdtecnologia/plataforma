<? session_start(); ?>
<html>
<head>
<title>RFD -- ACTUALIZACIÓN MISI&Oacute;N Y VISI&Oacute;N</title>
<meta name="generator" content="text/html">
<link href="SpryAssets/HojasEstilos.css" rel="stylesheet" type="text/css">
<script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css">
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
include ('head.php');
?>
<table width="100%" border="0">
  <tr>
    <td><div align="center"><a href="MenuPrincipal.php" class="btn_menu">Menu Principal</a></div></td>
  </tr>
</table>
<?php
	include("../librerias/libs_sql.php");
	Conectar();
	$var_org=$_SESSION["var_organizacion"];

	$sql1 = "SELECT mision as MISION, vision as VISION FROM dbo.C_ORGANIZACION WHERE(ORGANIZACION_ID=" .$var_org .")";

	$resultado1=ConsultarTabla($sql1);
	$filas=NumeroFilas($resultado1);
	if ($filas > 0)
	{
		while ($row=mssql_fetch_array($resultado1))
		{
		$mision = $row["MISION"];
		$vision = $row["VISION"];
		}
	}

	if (isset($_POST["mision"]) && isset($_POST["vision"]))
	{
	$mision = $_POST["mision"];
	$vision = $_POST["vision"];

	global $conn;
	$sql = "update dbo.C_ORGANIZACION set  MISION = LTRIM(RTRIM('".$mision."')), VISION=LTRIM(RTRIM('".$vision."')) where " ."(ORGANIZACION_ID=".$var_org .")";
	//echo $sql;
	if (@mssql_query($sql, $conn) == false)
	  {
		echo $sql;
		echo '<span class="Mensajes">NO SE MODIFICO EL REGISTRO</span>';
		echo "<br></br>";
	  }
	}
	Desconectar();
?>
<form action="MenuPrincipal.php" method="post" name="form1">
<table class="tbl" border="0" cellspacing="1" cellpadding="5"width="100%">
<tr>
<td class="hr">
Ingrese Misi&oacute;n:</td>
<td class="dr">
<textarea name="mision" cols="35" rows="4"><?php echo trim($mision); ?></textarea></td></tr>
<tr>
<td class="hr">
Ingrese Visi&oacute;n:</td>
<td class="dr">
<textarea name="vision" cols="35" rows="4"><?php echo trim($vision); ?></textarea></td></tr>
<tr>
<td colspan="2" align="center">
<input name="ok" type="submit" class="btn save green" value="Grabar"></td></tr>
</table>
</form>

</body>
</html>
