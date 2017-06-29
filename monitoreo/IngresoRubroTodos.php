<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Ingreso de Rubros</title>
    <link href="SpryAssets/HojasEstilos.css" rel="stylesheet" type="text/css">
    <script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
    <link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>
<script src="js/dw_event.js" type="text/javascript"></script>
<script src="js/dw_viewport.js" type="text/javascript"></script>
<script src="js/dw_tooltip.js" type="text/javascript"></script>
<script src="js/dw_tooltip_aux.js" type="text/javascript"></script>
<body>
<?php
include('../librerias/libs_sql.php');
$var_perfil = $_SESSION["perfil_usuario"];
$var_nombre_usuario = $_SESSION["nombre_usuario"];
$var_usuario = $_SESSION['usuario_id'];
$var_organizacion = $_SESSION["var_organizacion"];
$var_periodo = $_SESSION["var_periodo"];
$var_nombre_periodo = $_SESSION["var_nombre_periodo"];
$var_nombre_organizacion = $_SESSION["var_nombre_organizacion"];
$var_rubro = @$_GET["var_rubro"];
$var_imagen = "../imagenes/".$_SESSION["var_organizacion"].".jpg";
$fecha = fecha();
$var_descripcion = "INGRESÓ Y NO GRABO";
$var_mes = substr("$var_periodo", -2);
Conectar();
include ('head.php');
?>
<div align="center"><a href="MenuPrincipal.php" class="btn_menu">Menu Principal</a></div>
<div class="content_main content_logo">
    <?php
    include ('top.php');
    ?>
</div>

<?php
$consultar="SELECT *
				FROM dbo.C_NOVEDAD
				WHERE
				PERIODO_ID = $var_periodo AND
				ORGANIZACION_ID = $var_organizacion AND
				MENU_ID = $var_menu";
$resultado=ConsultarTabla($consultar);
$filas=NumeroFilas($resultado);
if ($filas == 0)
{
    $query1='INSERT INTO dbo.C_NOVEDAD (PERIODO_ID,ORGANIZACION_ID,MENU_ID,ESTADO_ID,USUARIO_ID,HORA_NOVEDAD,DESCRIPCION_NOVEDAD,NOMBRE_USUARIO) VALUES 
    ('.$var_periodo.','.$var_organizacion.','.$var_menu.',0,'.$var_usuario.',"'.$fecha.'","'.$var_descripcion.'","'.$var_nombre_usuario.'")';
    Actualizar($query1);
}

/*SUMA LOS ESTADOS DE RESULTADOS*/
$consultar="SELECT SUM(DAT.RUBRO_VALOR) SUMA
				FROM
				dbo.C_RUBRO_DATOS DAT,
				dbo.C_RUBRO RUB
				WHERE
				DAT.ORGANIZACION_ID = $var_organizacion AND
				DAT.PERIODO_ID = $var_periodo AND
				DAT.RUBRO_ID = RUB.RUBRO_ID AND
				RUB.GRUPO_ID = 1";
$resultado=ConsultarTabla($consultar);
$var_suma = mssql_result($resultado,0,"SUMA");
/*FIN*/

/*SUMA PATRIMONIO TECNICO*/
$consultar="SELECT SUM(DAT.RUBRO_VALOR) SUMA
				FROM
				dbo.C_RUBRO_DATOS DAT,
				dbo.C_RUBRO RUB
				WHERE
				DAT.ORGANIZACION_ID = $var_organizacion AND
				DAT.PERIODO_ID = $var_periodo AND
				DAT.RUBRO_ID = RUB.RUBRO_ID AND
				RUB.GRUPO_ID = 10";
$resultado=ConsultarTabla($consultar);
$var_suma_patrimonio = mssql_result($resultado,0,"SUMA");

/**/

$consultar="select sum(NUMERO_OFICINAS) OFICINAS,sum(MONTO_CARTERA) CARTERA,sum(CLIENTES_ACTIVOS_CREDITOS) CLIENTES, sum(MONTO_AHORRO) AHORRO, sum(CLIENTES_ACTIVOS_AHORROS) CLIAHO, sum(MONTO_CARTERA_POR_VENCER) POR_VENCER, sum(MONTO_CARTERA_NO_DEVENGA_INTERES) NO_DEVENGA, sum(MONTO_CARTERA_VENCIDO) VENCIDO
				FROM dbo.C_COBERTURA_GEOGRAFICA
				WHERE PERIODO_ID = $var_periodo AND ORGANIZACION_ID = $var_organizacion AND ESTADO_ID = 1";
$resultado=ConsultarTabla($consultar);
$var_oficinas = mssql_result($resultado,0,"OFICINAS");
$var_cartera = mssql_result($resultado,0,"CARTERA");
$var_clientes = mssql_result($resultado,0,"CLIENTES");
/*INICIO LAS VARIABLES*/
$var_total_monto_ahorro_cobertura = mssql_result($resultado,0,"AHORRO");
$var_total_clientes_activos_ahorros_cobertura = mssql_result($resultado,0, "CLIAHO");
$var_por_vencer = mssql_result($resultado,0, "POR_VENCER");
$var_no_devenga = mssql_result($resultado,0, "NO_DEVENGA");
$var_vencido = mssql_result($resultado,0, "VENCIDO");
/*FIN DE VARIABLE*/
$consultar="SELECT mision as MISION, vision as VISION FROM dbo.C_ORGANIZACION WHERE(ORGANIZACION_ID=" .$var_organizacion .")";
$resultado=ConsultarTabla($consultar);
$var_mision = trim(mssql_result($resultado,0,"MISION"));
$var_vision = trim(mssql_result($resultado,0,"VISION"));

$consultar="SELECT
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
$resultado=ConsultarTabla($consultar);
$filas=NumeroFilas($resultado);

if ($filas > 0)
{
    if((empty($var_mision) or empty($var_vision)) and $var_perfil <> 1)
    {
        ?>
        <span class="Alerta">Primero debe ingresar la Misión y Visión de su Institución</span>
        <?php
    }
    else
    {
        $var_sw = false;
        switch($var_rubro)
        {
            case 2:
                //if($var_suma > 0 and $var_suma_balance > 0 )
                //if($var_suma > 0 and $var_suma_patrimonio > 0) ESTE PARAMETRO VALIDA QUE SE INGRESE ESTADO DE RESULTADOS Y PATRIMONIO TECNICO PARA JUNIO 2014
                if($var_suma > 0)
                {
                    $var_sw = true;
                }
                else
                {
                    //$var_mensaje = "Primero debe ingresar el Estado de Resultados y/o Patrimonio Técnico";
                    $var_mensaje = "Primero debe ingresar el Estado de Resultados";
                }
                break;
            case 3:
                if ($var_mes == '01' || $var_mes == '02' || $var_mes == '04' || $var_mes == '05' || $var_mes == '07' || $var_mes == '08' || $var_mes == '10' || $var_mes == '11' ) {
                    $var_sw = true;
                }
                else
                {
                    if ($var_intermediacion == 'S')
                    {
                        if($var_rubro == 3 and $var_oficinas > 0 and $var_cartera > 0 and $var_clientes > 0 and $var_total_monto_ahorro_cobertura >0 and $var_total_clientes_activos_ahorros_cobertura > 0 and $var_por_vencer > 0 and $var_no_devenga > 0 and $var_vencido > 0)
                        {
                            $var_sw = true;
                        }
                        else
                        {
                            $var_mensaje = "Primero debe ingresar la Cobertura Geográfica";
                        }
                    }
                    else
                    {
                        if($var_rubro == 3 and $var_oficinas > 0 and $var_cartera > 0 and $var_clientes > 0 and $var_por_vencer > 0 and $var_no_devenga > 0 and $var_vencido > 0)
                        {
                            $var_sw = true;
                        }
                        else
                        {
                            $var_mensaje = "Primero debe ingresar la Cobertura Geográfica";
                        }
                    }
                }
                break;
            default:
                $var_sw = true;
                break;
        }
        if ($var_sw)
        {
            if($var_rubro == 5 || $var_rubro == 3 || $var_rubro == 8  || $var_rubro == 10)
            {
                $var_encabezado = "AYUDA";
            }
            else
            {
                $var_encabezado = "CUENTA CONTABLE";
            }
            ?>
            <form action="ModificarRubroTodos.php" method="post">
                <input name="var_rubro" type="hidden" value="<?php echo $var_rubro; ?>" />
                <table width="100%" border="1" align="center">
                    <tr class="Etiquetas">
                        <!-- Aqui aparece el código -->
                        <!--  <td width="5%" >RUBRO</td> -->
                        <td width="74%">DESCRIPCION</td>
                        <td width="10%">VALOR</td>
                        <td width="10%"><div align="center"><?php echo $var_encabezado;?></div></td>
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
                    $i=0;
                    while($i<$filas)
                    {
                        $var_cue = "";
                        $var_cue1 = "var_cue_"  ;
                        $var_cue2 = $i;
                        $var_cue = $var_cue1.$var_cue2;
                        $var_des = "";
                        $var_des1 = "var_des_"  ;
                        $var_des2 = $i;
                        $var_des = $var_des1.$var_des2;
                        $var_span = "";
                        $var_span1 = "var_"  ;
                        $var_span2 = $i;
                        $var_span = $var_span1.$var_span2;
                        $var_rubro_id = mssql_result($resultado,$i,"RUBRO_ID");
                        $var_valida_decimal = "real";
                        /*AQUI COLOCAMOS LOS RUBROS QUE NO SE PUEDE INGRESAR DECIMALES*/
                        if ($var_rubro_id == 104 || $var_rubro_id == 121 || $var_rubro_id == 105 || $var_rubro_id == 106 || $var_rubro_id == 122 || $var_rubro_id == 260 || $var_rubro_id == 107 || $var_rubro_id == 108 || $var_rubro_id == 316 || $var_rubro_id == 109 || $var_rubro_id == 196 || $var_rubro_id == 153 || $var_rubro_id == 154 || $var_rubro_id == 155 || $var_rubro_id == 156 || $var_rubro_id == 197 || $var_rubro_id == 131 || $var_rubro_id == 132 || $var_rubro_id == 133 || $var_rubro_id == 134) {
                            $var_valida_decimal = "integer";
                        }
                        /*AQUI PONEMOS NEGRILA A LOS TITULOS*/
                        if($var_rubro_id == 5 || $var_rubro_id == 11 || $var_rubro_id == 12 || $var_rubro_id == 14 ||
                            $var_rubro_id == 17 || $var_rubro_id == 19 || $var_rubro_id == 29 || $var_rubro_id == 38 ||
                            $var_rubro_id == 45 || $var_rubro_id == 46 || $var_rubro_id == 257 || $var_rubro_id == 259 ||
                            $var_rubro_id == 263 || $var_rubro_id == 270 || $var_rubro_id == 325 || $var_rubro_id == 324 ||
                            $var_rubro_id == 323  || $var_rubro_id == 322 || $var_rubro_id == 326 || $var_rubro_id == 327 || $var_rubro_id == 328 )
                        {
                            $var_nombre = "<strong> ".mssql_result($resultado,$i,"NOMBRE_RUBRO")." </strong>";
                        }
                        else
                        {
                            $var_nombre = mssql_result($resultado,$i,"NOMBRE_RUBRO");
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
                            $var_rubro_id == 342 || $var_rubro_id == 343 || $var_rubro_id == 344 || $var_rubro_id == 345 || $var_rubro_id == 346)
                        {
                            $var_fondo = " bgcolor='#D6D6D6' ";
                        }
                        else
                        {
                            $var_fondo = "  ";
                        }
                        ?>
                        <tr class="dr">
                            <!-- Aqui aparece el código -->
                            <!-- <td width="5%" class="dr" title="<? echo mssql_result($resultado,$i,"DESCRIPCION_RUBRO");?>"><? echo mssql_result($resultado,$i,"RUBRO_ID");?></td> -->
                            <td width="74%" <?php echo $var_fondo;?>  class= "<?php echo "showTip ".$var_des;?>" ><? echo $var_nombre;?></td>
                            <td width="8%">
                                <input name="<? echo 'codigo'.$i?>" type="hidden" value="<? echo mssql_result($resultado,$i,"CODIGO_SKU");?>"/>
                                <input name="<? echo 'rubro'.$i?>" type="hidden" value="<? echo mssql_result($resultado,$i,"RUBRO_ID");?>"/>
                                <span id="<?php echo $var_span ;?>">
						<label>
						<input type="text"
                            <?php
                            $var_var_rubro_valor = 0.00;
                            $var_var_rubro_valor = mssql_result($resultado,$i,"RUBRO_VALOR");
                            if ($var_carga_cuc == 'N' && $var_intermediacion == 'S')
                            {
                                if(mssql_result($resultado,$i,"ESTADO_ID") == 1)
                                {
                                    echo 'class="dr"';
                                }
                                else
                                {
                                    echo 'class="calculados"';
                                }
                            }
                            else
                            {	/*aqui el color del fondo de la caja de texto de los rubros*/
                                if(($var_rubro_id == 100 || $var_rubro_id == 101 ||$var_rubro_id == 102 || $var_rubro_id == 256 ||
                                        $var_rubro_id == 149 || $var_rubro_id == 150 ||$var_rubro_id == 151 || $var_rubro_id == 258 ||
                                        $var_rubro_id == 195 || $var_rubro_id == 301 ||$var_rubro_id == 302 || $var_rubro_id == 322 ||
                                        $var_rubro_id == 323 || $var_rubro_id == 324 || $var_rubro_id == 325 || $var_rubro_id == 327 ||
                                        $var_rubro_id == 328 || $var_rubro_id == 326 || $var_rubro_id == 331 || $var_rubro_id == 332 ||
                                        $var_rubro_id == 333 || $var_rubro_id == 334 || $var_rubro_id == 335 || $var_rubro_id == 336 ||
                                        $var_rubro_id == 337 || $var_rubro_id == 338)
                                    and $var_carga_cuc == 'S')
                                {
                                    echo 'class="read_only"';
                                }
                                /*AQUI PUSE LOS ID DE LOS RUBROS PARA QUE SE SOMBREEN EL VALOR PARA ONG EL VALOR ID*/
                                elseif(($var_rubro_id == 198 || $var_rubro_id == 199 || $var_rubro_id == 200 || $var_rubro_id == 30 ||
                                        $var_rubro_id == 31 || $var_rubro_id == 122 || $var_rubro_id == 106 || $var_rubro_id == 260 ||
                                        $var_rubro_id == 313 || $var_rubro_id == 314 || $var_rubro_id == 322 || $var_rubro_id == 323 ||
                                        $var_rubro_id == 324 || $var_rubro_id == 325 || $var_rubro_id == 327 || $var_rubro_id == 328 ||
                                        $var_rubro_id == 326 || $var_rubro_id == 157 || $var_rubro_id == 158 || $var_rubro_id == 159 ||
                                        $var_rubro_id == 160 || $var_rubro_id == 329 || $var_rubro_id == 330) and $var_intermediacion == 'N' )
                                {
                                    echo 'class="read_only"';
                                }
                                else
                                {
                                    if(mssql_result($resultado,$i,"ESTADO_ID") == 1)
                                    {
                                        echo 'class="dr"';
                                    }
                                    else
                                    {
                                        echo 'class="calculados"';
                                    }
                                }
                            }
                            ?>
                               name="<? echo 'valor'.$i?>"
                               id="text1"
                               value="<? echo $var_var_rubro_valor;?>"
                            <?php
                            if ($var_carga_cuc == 'N' && $var_intermediacion == 'S')
                            {
                                if(mssql_result($resultado,$i,"ESTADO_ID") == 1)
                                {
                                    echo '>';
                                }
                                else
                                {
                                    echo 'readonly="readonly">';
                                }
                            }
                            else
                            {	/*AQUI PONGO PARA QUE LOS RUBROS SEAN DE SOLO LECTURA EL VALOR ID*************************************************************************************/
                                if(($var_rubro_id == 100 || $var_rubro_id == 101 ||$var_rubro_id == 102 || $var_rubro_id == 256 ||
                                        $var_rubro_id == 149 || $var_rubro_id == 150 ||$var_rubro_id == 151 || $var_rubro_id == 258 ||
                                        $var_rubro_id == 195 || $var_rubro_id == 301 ||$var_rubro_id == 302 ||$var_rubro_id == 322 ||
                                        $var_rubro_id == 323 || $var_rubro_id == 324 || $var_rubro_id == 325 || $var_rubro_id == 327 ||
                                        $var_rubro_id == 328 || $var_rubro_id == 326 || $var_rubro_id == 331 || $var_rubro_id == 332 ||
                                        $var_rubro_id == 333 || $var_rubro_id == 334 || $var_rubro_id == 335 || $var_rubro_id == 336 ||
                                        $var_rubro_id == 337 || $var_rubro_id == 338)
                                    and $var_carga_cuc == 'S')
                                {
                                    echo 'readonly="readonly">';
                                }
                                /*AQUI PUSE LOS ID DE LOS RUBROS PARA QUE SEAN DE LECTURA PARA ONG EL VALOR ID*/
                                elseif(($var_rubro_id == 198 || $var_rubro_id == 199 || $var_rubro_id == 200 || $var_rubro_id == 30 ||
                                        $var_rubro_id == 31 || $var_rubro_id == 122 || $var_rubro_id == 106 || $var_rubro_id == 313 ||
                                        $var_rubro_id == 314 ||$var_rubro_id == 322 ||$var_rubro_id == 323 || $var_rubro_id == 324 ||
                                        $var_rubro_id == 325 || $var_rubro_id == 327 || $var_rubro_id == 328 || $var_rubro_id == 326 ||
                                        $var_rubro_id == 157 || $var_rubro_id == 158 || $var_rubro_id == 159 || $var_rubro_id == 160 ||
                                        $var_rubro_id == 329 || $var_rubro_id == 330) and $var_intermediacion == 'N' )
                                {
                                    echo 'readonly="readonly">';
                                }
                                else
                                {
                                    if(mssql_result($resultado,$i,"ESTADO_ID") == 1)
                                    {
                                        echo '>';
                                    }
                                    else
                                    {
                                        echo 'readonly="readonly">';
                                    }
                                }
                            }
                            ?>
						</label>
						<span class="textfieldInvalidFormatMsg">Formato Incorrecto</span>
						<span class="textfieldRequiredMsg">Ingrese Algun Valor</span> </span>
                                <script type="text/javascript">
                                    <!--
                                    var <?php echo $var_span ;?> = new Spry.Widget.ValidationTextField("<?php echo $var_span ;?>", "<?php echo $var_valida_decimal ?>", {validateOn:["blur"]});
                                    -->
                                </script>            </td>
                            <td width="8%" align="center" class= "<?php echo "showTip ".$var_cue;?>" ><img src="../imagenes/ayuda.jpg" width="26" height="26" /></td>
                        </tr>
                        <?
                        $i++;
                    }
                    ?>
                    
                </table>
                <table width="100%" border="0">
                                    <tr>
                                        <td>
                                        <input type="hidden" name="contador" value="<? echo $i?>" />
                                        <input type="submit" value="Grabar y Salir" class="btn save green" /></td>
                                        <td><div align="right">

                                                <input type="submit" value="Calcular" class="btn calc blue" onClick="this.form.action='ModificarRubroTodosCalcula.php'"/>

                                            </div></td>
                                    </tr>
                                </table>
            </form>
            <?php
        }
        else
        {
            echo "<span class=\"Alerta\">".$var_mensaje."</span>";
        }
    }
}
else
{
    ?>
    <span class="Alerta">No existen datos a ser ingresados favor comunicarse con la RFD</span>
    <?php
}
?>
<br><br />
<table width="100%" border="0">
    <tr>
        <td><div align="center"><a href="MenuPrincipal.php" class="btn_menu">Menu Principal</a></div></td>
    </tr>
</table>
<table class="bd" width="100%"><tr><td class="hr"></td></tr></table>
<?php Desconectar(); ?>
</body>
</html>
