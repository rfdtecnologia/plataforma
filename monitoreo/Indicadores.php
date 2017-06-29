<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html>
<head>
    <title>Indicadores Sociales</title>
    <meta name="generator" content="text/html">
    <link href="SpryAssets/HojasEstilos.css" rel="stylesheet" type="text/css">
    <script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
    <link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
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
$var_imagen = "../imagenes/" . $_SESSION["var_organizacion"] . ".jpg";
$var_intermediacion = $_SESSION["var_intermediacion"];
$var_descripcion = "INGRESÓ Y NO ENVIÓ";
$consultar = "SELECT *
				FROM dbo.C_NOVEDAD
				WHERE
				PERIODO_ID = $var_periodo AND
				ORGANIZACION_ID = $var_organizacion AND
				MENU_ID = 7";
$resultado = ConsultarTabla($consultar);
$filas = NumeroFilas($resultado);
if ($filas == 0) {
    $query1 = "INSERT INTO
				dbo.C_NOVEDAD
				(PERIODO_ID,ORGANIZACION_ID,MENU_ID,ESTADO_ID,USUARIO_ID,HORA_NOVEDAD,DESCRIPCION_NOVEDAD,NOMBRE_USUARIO)
				VALUES
				($var_periodo,$var_organizacion,7,0,$var_usuario,'$fecha','$var_descripcion','$var_nombre_usuario')";
    Actualizar($query1);
}

include ('head.php');
?>

<div align="center"><a href="MenuPrincipal.php" class="btn_menu">Menu Principal</a></div>
<table width="100%" border="0">
    <tr>
        <?php
        $var_imagen = "../imagenes/" . $_SESSION["var_organizacion"] . ".jpg";
        $var_titulo = "ESTRUCTURAS SOCIALES";
        $var_logo_ancho = $_SESSION["var_logo_ancho"];
        $var_logo_alto = $_SESSION["var_logo_alto"];
        if (empty($_SESSION["var_web_organizacion"])) {
            ?>
            <td width="50%" height="102">
            <div align="left"><img src="<?php echo $var_imagen; ?>" alt="" width="<?php echo $var_logo_ancho ?>"
                                   height="<?php echo $var_logo_alto ?>"/></a></div></td><?php
        } else {
            echo '<td width="50%" height="102"><div align="left"><a href="' . $_SESSION["var_web_organizacion"] . '" target="_blank"><img src="' . $var_imagen . '" alt="" width="' . $var_logo_ancho . '" height="' . $var_logo_alto . '" /></a></a></div></td>';
        }
        ?>
        <td width="0%">
            <p align="center" class="Mensajes"><?php echo $var_titulo; ?></p>
        </td>
        <td width="50%">
            <div align="right"><a href="http://www.rfr.org.ec/" target="_blank"><img src="../imagenes/logo_rfr.jpg"
                                                                                     alt="" width="95" height="95"/></a>
            </div>
        </td>
    </tr>
</table>
<p class="Mensajes">Miembro: <?php echo strtoupper($_SESSION["var_nombre_organizacion"]); ?></p>
<p class="Mensajes">Periodo: <?php echo strtoupper($_SESSION["var_nombre_periodo"]); ?></p>
<br><br/>
<form action="ValidacionInd.php" method="post" enctype="multipart/form-data" name="form1">
    <input name="var_cuc" type="hidden" value="<?php echo $var_cuc; ?>">
    <table width="48%" border="0">
        <tr>
            <td width="26%" class="Etiquetas">Estructura 1:</td>
            <td width="74%" class="dr">
    <span id="sprytextfield1">
      <input name="est_1" type="file">
    <span class="textfieldRequiredMsg">Escoja el Archivo</span></span>
            </td>
        </tr>
        <?php
        /* if($var_estatuto == 1 || $var_estatuto == 2 || $var_estatuto == 3 || $var_estatuto == 5 || $var_estatuto == 6 || $var_estatuto == 9) */
        if ($var_intermediacion == 'S') {
            ?>
            <tr>
                <td class="Etiquetas">Estructura 2:</td>
                <td class="dr">
    <span id="sprytextfield2">
      <input name="est_2" type="file">
    <span class="textfieldRequiredMsg">Escoja el Archivo</span></span>
                </td>
            </tr>
            <?php
        }
        ?>
        <tr>
            <td class="Etiquetas">Estructura 3:</td>
            <td class="dr">
    <span id="sprytextfield3">
      <input name="est_3" type="file">
    <span class="textfieldRequiredMsg">Escoja el Archivo</span></span>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="dr">
                <div align="left">
                    <br></br>
                    <input class='btn save blue' type="submit" value="Grabar">
                </div>
            </td>
        </tr>
    </table>
</form>
</br>
<table class="bd" width="100%">
    <tr>
        <td class="hr"></td>
    </tr>
</table>
<script type="text/javascript">
    <!--
    var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
    var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
    var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
    //-->
</script>
<?php Desconectar(); ?>
</body>
</html>
