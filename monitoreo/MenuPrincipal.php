
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/199/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Menu Principal</title>
    <script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
    <link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
    <link href="SpryAssets/HojasEstilos.css" rel="stylesheet" type="text/css">
    <link href="SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />

</head>
<body>
<?php
include ('head.php');

include('../librerias/libs_sql.php');
$var_org=$_SESSION["usuario_organizacion"];
if (isset($_POST["mision"]) && isset($_POST["vision"]))
{
    $mision = $_POST["mision"];
    $vision = $_POST["vision"];
    global $conn;
    $sql = "update dbo.C_ORGANIZACION set  MISION='" .$mision."', VISION='" .$vision."' where " ."(ORGANIZACION_ID=" .$var_org .")";
    if (@mssql_query($sql, $conn) == false)
    {
        echo $sql;
        echo '<span class="Mensajes">NO SE MODIFICO EL REGISTRO</span>';
        echo "<br></br>";
    }
}

$var_sw = true;
$var_ingresa = false;
if (empty($var_usuario))
{
    $var_usuario = $_SESSION['usuario_id'];
}
else
{
    $_SESSION['usuario_id'] = $var_usuario;
    $var_ingresa = true;
}

$var_per = $_POST['PERIODO_ID'];
$var_org = $_POST['ORGANIZACION_ID'];

if (empty($var_per) && empty($var_org))
{
    $var_per = $_SESSION['var_per'];
    $var_org = $_SESSION['var_org'];
}
else
{
    $_SESSION['var_per'] = $var_per;
    $_SESSION['var_org'] = $var_org;
}
Conectar();
$consulta="SELECT * FROM C_USUARIO_ORGANIZACION WHERE USUARIO_ID='$var_usuario' AND ESTADO_ID = 1";
$resultado=ConsultarTabla($consulta);
$filas=NumeroFilas($resultado);
$columnas=NumeroColumnas($resultado);
if ($filas == 1)
{
    if($var_ingresa)
    {
        $query="update C_USUARIO_ORGANIZACION SET NUMERO_VECES_USUARIO = NUMERO_VECES_USUARIO + 1 WHERE USUARIO_ID='$var_usuario' AND ID_ORGANIZACION = '$var_org' AND ESTADO_ID = 1";
        Actualizar($query);
    }
    $var_perfil = mssql_result($resultado,0,"PERFIL_ID");
    $var_organizacion=mssql_result($resultado,0,"ORGANIZACION_ID");
    $_SESSION["perfil_usuario"] = $var_perfil;
    $_SESSION["nombre_usuario"] = mb_strtoupper(mssql_result($resultado,0,"NOMBRE_USUARIO"));
    $_SESSION["clave_usuario"] = mb_strtoupper(mssql_result($resultado,0,"CLAVE_USUARIO"));
    if (empty($var_org))
    {
        $var_org = $var_organizacion;
    }
    if ($var_perfil == 1 or $var_perfil == 11 or $var_perfil == 13)
    {
        $consultar="SELECT * FROM dbo.C_ORGANIZACION WHERE ORGANIZACION_ID = $var_org";
        $_SESSION["var_organizacion"] = $var_org;
    }
    else
    {
        $consultar="SELECT * FROM dbo.C_ORGANIZACION WHERE ORGANIZACION_ID = $var_organizacion";
        $_SESSION["var_organizacion"] = $var_organizacion;
    }
    $resultado=ConsultarTabla($consultar);
    $var_nombre_organizacion=mssql_result($resultado,0,"NOMBRE_ORGANIZACION");
    $_SESSION["var_nombre_organizacion"] = $var_nombre_organizacion;
    $var_web_organizacion=mssql_result($resultado,0,"WEB_ORGANIZACION");
    $_SESSION["var_web_organizacion"] = $var_web_organizacion;
    $_SESSION["var_logo_ancho"] = mssql_result($resultado,0,"LOGO_ANCHO");
    $_SESSION["var_logo_alto"] = mssql_result($resultado,0,"LOGO_ALTO");
    $_SESSION["var_carga_cuc"] = mssql_result($resultado,0,"CARGA_CUC");
    $_SESSION["var_solo_cartera"] = mssql_result($resultado,0,"SOLO_CARTERA");
    $_SESSION["var_intermediacion"] = mssql_result($resultado,0,"INTERMEDIACION_ID");
    /*VARIABLE PARA TIPO DE ORGANIZACION*/
    $_SESSION["var_tipo_organizacion"] = mssql_result($resultado,0,"TIPO_ORGANIZACION_ID");
    $var_tipo_organizacion = $_SESSION["var_tipo_organizacion"];
    $consultar="SELECT * FROM C_ESTATUTO_JURIDICO WHERE TIPO_ORGANIZACION_ID = $var_tipo_organizacion";
    $resultado=ConsultarTabla($consultar);
    $_SESSION["var_valida_patrimonio_secundario"] = mssql_result($resultado,0,"VALIDA_PATRIMONIO_SECUNDARIO");
    $_SESSION["var_valida_fondos_irrepartibles"] = mssql_result($resultado,0,"VALIDA_FONDOS_IRREPARTIBLES");
    //$var_valida_patrimonio_secundario = $_SESSION["var_valida_patrimonio_secundario"];
    /*echo "tipo_id: ".$var_tipo_organizacion;
    echo "<br>";
    echo "valida: ".$var_valida_patrimonio_secundario;*/
    if (empty($var_per))
    {
        $consultar="SELECT MAX(PERIODO_ID) AS PERIODO_ID FROM dbo.C_PERIODO";
        $resultado=ConsultarTabla($consultar);
        $var_per = mssql_result($resultado,0,"PERIODO_ID");
    }
    if ($var_perfil == 1 or $var_perfil == 11 or $var_perfil == 13)
    {
        $consultar="SELECT * FROM dbo.C_PERIODO WHERE PERIODO_ID = $var_per";
    }
    else
    {
        $consultar="SELECT * FROM dbo.C_PERIODO WHERE ESTADO_ID = 1 AND getdate() <= FECHA_LIMITE_PERIODO";
    }
    $resultado=ConsultarTabla($consultar);
    $filas=NumeroFilas($resultado);
    if ($filas == 1) {
        $var_imagen = "../imagenes/" . $_SESSION["var_organizacion"] . ".jpg";
        $var_periodo = mssql_result($resultado, 0, "PERIODO_ID");
        $_SESSION["var_periodo"] = $var_periodo;
        $var_nombre_periodo = mssql_result($resultado, 0, "NOMBRE_PERIODO");
        $_SESSION["var_nombre_periodo"] = $var_nombre_periodo;
        ?>
        <div class="content_main content_logo">
            <div class="content_vision">
                <div onclick="document.location='C_MISION_VISION.php'">
                        <h2 class="link">Para Actualizar Misión y Visión,CLICK AQUÍ</h2>
                        <!--Visi;on
                        <embed src="http://www.flashtoys.myprofilepimp.us/pimp/toys/LCD1.swf?t=ACTUALIZA MISION VISION&msg=ACTUALIZA MISION VISION&b=2" quality="high" bgcolor="#FFFFFF" width="350" height="50" name="LCDScroller" align="middle" allowScriptAccess="samedomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
                      -->
                    </div>
                </div>
            <div class="content_logo_left">
                <?php
                $var_logo_ancho = $_SESSION["var_logo_ancho"];
                $var_logo_alto = $_SESSION["var_logo_alto"];
                if (empty($_SESSION["var_web_organizacion"])) {
                    ?>
                    <div align="left"><img src="<?php echo $var_imagen; ?>" alt="" width="<?php echo $var_logo_ancho?>" height="<?php echo $var_logo_alto?>" /></a></div>
                    <?php
                } else {
                    ?>
                    <div align="left"><a href="<?php echo $_SESSION["var_web_organizacion"] ?>" target="_blank"><img src="<?php echo $var_imagen ?>" alt=""  /></a></div>
                    <?php
                }
                ?>
            </div>
            <div class="content_message_center">
                <div class="content_message">
                    <p class="Mensajes"><b>Bienvenido: <?php echo $_SESSION["nombre_usuario"]; ?> </b></p>
                    <p class="Mensajes"><b>Miembro: <?php echo strtoupper($_SESSION["var_nombre_organizacion"]); ?></b></p>
                    <p class="Mensajes"><b>Periodo: <?php echo strtoupper($_SESSION["var_nombre_periodo"]); ?></b></p>
                </div>
            </div>
            <div class="content_logo_right">
                <div align="right"><a href="http://www.rfd.org.ec/" target="_blank"><img src="../imagenes/logo_rfd_n.jpg" alt="" /></a></div>
            </div>
            <div class="clr"></div>
            </div>

        <div class="content_menu">
            <?php
            switch ($var_perfil) {
                case 1:
                    ?>

                    <ul class="MenuBarHorizontal" id="MenuBar1">
                        <li><a href="#" class="MenuBarItemSubmenu">Datos Financieros</a>
                            <ul>
                                <li><a href="IngresoRubroTodos.php?var_rubro=10">Patrimonio Técnico</a></li>
                                <li><a href="IngresoRubroTodos.php?var_rubro=1">Estado de Resultados</a></li>
                                <li><a href="IngresoRubroTodos.php?var_rubro=2">Balance</a></li>
                                <li><a href="CoberturaOrganizacion.php?a=reset">Cobertura Geográfica</a></li>
                                <li><a href="IngresoRubroTodos.php?var_rubro=3">Cartera & Alcance</a></li>
                                <li><a href="IngresoRubroTodos.php?var_rubro=12">Rubros CUC</a></li>
                                <li><a href="IngresoRubroTodos.php?var_rubro=8">Datos Cualitativos</a></li>
                                <!--<li><a href="IngresoRubroTodos.php?var_rubro=6">Rubros RFR</a></li>!--->
                                <!--<li><a href="IngresoRubroTodos.php?var_rubro=7">Rubros SWISSCONTACT</a></li>!--->
                            </ul>
                        </li>

                        <li><a href="IngresoRubroTodos.php?var_rubro=5">Datos Sociales</a></li>

                        <li><a href="#" class="MenuBarItemSubmenu">Envío de Archivos</a>
                            <ul>
                                <!--<li><a href="Cuc.php?var_cuc=1">CUC Un Cuerpo</a></li>
                                <li><a href="Cuc.php?var_cuc=2">CUC Dos Cuerpos</a></li>!--->
                                <li><a href="cargar_cvs/cargar.php?var_cuc=13">Balance CUC</a></li>
                                <li><a href="cargar_cvs2/cargar2.php?var_cuc=13">Balance CUC por Agencias</a></li>
                                <li><a href="Indicadores.php">Estructuras Sociales</a></li>
                            </ul>
                        </li>

                        <li><a href="IngresoPerOrg.php">Ingreso Parámetros</a></li>
                        <li><a href="#" class="MenuBarItemSubmenu">Administración</a>
                            <ul>
                                <li><a href="#" class="MenuBarItemSubmenu">Miembros</a>
                                    <ul>
                                        <li><a href="C_ESTATUTO_JURIDICO.php?a=reset">Estatuto Jurídico</a></li>
                                        <li><a href="C_ORGANIZACION.php?a=reset">Organización</a></li>
                                        <li><a href="C_METODOLOGIA_CREDITO.php?a=reset">Metodología Crédito</a></li>
                                        <li><a href="C_ORGANIZACION_METODOLOGIA.php?a=reset">Organización
                                                Metodología</a></li>
                                        <!--<li><a href="C_ESTATUTO_JURIDICO_HISTORICO.php?a=reset">Estatuto Juridico Historico</a></li>-->
                                    </ul>
                                </li>
                                <li><a href="#">Cobertura</a>
                                    <ul>
                                        <li><a href="C_PROVINCIA.php?a=reset">Provincia</a></li>
                                        <li><a href="C_CANTON.php?a=reset">Cantón</a></li>
                                        <li><a href="C_COBERTURA_GEOGRAFICA.php?a=reset">Cobertura Geográfica</a></li>
                                    </ul>
                                </li>
                                <li><a href="#">Cuentas y Rubros</a>
                                    <ul>
                                        <li><a href="C_CUENTA_CONTABLE.php?a=reset">Cuentas Contables</a></li>
                                        <li><a href="C_RUBRO.php?a=reset">Rubros</a></li>
                                        <li><a href="C_GRUPO.php?a=reset">Tipos de Rubros</a></li>
                                    </ul>
                                </li>
                                <li><a href="#">Parámetros</a>
                                    <ul>
                                        <li><a href="C_PERIODO.php?a=reset">Periodo</a></li>
                                        <li><a href="C_TASA.php?a=reset">Datos para Ajustes</a></li>
                                        <li><a href="C_USUARIO_ORGANIZACION.php?a=reset">Usuario</a></li>
                                        <li><a href="C_PERFIL.php?a=reset">Perfil de Usuario</a></li>
                                        <li><a href="C_INTERMEDIACION.php?a=reset">Intermediación</a></li>
                                        <li><a href="C_LUCRO.php?a=reset">Lucro</a></li>
                                        <li><a href="C_RESPUESTA.php?a=reset">Respuestas</a></li>
                                        <li><a href="C_ESTADO.php?a=reset">Estado</a></li>
                                        <li><a href="C_BOLETIN.php?a=reset">Boletín</a></li>
                                        <li><a href="C_PROYECTO.php?a=reset">Proyecto</a></li>
                                    </ul>
                                </li>
                                <li><a href="CambioClave.php">Cambio de Clave</a></li>
                            </ul>
                        </li>
                        <li><a href="#" class="MenuBarItemSubmenu">Consultas</a>
                            <ul>
                                <li><a href="ConsultaPer.php">Periodos Anteriores</a></li>
                                <li><a href="C_RUBRO_CONSULTA.php?a=reset">Rubros</a></li>
                                <li><a href="http://rfr-bi.rfr.org.ec:8080/MicroStrategy/servlet/mstrWeb"
                                       target="_blank">Reportes BI (MicroStrategy)</a></li>
                            </ul>
                        </li>

                        <li><a href="cerrar_sesion.php">Salir</a></li>
                    </ul>
                    <?php
                    break;
                case 2:
                    ?>

                    <ul class="MenuBarHorizontal" id="MenuBar1">
                        <li><a href="#" class="MenuBarItemSubmenu">Datos Financieros</a>
                            <ul>
                                <li><a href="IngresoRubroTodos.php?var_rubro=10">Patrimonio Técnico</a></li>
                                <li><a href="CoberturaOrganizacion.php?a=reset">Cobertura Geográfica</a></li>
                                <li><a href="IngresoRubroTodos.php?var_rubro=3">Cartera & Alcance</a></li>
                            </ul>
                        </li>

                        <li><a href="#" class="MenuBarItemSubmenu">Envío de Archivos</a>
                            <ul>
                                <li><a href="cargar_cvs/cargar.php?var_cuc=13">Balance CUC</a></li>
                            </ul>
                        </li>

                        <li><a href="#" class="MenuBarItemSubmenu">Consultas</a>
                            <ul>
                                <li><a href="ConsultaPer.php">Periodos Anteriores</a></li>
                                <li><a href="C_RUBRO_CONSULTA.php?a=reset">Rubros</a></li>
                            </ul>
                        </li>

                        <li><a href="CambioClave.php">Cambio de Clave</a></li>

                        <li><a href="cerrar_sesion.php">Salir</a></li>
                    </ul>
                    <?php
                    break;
                case 3:
                    ?>
                    <ul class="MenuBarHorizontal" id="MenuBar1">
                        <li><a href="#" class="MenuBarItemSubmenu">Datos Financieros</a>
                            <ul>
                                <li><a href="IngresoRubroTodos.php?var_rubro=10">Patrimonio Técnico</a></li>
                                <li><a href="CoberturaOrganizacion.php?a=reset">Cobertura Geográfica</a></li>
                                <li><a href="IngresoRubroTodos.php?var_rubro=3">Cartera & Alcance</a></li>

                            </ul>
                        </li>

                        <li><a href="CambioClave.php">Cambio de Clave</a></li>
                        <li><a href="#" class="MenuBarItemSubmenu">Consultas</a>
                            <ul>
                                <li><a href="ConsultaPer.php">Periodos Anteriores</a></li>
                                <li><a href="C_RUBRO_CONSULTA.php?a=reset">Rubros</a></li>
                            </ul>
                        </li>
                        <li><a href="/cerrar_sesion">Salir</a></li>
                    </ul>
                    <?php
                    break;
                case 4:
                    ?>
                    <ul class="MenuBarHorizontal" id="MenuBar1">
                        <li><a href="#" class="MenuBarItemSubmenu">Datos Financieros</a>
                            <ul>
                                <li><a href="IngresoRubroTodos.php?var_rubro=10">Patrimonio Técnico</a></li>
                                <li><a href="CoberturaOrganizacion.php?a=reset">Cobertura Geográfica</a></li>
                                <li><a href="IngresoRubroTodos.php?var_rubro=3">Cartera & Alcance</a></li>
                            </ul>
                        </li>
                        <li><a href="#" class="MenuBarItemSubmenu">Envío de Archivos</a>
                            <ul>
                                <li><a href="Cuc.php?var_cuc=1">CUC Un Cuerpo</a></li>
                            </ul>
                        </li>
                        <li><a href="CambioClave.php">Cambio de Clave</a></li>
                        <li><a href="#" class="MenuBarItemSubmenu">Consultas</a>
                            <ul>
                                <li><a href="ConsultaPer.php">Periodos Anteriores</a></li>
                                <li><a href="C_RUBRO_CONSULTA.php?a=reset">Rubros</a></li>
                            </ul>
                        </li>
                        <li><a href="cerrar_sesion.php">Salir</a></li>
                    </ul>
                    <?php
                    break;
                case 5:
                    ?>
                    <ul class="MenuBarHorizontal" id="MenuBar1">
                        <li><a href="#" class="MenuBarItemSubmenu">Datos Financieros</a>
                            <ul>
                                <li><a href="IngresoRubroTodos.php?var_rubro=10">Patrimonio Técnico</a></li>
                                <li><a href="CoberturaOrganizacion.php?a=reset">Cobertura Geográfica</a></li>
                                <li><a href="IngresoRubroTodos.php?var_rubro=3">Cartera & Alcance</a></li>
                            </ul>
                        </li>
                        <li><a href="#" class="MenuBarItemSubmenu">Envío de Archivos</a>
                            <ul>
                                <li><a href="Cuc.php?var_cuc=2">CUC Dos Cuerpos</a></li>
                            </ul>
                        </li>

                        <li><a href="CambioClave.php">Cambio de Clave</a></li>
                        <li><a href="#" class="MenuBarItemSubmenu">Consultas</a>
                            <ul>
                                <li><a href="ConsultaPer.php">Periodos Anteriores</a></li>
                                <li><a href="C_RUBRO_CONSULTA.php?a=reset">Rubros</a></li>
                            </ul>
                        </li>
                        <li><a href="cerrar_sesion.php">Salir</a></li>
                    </ul>
                    <?php
                    break;
                case 6:
                    ?>
                    <ul class="MenuBarHorizontal" id="MenuBar1">

                        <li><a href="#" class="MenuBarItemSubmenu">Envío de Archivos</a>
                            <ul>
                                <li><a href="Indicadores.php">Estructuras Sociales</a></li>
                            </ul>
                        </li>

                        <li><a href="CambioClave.php">Cambio de Clave</a></li>

                        <li><a href="cerrar_sesion.php">Salir</a></li>
                    </ul>
                    <?php
                    break;
                case 7:
                    ?>
                    <ul class="MenuBarHorizontal" id="MenuBar1">

                        <li><a href="#" class="MenuBarItemSubmenu">Datos Financieros</a>
                            <ul>
                                <li><a href="IngresoRubroTodos.php?var_rubro=10">Patrimonio Técnico</a></li>
                                <li><a href="CoberturaOrganizacion.php?a=reset">Cobertura Geográfica</a></li>
                                <li><a href="IngresoRubroTodos.php?var_rubro=3">Cartera & Alcance</a></li>
                            </ul>
                        </li>

                        <li><a href="IngresoRubroTodos.php?var_rubro=5">Datos Sociales</a></li>

                        <li><a href="#" class="MenuBarItemSubmenu">Envío de Archivos</a>
                            <ul>
                                <li><a href="cargar_cvs/cargar.php?var_cuc=13">Balance CUC</a></li>
                                <li><a href="Indicadores.php">Estructuras Sociales</a></li>
                            </ul>
                        </li>

                        <li><a href="#" class="MenuBarItemSubmenu">Consultas</a>
                            <ul>
                                <li><a href="ConsultaPer.php">Periodos Anteriores</a></li>
                                <li><a href="C_RUBRO_CONSULTA.php?a=reset">Rubros</a></li>
                            </ul>
                        </li>

                        <li><a href="CambioClave.php">Cambio de Clave</a></li>

                        <li><a href="cerrar_sesion.php">Salir</a></li>
                    </ul>
                    <?php
                    break;
                case 8:
                    ?>
                    <ul class="MenuBarHorizontal" id="MenuBar1">
                        <li><a href="#" class="MenuBarItemSubmenu">Datos Financieros</a>
                            <ul>
                                <li><a href="IngresoRubroTodos.php?var_rubro=10">Patrimonio Técnico</a></li>
                                <li><a href="CoberturaOrganizacion.php?a=reset">Cobertura Geográfica</a></li>
                                <li><a href="IngresoRubroTodos.php?var_rubro=3">Cartera & Alcance</a></li>


                            </ul>
                        </li>
                        <li><a href="IngresoRubroTodos.php?var_rubro=5">Datos Sociales</a></li>
                        <li><a href="#" class="MenuBarItemSubmenu">Envío de Archivos</a>
                            <ul>
                                <li><a href="Indicadores.php">Estructuras Sociales</a></li>
                            </ul>
                        </li>
                        <li><a href="CambioClave.php">Cambio de Clave</a></li>
                        <li><a href="#" class="MenuBarItemSubmenu">Consultas</a>
                            <ul>
                                <li><a href="ConsultaPer.php">Periodos Anteriores</a></li>
                                <li><a href="C_RUBRO_CONSULTA.php?a=reset">Rubros</a></li>
                            </ul>
                        </li>
                        <li><a href="cerrar_sesion.php">Salir</a></li>
                    </ul>
                    <?php
                    break;
                case 9:
                    ?>
                    <ul class="MenuBarHorizontal" id="MenuBar1">
                        <li><a href="#" class="MenuBarItemSubmenu">Datos Financieros</a>
                            <ul>
                                <li><a href="IngresoRubroTodos.php?var_rubro=10">Patrimonio Técnico</a></li>
                                <li><a href="CoberturaOrganizacion.php?a=reset">Cobertura Geográfica</a></li>
                                <li><a href="IngresoRubroTodos.php?var_rubro=3">Cartera & Alcance</a></li>


                            </ul>
                        </li>
                        <li><a href="IngresoRubroTodos.php?var_rubro=5">Datos Sociales</a></li>
                        <li><a href="#" class="MenuBarItemSubmenu">Envío de Archivos</a>
                            <ul>
                                <li><a href="Cuc.php?var_cuc=1">CUC Un Cuerpo</a></li>
                                <li><a href="Indicadores.php">Estructuras Sociales</a></li>
                            </ul>
                        </li>
                        <li><a href="CambioClave.php">Cambio de Clave</a></li>
                        <li><a href="#" class="MenuBarItemSubmenu">Consultas</a>
                            <ul>
                                <li><a href="ConsultaPer.php">Periodos Anteriores</a></li>
                                <li><a href="C_RUBRO_CONSULTA.php?a=reset">Rubros</a></li>
                            </ul>
                        </li>
                        <li><a href="cerrar_sesion.php">Salir</a></li>
                    </ul>
                    <?php
                    break;
                case 10:
                    ?>
                    <ul class="MenuBarHorizontal" id="MenuBar1">
                        <li><a href="#" class="MenuBarItemSubmenu">Datos Financieros</a>
                            <ul>
                                <li><a href="IngresoRubroTodos.php?var_rubro=10">Patrimonio Técnico</a></li>
                                <li><a href="CoberturaOrganizacion.php?a=reset">Cobertura Geográfica</a></li>
                                <li><a href="IngresoRubroTodos.php?var_rubro=3">Cartera & Alcance</a></li>
                            </ul>
                        </li>
                        <li><a href="IngresoRubroTodos.php?var_rubro=5">Datos Sociales</a></li>
                        <li><a href="#" class="MenuBarItemSubmenu">Envío de Archivos</a>
                            <ul>
                                <li><a href="Cuc.php?var_cuc=2">CUC Dos Cuerpos</a></li>
                                <li><a href="Indicadores.php">Estructuras Sociales</a></li>
                            </ul>
                        </li>

                        <li><a href="CambioClave.php">Cambio de Clave</a></li>
                        <li><a href="#" class="MenuBarItemSubmenu">Consultas</a>
                            <ul>
                                <li><a href="ConsultaPer.php">Periodos Anteriores</a></li>
                                <li><a href="C_RUBRO_CONSULTA.php?a=reset">Rubros</a></li>
                            </ul>
                        </li>
                        <li><a href="cerrar_sesion.php">Salir</a></li>
                    </ul>
                    <?php
                    break;
                case 11:
                    ?>
                    <ul class="MenuBarHorizontal" id="MenuBar1">
                        <li><a href="#" class="MenuBarItemSubmenu">Datos Financieros</a>
                            <ul>
                                <li><a href="IngresoRubroTodos.php?var_rubro=8">Datos Cualitativos</a></li>
                            </ul>
                        </li>

                        <li><a href="IngresoPerOrg.php">Ingreso Parámetros</a></li>

                        <li><a href="#" class="MenuBarItemSubmenu">Consultas</a>
                            <ul>
                                <li><a href="ConsultaPer.php">Periodos Anteriores</a></li>
                                <li><a href="C_RUBRO_CONSULTA.php?a=reset">Rubros</a></li>
                            </ul>
                        </li>

                        <li><a href="CambioClave.php">Cambio de Clave</a></li>

                        <li><a href="cerrar_sesion.php">Salir</a></li>
                    </ul>
                    <?php
                    break;
                case 12:
                    ?>
                    <ul class="MenuBarHorizontal" id="MenuBar1">
                        <li><a href="#" class="MenuBarItemSubmenu">Datos Financieros</a>
                            <ul>
                                <li><a href="IngresoRubroTodos.php?var_rubro=10">Patrimonio Técnico</a></li>
                            </ul>
                        </li>
                        <li><a href="CambioClave.php">Cambio de Clave</a></li>

                        <li><a href="#" class="MenuBarItemSubmenu">Consultas</a>
                            <ul>
                                <li><a href="ConsultaPer.php">Periodos Anteriores</a></li>
                                <li><a href="C_RUBRO_CONSULTA.php?a=reset">Rubros</a></li>
                            </ul>
                        </li>
                        <li><a href="cerrar_sesion.php">Salir</a></li>
                    </ul>
                    <?php
                    break;
                case 13:
                    ?>
                    <ul class="MenuBarHorizontal" id="MenuBar1">
                        <li><a href="IngresoPerOrg.php">Ingreso Parámetros</a></li>
                        <li><a href="#" class="MenuBarItemSubmenu">Consultas</a>
                            <ul>
                                <li><a href="ConsultaPer.php">Periodos Anteriores</a></li>
                                <li><a href="C_RUBRO_CONSULTA.php?a=reset">Rubros</a></li>
                                <li><a href="http://rfr-bi.rfr.org.ec:8080/MicroStrategy/servlet/mstrWeb"
                                       target="_blank">Reportes BI (MicroStrategy)</a></li>
                            </ul>
                        </li>
                        <li><a href="CambioClave.php">Cambio de Clave</a></li>
                        <li><a href="cerrar_sesion.php">Salir</a></li>
                    </ul>
                    <?php
                    break;
            }
            ?>
        </div>
        <?php
    }else {
        $var_sw = false;
        ?>
       <span class="Mensajes">Su fecha de ingreso expiró; favor comunicarse con la RFD</span>
        <!--<meta http-equiv="refresh" content=3;url=Login.php>-->
        <?php
        header( "refresh:4;url=cerrar_sesion.php" );
    }
    ?>
    <?php
}
else
{
    $var_sw = false;
    header( "refresh:4;url=cerrar_sesion.php" );
}
?>
<table class="bd" width="100%"><tr><td class="hr"></td></tr></table>

<div class="content_main">
    <?php
    if($var_sw)
    {
        $var_nov_org = $_SESSION["var_organizacion"];
        $var_nov_per = $_SESSION["var_periodo"];
        $consulta="SELECT 	MENU_ID,
        NOMBRE_USUARIO,
        convert(varchar(10),HORA_NOVEDAD,111) FECHA,
        convert(varchar(10),HORA_NOVEDAD,108) HORA,
        DESCRIPCION_NOVEDAD,
        ESTADO_ID
        FROM dbo.C_NOVEDAD
        WHERE
        PERIODO_ID = $var_nov_per AND
        ORGANIZACION_ID = $var_nov_org";
        $resultado=ConsultarTabla($consulta);
        $filas=NumeroFilas($resultado);
        if ($filas > 0)
        {
            echo "<br><br />";
            ?>
            <span class="Novedades">SUS NOVEDADES SON LAS SIGUIENTES:</span>
            <?php
            $i=0;
            while($i<$filas)
            {
                echo "<br><br />";
                switch (mssql_result($resultado,$i,"MENU_ID"))
                {
                    case 1:
                        $var_menu = "ESTADO DE RESULTADOS";
                        break;
                    case 2:
                        $var_menu = "BALANCE";
                        break;
                    case 3:
                        $var_menu = "CARTERA & ALCANCE";
                        break;
                    case 4:
                        $var_menu = "CUC 1 CUERPO";
                        break;
                    case 5:
                        $var_menu = "CUC 2 CUERPO";
                        break;
                    case 6:
                        $var_menu = "COBERTURA";
                        break;
                    case 7:
                        $var_menu = "ESTRUCTURAS SOCIALES";
                        break;
                    case 8:
                        $var_menu = "DATOS SOCIALES";
                        break;
                    case 9:
                        $var_menu = "RUBROS RFR";
                        break;
                    case 10:
                        $var_menu = "RUBROS SWISSCONTACT";
                        break;
                    case 11:
                        $var_menu = "DATOS CUALITATIVOS";
                        break;
                    case 12:
                        $var_menu = "DATOS DE PATRIMONIO TÉCNICO";
                        break;
                    case 13:
                        $var_menu = "CARGAR CUC";
                        break;
                    case 14:
                        $var_menu = "RUBROS DEL CUC";
                        break;
                }
                if(mssql_result($resultado,$i,"ESTADO_ID") == 0)
                {
                    $var_tmp = " E ";
                }
                else
                {
                    $var_tmp = " Y ";
                }
                $var_novedad = mssql_result($resultado,$i,"NOMBRE_USUARIO")
                    .' EL '.mssql_result($resultado,$i,"FECHA")
                    .' A LAS '.mssql_result($resultado,$i,"HORA")
                    .' INGRESÓ A '.$var_menu
                    .$var_tmp.mssql_result($resultado,$i,"DESCRIPCION_NOVEDAD");
                $pos = strpos($var_novedad, ';');
                if(mssql_result($resultado,$i,"ESTADO_ID") == 1)
                {
                    if ($pos === false) {
                        ?>
                        <span class="Bien_Menu"><?php echo $var_novedad; ?></span>
                        <?php
                    }else {
                        $var_novedades = explode(";", $var_novedad);
                        ?>
                        <span class="Bien_Menu"><?php
                            foreach ($var_novedades as $row) {
                                echo $row;
                            } ?></span>
                        <?php
                    }
                }
                else
                {
                    if ($pos === false) {
                        ?>
                        <span class="Mal_Menu"><?php echo $var_novedad; ?></span>
                        <?php
                    }else {
                        $var_novedades = explode(";", $var_novedad);
                        ?>
                        <span class="Mal_Menu">
                  <ul>
                    <?php
                    foreach ($var_novedades as $row) {
                        if ($row != ' ') {
                            echo "<li>$row</li>";
                        }
                    } ?>
                  </ul></span>
                        <?php
                    }
                }
                $i++;
            }
            ?>
            <br>
            <br />
            <table class="bd" width="100%"><tr><td class="hr"></td></tr></table>
            <?php
        }
    }
    Desconectar();
    ?>
</div>

</body>
</html>
<script type="text/javascript">
    <!--
    var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif"});
    //-->
</script>
