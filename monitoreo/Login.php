<?php
include('../librerias/libs_sql.php');
$error='';

if ($_POST) {
	$usuario = $_POST['usuario'];
	$pass = $_POST['clave'];
	if ($usuario == '' || $pass =='') {
		$error .= 'Ingrese su C&eacute;dula y Contrase&ntilde;a.';
	}
	if ($error == '') {
		Conectar();
		$valida_usuario = "SELECT * FROM C_USUARIO_ORGANIZACION WHERE USUARIO_ID='$usuario' AND CLAVE_USUARIO='$pass' AND ESTADO_ID = 1";
		$resultado=ConsultarTabla($valida_usuario);
		$filas=NumeroFilas($resultado);
		if ($filas == 1)
		{
			$_SESSION['usuario_id'] = $usuario;
			$_SESSION['clave'] = $pass;
			if(isset( $_SESSION['usuario_id'] )) {
				$var_user_enc= base64_encode($usuario);
				$var_pass_enc= base64_encode($pass);
        http_redirect("MenuPrincipal.php");
      }
		}else{
			$error .= 'C&eacute;dula o Contrase&ntilde;a Incorrecta';
		}
	}
	Desconectar();
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Ingreso</title>
<style type="text/css">
.Estilo2 {
	color: #FF0000;
	font-weight: bold;
	font-size: 36px;
}
#ingreso{
	text-align: center;
	color: #084FA2;
}
.error{
	text-align: center;
	color: #F04031;
	border: 1px solid #F04031;
	margin: 0 auto;
	width: 220px;
	padding: 5px 10px;
}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="SpryAssets/HojasEstilos.css" rel="stylesheet" type="text/css">
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
</head>

<body>
	<h1 id="ingreso">Ingreso</h1>
	<?php if($error != '') :?>
		<div class="error"><?php echo $error; ?></div>
		<?php endif;?>
<form name="form1" method="post" action="">
  <table width="100%" border="0">
    <tr align="center">
      <td width="10%"><a href="http://www.rfr.org.ec/" target="_blank"><img src="../imagenes/logo_rfr.jpg" alt="" width="180" height="160" /></a></td>
		</tr>
		<tr>
	<td width="65%"><table align="center">
        <tr>
          <td class="Etiquetas">C&Eacute;DULA:</td>
          <td><span id="nombre">
            <label>
            <input name="usuario" type="text" id="text1" title="Ingrese su C&eacute;dula">
            <span class="textfieldRequiredMsg">Ingrese su Cédula</span> <span class="textfieldInvalidFormatMsg">Cedula Incorrecta</span> <span class="textfieldMinCharsMsg">Cedula Incorrecta</span> <span class="textfieldMaxCharsMsg">Cedula Incorrecta</span> </label>
          </span></td>
        </tr>
        <tr>
          <td class="Etiquetas">CLAVE:</td>
          <td><span id="clave">
            <label>
            <input type="password" name="clave" id="text2" title="Ingrese su Contrase&ntilde;a">
            </label>
            <span class="textfieldRequiredMsg">Ingresar su Contrase&ntilde;a</span></span> </td>
        </tr>
        <tr>
          <td align="center" colspan="2"><input type="submit" value="Aceptar"></td>
        </tr>
          </table></td>
    </tr>
  </table>
</form>
<br><br />
<table width="100%" border="0">
  <tr>
    <td><div align="center"><a href="index.php">P&aacute;gina Principal</a></div></td>
  </tr>
</table>
<br><br />
<table class="bd" width="100%"><tr><td class="hr"></td></tr></table>
<br><br />
<?php
	Conectar();
	$consultar="SELECT (day(FECHA_LIMITE_PERIODO) - day(getdate())) DIAS FROM dbo.C_PERIODO WHERE ESTADO_ID = 1 AND getdate() <= FECHA_LIMITE_PERIODO";
	$resultado=ConsultarTabla($consultar);
	$var_dias = @mssql_result($resultado,0,"DIAS");
	if($var_dias > 0)
	{
		if ($var_dias == 1)
		{
			$var_descripcion = "Recuerde que queda - ".$var_dias." - dia para ingresar o enviar la informacion";

		}
		else
		{
			$var_descripcion = "Recuerde que quedan - ".$var_dias." - dias para ingresar o enviar la informacion";

		}
	}
	else
	{
		$var_descripcion = "El peri&oacute;do para ingresar o enviar la informaci&oacute;n ha concluido.!";
	}
	Desconectar();

?>
<table width="100%" border="0">
  <tr>
    <td class="Dias"><div align="center"><?php echo $var_descripcion; echo $var_msg; echo "";?></div>
</td>
  </tr>
</table>
<br><br />

<script type="text/javascript">
<!--
var clave = new Spry.Widget.ValidationTextField("clave", "none", {validateOn:["blur"]});
var nombre = new Spry.Widget.ValidationTextField("nombre", "integer", {allowNegative:false, validateOn:["blur"],useCharacterMasking:true, minChars:10, maxChars:10});
//-->
</script>
</body>
</html>
