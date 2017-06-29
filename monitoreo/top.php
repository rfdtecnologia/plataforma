<?php
$var_imagen = "";
$var_imagen_rfd = "";
if (file_exists("../imagenes/".$_SESSION["var_organizacion"].".jpg")){
    $var_imagen = "../imagenes/".$_SESSION["var_organizacion"].".jpg";
    $var_imagen_rfd = "../imagenes/logo_rfd_n.jpg";
}elseif (file_exists("../../imagenes/".$_SESSION["var_organizacion"].".jpg")){
    $var_titulo = "CARGAR CUC";
    $var_imagen = "../../imagenes/".$_SESSION["var_organizacion"].".jpg";
    $var_imagen_rfd = "../../imagenes/logo_rfd_n.jpg";
}

$consultar="SELECT * FROM dbo.C_GRUPO WHERE GRUPO_ID = ".$var_rubro;

$resultado=ConsultarTabla($consultar);
$var_titulo = mssql_result($resultado,0,"NOMBRE_GRUPO");
$var_menu = mssql_result($resultado,0,"MENU_ID");

$var_logo_ancho = $_SESSION["var_logo_ancho"];
$var_logo_alto = $_SESSION["var_logo_alto"];
$var_carga_cuc = $_SESSION["var_carga_cuc"];
$var_intermediacion = $_SESSION["var_intermediacion"];
?>

<div class="content_logo_left">
    <?php
    if (empty($_SESSION["var_web_organizacion"]))
    {
        ?>
        <div align="left"><img src="<?php echo $var_imagen; ?>" alt="" width="<?php echo $var_logo_ancho?>" height="<?php echo $var_logo_alto?>" /></a></div>
        <?php
    }
    else
    {
        ?>
        <div align="left"><a href="<?php echo $_SESSION["var_web_organizacion"] ?>" target="_blank"><img src="<?php echo $var_imagen ?>" alt=""  /></a></div>
    <?php
    }
    ?>
</div>
<div class="content_message_center">
    <div class="content_message">
        <p class="Mensajes"><?php echo $var_titulo; ?></p>
    </div>
</div>
<div class="content_logo_right">
    <div align="right"><a href="http://www.rfd.org.ec/" target="_blank"><img src="<?php echo $var_imagen_rfd ?>" alt="" /></a></div>
</div>
<div class="clr"></div>
<div class="content_message">
    <p class="Mensajes">Miembro: <?php echo strtoupper($_SESSION["var_nombre_organizacion"]); ?></p>
    <p class="Mensajes">Periodo: <?php echo strtoupper($_SESSION["var_nombre_periodo"]); ?></p>
</div>

<!--<table width="100%" border="0">-->
<!--    <tr>-->
<!--        --><?php
//        $var_imagen = "../imagenes/".$_SESSION["var_organizacion"].".jpg";
//
//        $consultar="SELECT * FROM dbo.C_GRUPO WHERE GRUPO_ID = ".$var_rubro;
//
//        $resultado=ConsultarTabla($consultar);
//        $var_titulo = mssql_result($resultado,0,"NOMBRE_GRUPO");
//        $var_menu = mssql_result($resultado,0,"MENU_ID");
//
//        $var_logo_ancho = $_SESSION["var_logo_ancho"];
//        $var_logo_alto = $_SESSION["var_logo_alto"];
//        $var_carga_cuc = $_SESSION["var_carga_cuc"];
//        $var_intermediacion = $_SESSION["var_intermediacion"];
//
//
//        if (empty($_SESSION["var_web_organizacion"]))
//        {
//            ?>
<!--            <td><div align="left"><img src="--><?php //echo $var_imagen; ?><!--" alt="" width="--><?php //echo $var_logo_ancho?><!--" height="--><?php //echo $var_logo_alto?><!--" /></a></div></td>-->
<!--            --><?php
//        }
//        else
//        {
//            echo '<td><div align="left"><a href="'.$_SESSION["var_web_organizacion"].'" target="_blank"><img src="'.$var_imagen.'" alt="" width="'.$var_logo_ancho.'" height="'.$var_logo_alto.'" /></a></div></td>';
//        }
//        ?>
<!--        <td>-->
<!--            <p class="Mensajes">--><?php //echo $var_titulo; ?><!--</p>-->
<!--        </td>-->
<!--        <td width="50%"><div align="right"><a href="http://www.rfr.org.ec/" target="_blank"><img src="../imagenes/logo_rfr.jpg" alt="" width="95" height="95" /></a></div></td>-->
<!--    </tr>-->
<!--</table>-->
<!--<p class="Mensajes">Miembro: --><?php //echo strtoupper($_SESSION["var_nombre_organizacion"]); ?><!--</p>-->
<!--<p class="Mensajes">Periodo: --><?php //echo strtoupper($_SESSION["var_nombre_periodo"]); ?><!--</p>-->