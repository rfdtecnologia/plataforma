<? session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
    <title>Ingreso de Rubros</title>
    <link href="SpryAssets/HojasEstilos.css" rel="stylesheet" type="text/css">
    <script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
    <link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css"/>
</head>
<script src="js/dw_event.js" type="text/javascript"></script>
<script src="js/dw_viewport.js" type="text/javascript"></script>
<script src="js/dw_tooltip.js" type="text/javascript"></script>
<script src="js/dw_tooltip_aux.js" type="text/javascript"></script>
<body>
<?php
include('../librerias/libs_sql.php');
Conectar();
$var_rubro = @$_POST['TIPO_RUBRO'];
$var_per_consulta = @$_POST['PERIODO_CONSULTA'];
$var_nombre_usuario = $_SESSION["nombre_usuario"];
$var_usuario = $_SESSION['usuario_id'];
$var_organizacion = $_SESSION["var_organizacion"];
$var_nombre_organizacion = $_SESSION["var_nombre_organizacion"];
$var_imagen = "../imagenes/" . $_SESSION["var_organizacion"] . ".jpg";
$var_periodo = $var_per_consulta;
$consultar = "SELECT *
				FROM dbo.C_PERIODO
				WHERE
				PERIODO_ID = $var_periodo";
$resultado = ConsultarTabla($consultar);
if (mssql_num_rows($resultado)) {
    $var_nombre_periodo = mssql_result($resultado, 0, "NOMBRE_PERIODO");
}
include ('head.php');
?>

<div align="center"><a href="MenuPrincipal.php" class="btn_menu">Menu Principal</a></div>
<div class="content_main content_logo">
    <?php
    include ('top.php');
    ?>
</div>
<div align="center"><a class="btn new blue2" href="ConsultaPer.php">Otra consulta</a></div>
<br></br>
<? if ($var_rubro != 9 && $var_rubro != 11) {
    $consultar = "SELECT
				DAT.CODIGO_SKU,
				DAT.RUBRO_ID,
				RUB.NOMBRE_RUBRO,
				RUB.DESCRIPCION_RUBRO,
				RUB.ESTADO_ID,
				RUB.DESCRIPCION_CUENTA_CONTABLE,
				DAT.RUBRO_VALOR
				FROM
				dbo.C_RUBRO_DATOS DAT,
				dbo.C_RUBRO RUB
				WHERE
				DAT.ORGANIZACION_ID = $var_organizacion AND
				DAT.PERIODO_ID = $var_periodo AND
				DAT.RUBRO_ID = RUB.RUBRO_ID AND
				RUB.GRUPO_ID = $var_rubro
				ORDER BY RUB.SECUENCIAL_DESPLIEGUE_RUBRO";
    $resultado = ConsultarTabla($consultar);
    $filas = NumeroFilas($resultado);
    if ($filas > 0) {
        if ($var_rubro == 5 || $var_rubro == 3 || $var_rubro == 8 || $var_rubro == 10) {
            $var_encabezado = "AYUDA";
        } else {
            $var_encabezado = "CUENTA CONTABLE";
        }
        ?>
        <form action="ModificarRubroTodos.php" method="post">
            <input name="var_rubro" type="hidden" value="<?php echo $var_rubro; ?>"/>
            <table width="100%" border="1" align="center">
                <tr class="Etiquetas">
                    <!--<td width="5%" >RUBRO</td>-->
                    <td width="74%">DESCRIPCION</td>
                    <td width="8%">VALOR</td>
                    <td width="8%">
                        <div align="center"><?php echo $var_encabezado; ?></div>
                    </td>
                <tr/>
                <script type="text/javascript">
                    dw_Tooltip.content_vars =
                        {
                            <?php
                            $i=0;
                            while($i<$filas)
                            {
                                $var_des = "";
                                $var_des1 = "var_des_"  ;
                                $var_des2 = $i;
                                $var_des = $var_des1.$var_des2;
                                $var_cue = "";
                                $var_cue1 = "var_cue_"  ;
                                $var_cue2 = $i;
                                $var_cue = $var_cue1.$var_cue2;
                                $var_texto_des = mssql_result($resultado,$i,"DESCRIPCION_RUBRO");
                                $var_texto_des_salto = str_replace(chr(13).chr(10), " ", $var_texto_des);
                                $var_texto_cue = mssql_result($resultado,$i,"DESCRIPCION_CUENTA_CONTABLE");
                                $var_texto_cue_comma = str_replace(",", ", ", $var_texto_cue);
                                $var_texto_cue_salto = str_replace(chr(13).chr(10), " ", $var_texto_cue_comma);
                                $i++;
                                if ($i < $filas)
                                {

                                    echo "$var_des : '$var_texto_des_salto',";
                                    echo "$var_cue : '$var_texto_cue_salto',";
                                }
                                else
                                {
                                    echo $var_des." : '$var_texto_des_salto'".",";
                                    echo $var_cue." : "."'".$var_texto_cue_salto."'";
                                }
                            }
                            ?>
                        }

                </script>
                <?
                $i = 0;
                while ($i < $filas) {
                    $var_cue = "";
                    $var_cue1 = "var_cue_";
                    $var_cue2 = $i;
                    $var_cue = $var_cue1 . $var_cue2;
                    $var_des = "";
                    $var_des1 = "var_des_";
                    $var_des2 = $i;
                    $var_des = $var_des1 . $var_des2;
                    $var_span = "";
                    $var_span1 = "var_";
                    $var_span2 = $i;
                    $var_span = $var_span1 . $var_span2;
                    $var_rubro_id = mssql_result($resultado, $i, "RUBRO_ID");
                    if ($var_rubro_id == 5 || $var_rubro_id == 11 || $var_rubro_id == 12 || $var_rubro_id == 14 ||
                        $var_rubro_id == 17 || $var_rubro_id == 19 || $var_rubro_id == 29 || $var_rubro_id == 38 ||
                        $var_rubro_id == 45 || $var_rubro_id == 46 || $var_rubro_id == 257 || $var_rubro_id == 259 ||
                        $var_rubro_id == 263 || $var_rubro_id == 270
                    ) {
                        $var_nombre = "<strong> " . mssql_result($resultado, $i, "NOMBRE_RUBRO") . " </strong>";
                    } else {
                        $var_nombre = mssql_result($resultado, $i, "NOMBRE_RUBRO");
                    }
                    /*AQUI SE COLOCA LOS RUBROS EN FONDO GRIS*/
                    if ($var_rubro_id == 149 || $var_rubro_id == 150 || $var_rubro_id == 151 || $var_rubro_id == 152 || $var_rubro_id == 195 ||
                        $var_rubro_id == 153 || $var_rubro_id == 154 || $var_rubro_id == 155 || $var_rubro_id == 156 || $var_rubro_id == 197 ||
                        $var_rubro_id == 126 || $var_rubro_id == 127 || $var_rubro_id == 128 || $var_rubro_id == 129 || $var_rubro_id == 130 ||
                        $var_rubro_id == 135 || $var_rubro_id == 136 || $var_rubro_id == 137 || $var_rubro_id == 138 || $var_rubro_id == 139 ||
                        $var_rubro_id == 140 || $var_rubro_id == 202 || $var_rubro_id == 203 || $var_rubro_id == 204 || $var_rubro_id == 205 ||
                        $var_rubro_id == 206 || $var_rubro_id == 207 || $var_rubro_id == 208 || $var_rubro_id == 209 || $var_rubro_id == 178 ||
                        $var_rubro_id == 179 || $var_rubro_id == 180 || $var_rubro_id == 181 || $var_rubro_id == 182 || $var_rubro_id == 183 ||
                        $var_rubro_id == 184 || $var_rubro_id == 185 || $var_rubro_id == 186 || $var_rubro_id == 187 || $var_rubro_id == 189 ||
                        $var_rubro_id == 190 || $var_rubro_id == 191 || $var_rubro_id == 192 || $var_rubro_id == 201 || $var_rubro_id == 253 ||
                        $var_rubro_id == 255 || $var_rubro_id == 258 || $var_rubro_id == 259 || $var_rubro_id == 302 || $var_rubro_id == 157 ||
                        $var_rubro_id == 158 || $var_rubro_id == 159 || $var_rubro_id == 160 || $var_rubro_id == 194 || $var_rubro_id == 178 ||
                        $var_rubro_id == 255 || $var_rubro_id == 183 || $var_rubro_id == 184 || $var_rubro_id == 317 || $var_rubro_id == 167 ||
                        $var_rubro_id == 168 || $var_rubro_id == 176 || $var_rubro_id == 179 || $var_rubro_id == 180 || $var_rubro_id == 181 ||
                        $var_rubro_id == 319 || $var_rubro_id == 322 || $var_rubro_id == 323 || $var_rubro_id == 324 || $var_rubro_id == 321 ||
                        $var_rubro_id == 325 || $var_rubro_id == 329 || $var_rubro_id == 330 || $var_rubro_id == 335 || $var_rubro_id == 336 ||
                        $var_rubro_id == 337 || $var_rubro_id == 338 || $var_rubro_id == 339 || $var_rubro_id == 340 || $var_rubro_id == 341 ||
                        $var_rubro_id == 342 || $var_rubro_id == 343 || $var_rubro_id == 344 || $var_rubro_id == 345 || $var_rubro_id == 346
                    ) {
                        $var_fondo = " bgcolor='#D6D6D6' ";
                    } else {
                        $var_fondo = "  ";
                    }
                    ?>
                    <tr class="dr">
                        <!--<td width="5%" class="dr" title="<? echo mssql_result($resultado, $i, "DESCRIPCION_RUBRO"); ?>"><? echo mssql_result($resultado, $i, "RUBRO_ID"); ?></td>-->
                        <td width="74%" <?php echo $var_fondo; ?>
                            class="<?php echo "showTip " . $var_des; ?>"><? echo $var_nombre; ?></td>
                        <td width="8%">
                            <input name="<? echo 'codigo' . $i ?>" type="hidden"
                                   value="<? echo mssql_result($resultado, $i, "CODIGO_SKU"); ?>"/>
                            <input name="<? echo 'rubro' . $i ?>" type="hidden"
                                   value="<? echo mssql_result($resultado, $i, "RUBRO_ID"); ?>"/>
                            <span id="<?php echo $var_span; ?>">
				<label>
				<input type="text"
                    <?php
                    $var_var_rubro_valor = 0.00;
                    $var_var_rubro_valor = mssql_result($resultado, $i, "RUBRO_VALOR");
                    if (mssql_result($resultado, $i, "ESTADO_ID") == 1) {
                        echo 'class="dr"';
                    } else {
                        echo 'class="dr"';
                    }
                    ?>
                       name="<? echo 'valor' . $i ?>"
                       id="text1"
                       value="<? echo $var_var_rubro_valor; ?>"
                    <?php
                    if (mssql_result($resultado, $i, "ESTADO_ID") == 1) {
                        echo 'readonly="readonly">';
                    } else {
                        echo 'readonly="readonly">';
                    }
                    ?>
				</label>
				<span class="textfieldInvalidFormatMsg">Formato Incorrecto</span>
				<span class="textfieldRequiredMsg">Ingrese Algun Valor</span> </span>
                            <script type="text/javascript">
                                var <?php echo $var_span;?> = new Spry.Widget.ValidationTextField("<?php echo $var_span;?>", "real", {validateOn: ["blur"]});
                            </script>
                        </td>
                        <td width="8%" align="center" class="<?php echo  'showTip ' . $var_cue; ?>"><img src="../imagenes/ayuda.jpg" width="26" height="26"/></td>
                    </tr>
                    <?
                    $i++;
                }
                ?>
            </table>
        </form>
        <?php
    } else {
        ?>
        <span class="Mensajes">No existen datos favor comunicarse con RFD</span>
        <?php
    }
    ?>
    <br><br/>
    <table class="bd" width="100%">
        <tr>
            <td class="hr"></td>
        </tr>
    </table>
    <?php Desconectar();
} else {
//se cierra el if $var_rubro <> 9
    if ($var_rubro == 9) {
        $consultaTotalCobertura = "SELECT
    			SUM(MONTO_CARTERA_POR_VENCER) AS POR_VENCER,
    			SUM(MONTO_CARTERA_NO_DEVENGA_INTERES) AS NO_DEVENGA,
    			SUM(MONTO_CARTERA_VENCIDO) AS VENCIDO,
    			SUM(MONTO_CARTERA) AS CARTERA,
    			SUM(CLIENTES_ACTIVOS_CREDITOS) AS CLIENTES,
    			SUM(NUMERO_OFICINAS) AS OFICINAS,
    			SUM(MONTO_AHORRO) AS MONTO_AHORRO,
    			SUM(CLIENTES_ACTIVOS_AHORROS) AS CLIENTES_ACTIVOS_AHORROS
    			FROM dbo.C_COBERTURA_GEOGRAFICA
    			WHERE
    			PERIODO_ID = $var_periodo AND
    			ORGANIZACION_ID =" . $var_organizacion
            . "AND ESTADO_ID = 1";
        $res = mssql_query($consultaTotalCobertura, $conn);
        $var_cartera_por_vencer = mssql_result($res, 0, "POR_VENCER");
        $var_cartera_no_devenga_interes = mssql_result($res, 0, "NO_DEVENGA");
        $var_cartera_vencido = mssql_result($res, 0, "VENCIDO");
        $var_cartera = mssql_result($res, 0, "CARTERA");
        $var_clientes = mssql_result($res, 0, "CLIENTES");
        $var_oficinas = mssql_result($res, 0, "OFICINAS");
        $var_ahorros = mssql_result($res, 0, "MONTO_AHORRO");
        $var_cliActAhorros = mssql_result($res, 0, "CLIENTES_ACTIVOS_AHORROS");
        $resultadoTotal = ConsultarTabla($consultaTotalCobertura);
        $filas = NumeroFilas($resultadoTotal);
        ?>
        <br>
        <table width="80%" border="0" align="center">
            <tr class="Bien" align="center" bgcolor="#CED8F6">
                <td>TOTAL OFICINAS</td>
                <td>TOTAL MONTO CARTERA POR VENCER</td>
                <td>TOTAL MONTO CARTERA QUE NO DEVENGA INTERESES</td>
                <td>TOTAL MONTO CARTERA VENCIDA</td>
                <td>TOTAL MONTO CARTERA</td>
                <td>TOTAL CLIENTES ACTIVOS CRÉDITOS</td>
                <td>TOTAL MONTO AHORRO</td>
                <td>TOTAL CLIENTES ACTIVOS AHORROS</td>
            </tr>
            <tr class="Etiquetas" align="center">
                <td><?php echo number_format($var_oficinas, 0, '.', ','); ?></td>
                <td><?php echo number_format($var_cartera_por_vencer, 2, '.', ','); ?></td>
                <td><?php echo number_format($var_cartera_no_devenga_interes, 2, '.', ','); ?></td>
                <td><?php echo number_format($var_cartera_vencido, 2, '.', ','); ?></td>
                <td><?php echo number_format($var_cartera, 2, '.', ','); ?></td>
                <td><?php echo number_format($var_clientes, 0, '.', ','); ?></td>
                <td><?php echo number_format($var_ahorros, 2, '.', ','); ?></td>
                <td><?php echo number_format($var_cliActAhorros, 0, '.', ','); ?></td>
            </tr>
        </table>
        <?php
        $consultaCobertura = "SELECT CBR.PERIODO_ID AS PERIODO, CONVERT(VARCHAR(6),CBR.PERIODO_ID) AS PERIODO_ID, CONVERT(VARCHAR(30),PER.NOMBRE_PERIODO) AS NOMBRE_PERIODO, CBR.ORGANIZACION_ID, CONVERT(VARCHAR(80),ORG.NOMBRE_ORGANIZACION) AS NOMBRE_ORGANIZACION, CBR.PROVINCIA_ID, CONVERT(VARCHAR(50),PRO.NOMBRE_PROVINCIA) AS NOMBRE_PROVINCIA, CBR.CANTON_ID, CONVERT(VARCHAR(50),CAN.NOMBRE_CANTON)AS NOMBRE_CANTON,CONVERT(VARCHAR(15),CBR.NUMERO_OFICINAS) AS NUMERO_OFICINAS,CONVERT(VARCHAR(15),CBR.MONTO_CARTERA_POR_VENCER) AS POR_VENCER,CONVERT(VARCHAR(15),CBR.MONTO_CARTERA_NO_DEVENGA_INTERES) AS NO_DEVENGA,CONVERT(VARCHAR(15),CBR.MONTO_CARTERA_VENCIDO) AS VENCIDO,CONVERT(VARCHAR(15),CBR.MONTO_CARTERA) AS MONTO_CARTERA,CONVERT(VARCHAR(15),CBR.CLIENTES_ACTIVOS_CREDITOS) AS CLIENTES_ACTIVOS_CREDITOS,CONVERT(VARCHAR(15),CBR.MONTO_AHORRO ) AS MONTO_AHORRO,	CONVERT(VARCHAR(15),CBR.CLIENTES_ACTIVOS_AHORROS) AS CLIENTES_ACTIVOS_AHORROS,	CONVERT(VARCHAR(4),CBR.ESTADO_ID ) AS ESTADO_ID from dbo.C_COBERTURA_GEOGRAFICA CBR, dbo.C_PERIODO PER, dbo.C_ORGANIZACION ORG, dbo.C_PROVINCIA PRO, dbo.C_CANTON CAN WHERE CBR.PERIODO_ID = PER.PERIODO_ID AND CBR.ORGANIZACION_ID = ORG.ORGANIZACION_ID AND PRO.PROVINCIA_ID = CAN.PROVINCIA_ID AND CBR.PROVINCIA_ID = CAN.PROVINCIA_ID AND CBR.CANTON_ID = CAN.CANTON_ID AND CBR.ORGANIZACION_ID =" . $var_organizacion . " AND CBR.PERIODO_ID =" . $var_per_consulta;
        $resultado = ConsultarTabla($consultaCobertura);
        $filas = NumeroFilas($resultado);
        if ($filas > 0) {
            ?>

            <table class="tbl" border="0" cellspacing="1" cellpadding="7" width="100%">
            <tr>
                <td class="hr">PROVINCIA</td>
                <td class="hr">CANTON</td>
                <td class="hr">NRO. OFICINAS</td>
                <td class="hr">MONTO CARTERA POR VENCER</td>
                <td class="hr">MONTO CARTERA QUE NO DEVENGA INTERESES</td>
                <td class="hr">MONTO CARTERA VENCIDA</td>
                <td class="hr">MONTO CARTERA</td>
                <td class="hr">CLIENTES ACTIVOS CREDITOS</td>
                <td class="hr">MONTO AHORRO</td>
                <td class="hr">CLIENTES ACTIVOS AHORROS</td>
                <td class="hr">ESTADO</td>
            </tr>
            <?

            //Mostramos los registros
            while ($row = mssql_fetch_array($resultado)) {
                ?>
                <tr>
                    <td><?php echo $row["NOMBRE_PROVINCIA"]; ?></td>
                    <td><?php echo $row["NOMBRE_CANTON"]; ?></td>
                    <td><?php echo $row["NUMERO_OFICINAS"]; ?></td>
                    <td><?php echo $row["POR_VENCER"]; ?></td>
                    <td><?php echo $row["NO_DEVENGA"]; ?></td>
                    <td><?php echo $row["VENCIDO"]; ?></td>
                    <td><?php echo $row["MONTO_CARTERA"]; ?></td>
                    <td><?php echo $row["CLIENTES_ACTIVOS_CREDITOS"]; ?></td>
                    <td><?php echo $row["MONTO_AHORRO"]; ?></td>
                    <td><?php echo $row["CLIENTES_ACTIVOS_AHORROS"]; ?></td>
                    <td><?php echo $row["ESTADO_ID"]; ?></td>
                </tr>
            <?php }
        } ?>
        </table>

    <?php }
    if ($var_rubro == 11) {
        $consulta_cuc = "SELECT CAR.CC, CUC.NOMBRE_CUC, CAR.SALDO_NUMERICO FROM C_CUC_CARGA CAR, C_CUC CUC WHERE CAR.CC = CUC.CUC_ID AND CAR.ORGANIZACION_ID = $var_organizacion AND CAR.PERIODO_ID = $var_periodo ORDER BY CUC.SECUENCIAL_DESPLIEGUE_CUC";
        $resutado_cuc = ConsultarTabla($consulta_cuc);
        $fila_cuc = NumeroFilas($resutado_cuc);
        if ($fila_cuc > 0) { ?>
            <table class="tbl tbl_cuc" border="0" cellspacing="1" cellpadding="7" width="100%">
                <tr>
                    <td class="hr">CUENTA</td>
                    <td class="hr">DESCRIPCIÓN</td>
                    <td class="hr">VALOR</td>
                </tr>
                <?php
                //Mostramos los registros
                while ($row = mssql_fetch_array($resutado_cuc)) {
                    ?>
                    <tr>
                        <td><?php echo $row["CC"]; ?></td>
                        <td><?php echo $row["NOMBRE_CUC"]; ?></td>
                        <td><?php echo $row["SALDO_NUMERICO"]; ?></td>
                    </tr>
                <?php } ?>
            </table>
        <?php }
    }
} ?>
<table width="100%" border="0">
    <tr>
        <td>
            <br></br>
            <div align="center"><a class="btn new blue2" href="ConsultaPer.php">Otra consulta</a></div>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>
            <div align="center"><a href="MenuPrincipal.php" class="btn_menu">Menu Principal</a></div>
        </td>
    </tr>
</table>
</body>
</html>
