<? session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Grabar Rubros</title>
    <link href="SpryAssets/HojasEstilos.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
    include('../librerias/libs_sql.php');
    Conectar();
    $var_nombre_usuario = $_SESSION["nombre_usuario"];
    $var_usuario = $_SESSION['usuario_id'];
    $var_rubro = $_POST["var_rubro"];
    $var_organizacion = $_SESSION["var_organizacion"];
    $var_periodo = $_SESSION["var_periodo"];
    $var_imagen = "../imagenes/".$_SESSION["var_organizacion"].".jpg";
    $fecha = fecha();
    $var_solo_cartera = $_SESSION["var_solo_cartera"];
    $var_intermediacion = $_SESSION["var_intermediacion"];
    $var_valida_patrimonio_secundario = $_SESSION["var_valida_patrimonio_secundario"];
    $var_mes = substr("$var_periodo", -2);
    $var_ano = substr("$var_periodo", 0, 4);
    $var_ano_anteior = $var_ano;
    switch ($var_mes) {
        case '03':
            $var_ano_anteior = $var_ano_anteior - 1;
            $var_mes_anterior = '12';
            break;
        case '06':
            $var_mes_anterior = '03';
            break;
        case '09':
            $var_mes_anterior = '06';
            break;
        case '12':
            $var_mes_anterior = '09';
            break;
    }
    $var_periodo_anterior = $var_ano_anteior.$var_mes_anterior;
?>
<table class="bd" width="100%"><tr><td class="hr"><h2>RFD-ONLINE</h2></td></tr></table>
<!--<div align="center"><a href="MenuPrincipal.php" class="btn_menu">Menu Principal</a></div>-->
<div class="content_main content_logo">
    <?php
    include ('top.php');
    ?>
</div>
<?
switch ($var_rubro)
{
    case 1:
        $sw = false;
        $var_rubro_5 = 0.00;
        $var_rubro_11 = 0.00;
        $var_rubro_12 = 0.00;
        $var_rubro_14 = 0.00;
        $var_rubro_17 = 0.00;
        $var_rubro_19 = 0.00;
        $i=$_POST['contador'];
        for($j=0;$j<$i;$j++)
        {
            $var="codigo".$j;
            $var1="valor".$j;
            $var2="rubro".$j;
            $codigo=$_POST[$var];
            $cajatexto=$_POST[$var1];
            $var_rubro_id = $_POST[$var2];
            if($var_rubro_id == 1 || $var_rubro_id == 2 || $var_rubro_id == 3 || $var_rubro_id == 4)
            {
                $var_rubro_5 = $var_rubro_5 + $cajatexto;
            }
            if($var_rubro_id == 6 || $var_rubro_id == 7 || $var_rubro_id == 8 || $var_rubro_id == 9 || $var_rubro_id == 10)
            {
                $var_rubro_11 = $var_rubro_11 + $cajatexto;
            }
            if($var_rubro_id == 15 || $var_rubro_id == 16)
            {
                $var_rubro_17 = $var_rubro_17 + $cajatexto;
            }
            switch ($var_rubro_id)
            {
                case 13:
                    $var_rubro_14 = $cajatexto * -1;
                    break;
                case 18:
                    $var_rubro_19 = $cajatexto * -1;
                    break;
            }
            switch ($var_rubro_id)
            {
                case 5:
                    $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$var_rubro_5 WHERE CODIGO_SKU=$codigo";
                    break;
                case 11:
                    $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$var_rubro_11 WHERE CODIGO_SKU=$codigo";
                    break;
                case 12:
                    $var_rubro_12 = $var_rubro_5 - $var_rubro_11;
                    $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$var_rubro_12 WHERE CODIGO_SKU=$codigo";
                    break;
                case 14:
                    $var_rubro_14 = $var_rubro_14 + $var_rubro_12;
                    $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$var_rubro_14 WHERE CODIGO_SKU=$codigo";
                    break;
                case 17:
                    $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$var_rubro_17 WHERE CODIGO_SKU=$codigo";
                    break;
                case 19:
                    $var_rubro_19 = $var_rubro_19 + $var_rubro_14 + $var_rubro_17;
                    $query="update C_RUBRO_DATOS SET RUBRO_VALOR='$var_rubro_19' WHERE CODIGO_SKU=$codigo";
                    $query1="update C_RUBRO_DATOS SET RUBRO_VALOR='$var_rubro_19' WHERE ORGANIZACION_ID = $var_organizacion AND PERIODO_ID = $var_periodo AND RUBRO_ID = 43";
                    Actualizar($query1);
                    break;
                default:
                    $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$cajatexto WHERE CODIGO_SKU=$codigo";
                    break;
            }
            Actualizar($query);
        }
        $sw = true;
        $var_graba = "SUS DATOS SE GRABARON Y VALIDARON CON ÉXITO";
        ?>
        <span class="Bien"><?php echo $var_graba;?></span>
        <?php
        break;
    case 2:
        $sw = false;
        $sw1 = false;
        $sw2 = false;
        $sw3 = false;
        $sw4 = false;
        //$var_cliActAhorros;
        $var_rubro_29 = 0.00; //total activos
        $var_rubro_32 = 0.00; //DEPOSITO A PLAZO FIJO
        $var_rubro_38 = 0.00;
        $var_rubro_22 = 0.00; //inversiones a corto plazo
        $var_rubro_43 = 0.00;
        $var_rubro_45 = 0.00;
        $var_rubro_46 = 0.00;
        $var_rubro_ahorros = 0.00;
        $var_rubro_24 = 0.00; //VARIABLE PARA PROVISION DE INVERSIONES
        $var_rubro_315 = 0.00; //VARIABLE PARA PROVISION DE INVERSIONES
        $i=$_POST['contador'];
        for($j=0;$j<$i;$j++)
        {
            $var="codigo".$j;
            $var1="valor".$j;
            $var2="rubro".$j;
            $codigo=$_POST[$var];
            $cajatexto=$_POST[$var1];
            $var_rubro_id = $_POST[$var2];
            /*VARIABLES INICION SUMA*/
            if($var_rubro_id == 308 || $var_rubro_id == 309 || $var_rubro_id == 310 || $var_rubro_id == 311 || $var_rubro_id == 312 || $var_rubro_id == 315 )
            {
                $var_rubro_22 = $var_rubro_22 + $cajatexto;
                //echo $var_rubro_22;
            }
            /*FIN*/
            if($var_rubro_id == 20 || $var_rubro_id == 21 || $var_rubro_id == 23 || $var_rubro_id == 24 || $var_rubro_id == 25 ||
                $var_rubro_id == 26 || $var_rubro_id == 27 || $var_rubro_id == 28)
            {
                $var_rubro_29 = $var_rubro_29 + $cajatexto;
            }
            if($var_rubro_id == 198 || $var_rubro_id == 199 || $var_rubro_id == 200)
            {
                $var_rubro_32 = $var_rubro_32 + $cajatexto;
            }
            if($var_rubro_id == 198 || $var_rubro_id == 199 || $var_rubro_id == 200 || $var_rubro_id == 30 || $var_rubro_id == 31)
            {
                $var_rubro_ahorros = $var_rubro_ahorros + $cajatexto;
            }
            if($var_rubro_id == 30 || $var_rubro_id == 31 || $var_rubro_id == 33 || $var_rubro_id == 34 || $var_rubro_id == 35 ||
                $var_rubro_id == 36 || $var_rubro_id == 37)
            {
                $var_rubro_38 = $var_rubro_38 + $cajatexto;
            }
            if($var_rubro_id == 39 || $var_rubro_id == 40 || $var_rubro_id == 41 || $var_rubro_id == 42 || $var_rubro_id == 44)
            {
                $var_rubro_45 = $var_rubro_45 + $cajatexto;
            }
            if($var_rubro_id == 43)
            {
                $var_rubro_43 = $cajatexto;
            }
            if($var_rubro_id == 24)
            {
                $var_rubro_24 = $cajatexto;
            }
            if($var_rubro_id == 315)
            {
                $var_rubro_315 = $cajatexto;
            }

            switch ($var_rubro_id)
            {
                /*ini*/
                case 22:
                    //$var_rubro_22 = $var_rubro_308 + $var_rubro_309 + $var_rubro_310 + $var_rubro_311 + $var_rubro_312 + $var_rubro_315;
                    $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$var_rubro_22 WHERE CODIGO_SKU=$codigo";
                    break;

                /*fin*/
                case 29:
                    $var_rubro_29 = $var_rubro_29 + $var_rubro_22;
                    $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$var_rubro_29 WHERE CODIGO_SKU=$codigo";
                    break;
                case 32:
                    $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$var_rubro_32 WHERE CODIGO_SKU=$codigo";
                    break;
                case 38:
                    $var_rubro_38 = $var_rubro_38 + $var_rubro_32;
                    $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$var_rubro_38 WHERE CODIGO_SKU=$codigo";
                    break;

                case 45:
                    $var_rubro_45 = $var_rubro_45 + $var_rubro_43;
                    $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$var_rubro_45 WHERE CODIGO_SKU=$codigo";
                    break;
                case 46:
                    $var_rubro_46 = $var_rubro_45 + $var_rubro_38;
                    $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$var_rubro_46 WHERE CODIGO_SKU=$codigo";
                    break;
                default:
                    $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$cajatexto WHERE CODIGO_SKU=$codigo";
                    break;
            }
            Actualizar($query);
        }

        if (round($var_rubro_29,2) == round($var_rubro_46,2))
        {
            $sw1 = true;
            $var_graba1 = "";
        }
        else
        {
            $sw1 = false;
            $var_graba1 = " TOTAL ACTIVOS ES DIFERENTE AL TOTAL PASIVOS Y PATRIMONIO ;";
        }

        if($var_intermediacion == 'S')
        {
            $sw2 = true;
            $var_graba2 = "";
        }
        else
        {
            if ($var_rubro_ahorros == 0)
            {
                $sw2 = true;
                $var_graba2 = "";
            }
            else
            {
                $sw2 = false;
                $var_graba2 = " IMF NO TIENEN AHORROS ;";
            }
        }

        if (round($var_rubro_24,2) <= 0)
        {
            $sw3 = true;
            $var_graba3 = "";
        }
        else
        {
            $sw3 = false;
            $var_graba3 = " LAS PROVISIONES POR PRÉSTAMOS INCOBRABLES, DEBEN SER INGRESADAS CON SIGNO NEGATIVO ;";
        }

        if (round($var_rubro_315,2) <= 0)
        {
            $sw4 = true;
            $var_graba4 = "";
        }
        else
        {
            $sw4 = false;
            $var_graba4 = " LAS PROVISIONES POR INVERSIONES, DEBEN SER INGRESADAS CON SIGNO NEGATIVO ;";
        }
        if($sw1 && $sw2 && $sw3 && $sw4)
        {
            $sw = true;
        }
        else
        {
            $sw = false;
        }
        if ($sw)
        {
            $var_graba = "SUS DATOS SE GRABARON Y VALIDARON CON ÉXITO";
            ?>
            <span class="Bien"><?php echo $var_graba;?></span>
            <?php
        }
        else
        {
            $var_graba = "SUS DATOS SE GRABARON EXISTE ERROR Y NO SERÁN PUBLICADOS:".$var_graba1.$var_graba2.$var_graba3.$var_graba4;
            $var_longitud = strlen($var_graba) - 2;
            $var_graba = substr($var_graba,0,$var_longitud);
            ?>
            <span class="Mal"><?php echo $var_graba;?></span>
            <?php
        }
        break;
    case 3:
        $sw = false;
        $sw1 = false;
        $sw2 = true;
        $sw3 = false;
        $sw4 = false;
        $sw5 = false;
        $sw6 = false;
        $sw7 = false;
        $sw8 = false;
        $sw9 = false;
        $sw10 = false;
        $sw11 = false;
        $sw12 = false;
        $sw13 = false;
        $sw14 = false;
        $sw15 = false;
        $sw16 = false;
        $sw17 = false;
        $sw18 = false;
        $sw19 = false;
        $sw20 = false;
        $sw21 = false;
        $sw22 = false;
        $sw23 = false;
        $sw24 = false;
        $sw25 = false;
        $sw26 = false;
        $sw27 = false;
        /*INICIO DE VARIABLES ASIGNADAS*/
        $sw28 = false;
        $sw29 = false; //total activos
        $sw30 = false; //25 mayores
        $sw31 = false; //100 mayores
        $sw32 = false; //25<100
        //$sw33 = false;
        //$sw34 = false;
        $sw35 = false;
        $sw36 = false;
        $sw37 = false;
        $sw38 = false;
        $sw39 = false;
        $sw40 = false;
        $sw41 = false;
        $sw42 = false;
        $sw43 = false;
        $sw44 = false;
        $sw45 = false;
        $sw46 = false;
        $sw47 = false;
        $sw48 = false;
        $sw49 = false;
        $sw50 = false;
        $sw51 = false;
        $sw52 = false;
        $sw53 = false;
        $sw54 = false;
        $sw55 = false;
        $sw56 = false;
        $sw57 = false;
        $sw58 = false;
        $sw59 = false;
        $sw60 = false;
        $sw61 = false;
        $sw62 = false;
        $sw63 = false;
        $sw64 = false;
        $sw65 = false;
        $sw66 = false;
        $sw67 = false;
        $sw68 = false;
        $sw69 = false;
        $sw70 = false;
        $sw71 = false;
        $sw72 = false;
        $sw73 = false;
        $sw74 = false;
        $sw75 = false;
        $sw76 = false;
        $sw77 = false;
        $sw78 = false;
        $sw79 = false;
        $sw80 = false;
        $sw81 = false;
        $sw82 = false;

        /*FIN DE VARIBLES ASIGNADAS*/
        $var_rubro_257 = 0.00;
        $var_rubro_259 = 0.00;
        $var_total_personal = 0.00;
        $var_total_tasas = 0.00;
        $var_rubro_metodologia = 0.00;
        //$var_total_156 = 0.00;
        //$var_total_197 = 0.00;
        $var_total_cartera = 0.00;
        $var_total_cartera_micro = 0.00;
        $var_total_cartera_balance = 0.00;
        $var_total_cartera_cobertura = 0.00;
        $var_total_oficinas = 0.00;
        $var_total_oficinas_cobertura = 0.00;
        $var_total_cartera_por_vencer_cobertura = 0.00;
        $var_total_cartera_no_devenga_interes_cobertura = 0.00;
        $var_total_cartera_vencido_cobertura = 0.00;
        $var_total_cartera_por_vencer = 0.00;
        $var_total_cartera_no_devenga_interes = 0.00;
        $var_total_cartera_vencido = 0.00;
        /*INICIO DE VARIABLE*/
        $var_total_monto_ahorros = 0.00;
        $var_total_clientes_activos_ahorros = 0.00;
        $var_total_monto_ahorro_cobertura = 0.00;
        $var_total_clientes_activos_ahorros_cobertura = 0.00;
        $var_100_may_dpt = 0.00;
        $var_25_may_dpt = 0.00;
        $var_may_dpt = 0.00;
        $var_total_personal_mujeres = 0.00;
        /*FIN DE VARIABLES*/
        $var_total_clientes = 0.00;
        $var_total_clientes_cobertura = 0.00;
        $var_total_clientes_micro = 0.00;
        $var_total_clientes_mujeres = 0.00;
        $var_total_clientes_mujeres_micro = 0.00;
        $var_total_ahorros = 0.00;
        $var_total_ahorros_mujeres = 0.00;
        $var_total_ahorros_mujeres_periodo_anterior = 0.00;
        $var_total_ahorros_cuentas = 0.00;
        $var_total_prestamos = 0.00;
        $var_total_prestamos_micro = 0.00;
        $var_total_prestamos_castigados = 0.00;
        $var_total_prestamos_castigados_micro = 0.00;
        $var_total_prestamos_castigados_periodo_anterior = 0.00;
        $var_total_prestamos_castigados_micro_periodo_anterior = 0.00;
        $var_total_oficiales = 0.00;
        $var_total_oficiales_mujeres = 0.00;
        $var_total_oficiales_micro = 0.00;
        $var_total_oficiales_mujeres_micro = 0.00;
        $var_tasa_nominal = 0.00;
        $var_reserva_balance = 0.00;
        $var_reserva_cartera = 0.00;

        $var_cartera_sin_atrasos = 0.00;
        $var_cartera_1_a_30 = 0.00;
        $var_cartera_mas_30 = 0.00;

        $var_cartera_restructurada_sin_atrasos = 0.00;
        $var_cartera_restructurada_1_a_30 = 0.00;
        $var_cartera_restructurada_mas_30 = 0.00;

        $var_cartera_refinanciada_sin_atrasos = 0.00;
        $var_cartera_refinanciada_1_a_30 = 0.00;
        $var_cartera_refinanciada_mas_30 = 0.00;

        $var_cartera_sin_atrasos_micro = 0.00;
        $var_cartera_1_a_30_micro = 0.00;
        $var_cartera_mas_30_micro = 0.00;

        $var_cartera_restructurada_sin_atrasos_micro = 0.00;
        $var_cartera_restructurada_1_a_30_micro = 0.00;
        $var_cartera_restructurada_mas_30_micro = 0.00;

        $var_cartera_refinanciada_sin_atrasos_micro = 0.00;
        $var_cartera_refinanciada_1_a_30_micro = 0.00;
        $var_cartera_refinanciada_mas_30_micro = 0.00;

        $var_colocacion_cartera_credito = 0.00;
        $var_colocacion_cartera_credito_periodo_anterior = 0.00;
        $var_cartera_sector_urbano = 0.00;
        $var_cartera_sector_rural = 0.00;
        $var_cartera_sector_urbano_rural = 0.00;
        $tasa_interes_promedio_ahorros = 0.00;
        $tasa_interes_promedio_plazo_fijo = 0.00;
        $var_educacion_financiera = 0;
        $var_educacion_financiera_periodo_anterior = 0;

        $consulta="SELECT * FROM C_RUBRO_DATOS WHERE PERIODO_ID = $var_periodo_anterior AND ORGANIZACION_ID = $var_organizacion AND RUBRO_ID = 454";
        $resultado=ConsultarTabla($consulta);
        $var_colocacion_cartera_credito_periodo_anterior = mssql_result($resultado,0,"RUBRO_VALOR");

        $consulta="SELECT * FROM C_RUBRO_DATOS WHERE PERIODO_ID = $var_periodo_anterior AND ORGANIZACION_ID = $var_organizacion AND RUBRO_ID = 103";
        $resultado=ConsultarTabla($consulta);
        $var_total_prestamos_castigados_periodo_anterior = mssql_result($resultado,0,"RUBRO_VALOR");

        $consulta="SELECT * FROM C_RUBRO_DATOS WHERE PERIODO_ID = $var_periodo_anterior AND ORGANIZACION_ID = $var_organizacion AND RUBRO_ID = 152";
        $resultado=ConsultarTabla($consulta);
        $var_total_prestamos_castigados_micro_periodo_anterior = mssql_result($resultado,0,"RUBRO_VALOR");

        $consulta="SELECT * FROM C_RUBRO_DATOS WHERE PERIODO_ID = $var_periodo_anterior AND ORGANIZACION_ID = $var_organizacion AND RUBRO_ID = 122";
        $resultado=ConsultarTabla($consulta);
        $var_total_ahorros_mujeres_periodo_anterior = mssql_result($resultado,0,"RUBRO_VALOR");

        $consulta="SELECT * FROM C_RUBRO_DATOS WHERE PERIODO_ID = $var_periodo_anterior AND ORGANIZACION_ID = $var_organizacion AND RUBRO_ID = 131";
        $resultado=ConsultarTabla($consulta);
        $var_educacion_financiera_periodo_anterior = mssql_result($resultado,0,"RUBRO_VALOR");

        $consulta="SELECT SUM(MONTO_CARTERA_POR_VENCER) MONTO_CARTERA_POR_VENCER FROM dbo.C_COBERTURA_GEOGRAFICA WHERE PERIODO_ID = $var_periodo AND ORGANIZACION_ID = $var_organizacion AND ESTADO_ID = 1";
        $resultado=ConsultarTabla($consulta);
        $var_total_cartera_por_vencer_cobertura = mssql_result($resultado,0,"MONTO_CARTERA_POR_VENCER");

        $consulta="SELECT SUM(MONTO_CARTERA_NO_DEVENGA_INTERES) NO_DEVENGA FROM dbo.C_COBERTURA_GEOGRAFICA WHERE PERIODO_ID = $var_periodo AND ORGANIZACION_ID = $var_organizacion AND ESTADO_ID = 1";
        $resultado=ConsultarTabla($consulta);
        $var_total_cartera_no_devenga_interes_cobertura = mssql_result($resultado,0,"NO_DEVENGA");

        $consulta="SELECT SUM(MONTO_CARTERA_VENCIDO) MONTO_CARTERA_VENCIDO FROM dbo.C_COBERTURA_GEOGRAFICA WHERE PERIODO_ID = $var_periodo AND ORGANIZACION_ID = $var_organizacion AND ESTADO_ID = 1";
        $resultado=ConsultarTabla($consulta);
        $var_total_cartera_vencido_cobertura = mssql_result($resultado,0,"MONTO_CARTERA_VENCIDO");

        $consulta="SELECT SUM(MONTO_CARTERA) TOTAL_CARTERA FROM dbo.C_COBERTURA_GEOGRAFICA WHERE PERIODO_ID = $var_periodo AND ORGANIZACION_ID = $var_organizacion AND ESTADO_ID = 1";
        $resultado=ConsultarTabla($consulta);
        $var_total_cartera_cobertura = mssql_result($resultado,0,"TOTAL_CARTERA");

        $consulta="SELECT SUM(NUMERO_OFICINAS) NUMERO_OFICINAS FROM dbo.C_COBERTURA_GEOGRAFICA WHERE PERIODO_ID = $var_periodo AND ORGANIZACION_ID = $var_organizacion AND ESTADO_ID = 1";
        $resultado=ConsultarTabla($consulta);
        $var_total_oficinas_cobertura = mssql_result($resultado,0,"NUMERO_OFICINAS");

        $consulta="SELECT SUM(CLIENTES_ACTIVOS_CREDITOS) CLIENTES_ACTIVOS_CREDITOS FROM dbo.C_COBERTURA_GEOGRAFICA WHERE PERIODO_ID = $var_periodo AND ORGANIZACION_ID = $var_organizacion AND ESTADO_ID = 1";
        $resultado=ConsultarTabla($consulta);
        $var_total_clientes_cobertura = mssql_result($resultado,0,"CLIENTES_ACTIVOS_CREDITOS");

        /*INICIO SUMA DE NUEVOS CAMPOS DE LA COBERTURA GEOGRAFICA*/
        $consulta="SELECT SUM(MONTO_AHORRO) MONTO_AHORRO FROM dbo.C_COBERTURA_GEOGRAFICA WHERE PERIODO_ID = $var_periodo AND ORGANIZACION_ID = $var_organizacion AND ESTADO_ID = 1";
        $resultado=ConsultarTabla($consulta);
        $var_total_monto_ahorro_cobertura = mssql_result($resultado,0,"MONTO_AHORRO");

        $consulta="SELECT SUM(CLIENTES_ACTIVOS_AHORROS) CLIENTES_ACTIVOS_AHORROS FROM dbo.C_COBERTURA_GEOGRAFICA WHERE PERIODO_ID = $var_periodo AND ORGANIZACION_ID = $var_organizacion AND ESTADO_ID = 1";
        $resultado=ConsultarTabla($consulta);
        $var_total_clientes_activos_ahorros_cobertura = mssql_result($resultado,0,"CLIENTES_ACTIVOS_AHORROS");
        /*FIN*/

        /*INICIO CONSULTA RUBRO 106 numero de clientes activos de ahorro
        $consulta="select *
                    from dbo.C_RUBRO_DATOS DAT
                    where
                    DAT.ORGANIZACION_ID = $var_organizacion AND PERIODO_ID = $var_periodo AND RUBRO_ID = 106";
        $resultado=ConsultarTabla($consulta);
        $var_total_num_cli_act_aho=mssql_result($resultado,0,"RUBRO_VALOR");		*/

        $consulta="select *
							from dbo.C_RUBRO_DATOS DAT
							where 
							DAT.ORGANIZACION_ID = $var_organizacion AND PERIODO_ID = $var_periodo AND RUBRO_ID = 23";
        $resultado=ConsultarTabla($consulta);
        $var_total_cartera_balance=mssql_result($resultado,0,"RUBRO_VALOR");
        $consulta="select *
						from dbo.C_RUBRO_DATOS DAT
						where 
						DAT.ORGANIZACION_ID = $var_organizacion AND PERIODO_ID = $var_periodo AND RUBRO_ID = 24";

        $resultado=ConsultarTabla($consulta);
        $var_reserva_balance= (mssql_result($resultado,0,"RUBRO_VALOR"))* - 1;
        $i=$_POST['contador'];
        for($j=0;$j<$i;$j++)
        {
            $var="codigo".$j;
            $var1="valor".$j;
            $var2="rubro".$j;
            $codigo=$_POST[$var];
            $cajatexto=$_POST[$var1];
            $var_rubro_id = $_POST[$var2];
            if($var_rubro_id == 202 || $var_rubro_id == 203 || $var_rubro_id == 204 || $var_rubro_id == 205 || $var_rubro_id == 206 ||
                $var_rubro_id == 207 || $var_rubro_id == 208 || $var_rubro_id == 209 || $var_rubro_id == 138 || $var_rubro_id == 139 ||
                $var_rubro_id == 140)
            {
                $var_total_tasas = $var_total_tasas + $cajatexto;
            }
            if($var_rubro_id == 100 || $var_rubro_id == 101 || $var_rubro_id == 102 || $var_rubro_id == 256 || $var_rubro_id == 331 ||
                $var_rubro_id == 332 || $var_rubro_id == 301 || $var_rubro_id == 333 || $var_rubro_id == 334)
            {
                $var_total_cartera 	= $var_total_cartera + $cajatexto;
                $var_rubro_257 		= $var_rubro_257 + $cajatexto;
            }
            if($var_rubro_id == 149 || $var_rubro_id == 150 || $var_rubro_id == 151 || $var_rubro_id == 258 || $var_rubro_id == 335 ||
                $var_rubro_id == 336 || $var_rubro_id == 302 || $var_rubro_id == 337 || $var_rubro_id == 338)
            {
                $var_total_cartera_micro = $var_total_cartera_micro + $cajatexto;
                $var_rubro_259 		= $var_rubro_259 + $cajatexto;
            }
            if($var_rubro_id == 126 || $var_rubro_id == 127 || $var_rubro_id == 128 || $var_rubro_id == 129 || $var_rubro_id == 130)
            {
                $var_rubro_metodologia = $var_rubro_metodologia + $cajatexto;
            }
            if($var_rubro_id == 313)
            {
                $var_25_may_dpt = $var_25_may_dpt + $cajatexto;
                $var_may_dpt = $var_may_dpt + $cajatexto;
            }
            if($var_rubro_id == 314)
            {
                $var_100_may_dpt = $var_100_may_dpt + $cajatexto;
                $var_may_dpt = $var_may_dpt + $cajatexto;
            }
            switch ($var_rubro_id)
            {
                case 108:
                    $var_total_personal = $var_total_personal + $cajatexto;
                    break;
                case 195:
                    $var_reserva_cartera = $var_reserva_cartera + $cajatexto;
                    break;
                case 196:
                    $var_total_oficiales_mujeres = $var_total_oficiales_mujeres + $cajatexto;
                    break;
                case 109:
                    $var_total_oficiales = $var_total_oficiales + $cajatexto;
                    break;
                case 197:
                    $var_total_oficiales_mujeres_micro = $var_total_oficiales_mujeres_micro + $cajatexto;
                    break;
                case 156:
                    $var_total_oficiales_micro = $var_total_oficiales_micro + $cajatexto;
                    break;
                case 104:
                    $var_total_clientes = $var_total_clientes + $cajatexto;
                    break;
                case 121:
                    $var_total_clientes_mujeres = $var_total_clientes_mujeres + $cajatexto;
                    break;
                case 103:
                    $var_total_prestamos_castigados = $var_total_prestamos_castigados + $cajatexto;
                    break;
                case 122:
                    $var_total_ahorros_mujeres = $var_total_ahorros_mujeres + $cajatexto;
                    break;
                case 106:
                    $var_total_ahorros = $var_total_ahorros + $cajatexto;
                    break;
                case 260:
                    $var_total_ahorros_cuentas = $var_total_ahorros_cuentas + $cajatexto;
                    break;
                case 152:
                    $var_total_prestamos_castigados_micro = $var_total_prestamos_castigados_micro + $cajatexto;
                    break;
                case 105:
                    $var_total_prestamos = $var_total_prestamos + $cajatexto;
                    break;
                case 153:
                    $var_total_clientes_micro = $var_total_clientes_micro + $cajatexto;
                    break;
                case 154:
                    $var_total_clientes_mujeres_micro = $var_total_clientes_mujeres_micro + $cajatexto;
                    break;
                case 155:
                    $var_total_prestamos_micro = $var_total_prestamos_micro + $cajatexto;
                    break;
                case 107:
                    $var_total_oficinas = $var_total_oficinas + $cajatexto;
                    break;
                case 316:
                    $var_total_personal_mujeres = $var_total_personal_mujeres + $cajatexto;
                    break;
                case 100:
                    $var_cartera_sin_atrasos = $var_cartera_sin_atrasos + $cajatexto;
                    break;
                case 101:
                    $var_cartera_1_a_30 = $var_cartera_1_a_30 + $cajatexto;
                    break;
                case 102:
                    $var_cartera_mas_30 = $var_cartera_mas_30 + $cajatexto;
                    break;
                case 256:
                    $var_cartera_restructurada_sin_atrasos = $var_cartera_restructurada_sin_atrasos + $cajatexto;
                    break;
                case 331:
                    $var_cartera_restructurada_1_a_30 = $var_cartera_restructurada_1_a_30 + $cajatexto;
                    break;
                case 332:
                    $var_cartera_restructurada_mas_30 = $var_cartera_restructurada_mas_30 + $cajatexto;
                    break;
                case 301:
                    $var_cartera_refinanciada_sin_atrasos = $var_cartera_refinanciada_sin_atrasos + $cajatexto;
                    break;
                case 333:
                    $var_cartera_refinanciada_1_a_30 = $var_cartera_refinanciada_1_a_30 + $cajatexto;
                    break;
                case 334:
                    $var_cartera_refinanciada_mas_30 = $var_cartera_refinanciada_mas_30 + $cajatexto;
                    break;
                case 149:
                    $var_cartera_sin_atrasos_micro = $var_cartera_sin_atrasos_micro + $cajatexto;
                    break;
                case 150:
                    $var_cartera_1_a_30_micro = $var_cartera_1_a_30_micro + $cajatexto;
                    break;
                case 151:
                    $var_cartera_mas_30_micro = $var_cartera_mas_30_micro + $cajatexto;
                    break;
                case 258:
                    $var_cartera_restructurada_sin_atrasos_micro = $var_cartera_restructurada_sin_atrasos_micro + $cajatexto;
                    break;
                case 335:
                    $var_cartera_restructurada_1_a_30_micro = $var_cartera_restructurada_1_a_30_micro + $cajatexto;
                    break;
                case 336:
                    $var_cartera_restructurada_mas_30_micro = $var_totalvar_cartera_restructurada_mas_30_micropersonal_mujeres + $cajatexto;
                    break;
                case 302:
                    $var_cartera_refinanciada_sin_atrasos_micro = $var_cartera_refinanciada_sin_atrasos_micro + $cajatexto;
                    break;
                case 337:
                    $var_cartera_refinanciada_1_a_30_micro = $var_cartera_refinanciada_1_a_30_micro + $cajatexto;
                    break;
                case 338:
                    $var_cartera_refinanciada_mas_30_micro = $var_cartera_refinanciada_mas_30_micro + $cajatexto;
                    break;
                case 454:
                    $var_colocacion_cartera_credito = $var_colocacion_cartera_credito + $cajatexto;
                    break;
                case 455:
                    $var_cartera_sector_urbano = $var_cartera_sector_urbano + $cajatexto;
                    $var_cartera_sector_urbano_rural = $var_cartera_sector_urbano_rural + $cajatexto;
                    break;
                case 456:
                    $var_cartera_sector_rural = $var_cartera_sector_rural + $cajatexto;
                    $var_cartera_sector_urbano_rural = $var_cartera_sector_urbano_rural + $cajatexto;
                    break;
                case 138:
                    $tasa_interes_promedio_ahorros = $tasa_interes_promedio_ahorros + $cajatexto;
                    break;
                case 139:
                    $tasa_interes_promedio_plazo_fijo = $tasa_interes_promedio_plazo_fijo + $cajatexto;
                    break;
                case 131:
                    $var_educacion_financiera = $var_educacion_financiera + $cajatexto;
                    if($cajatexto <> 0 && $cajatexto <> 1)
                    {
                        $sw2 = false;
                    }
                    break;
                case 132:
                    if($cajatexto <> 0 && $cajatexto <> 1)
                    {
                        $sw2 = false;
                    }
                    break;
                case 133:
                    if($cajatexto <> 0 && $cajatexto <> 1)
                    {
                        $sw2 = false;
                    }
                    break;
                case 134:
                    if($cajatexto <> 0 && $cajatexto <> 1)
                    {
                        $sw2 = false;
                    }
                    break;
            }
            switch ($var_rubro_id)
            {
                case 257:
                    $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$var_rubro_257 WHERE CODIGO_SKU=$codigo";
                    break;
                case 259:
                    $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$var_rubro_259 WHERE CODIGO_SKU=$codigo";
                    break;
                default:
                    $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$cajatexto WHERE CODIGO_SKU=$codigo";
                    break;
            }
            Actualizar($query);
        }//CIERRA CICLO FOR
        /*INICIO CONSULTA RUBRO 30 DESPOSITOS RESTRIN*/
        $consulta="select *
						from dbo.C_RUBRO_DATOS DAT
						where 
						DAT.ORGANIZACION_ID = $var_organizacion AND PERIODO_ID = $var_periodo AND RUBRO_ID = 30";
        $resultado=ConsultarTabla($consulta);
        $var_total_depositos_restringidos=mssql_result($resultado,0,"RUBRO_VALOR");
        /*FIN CONSULTA*/

        /*INICIO CONSULTA RUBRO 31 CTA AHORRO VOLUNTARIAS*/
        $consulta="select *
						from dbo.C_RUBRO_DATOS DAT
						where 
						DAT.ORGANIZACION_ID = $var_organizacion AND PERIODO_ID = $var_periodo AND RUBRO_ID = 31";
        $resultado=ConsultarTabla($consulta);
        $var_total_ctas_ahorros_voluntarias=mssql_result($resultado,0,"RUBRO_VALOR");
        /*FIN CONSULTA*/

        /*INICIO CONSULTA RUBRO 106 numero de clientes activos de ahorro*/
        $consulta="select *
						from dbo.C_RUBRO_DATOS DAT
						where 
						DAT.ORGANIZACION_ID = $var_organizacion AND PERIODO_ID = $var_periodo AND RUBRO_ID = 106";
        $resultado=ConsultarTabla($consulta);
        $var_total_num_cli_act_aho=mssql_result($resultado,0,"RUBRO_VALOR");

        /*INICIO CONSULTA RUBRO 32 TOTAL DEP PLAZO FIJO*/
        $consulta="select *
						from dbo.C_RUBRO_DATOS DAT
						where 
						DAT.ORGANIZACION_ID = $var_organizacion AND PERIODO_ID = $var_periodo AND RUBRO_ID = 32";
        $resultado=ConsultarTabla($consulta);
        $var_total_dep_plazo_fijo=mssql_result($resultado,0,"RUBRO_VALOR");

        $consulta="select sum(RUBRO_VALOR) RUBRO_VALOR
						from dbo.C_RUBRO_DATOS DAT
						where 
						DAT.ORGANIZACION_ID = $var_organizacion AND PERIODO_ID = $var_periodo AND RUBRO_ID in (457,459,461)";
        $resultado=ConsultarTabla($consulta);
        $var_total_cartera_no_devenga_interes=mssql_result($resultado,0,"RUBRO_VALOR");

        $consulta="select sum(RUBRO_VALOR) RUBRO_VALOR
						from dbo.C_RUBRO_DATOS DAT
						where 
						DAT.ORGANIZACION_ID = $var_organizacion AND PERIODO_ID = $var_periodo AND RUBRO_ID in (458,460,462)";
        $resultado=ConsultarTabla($consulta);
        $var_total_cartera_vencido=mssql_result($resultado,0,"RUBRO_VALOR");

        /*SUMA VARIABLES*/
        $var_total_monto_ahorros = $var_total_depositos_restringidos + $var_total_ctas_ahorros_voluntarias + $var_total_dep_plazo_fijo;
        $var_total_cartera_por_vencer = $var_cartera_sin_atrasos + $var_cartera_restructurada_sin_atrasos + $var_cartera_refinanciada_sin_atrasos;
        /*FIN SUMA VARIABLES*/

        /*CONSULTA RUBRO 109 156 196 - Oficiales de Crédito - Oficiales de Crédito (Micro) - Oficiales De Crédito Mujeres (Micro)*/
        /*$consulta="select *
                    from dbo.C_RUBRO_DATOS DAT
                    where
                    DAT.ORGANIZACION_ID = $var_organizacion AND PERIODO_ID = $var_periodo AND RUBRO_ID = 109";
        $resultado=ConsultarTabla($consulta);
        $var_total_109=mssql_result($resultado,0,"RUBRO_VALOR");

        $consulta="select *
                    from dbo.C_RUBRO_DATOS DAT
                    where
                    DAT.ORGANIZACION_ID = $var_organizacion AND PERIODO_ID = $var_periodo AND RUBRO_ID = 156";
        $resultado=ConsultarTabla($consulta);
        $var_total_156=mssql_result($resultado,0,"RUBRO_VALOR");

        $consulta="select *
                    from dbo.C_RUBRO_DATOS DAT
                    where
                    DAT.ORGANIZACION_ID = $var_organizacion AND PERIODO_ID = $var_periodo AND RUBRO_ID = 197";
        $resultado=ConsultarTabla($consulta);
        $var_total_197=mssql_result($resultado,0,"RUBRO_VALOR");*/
        /*FIN RUBRO 109 Oficiales de Crédito*/

        /* NUMERO DE PERSONAL MUJERES*/
        /*$consulta="select *
                    from dbo.C_RUBRO_DATOS DAT
                    where
                    DAT.ORGANIZACION_ID = $var_organizacion AND PERIODO_ID = $var_periodo AND RUBRO_ID = 316";
        $resultado=ConsultarTabla($consulta);
        $var_total_316=mssql_result($resultado,0,"RUBRO_VALOR");

        $consulta="select *
                    from dbo.C_RUBRO_DATOS DAT
                    where
                    DAT.ORGANIZACION_ID = $var_organizacion AND PERIODO_ID = $var_periodo AND RUBRO_ID = 108";
        $resultado=ConsultarTabla($consulta);
        $var_total_108=mssql_result($resultado,0,"RUBRO_VALOR");*/

        if(round($var_rubro_metodologia,2) == 100.00)
        {
            $sw1 = true;
            $var_graba1 = "";
        }
        else
        {
            $sw1 = false;
            $var_graba1 = " LAS METODOLOGÍAS DE CRÉDITO NO LLEGAN AL 100% ;";
        }
        if ($sw2)
        {
            $var_graba2 = "";
        }
        else
        {
            $var_graba2 = " ALGUNO DE ESTOS RUBROS (Capacitación, Asistencia Técnica, Promoción Social, Otros) SE DEBE INGRESAR (1/0) ;";
        }
        if(round($var_total_cartera_cobertura,2) == round($var_total_cartera,2))
        {
            $sw3 = true;
            $var_graba3 = "";
        }
        else
        {
            $sw3 = false;
            $var_graba3 = " EL TOTAL DE LA CARTERA NO ES IGUAL AL TOTAL DE LA CARTERA DE LA COBERTURA GEOGRÁFICA ;";
        }
        if($var_solo_cartera == 'N')
        {
            if(round($var_total_cartera,2) == round($var_total_cartera_balance,2))
            {
                $sw4 = true;
                $var_graba4 = "";
            }
            else
            {
                $sw4 = false;
                $var_graba4 = " EL TOTAL DE LA CARTERA NO ES IGUAL AL TOTAL DE LA CARTERA DEL BALANCE GENERAL ;";
            }
        }
        else
        {
            $sw4 = true;
            $var_graba4 = "";
        }
        if(round($var_total_clientes_cobertura,2) == round($var_total_clientes,2))
        {
            $sw5 = true;
            $var_graba5 = "";
        }
        else
        {
            $sw5 = false;
            $var_graba5 = " EL TOTAL DE LOS CLIENTES ACTIVOS DE CRÉDITO, NO ES IGUAL AL TOTAL DE LOS CLIENTES ACTIVOS DE CRÉDITO DE LA COBERTURA GEOGRÁFICA ;";
        }
        if(round($var_total_oficinas_cobertura,2) == round($var_total_oficinas,2))
        {
            $sw6 = true;
            $var_graba6 = "";
        }
        else
        {
            $sw6 = false;
            $var_graba6 = " EL TOTAL DE LOS PUNTOS DE SERVICIO NO ES IGUAL AL TOTAL DE LOS PUNTOS DE SERVICIO DE LA COBERTURA GEOGRÁFICA ;";
        }
        if ($var_total_tasas > 0)
        {
            $sw7 = true;
            $var_graba7 = "";
        }
        else
        {
            $sw7 = false;
            $var_graba7 = " LA SUMA DE TODAS LAS TASAS DE INTERÉS DEBEN SER MAYOR QUE 0 ;";
        }
        if(round($var_total_prestamos,2) >= round($var_total_clientes,2))
        {
            $sw8 = true;
            $var_graba8 = "";
        }
        else
        {
            $sw8 = false;
            $var_graba8 = " LOS CLIENTES ACTIVOS DE CRÉDITO, NO DEBEN SER MAYORES QUE EL TOTAL DE LOS PRÉSTAMOS ACTIVOS DE CRÉDITO ;";
        }
        if(round($var_total_prestamos_micro,2) >= round($var_total_clientes_micro,2))
        {
            $sw9 = true;
            $var_graba9 = "";
        }
        else
        {
            $sw9 = false;
            $var_graba9 = " LOS CLIENTES ACTIVOS DE CRÉDITO MICRO, NO DEBEN SER MAYORES QUE EL TOTAL DE LOS PRESTAMOS ACTIVOS DE CRÉDITO MICRO ;";
        }
        if(round($var_total_cartera_micro,2) <= round($var_total_cartera,2))
        {
            $sw10 = true;
            $var_graba10 = "";
        }
        else
        {
            $sw10 = false;
            $var_graba10 = " LA CARTERA MICRO, NO DEBE SER MAYOR QUE LA CARTERA TOTAL ;";
        }
        if(round($var_total_prestamos_castigados_micro,2) <= round($var_total_prestamos_castigados,2))
        {
            $sw11 = true;
            $var_graba11 = "";
        }
        else
        {
            $sw11 = false;
            $var_graba11 = " LOS PRÉSTAMOS CASTIGADOS MICRO, NO DEBEN SER MAYORES QUE LOS PRÉSTAMOS CASTIGADOS ;";
        }
        if(round($var_total_clientes_mujeres,2) <= round($var_total_clientes,2))
        {
            $sw12 = true;
            $var_graba12 = "";
        }
        else
        {
            $sw12 = false;
            $var_graba12 = " LOS CLIENTES ACTIVOS DE CRÉDITO MUJERES, NO DEBEN SER MAYORES QUE EL TOTAL DE CLIENTES ACTIVOS DE CRÉDITO ;";
        }
        if(round($var_total_ahorros_mujeres,2) <= round($var_total_ahorros,2))
        {
            $sw13 = true;
            $var_graba13 = "";
        }
        else
        {
            $sw13 = false;
            $var_graba13 = " LOS CLIENTES ACTIVOS DE AHORROS MUJERES, NO DEBEN SER MAYORES QUE EL TOTAL DE CLIENTES ACTIVOS DE AHORROS ;";
        }
        if(round($var_total_oficiales_mujeres,2) <= round($var_total_oficiales,2))
        {
            $sw14 = true;
            $var_graba14 = "";
        }
        else
        {
            $sw14 = false;
            $var_graba14 = " LOS OFICIALES DE CRÉDITO MUJERES, NO DEBEN SER MAYORES QUE EL TOTAL DE OFICIALES DE CRÉDITO ;";
        }
        if(round($var_total_clientes_mujeres_micro,2) <= round($var_total_clientes_micro,2))
        {
            $sw15 = true;
            $var_graba15 = "";
        }
        else
        {
            $sw15 = false;
            $var_graba15 = " LOS CLIENTES ACTIVOS DE CRÉDITO MUJERES MICRO, NO DEBEN SER MAYORES QUE EL TOTAL DE CLIENTES ACTIVOS DE CRÉDITO MICRO ;";
        }
        if(round($var_total_oficiales_mujeres_micro,2) <= round($var_total_oficiales_micro,2))
        {
            $sw16 = true;
            $var_graba16 = "";
        }
        else
        {
            $sw16 = false;
            $var_graba16 = " LOS OFICIALES DE CRÉDITO MUJERES MICRO, NO DEBEN SER MAYORES QUE EL TOTAL DE OFICIALES MICRO ;";
        }
        if(round($var_total_clientes_micro,2) <= round($var_total_clientes,2))
        {
            $sw17 = true;
            $var_graba17 = "";
        }
        else
        {
            $sw17 = false;
            $var_graba17 = " LOS CLIENTES ACTIVOS DE CRÉDITO MICRO, NO DEBEN SER MAYORES QUE EL TOTAL DE CLIENTES ACTIVOS DE CRÉDITO ;";
        }
        if(round($var_total_clientes_mujeres_micro,2) <= round($var_total_clientes_mujeres,2))
        {
            $sw18 = true;
            $var_graba18 = "";
        }
        else
        {
            $sw18 = false;
            $var_graba18 = " LOS CLIENTES ACTIVOS DE CRÉDITO MUJERES MICRO, NO DEBEN SER MAYORES QUE EL TOTAL DE CLIENTES ACTIVOS DE CRÉDITO MUJERES ;";
        }
        if(round($var_total_prestamos_micro,2) <= round($var_total_prestamos,2))
        {
            $sw19 = true;
            $var_graba19 = "";
        }
        else
        {
            $sw19 = false;
            $var_graba19 = " LOS PRÉSTAMOS ACTIVOS DE CRÉDITO MICRO, NO DEBEN SER MAYORES QUE EL TOTAL DE PRÉSTAMOS ACTIVOS DE CRÉDITO ;";
        }
        if(round($var_total_oficiales_micro,2) <= round($var_total_oficiales,2))
        {
            $sw20 = true;
            $var_graba20 = "";
        }
        else
        {
            $sw20 = false;
            $var_graba20 = " LOS OFICIALES MICRO, NO DEBEN SER MAYORES QUE EL TOTAL DE OFICIALES ;";
        }
        if(round($var_total_oficiales_mujeres_micro,2) <= round($var_total_oficiales_mujeres,2))
        {
            $sw21 = true;
            $var_graba21 = "";
        }
        else
        {
            $sw21 = false;
            $var_graba21 = " LOS OFICIALES MUJERES MICRO, NO DEBEN SER MAYORES QUE EL TOTAL DE OFICIALES MUJERES ;";
        }
        if($var_total_personal > 0)
        {
            $sw22 = true;
            $var_graba22 = "";
        }
        else
        {
            $sw22 = false;
            $var_graba22 = " EL NÚMERO DE PERSONAL, DEBE SER MAYOR QUE 0 ;";
        }
        if(round($var_reserva_cartera,2) <= round($var_reserva_balance,2))
        {
            $sw23 = true;
            $var_graba23 = "";
        }
        else
        {
            $sw23 = false;
            $var_graba23 = " LAS PROVISIONES MICRO, NO DEBE SER MAYOR QUE LAS PROVISIONES DEL BALANCE ;";
        }
        if($var_total_cartera_micro > 0)
        {
            if($var_reserva_cartera > 0)
            {
                $sw24 = true;
                $var_graba24 = "";
            }
            else
            {
                $sw24 = false;
                $var_graba24 = " SI EXISTE VALOR EN LA CARTERA MICRO, TAMBIÉN DEBE EXISTIR VALOR EN LAS PROVISIONES MICRO, VALOR EN POSITIVO;";
            }
        }
        else
        {
            $sw24 = true;
            $var_graba24 = "";
        }
        if(round($var_total_ahorros,2) <= round($var_total_ahorros_cuentas,2))
        {
            $sw25 = true;
            $var_graba25 = "";
        }
        else
        {
            $sw25 = false;
            $var_graba25 = " LOS CLIENTES ACTIVOS DE AHORRO, NO DEBEN SER MAYORES QUE EL TOTAL DE CUENTAS ACTIVAS DE AHORRO ;";
        }
        if(round($var_total_clientes,2) > 0 and round($var_total_cartera,2) > 0 and round($var_total_prestamos,2) > 0)
        {
            $sw26 = true;
            $var_graba26 = "";
        }
        else
        {
            $sw26 = false;
            $var_graba26 = " LOS CLIENTES ACTIVOS DE CRÉDITO, CARTERA Y PRÉSTAMOS ACTIVOS DE CRÉDITO DEBEN SER MAYOR QUE 0 ;";
        }
        if($var_intermediacion == 'S')
        {
            if(round($var_total_ahorros,2) > 0 and round($var_total_ahorros_cuentas,2) > 0)
            {
                $sw27 = true;
                $var_graba27 = "";
            }
            else
            {
                $sw27 = false;
                $var_graba27 = " LOS CLIENTES Y CUENTAS ACTIVAS DE AHORRO DEBEN SER MAYOR QUE 0 ;";
            }
        }
        else
        {
            $sw27 = true;
            $var_graba27 = "";
        }
        /*INICIO LA COMPARACION CON LA VARIABLE CONSULTADA Y DECLARADA  $var_total_monto_ahorro_cobertura - $var_total_clientes_activos_ahorros_cobertura*/
        if(round($var_total_monto_ahorro_cobertura,2) == round($var_total_monto_ahorros,2))
        {
            $sw28 = true;
            $var_graba28 = "";
        }
        else
        {
            $sw28 = false;
            $var_graba28 = " EL TOTAL DEL MONTO DE AHORROS DE BALANCE, NO ES IGUAL AL TOTAL DEL MONTO DE AHORROS DE LA COBERTURA GEOGRÁFICA ;";
        }

        if(round($var_total_clientes_activos_ahorros_cobertura,2) == round($var_total_num_cli_act_aho,2))
        {
            $sw29 = true;
            $var_graba29 = "";
        }
        else
        {
            $sw29 = false;
            $var_graba29 = " EL TOTAL DE CLIENTES ACTIVOS DE AHORRO, NO ES IGUAL AL TOTAL DE CLIENTES ACTIVOS DE AHORRO DE LA COBERTURA GEOGRÁFICA ;";
        }

        /*INICIO LOS 25 MAYORES DEP ES MENOS AL MONTO TOTAL AHORROS*/
        if(round($var_25_may_dpt,2) <= round($var_total_monto_ahorros,2))
        {
            $sw30 = true;
            $var_graba30 = "";
        }
        else
        {
            $sw30 = false;
            $var_graba30 = " EL TOTAL DEL SALDO DE LOS 25 MAYORES DEPOSITANTES, DEBE SER MENOR O IGUAL AL MONTO TOTAL DE AHORROS DEL BALANCE ;";
        }
        /*FIN LOS 25 MAYORES DEP ES MENOS AL MONTO TOTAL AHORROS*/

        /*INICIO LOS 100 MAYORES DEP ES MENOS AL MONTO TOTAL AHORROS*/
        if(round($var_100_may_dpt,2) <= round($var_total_monto_ahorros,2))
        {
            $sw31 = true;
            $var_graba31 = "";
        }
        else
        {
            $sw31 = false;
            $var_graba31 = " EL TOTAL DEL SALDO DE LOS 100 MAYORES DEPOSITANTES, DEBE SER MENOR O IGUAL AL MONTO TOTAL DE AHORROS DEL BALANCE ;";
        }
        /*FIN LOS 25 MAYORES DEP ES MENOS AL MONTO TOTAL AHORROS*/

        /*COMPARACION ENTRE SALDO 25 < SALDO 100*/
        if(round($var_25_may_dpt,2) <= round($var_100_may_dpt,2))
        {
            $sw32 = true;
            $var_graba32 = "";
        }
        else
        {
            $sw32 = false;
            $var_graba32 = " EL TOTAL DEL SALDO DE LOS 25 MAYORES DEPOSITANTES, DEBE SER MENOR AL SALDO DE LOS 100 MAYORES DEPOSITANTES ;";
        }
        /*FIN COMPARACION ENTRE SALDO 25 < SALDO 100*/
        /*VALIDACION DE VARIABLES 109 - 156 - 196 OFICIALES DE
        if (round($var_total_156,2) <= round($var_total_109,2))
        {
            $sw33 = true;
            $var_graba33 = "";
        }
        else
        {
            $sw33 = false;
            $var_graba33 = " LOS OFICIALES CREDITO (MICRO), NO DEBEN SER MAYORES QUE EL TOTAL DE OFICIALES DE CRÉDITO ;";
        }
        if (round($var_total_197,2) <= round($var_total_109,2))
        {
            $sw34 = true;
            $var_graba34 = "";
        }
        else
        {
            $sw34 = false;
            $var_graba34 = "  LOS OFICIALES CRÉDITO MUJERES (MICRO), NO DEBEN SER MAYORES QUE EL TOTAL DE OFICIALES DE CRÉDITO MUJERES ;";
        }*/

        if (round($var_total_personal_mujeres,2) <= round($var_total_personal,2))
        {
            $sw35 = true;
            $var_graba35 = "";
        }
        else
        {

            $sw35 = false;
            $var_graba35 = " EL NÚMERO DE PERSONAL MUJERES, DEBE SER MENOR O IGUAL AL NÚMERO DE PERSONAL TOTAL ;";
        }

        /*25 variables*/
        if($var_intermediacion == 'N')
        {
            $sw36 = true;
            $var_graba36 = "";
        }
        else
        {
            if($var_25_may_dpt > 0)
            {
                $sw36 = true;
                $var_graba36 = "";
            }
            else
            {
                $sw36 = false;
                $var_graba36 = " EL SALDO DE LOS 25 MAYORES DEPOSITANTES, DEBEN SER MAYOR QUE 0 ;";
            }
        }

        if($var_intermediacion == 'N')
        {
            $sw37 = true;
            $var_graba37 = "";
        }
        else
        {
            if ($var_100_may_dpt > 0)
            {
                $sw37 = true;
                $var_graba37 = "";
            }
            else
            {
                $sw37 = false;
                $var_graba37 = " EL SALDO DE LOS 100 MAYORES DEPOSITANTES, DEBEN SER MAYOR QUE 0 ;";
            }
        }
        /*fin de la comparacion*/

        /*total cartera micro vs oficiales de credito micro*/
        if ($var_total_cartera_micro > 0)
        {
            if ($var_total_oficiales_micro > 0)
            {
                $sw38 = true;
                $var_graba38 = "";
            }
            else
            {
                $sw38 = false;
                $var_graba38 = " SI EXISTE CARTERA MICRO, DEBE EXISTIR OFICIALES DE CRÉDITO MICRO ;";
            }
        }
        else
        {
            $sw38 = true;
            $var_graba38 = "";
        }


        if ($var_rubro_259 > 0)
        {
            if ($var_total_clientes_micro > 0)
            {
                $sw39 = true;
                $var_graba39 = "";
            }
            else
            {
                $sw39 = false;
                $var_graba39 = " SI EXISTE CARTERA MICRO, DEBE EXISTIR NÚMERO DE CLIENTES DE CRÉDITO MICRO ;";
            }
        }
        else
        {
            $sw39 = true;
            $var_graba39 = "";
        }

        if (round($var_cartera_restructurada_sin_atrasos,2) <= round($var_total_cartera,2))
        {
            $sw40 = true;
            $var_graba40 = "";
        }
        else
        {

            $sw40 = false;
            $var_graba40 = " EL SALDO DE CARTERA REESTRUCTURADA SIN ATRASOS NO PUEDE SER MAYOR AL TOTAL DE CARTERA ;";
        }

        if (round($var_cartera_restructurada_sin_atrasos,2) <= round($var_cartera_sin_atrasos,2))
        {
            $sw41 = true;
            $var_graba41 = "";
        }
        else
        {

            $sw41 = false;
            $var_graba41 = " EL SALDO DE CARTERA REESTRUCTURADA SIN ATRASOS NO PUEDE SER MAYOR AL TOTAL DE SALDO SIN ATRASOS ;";
        }

        if (round($var_cartera_restructurada_1_a_30,2) <= round($var_total_cartera,2))
        {
            $sw42 = true;
            $var_graba42 = "";
        }
        else
        {
            $sw42 = false;
            $var_graba42 = " EL SALDO DE CARTERA REESTRUCTURADA CON ATRASOS DE 1 A 30 DÍAS NO PUEDE SER MAYOR AL TOTAL DE CARTERA ;";
        }

        if (round($var_cartera_restructurada_1_a_30,2) <= round($var_cartera_1_a_30,2))
        {
            $sw43 = true;
            $var_graba43 = "";
        }
        else
        {
            $sw43 = false;
            $var_graba43 = " EL SALDO DE CARTERA REESTRUCTURADA CON ATRASOS DE 1 A 30 DÍAS NO PUEDE SER MAYOR AL TOTAL DE SALDO CON ATRASOS DE 1 A 30 DÍAS ;";
        }

        if (round($var_cartera_restructurada_mas_30,2) <= round($var_total_cartera,2))
        {
            $sw44 = true;
            $var_graba44 = "";
        }
        else
        {
            $sw44 = false;
            $var_graba44 = " EL SALDO DE CARTERA REESTRUCTURADA CON ATRASOS MAYOR A 30 DÍAS NO PUEDE SER MAYOR AL TOTAL DE CARTERA ;";
        }

        if (round($var_cartera_restructurada_mas_30,2) <= round($var_cartera_mas_30,2))
        {
            $sw45 = true;
            $var_graba45 = "";
        }
        else
        {
            $sw45 = false;
            $var_graba45 = " EL SALDO DE CARTERA REESTRUCTURADA CON ATRASOS MAYOR A 30 DÍAS NO PUEDE SER MAYOR AL TOTAL DE SALDO CON ATRASOS MAYOR A 30 DÍAS ;";
        }

        if (round($var_cartera_refinanciada_sin_atrasos,2) <= round($var_total_cartera,2))
        {
            $sw46 = true;
            $var_graba46 = "";
        }
        else
        {
            $sw46 = false;
            $var_graba46 = " EL SALDO DE CARTERA REFINANCIADA SIN ATRASOS NO PUEDE SER MAYOR AL TOTAL DE CARTERA ;";
        }

        if (round($var_cartera_refinanciada_sin_atrasos,2) <= round($var_cartera_sin_atrasos,2))
        {
            $sw47 = true;
            $var_graba47 = "";
        }
        else
        {
            $sw47 = false;
            $var_graba47 = " EL SALDO DE CARTERA REFINANCIADA SIN ATRASOS NO PUEDE SER MAYOR AL TOTAL DE SALDO SIN ATRASOS ;";
        }

        if (round($var_cartera_refinanciada_1_a_30,2) <= round($var_total_cartera,2))
        {
            $sw48 = true;
            $var_graba48 = "";
        }
        else
        {
            $sw48 = false;
            $var_graba48 = " EL SALDO DE CARTERA REFINANCIADA CON ATRASOS DE 1 A 30 DÍAS NO PUEDE SER MAYOR AL TOTAL DE CARTERA ;";
        }

        if (round($var_cartera_refinanciada_1_a_30,2) <= round($var_cartera_1_a_30,2))
        {
            $sw49 = true;
            $var_graba49 = "";
        }
        else
        {
            $sw49 = false;
            $var_graba49 = " EL SALDO DE CARTERA REFINANCIADA CON ATRASOS DE 1 A 30 DÍAS NO PUEDE SER MAYOR AL TOTAL DE SALDO CON ATRASOS DE 1 A 30 DÍAS ;";
        }

        if (round($var_cartera_refinanciada_mas_30,2) <= round($var_total_cartera,2))
        {
            $sw50 = true;
            $var_graba50 = "";
        }
        else
        {
            $sw50 = false;
            $var_graba50 = " EL SALDO DE CARTERA REFINANCIADA CON ATRASOS MAYOR A 30 DÍAS NO PUEDE SER MAYOR AL TOTAL DE CARTERA ;";
        }

        if (round($var_cartera_refinanciada_mas_30,2) <= round($var_cartera_mas_30,2))
        {
            $sw51 = true;
            $var_graba51 = "";
        }
        else
        {
            $sw51 = false;
            $var_graba51 = " EL SALDO DE CARTERA REFINANCIADA CON ATRASOS MAYOR A 30 DÍAS NO PUEDE SER MAYOR AL TOTAL DE SALDO CON ATRASOS MAYOR A 30 DÍAS ;";
        }

        if (round($var_cartera_restructurada_sin_atrasos_micro,2) <= round($var_total_cartera,2))
        {
            $sw52 = true;
            $var_graba52 = "";
        }
        else
        {
            $sw52 = false;
            $var_graba52 = " EL SALDO DE CARTERA REESTRUCTURADA SIN ATRASOS (MICRO) NO PUEDE SER MAYOR AL TOTAL DE CARTERA (MICRO) ;";
        }

        if (round($var_cartera_restructurada_sin_atrasos_micro,2) <= round($var_cartera_sin_atrasos_micro,2))
        {
            $sw53 = true;
            $var_graba53 = "";
        }
        else
        {
            $sw53 = false;
            $var_graba53 = " EL SALDO DE CARTERA REESTRUCTURADA (MICRO) SIN ATRASOS NO PUEDE SER MAYOR AL TOTAL DE SALDO SIN ATRASOS (MICRO) ;";
        }

        if (round($var_cartera_restructurada_1_a_30_micro,2) <= round($var_total_cartera,2))
        {
            $sw54 = true;
            $var_graba54 = "";
        }
        else
        {
            $sw54 = false;
            $var_graba54 = " EL SALDO DE CARTERA REESTRUCTURADA (MICRO) CON ATRASOS DE 1 A 30 DÍAS NO PUEDE SER MAYOR AL TOTAL DE CARTERA ;";
        }

        if (round($var_cartera_restructurada_1_a_30_micro,2) <= round($var_cartera_1_a_30_micro,2))
        {
            $sw55 = true;
            $var_graba55 = "";
        }
        else
        {
            $sw55 = false;
            $var_graba55 = " EL SALDO DE CARTERA REESTRUCTURADA (MICRO) CON ATRASOS DE 1 A 30 DÍAS NO PUEDE SER MAYOR AL TOTAL DE SALDO CON ATRASOS DE 1 A 30 DÍAS (MICRO) ;";
        }

        if (round($var_cartera_restructurada_mas_30_micro,2) <= round($var_total_cartera,2))
        {
            $sw56 = true;
            $var_graba56 = "";
        }
        else
        {
            $sw56 = false;
            $var_graba56 = " EL SALDO DE CARTERA REESTRUCTURADA (MICRO) CON ATRASOS MAYOR A 30 DÍAS NO PUEDE SER MAYOR AL TOTAL DE CARTERA ;";
        }

        if (round($var_cartera_restructurada_mas_30_micro,2) <= round($var_cartera_mas_30_micro,2))
        {
            $sw57 = true;
            $var_graba57 = "";
        }
        else
        {
            $sw57 = false;
            $var_graba57 = " EL SALDO DE CARTERA REESTRUCTURADA (MICRO) CON ATRASOS MAYOR A 30 DÍAS NO PUEDE SER MAYOR AL TOTAL DE SALDO CON ATRASOS MAYOR A 30 DÍAS (MICRO) ;";
        }

        if (round($var_cartera_refinanciada_sin_atrasos_micro,2) <= round($var_total_cartera,2))
        {
            $sw58 = true;
            $var_graba58 = "";
        }
        else
        {
            $sw58 = false;
            $var_graba58 = " EL SALDO DE CARTERA REFINANCIADA (MICRO) SIN ATRASOS NO PUEDE SER MAYOR AL TOTAL DE CARTERA ;";
        }

        if (round($var_cartera_refinanciada_sin_atrasos_micro,2) <= round($var_cartera_sin_atrasos_micro,2))
        {
            $sw59 = true;
            $var_graba59 = "";
        }
        else
        {
            $sw59 = false;
            $var_graba59 = " EL SALDO DE CARTERA REFINANCIADA (MICRO) SIN ATRASOS NO PUEDE SER MAYOR AL TOTAL DE SALDO SIN ATRASOS (MICRO) ;";
        }

        if (round($var_cartera_refinanciada_1_a_30_micro,2) <= round($var_total_cartera,2))
        {
            $sw60 = true;
            $var_graba60 = "";
        }
        else
        {
            $sw60 = false;
            $var_graba60 = " EL SALDO DE CARTERA REFINANCIADA (MICRO) CON ATRASOS DE 1 A 30 DÍAS NO PUEDE SER MAYOR AL TOTAL DE CARTERA ;";
        }

        if (round($var_cartera_refinanciada_1_a_30_micro,2) <= round($var_cartera_1_a_30_micro,2))
        {
            $sw61 = true;
            $var_graba61 = "";
        }
        else
        {
            $sw61 = false;
            $var_graba61 = " EL SALDO DE CARTERA REFINANCIADA (MICRO) CON ATRASOS DE 1 A 30 DÍAS NO PUEDE SER MAYOR AL TOTAL DE SALDO CON ATRASOS DE 1 A 30 DÍAS (MICRO) ;";
        }

        if (round($var_cartera_refinanciada_mas_30_micro,2) <= round($var_total_cartera,2))
        {
            $sw62 = true;
            $var_graba62 = "";
        }
        else
        {
            $sw62 = false;
            $var_graba62 = " EL SALDO DE CARTERA REFINANCIADA (MICRO) CON ATRASOS MAYOR A 30 DÍAS NO PUEDE SER MAYOR AL TOTAL DE CARTERA ;";
        }

        if (round($var_cartera_refinanciada_mas_30_micro,2) <= round($var_cartera_mas_30_micro,2))
        {
            $sw63 = true;
            $var_graba63 = "";
        }
        else
        {
            $sw63 = false;
            $var_graba63 = " EL SALDO DE CARTERA REFINANCIADA (MICRO) CON ATRASOS MAYOR A 30 DÍAS NO PUEDE SER MAYOR AL TOTAL DE SALDO CON ATRASOS MAYOR A 30 DÍAS (MICRO) ;";
        }

        if ($var_mes == '03' || $var_mes == '06')
        {
            if (round($var_colocacion_cartera_credito,2) <= round($var_total_cartera,2))
            {
                $sw64 = true;
                $var_graba64 = "";
            }
            else
            {
                $sw64 = false;
                $var_graba64 = " EL MONTO DE COLOCACIÓN DE CARTERA DE CRÉDITO NO PUEDE SER MAYOR AL TOTAL DE LA CARTERA DE CRÉDITO ;";
            }
        }
        else
        {
            $sw64 = true;
            $var_graba64 = "";
        }

        if (round($var_cartera_sector_urbano,2) <= round($var_total_cartera,2))
        {
            $sw65 = true;
            $var_graba65 = "";
        }
        else
        {
            $sw65 = false;
            $var_graba65 = " EL SALDO DE LA CARTERA DE CRÉDITO SECTOR URBANO NO PUEDE SER MAYOR AL TOTAL DE CARTERA ;";
        }

        if (round($var_cartera_sector_rural,2) <= round($var_total_cartera,2))
        {
            $sw66 = true;
            $var_graba66 = "";
        }
        else
        {
            $sw66 = false;
            $var_graba66 = " EL SALDO DE LA CARTERA DE CRÉDITO SECTOR RURAL NO PUEDE SER MAYOR AL TOTAL DE CARTERA ;";
        }

        if (round($var_cartera_sector_urbano_rural,2) == round($var_total_cartera,2))
        {
            $sw67 = true;
            $var_graba67 = "";
        }
        else
        {
            $sw67 = false;
            $var_graba67 = " LA SUMATORIA DEL SALDO DE LA CARTERA DE CRÉDITO SECTOR URBANO Y RURAL DEBE SER IGUAL AL TOTAL DE CARTERA ;";
        }

        if (round($var_colocacion_cartera_credito,2) > 0)
        {
            $sw68 = true;
            $var_graba68 = "";
        }
        else
        {
            $sw68 = false;
            $var_graba68 = " EL MONTO DE COLOCACIÓN DE CARTERA DE CRÉDITO DEBE SER MAYOR A 0 ;";
        }

        if (round($var_total_clientes_mujeres,2) > 0)
        {
            if (round($var_total_clientes_mujeres_micro,2) > 0)
            {
                $sw69 = true;
                $var_graba69 = "";
            }
            else
            {
                $sw69 = false;
                $var_graba69 = " SI EXISTE NÚMERO DE CLIENTES ACTIVOS DE CRÉDITO MUJERES, DEBE EXISTIR NÚMERO DE CLIENTES ACTIVOS DE CRÉDITO MUJERES (MICRO) ;";
            }
        }
        else
        {
            $sw69 = true;
            $var_graba69 = "";
        }

        if (round($var_total_oficiales,2) < round($var_total_personal,2))
        {
            $sw70 = true;
            $var_graba70 = "";
        }
        else
        {
            $sw70 = false;
            $var_graba70 = " EL TOTAL DE OFICIALES DE CRÉDITO NO PUEDE SER MAYOR AL NÚMERO DE PERSONAL QUE TRABAJA EN LA INSTITUCIÓN ;";
        }

        if (round($var_total_oficiales_mujeres,2) <= round($var_total_personal_mujeres,2))
        {
            $sw71 = true;
            $var_graba71 = "";
        }
        else
        {
            $sw71 = false;
            $var_graba71 = " EL TOTAL DE OFICIALES DE CRÉDITO MUJERES NO PUEDE SER MAYOR AL NÚMERO DE PERSONAL MUJERES QUE TRABAJA EN LA INSTITUCIÓN ;";
        }

        if (round($var_total_ctas_ahorros_voluntarias,2) > 0)
        {
            if (round($tasa_interes_promedio_ahorros,2) > 0)
            {
                $sw72 = true;
                $var_graba72 = "";
            }
            else
            {
                $sw72 = false;
                $var_graba72 = " SI EXISTE CUENTAS DE AHORRO VOLUNTARIAS, DEBE EXISTIR TASA DE INTERÉS PROMEDIO EN AHORROS ;";
            }
        }
        else
        {
            $sw72 = true;
            $var_graba72 = "";
        }

        if (round($var_total_dep_plazo_fijo,2) > 0)
        {
            if (round($tasa_interes_promedio_plazo_fijo,2) > 0)
            {
                $sw73 = true;
                $var_graba73 = "";
            }
            else
            {
                $sw73 = false;
                $var_graba73 = " SI EXISTE DEPÓSITOS A PLAZO FIJO, DEBE EXISTIR TASA DE INTERÉS PROMEDIO EN DEPÓSITOS A PLAZO FIJO ;";
            }
        }
        else
        {
            $sw73 = true;
            $var_graba73 = "";
        }

        if ($var_mes == '03')
        {
            $sw74 = true;
            $var_graba74 = "";
        }
        else
        {
            if (round($var_colocacion_cartera_credito,2) > round($var_colocacion_cartera_credito_periodo_anterior,2))
            {
                $sw74 = true;
                $var_graba74 = "";
            }
            else
            {
                $sw74 = false;
                $var_graba74 = " EL MONTO DE COLOCACIÓN DE CARTERA DE CRÉDITO NO PUEDE SER MENOR AL MONTO DEL ANTERIOR PERIODO ;";
            }
        }

        if ($var_mes == '03')
        {
            $sw75 = true;
            $var_graba75 = "";
        }
        else
        {
            if (round($var_total_prestamos_castigados,2) >= round($var_total_prestamos_castigados_periodo_anterior,2))
            {
                $sw75 = true;
                $var_graba75 = "";
            }
            else
            {
                $sw75 = false;
                $var_graba75 = " EL TOTAL DE PRÉSTAMOS CASTIGADOS NO PUEDE SER MENOR AL CASTIGO DEL ANTERIOR PERIODO ;";
            }
        }

        if ($var_mes == '03')
        {
            $sw76 = true;
            $var_graba76 = "";
        }
        else
        {
            if (round($var_total_prestamos_castigados_micro,2) >= round($var_total_prestamos_castigados_micro_periodo_anterior,2))
            {
                $sw76 = true;
                $var_graba76 = "";
            }
            else
            {
                $sw76 = false;
                $var_graba76 = " EL TOTAL DE PRÉSTAMOS CASTIGADOS MICRO NO PUEDE SER MENOR AL CASTIGO DEL ANTERIOR PERIODO ;";
            }
        }

        if (round($var_total_ahorros_mujeres_periodo_anterior,2) == 0)
        {
            $sw77 = true;
            $var_graba77 = "";
        }
        else
        {
            if (round($var_total_ahorros_mujeres,2) > 0)
            {
                $sw77 = true;
                $var_graba77 = "";
            }
            else
            {
                $sw77 = false;
                $var_graba77 = " EL NÚMERO DE CLIENTES ACTIVOS DE AHORRO MUJERES, DEBE SER MAYOR A 0 ;";
            }
        }

        if (round($var_educacion_financiera_periodo_anterior,2) == 0)
        {
            $sw78 = true;
            $var_graba78 = "";
        }
        else
        {
            if (round($var_educacion_financiera,2) > 0)
            {
                $sw78 = true;
                $var_graba78 = "";
            }
            else
            {
                $sw78 = false;
                $var_graba78 = " EDUCACIÓN FINANCIERA FUE SEÑALADO EN EL ANTERIOR PERIODO ;";
            }
        }

        if (round($var_may_dpt,2) <= round($var_total_monto_ahorros,2))
        {
            $sw79 = true;
            $var_graba79 = "";
        }
        else
        {
            $sw79 = false;
            $var_graba79 = " EL TOTAL DEL SALDO DE LOS 25 Y 100 MAYORES DEPOSITANTES  NO PUEDE SER MAYOR AL TOTAL DEL MONTO DE AHORROS ;";
        }

        if (round($var_total_cartera_por_vencer,2) == round($var_total_cartera_por_vencer_cobertura,2))
        {
            $sw80 = true;
            $var_graba80 = "";
        }
        else
        {
            $sw80 = false;
            $var_graba80 = " EL SALDO DE CARTERA DE CRÉDITO POR VENCER DE LA COBERTURA GEOGRÁFICA NO ES IGUAL A LO REPORTADO EN BALANCE GENERAL ;";
        }

        if (round($var_total_cartera_no_devenga_interes,2) == round($var_total_cartera_no_devenga_interes_cobertura,2))
        {
            $sw81 = true;
            $var_graba81 = "";
        }
        else
        {
            $sw81 = false;
            $var_graba81 = " EL SALDO DE CARTERA DE CRÉDITO QUE NO DEVENGA INTERESES DE LA COBERTURA GEOGRÁFICA NO ES IGUAL A LO REPORTADO EN BALANCE GENERAL ;";
        }

        if (round($var_total_cartera_vencido,2) == round($var_total_cartera_vencido_cobertura,2))
        {
            $sw82 = true;
            $var_graba82 = "";
        }
        else
        {
            $sw82 = false;
            $var_graba82 = " EL SALDO DE CARTERA DE CRÉDITO VENCIDO DE LA COBERTURA GEOGRÁFICA NO ES IGUAL A LO REPORTADO EN BALANCE GENERAL ;";
        }

        if ($sw1 && $sw2 && $sw3 && $sw4 && $sw5 && $sw6 && $sw7 && $sw8 && $sw9 && $sw10 &&
            $sw11 && $sw12 && $sw13 && $sw14 && $sw15 && $sw16 && $sw17 && $sw18 && $sw19 &&
            $sw20 && $sw21 && $sw22 && $sw23 && $sw24  && $sw25  && $sw26  && $sw27 && $sw28 &&
            $sw29 && $sw30 && $sw31 && $sw32 && $sw35 && $sw36 && $sw37 && $sw38 && $sw39 &&
            $sw40 && $sw41 && $sw42 && $sw43 && $sw44  && $sw45  && $sw46  && $sw47 && $sw48 &&
            $sw49 && $sw50 && $sw51 && $sw52 && $sw53  && $sw54  && $sw55  && $sw56 && $sw57 &&
            $sw58 && $sw59 && $sw60 && $sw61 && $sw62  && $sw63 && $sw64 && $sw65 && $sw66 &&
            $sw67&& $sw68 && $sw70 && $sw71 && $sw72 && $sw73 && $sw74 && $sw75 && $sw76 && $sw77 &&
            $sw78 && $sw79 && $sw80 && $sw81 && $sw82)
        {
            $sw = true;
        }
        if ($sw)
        {
            $var_graba = "SUS DATOS SE GRABARON Y VALIDARON CON ÉXITO";
            ?>
            <span class="Bien"><?echo $var_graba;?></span>
            <?php
        }
        else
        {
            /*Para Verificar las valizaciones
            echo $sw1." 1 ".$sw2." 2 ".$sw3." 3 ".$sw4." 4 ".$sw5." 5 ".$sw6." 6 ".$sw7." 7 ".$sw8." 8 ".$sw9." 9 ".$sw10." 10 ".$sw11." 11 ".
            $sw12." 12 ".$sw13." 13 ".$sw14." 14 ".$sw15." 15 ".$sw16." 16 ".$sw17." 17 ".$sw18." 18 ".$sw19." 19 ".$sw20." 20 ".$sw21." 21 ".
            $sw22." 22 ".$sw23." 23 ".$sw24." 24 ".$sw25." 25 ".$sw26." 26 ".$sw27." 27 "; */
            $var_graba = "SUS DATOS SE GRABARON EXISTE ERROR Y NO SERÁN PUBLICADOS:".$var_graba1.$var_graba2.$var_graba3.
                $var_graba4.$var_graba5.$var_graba6.$var_graba7.$var_graba8.$var_graba9.$var_graba10.$var_graba11.$var_graba12.
                $var_graba13.$var_graba14.$var_graba15.$var_graba16.$var_graba17.$var_graba18.$var_graba19.$var_graba20.$var_graba21.
                $var_graba22.$var_graba23.$var_graba24.$var_graba25.$var_graba26.$var_graba27.$var_graba28.$var_graba29.$var_graba30.
                $var_graba31.$var_graba32.$var_graba35.$var_graba36.$var_graba37.$var_graba38.$var_graba39.$var_graba40.$var_graba41.
                $var_graba42.$var_graba43.$var_graba44.$var_graba45.$var_graba46.$var_graba47.$var_graba48.$var_graba49.$var_graba50.
                $var_graba51.$var_graba52.$var_graba53.$var_graba54.$var_graba55.$var_graba56.$var_graba57.$var_graba58.$var_graba59.
                $var_graba60.$var_graba61.$var_graba62.$var_graba63.$var_graba64.$var_graba65.$var_graba66.$var_graba67.$var_graba68.
                $var_graba69.$var_graba70.$var_graba71.$var_graba72.$var_graba73.$var_graba74.$var_graba75.$var_graba76.$var_graba77.
                $var_graba78.$var_graba79.$var_graba80.$var_graba81.$var_graba82;
            $var_longitud = strlen($var_graba) - 2;
            $var_graba = substr($var_graba,0,$var_longitud);
            /*				echo "valo  no denva alcance ".$var_total_cartera_no_devenga_interes;
                            echo "<br>";
                            echo "valo  no denva cobertura ".$var_total_cartera_no_devenga_interes_cobertura;
                            echo "<br>";
                            echo "valo  vencido alcance ".$var_total_cartera_vencido;
                            echo "<br>";
                            echo "valo  vencido cobertura ".$var_total_cartera_vencido_cobertura;
            */				?>
            <span class="Mal"><?php echo $var_graba;?></span>
            <?php
        }
        break;
    case 5:
        $sw = false;
        $sw1 = false; /*RUBRO 157*/
        $sw2 = false; /*RUBRO 158*/
        $sw3 = false; /*RUBRO 159*/
        $sw4 = false; /*RUBRO 160*/
        $sw5 = false; /*RUBRO 161*/
        $sw6 = false; /*RUBRO 162*/
        $sw7 = false; /*RUBRO 163*/
        $sw8 = false; /*RUBRO 164*/
        $sw9 = false; /*RUBRO 165*/
        $sw10 = false; /*RUBRO 166*/
        $sw11 = false; /*RUBRO 167*/
        $sw12 = false; /*RUBRO 168*/
        /*25-06-2014*/
        $sw14 = false; /*RUBRO 176*/
        $sw15 = false; /*RUBRO 177*/
        $sw16 = false; /*RUBRO 178*/
        $sw17 = false; /*RUBRO 179*/
        $sw18 = false; /*RUBRO 180*/
        $sw19 = false; /*RUBRO 181*/
        $sw20 = false; /*RUBRO 183*/
        $sw21 = false; /*RUBRO 184*/
        $sw22 = false; /*RUBRO 185*/
        $sw23 = false; /*RUBRO 187*/
        $sw24 = false; /*RUBRO 189*/
        $sw25 = false; /*RUBRO 190*/
        $sw26 = false; /*RUBRO 191*/
        $sw27 = false; /*RUBRO 194*/
        $sw28 = false; /*RUBRO 210*/
        $sw29 = false; /*RUBRO 211*/
        $sw30 = false; /*RUBRO 254*/
        $sw31 = false; /*RUBRO 255*/
        $sw32 = false; /*RUBRO 303*/
        $sw33 = false; /*RUBRO 305*/
        $sw34 = false; /*RUBRO 306*/
        $sw35 = false; /*RUBRO 307*/
        $sw36 = false; /*RUBRO 317*/
        $sw37 = false; /*RUBRO 318*/
        $sw38 = false; /*RUBRO 319*/
        $sw39 = false; /*RUBRO 320*/
        $sw40 = false; /*RUBRO 321*/

        /*24-06-2014*/
        $var_rubro_157 = 0.00;
        $var_rubro_158 = 0.00;
        $var_rubro_159 = 0.00;
        $var_rubro_160 = 0.00;
        $var_rubro_161 = 0.00;
        $var_rubro_162 = 0.00;
        $var_rubro_163 = 0.00;
        $var_rubro_164 = 0.00;
        $var_rubro_165 = 0.00;
        $var_rubro_166 = 0.00;
        $var_rubro_167 = 0.00;
        $var_rubro_168 = 0.00;
        /*25-06-2014*/
        $var_rubro_176 = 0.00;
        $var_rubro_177 = 0.00;
        $var_rubro_178 = 0.00;
        $var_rubro_179 = 0.00;
        $var_rubro_180 = 0.00;
        $var_rubro_181 = 0.00;
        $var_rubro_183 = 0.00;
        $var_rubro_184 = 0.00;
        $var_rubro_185 = 0.00;
        $var_rubro_187 = 0.00;
        $var_rubro_189 = 0.00;
        $var_rubro_190 = 0.00;
        $var_rubro_191 = 0.00;
        $var_rubro_194 = 0.00;
        $var_rubro_210 = 0.00;
        $var_rubro_211 = 0.00;
        $var_rubro_254 = 0.00;
        $var_rubro_255 = 0.00;
        $var_rubro_303 = 0.00;
        $var_rubro_305 = 0.00;
        $var_rubro_306 = 0.00;
        $var_rubro_307 = 0.00;
        $var_rubro_317 = 0.00;
        $var_rubro_318 = 0.00;
        $var_rubro_319 = 0.00;
        $var_rubro_320 = 0.00;
        $var_rubro_321 = 0.00;

        $i=$_POST['contador'];
        for($j=0;$j<$i;$j++)
        {
            $var="codigo".$j;
            $var1="valor".$j;
            $var2="rubro".$j;
            $codigo=$_POST[$var];
            $cajatexto=$_POST[$var1];
            $var_rubro_id = $_POST[$var2];
            switch ($var_rubro_id)
            {
                case 157:
                    $var_rubro_157 = $var_rubro_157 + $cajatexto;
                    break;
                case 158:
                    $var_rubro_158 = $var_rubro_158 + $cajatexto;
                    break;
                case 159:
                    $var_rubro_159 = $var_rubro_159 + $cajatexto;
                    break;
                case 160:
                    $var_rubro_160 = $var_rubro_160 + $cajatexto;
                    break;
                case 161:
                    $var_rubro_161 = $var_rubro_161 + $cajatexto;
                    break;
                case 162:
                    $var_rubro_162 = $var_rubro_162 + $cajatexto;
                    break;
                case 163:
                    $var_rubro_163 = $var_rubro_163 + $cajatexto;
                    break;
                case 164:
                    $var_rubro_164 = $var_rubro_164 + $cajatexto;
                    break;
                case 165:
                    $var_rubro_165 = $var_rubro_165 + $cajatexto;
                    break;
                case 166:
                    $var_rubro_166 = $var_rubro_166 + $cajatexto;
                    break;
                case 167:
                    $var_rubro_167 = $var_rubro_167 + $cajatexto;
                    break;
                case 168:
                    $var_rubro_168 = $var_rubro_168 + $cajatexto;
                    break;
                /*25-06-2014*/
                case 176:
                    $var_rubro_176 = $var_rubro_176 + $cajatexto;
                    break;
                case 177:
                    $var_rubro_177 = $var_rubro_177 + $cajatexto;
                    break;
                case 178:
                    $var_rubro_178 = $var_rubro_178 + $cajatexto;
                    break;
                case 179:
                    $var_rubro_179 = $var_rubro_179 + $cajatexto;
                    break;
                case 180:
                    $var_rubro_180 = $var_rubro_180 + $cajatexto;
                    break;
                case 181:
                    $var_rubro_181 = $var_rubro_181 + $cajatexto;
                    break;
                case 183:
                    $var_rubro_183 = $var_rubro_183 + $cajatexto;
                    break;
                case 184:
                    $var_rubro_184 = $var_rubro_184 + $cajatexto;
                    break;
                case 185:
                    $var_rubro_185 = $var_rubro_185 + $cajatexto;
                    break;
                case 187:
                    $var_rubro_187 = $var_rubro_187 + $cajatexto;
                    break;
                case 189:
                    $var_rubro_189 = $var_rubro_189 + $cajatexto;
                    break;
                case 190:
                    $var_rubro_190 = $var_rubro_190 + $cajatexto;
                    break;
                case 191:
                    $var_rubro_191 = $var_rubro_191 + $cajatexto;
                    break;
                case 194:
                    $var_rubro_194 = $var_rubro_194 + $cajatexto;
                    break;
                case 210:
                    $var_rubro_210 = $var_rubro_210 + $cajatexto;
                    break;
                case 211:
                    $var_rubro_211 = $var_rubro_211 + $cajatexto;
                    break;
                case 254:
                    $var_rubro_254 = $var_rubro_254 + $cajatexto;
                    break;
                case 255:
                    $var_rubro_255 = $var_rubro_255 + $cajatexto;
                    break;
                case 303:
                    $var_rubro_303 = $var_rubro_303 + $cajatexto;
                    break;
                case 305:
                    $var_rubro_305 = $var_rubro_305 + $cajatexto;
                    break;
                case 306:
                    $var_rubro_306 = $var_rubro_306 + $cajatexto;
                    break;
                case 307:
                    $var_rubro_307 = $var_rubro_307 + $cajatexto;
                    break;
                case 317:
                    $var_rubro_317 = $var_rubro_317 + $cajatexto;
                    break;
                case 318:
                    $var_rubro_318 = $var_rubro_318 + $cajatexto;
                    break;
                case 319:
                    $var_rubro_319 = $var_rubro_319 + $cajatexto;
                    break;
                case 320:
                    $var_rubro_320 = $var_rubro_320 + $cajatexto;
                    break;
                case 321:
                    $var_rubro_321 = $var_rubro_321 + $cajatexto;
                    break;
            }
            switch ($var_rubro_id)
            {
                case 157:
                    $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$var_rubro_157 WHERE CODIGO_SKU=$codigo";
                    break;
                case 158:
                    $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$var_rubro_158 WHERE CODIGO_SKU=$codigo";
                    break;
                case 159:
                    $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$var_rubro_159 WHERE CODIGO_SKU=$codigo";
                    break;
                case 160:
                    $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$var_rubro_160 WHERE CODIGO_SKU=$codigo";
                    break;
                case 161:
                    $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$var_rubro_161 WHERE CODIGO_SKU=$codigo";
                    break;
                case 162:
                    $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$var_rubro_162 WHERE CODIGO_SKU=$codigo";
                    break;
                case 163:
                    $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$var_rubro_163 WHERE CODIGO_SKU=$codigo";
                    break;
                case 164:
                    $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$var_rubro_164 WHERE CODIGO_SKU=$codigo";
                    break;
                case 165:
                    $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$var_rubro_165 WHERE CODIGO_SKU=$codigo";
                    break;
                case 166:
                    $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$var_rubro_166 WHERE CODIGO_SKU=$codigo";
                    break;
                case 167:
                    $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$var_rubro_167 WHERE CODIGO_SKU=$codigo";
                    break;
                case 168:
                    $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$var_rubro_168 WHERE CODIGO_SKU=$codigo";
                    break;
                /*25-06-2014*/
                case 176:
                    $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$var_rubro_176 WHERE CODIGO_SKU=$codigo";
                    break;
                case 177:
                    $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$var_rubro_177 WHERE CODIGO_SKU=$codigo";
                    break;
                case 178:
                    $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$var_rubro_178 WHERE CODIGO_SKU=$codigo";
                    break;
                case 179:
                    $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$var_rubro_179 WHERE CODIGO_SKU=$codigo";
                    break;
                case 180:
                    $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$var_rubro_180 WHERE CODIGO_SKU=$codigo";
                    break;
                case 181:
                    $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$var_rubro_181 WHERE CODIGO_SKU=$codigo";
                    break;
                case 183:
                    $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$var_rubro_183 WHERE CODIGO_SKU=$codigo";
                    break;
                case 185:
                    $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$var_rubro_185 WHERE CODIGO_SKU=$codigo";
                    break;
                case 187:
                    $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$var_rubro_187 WHERE CODIGO_SKU=$codigo";
                    break;
                case 189:
                    $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$var_rubro_189 WHERE CODIGO_SKU=$codigo";
                    break;
                case 190:
                    $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$var_rubro_190 WHERE CODIGO_SKU=$codigo";
                    break;
                case 191:
                    $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$var_rubro_191 WHERE CODIGO_SKU=$codigo";
                    break;
                case 194:
                    $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$var_rubro_194 WHERE CODIGO_SKU=$codigo";
                    break;
                case 210:
                    $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$var_rubro_210 WHERE CODIGO_SKU=$codigo";
                    break;
                case 211:
                    $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$var_rubro_211 WHERE CODIGO_SKU=$codigo";
                    break;
                case 254:
                    $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$var_rubro_254 WHERE CODIGO_SKU=$codigo";
                    break;
                case 255:
                    $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$var_rubro_255 WHERE CODIGO_SKU=$codigo";
                    break;
                case 303:
                    $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$var_rubro_303 WHERE CODIGO_SKU=$codigo";
                    break;
                case 305:
                    $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$var_rubro_305 WHERE CODIGO_SKU=$codigo";
                    break;
                case 306:
                    $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$var_rubro_306 WHERE CODIGO_SKU=$codigo";
                    break;
                case 307:
                    $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$var_rubro_307 WHERE CODIGO_SKU=$codigo";
                    break;
                case 317:
                    $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$var_rubro_317 WHERE CODIGO_SKU=$codigo";
                    break;
                case 318:
                    $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$var_rubro_318 WHERE CODIGO_SKU=$codigo";
                    break;
                case 319:
                    $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$var_rubro_319 WHERE CODIGO_SKU=$codigo";
                    break;
                case 320:
                    $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$var_rubro_320 WHERE CODIGO_SKU=$codigo";
                    break;
                case 321:
                    $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$var_rubro_321 WHERE CODIGO_SKU=$codigo";
                    break;
                default:
                    $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$cajatexto WHERE CODIGO_SKU=$codigo";
                    break;
            }
            Actualizar($query);
        }

        /*INICIO CONSULTA DE RUBROS*/
        $consulta="select *
						from dbo.C_RUBRO_DATOS DAT
						where 
						DAT.ORGANIZACION_ID = $var_organizacion AND PERIODO_ID = $var_periodo AND RUBRO_ID = 260";
        $resultado=ConsultarTabla($consulta);
        $var_total_260=mssql_result($resultado,0,"RUBRO_VALOR");

        $consulta="select *
						from dbo.C_RUBRO_DATOS DAT
						where 
						DAT.ORGANIZACION_ID = $var_organizacion AND PERIODO_ID = $var_periodo AND RUBRO_ID = 104";
        $resultado=ConsultarTabla($consulta);
        $var_total_104=mssql_result($resultado,0,"RUBRO_VALOR");

        $consulta="select *
						from dbo.C_RUBRO_DATOS DAT
						where 
						DAT.ORGANIZACION_ID = $var_organizacion AND PERIODO_ID = $var_periodo AND RUBRO_ID = 11";
        $resultado=ConsultarTabla($consulta);
        $var_total_11=mssql_result($resultado,0,"RUBRO_VALOR");

        $consulta="select *
						from dbo.C_RUBRO_DATOS DAT
						where 
						DAT.ORGANIZACION_ID = $var_organizacion AND PERIODO_ID = $var_periodo AND RUBRO_ID = 108";
        $resultado=ConsultarTabla($consulta);
        $var_total_108=mssql_result($resultado,0,"RUBRO_VALOR");
        /*FIN DE CONSULTA DE RUBROS*/

        if($var_intermediacion == 'N')
        {
            $sw1 = true;
            $var_graba1 = "";
        }
        else
        {
            if ($var_rubro_157 > 0)
            {
                $sw1 = true;
                $var_graba1 = "";
            }
            else
            {
                $sw1 = false;
                $var_graba1 = " El NÚMERO DE APERTURA DE CUENTAS DE AHORRO EN EL PERIÓDO, DEBE SER MAYOR A 0 ;";
            }
        }
        if($var_intermediacion == 'N')
        {
            $sw2 = true;
            $var_graba2 = "";
        }
        else
        {
            if($var_rubro_158 > 0)
            {
                $sw2 = true;
                $var_graba2 = "";
            }
            else
            {
                $sw2 = false;
                $var_graba2 ="NÚMERO DE CUENTAS DE AHORROS CERRADA EN EL PERIODO, DEBE SER MAYOR A 0 ;";
            }
        }
        if($var_intermediacion == 'N')
        {
            $sw3 = true;
            $var_graba3 = "";
        }
        else
        {
            if($var_rubro_159 > 0)
            {
                $sw3 = true;
                $var_graba3 = "";
            }
            else
            {
                $sw3 = false;
                $var_graba3 = "NÚMERO DE CUENTAS DE AHORRO SIN MOVIMIENTO EN EL PERIÓDO, DEBE SER MAYOR A 0 ;";
            }
        }
        /*ESTE RUBRO DEBE SER IGUAL A : CARTERA Y ALCANCE / NUMERO DE CUENTAS ACTIVAS DE AHORRO*/
        if($var_intermediacion == 'N')
        {
            $sw4 = true;
            $var_graba4 = "";
        }
        else
        {
            if(round($var_rubro_160,2) == round($var_total_260,2))
            {
                $sw4 = true;
                $var_graba4 = "";
            }
            else
            {
                $sw4 = false;
                $var_graba4 = "TOTAL DE CUENTAS ACTIVAS DE AHORRO DE LA IMF, DEBE SER IGUAL NÚMERO DE CUENTAS ACTIVAS DE AHORRO DE CARTERA Y ALCANCE ;";
            }
        }
        /*FIN ------ ESTE RUBRO DEBE SER IGUAL A : CARTERA Y ALCANCE / NUMERO DE CUENTAS ACTIVAS DE AHORRO*/
        if($var_rubro_161 >= 0)
        {
            $sw5 = true;
            $var_graba5 = "";
        }
        else
        {
            $sw5 = false;
            $var_graba5 = "NÚMERO DE OPERACIONES DE BANCA MOVIL EN EL PERIODO, DEBE SER MAYOR O IGUAL A 0 ;";
        }
        if($var_rubro_162 >= 0)
        {
            $sw6 = true;
            $var_graba6 = "";
        }
        else
        {
            $sw6 = false;
            $var_graba6 = "NÚMERO DE OPERACIONES DE CAJEROS AUTOMATICOS, DEBE SER MAYOR O IGUAL A 0 ;";
        }
        if($var_rubro_163 >= 0)
        {
            $sw7 = true;
            $var_graba7 = "";
        }
        else
        {
            $sw7 = false;
            $var_graba7 = "NÚMERO DE OPERACIONES DE BANCA VIRTUAL EN EL PERIODO, DEBE SER MAYOR O IGUAL A 0 ;";
        }
        if($var_rubro_164 >= 0)
        {
            $sw8 = true;
            $var_graba8 = "";
        }
        else
        {
            $sw8 = false;
            $var_graba8 = "NÚMERO DE OPERACIONES DE P.O.S EN EL PERIODO, DEBE SER MAYOR O IGUAL A 0 ;";
        }
        if(round($var_rubro_165,2) <= round($var_total_104,2))
        {
            $sw9 = true;
            $var_graba9 = "";
        }
        else
        {
            $sw9 = false;
            $var_graba9 = "NÚMERO DE CLIENTES DE CREDITO CON SEGURO DE DESGRAVAMEN, DEBE SER MENOR O IGUAL A NÚMERO DE CLIENTES ACTIVOS DE CREDITO DE CARTERA Y ALCANCE ;";
        }
        if(round($var_rubro_166,2) <= round($var_total_104,2))
        {
            $sw10 = true;
            $var_graba10 = "";
        }
        else
        {
            $sw10 = false;
            $var_graba10 = "NÚMERO DE CLIENTES DE CREDITO CON SEGURO DE ASISTENCIA MEDICA Y/O VIDA, DEBE SER MENOR O IGUAL A NÚMERO DE CLIENTES ACTIVOS DE CREDITO DE CARTERA Y ALCANCE ;";
        }
        if(round($var_rubro_167,2) <= round($var_total_104,2))
        {
            $sw11 = true;
            $var_graba11 = "";
        }
        else
        {
            $sw11 = false;
            $var_graba11 = "NÚMERO DE CLIENTES DE CREDITO CAPACITADOS EN EL PERIODO, DEBE SER MENOR O IGUAL A NÚMERO DE CLIENTES ACTIVOS DE CREDITO DE CARTERA Y ALCANCE ;";
        }
        if(round($var_rubro_168,2) <= round($var_total_104,2))
        {
            $sw12 = true;
            $var_graba12 = "";
        }
        else
        {
            $sw12 = false;
            $var_graba12 = "NÚMERO DE CLIENTES DE CREDITO  BENEFICIARIOS DE SERVICIOS NO FINANCIEROS, DEBE SER MENOR O IGUAL A NÚMERO DE CLIENTES ACTIVOS DE CREDITO DE CARTERA Y ALCANCE ;";
        }
        /*25-06-2014*/
        if(round($var_rubro_176,2) <= round($var_total_11,2))
        {
            $sw14 = true;
            $var_graba14 = "";
        }
        else
        {
            $sw14 = false;
            $var_graba14 = "MONTO INVERTIDO EN CAPACITACIÓN PARA CLIENTES DE CRÉDITO EN EL PERÍODO, DEBE SER MENOR A TOTAL GASTOS DE OPERACIÓN Y FINANCIEROS DEL ESTADO DE RESULTADOS ;";
        }
        /*if($var_rubro_177 > 0)
        {
            $sw15 = true;
            $var_graba15 = "";
        }
        else
        {
            $sw15 = false;
            $var_graba15 = "NÚMERO DE EMPLEADOS CON CONTRATO Y BENEFICIOS DE ACUERDO A LO ESTABLECIDO POR LA LEY, DEBE SER MAYOR A 0 ;";
        }*/
        if(round($var_rubro_178,2) <= round($var_total_108,2))
        {
            $sw16 = true;
            $var_graba16 = "";
        }
        else
        {
            $sw16 = false;
            $var_graba16 = "NÚMERO DE EMPLEADOS CON BENEFICIOS ADICIONALES A LA LEY, DEBE SER MENOR A NÚMERO DE PERSONAL DE CARTERA Y ALCANCE ;";
        }
        if($var_rubro_179 >= 0)
        {
            $sw17 = true;
            $var_graba17 = "";
        }
        else
        {
            $sw17 = false;
            $var_graba17 = "NÚMERO DE PLANES DE CAPACITACIÓN DISEÑADOS PARA LOS EMPLEADOS EN EL PERIODO, DEBE SER MAYOR O IGUAL A 0 ;";
        }
        if(round($var_rubro_180,2) <= round($var_total_108,2))
        {
            $sw18 = true;
            $var_graba18 = "";
        }
        else
        {
            $sw18 = false;
            $var_graba18 = "NÚMERO DE EMPLEADOS CON CAPACITACIÓN MAYOR A 2 DÍAS EN EL PERÍODO, DEBE SER MENOR O IGUAL A NÚMERO DE PERSONAL DE CARTERA Y ALCANCE ;";
        }
        if($var_rubro_181 >= 0)
        {
            $sw19 = true;
            $var_graba19 = "";
        }
        else
        {
            $sw19 = false;
            $var_graba19 = "MONTO INVERTIDO EN CAPACITACIÓN PARA EMPLEADOS EN EL PERÍODO, DEBE SER MAYOR O IGUAL A 0 ;";
        }
        if($var_rubro_183 > 0)
        {
            $sw20 = true;
            $var_graba20 = "";
        }
        else
        {
            $sw20 = false;
            $var_graba20 = "SALARIO MÁS ALTO DEL PERSONAL EN EL PERÍODO, DEBE SER MAYOR A 0 ;";
        }
        if(($var_rubro_184 > 0) && ($var_rubro_184 < $var_rubro_183))
        {
            $sw21 = true;
            $var_graba21 = "";
        }
        else
        {
            $sw21 = false;
            $var_graba21 = "SALARIO MÁS BAJO DEL PERSONAL EN EL PERÍODO, DEBE SER MAYOR A 0 Y MENOR AL SALARIO MAS ALTO ;";
        }
        if($var_rubro_185 >= 0)
        {
            $sw22 = true;
            $var_graba22 = "";
        }
        else
        {
            $sw22 = false;
            $var_graba22 = "MONTO DESTINADO PARA BENEFICIO DE LOS CLIENTES, DEBE SER MAYOR O IGUAL A 0 ;";
        }
        if($var_rubro_187 >= 0)
        {
            $sw23 = true;
            $var_graba23 = "";
        }
        else
        {
            $sw23 = false;
            $var_graba23 = "MONTO DESTINADO PARA BENEFICIO DE LA COMUNIDAD EN EL PERÍODO, DEBE SER MAYOR O IGUAL A 0 ;";
        }
        if($var_rubro_189 > 0)
        {
            $sw24 = true;
            $var_graba24 = "";
        }
        else
        {
            $sw24 = false;
            $var_graba24 = "NÚMERO DE RESMAS DE PAPEL ADQUIRIDAS EN EL PERÍODO, DEBE SER MAYOR A 0 ;";
        }
        if($var_rubro_190 > 0)
        {
            $sw25 = true;
            $var_graba25 = "";
        }
        else
        {
            $sw25 = false;
            $var_graba25 = "NÚMERO DE KILOVATIOS UTILIZADOS  EN EL PERÍODO (CONSOLIDADO OFICINAS), DEBE SER MAYOR A 0 ;";
        }

        if($var_rubro_191 > 0)
        {
            $sw26 = true;
            $var_graba26 = "";
        }
        else
        {
            $sw26 = false;
            $var_graba26 = "NÚMERO DE METROS CÚBICOS DE AGUA UTILIZADOS EN EL PERÍODO(CONSOLIDADO OFICINAS), DEBE SER MAYOR A 0 ;";
        }
        if($var_rubro_194 > 0)
        {
            $sw27 = true;
            $var_graba27 = "";
        }
        else
        {
            $sw27 = false;
            $var_graba27 = "TIEMPO PROMEDIO DE DESEMBOLSO DEL CRÉDITO - SOLO MICRO (EN HORAS), DEBE SER MAYOR A 0 ;";
        }
        /*if($var_rubro_210 > 0)
        {
            $sw28 = true;
            $var_graba28 = "";
        }
        else
        {
            $sw28 = false;
            $var_graba28 = "NÚMERO DE CLIENTES ACTIVOS DE CRÉDITO REPORTADOS AL INICIO DEL PERÍODO, DEBE SER MAYOR A 0 ;";
        }*/
        if(($var_rubro_211 > 0) && (round($var_rubro_211,2) < round($var_total_104,2)))
        {
            $sw29 = true;
            $var_graba29 = "";
        }
        else
        {
            $sw29 = false;
            $var_graba29 = "NÚMERO DE CLIENTES ACTIVOS DE CRÉDITO NUEVOS EN EL PERÍODO, DEBE SER MAYOR A 0 Y MENOR AL NÚMERO DE CLIENTES ACTIVOS DE CREDITO DE CARTERA Y ALCANCE ;";
        }
        /*if($var_rubro_254 > 0)
        {
            $sw30 = true;
            $var_graba30 = "";
        }
        else
        {
            $sw30 = false;
            $var_graba30 = "NÚMERO TOTAL DE PERSONAL AL INICIO DEL PERIODO DE REFERENCIA, DEBE SER MAYOR A 0 ;";
        }*/
        if(($var_rubro_255 >= 0) && (round($var_total_255,2) < round($var_total_108,2)))
        {
            $sw31 = true;
            $var_graba31 = "";
        }
        else
        {
            $sw31 = false;
            $var_graba31 = "NÚMERO DE PERSONAL SALIENTE DURANTE EL PERIODO DE REFERENCIA, DEBE SER MAYOR O IGUAL A 0 Y MENOR AL NÚMERO DE PERSONAL TOTAL ;";
        }
        if(round($var_rubro_303,2) < round($var_total_108,2))
        {
            $sw32 = true;
            $var_graba32 = "";
        }
        else
        {
            $sw32 = false;
            $var_graba32 = "NÚMERO DE CARGOS GERENCIALES DENTRO DE LA IMF, DEBE SER MENOR A NÚMERO DE PERSONAL DE LA CARTERA Y ALCANCE ;";
        }
        if(round($var_rubro_305,2) <= round($var_rubro_303,2))
        {
            $sw33 = true;
            $var_graba33 = "";
        }
        else
        {
            $sw33 = false;
            $var_graba33 = "NÚMERO DE CARGOS GERENCIALES OCUPADOS POR MUJERES, DEBE SER MENOR O IGUAL AL NÚMERO DE CARGOS GERENCIALES DENTRO DE LA IMF ;";
        }
        if($var_rubro_306 > 0)
        {
            $sw34 = true;
            $var_graba34 = "";
        }
        else
        {
            $sw34 = false;
            $var_graba34 = "NÚMERO DE PERSONAS QUE PARTICIPAN EN EL DIRECTORIO, DEBE SER MAYOR A 0 ;";
        }
        if(round($var_rubro_307,2) <= round($var_rubro_306,2))
        {
            $sw35 = true;
            $var_graba35 = "";
        }
        else
        {
            $sw35 = false;
            $var_graba35 = "NÚMERO DE MUJERES QUE PARTICIPAN EN DIRECTORIO, DEBE SER MENOR O IGUAL QUE EL TOTAL DE MIEMBROS DEL DIRECTORIO ;";
        }
        if(round($var_rubro_317,2) < round($var_total_108,2))
        {
            $sw36 = true;
            $var_graba36 = "";
        }
        else
        {
            $sw36 = false;
            $var_graba36 = "NÚMERO DE EMPLEADOS CONTRATADOS CON DISCAPACIDADES, DEBE SER MENOR AL NÚMERO DE PERSONAL DE LA CARTERA Y ALCANCE ;";
        }
        if(round($var_rubro_318,2) < round($var_total_104,2))
        {
            $sw37 = true;
            $var_graba37 = "";
        }
        else
        {
            $sw37 = false;
            $var_graba37 = "NÚMERO DE CLIENTES DE CRÉDITO CON DISCAPACIDADES, DEBE SER MENOR AL NÚMERO DE CLIENTES ACTIVOS DE CRÉDITO DE CARTERA Y ALCANCE ;";
        }
        if(round($var_rubro_319,2) < round($var_total_108,2))
        {
            $sw38 = true;
            $var_graba38 = "";
        }
        else
        {
            $sw38 = false;
            $var_graba38 = "NÚMERO DE EMPLEADOS MIGRANTES, DEBE SER MENOR A NÚMERO DE PERSONAL DE LA CARTERA Y ALCANCE ;";
        }
        if(round($var_rubro_320,2) < round($var_total_104,2))
        {
            $sw39 = true;
            $var_graba39 = "";
        }
        else
        {
            $sw39 = false;
            $var_graba39 = "NÚMERO DE CLIENTES DE CRÉDITO MIGRANTES, DEBE SER MENOR AL NÚMERO DE CLIENTES ACTIVOS DE CRÉDITO DE CARTERA Y ALCANCE ;";
        }
        if($var_rubro_321 ==0 || $var_rubro_321 ==1)
        {
            $sw40 = true;
            $var_graba40 = "";
        }
        else
        {
            $sw40 = false;
            $var_graba40 = "PRÁCTICAS O POLÍTICAS MEDIO AMBIENTALES DEBE SER 0 / 1 ;";
        }
        if($sw1 && $sw2 && $sw3 && $sw4 &&
            $sw5 && $sw6 && $sw7 && $sw8 && $sw9 && $sw10 &&
            $sw11 && $sw12 && $sw14 && $sw16 && $sw17 && $sw18 && $sw19 && $sw20 &&
            $sw21 && $sw22 && $sw23 && $sw24 && $sw25 && $sw26 && $sw27 && $sw29 && $sw31 && $sw32 && $sw33 &&
            $sw34 && $sw35 && $sw36 && $sw37 && $sw38 &&
            $sw39 && $sw40)
        {
            $sw = true;
        }
        else
        {
            $sw = false;
        }
        if ($sw)
        {
            $var_graba = "SUS DATOS SE GRABARON Y VALIDARON CON ÉXITO";
            ?>
            <span class="Bien"><?php echo $var_graba;?></span>
            <?php
        }
        else
        {
            $var_graba = "SUS DATOS SE GRABARON EXISTE ERROR Y NO SERÁN PUBLICADOS:".
                $var_graba1.$var_graba2.$var_graba3.$var_graba4.$var_graba5.$var_graba6.$var_graba7.$var_graba8.
                $var_graba9.$var_graba10.$var_graba11.$var_graba12.$var_graba14.$var_graba16.$var_graba17.
                $var_graba18.$var_graba19.$var_graba20.$var_graba21.$var_graba22.$var_graba23.$var_graba24.$var_graba25.$var_graba26.
                $var_graba27.$var_graba29.$var_graba31.$var_graba32.$var_graba33.$var_graba34.
                $var_graba35.$var_graba36.$var_graba37.$var_graba38.$var_graba39.$var_graba40;
            $var_longitud = strlen($var_graba) - 2;
            $var_graba = substr($var_graba,0,$var_longitud);
            ?>
            <span class="Mal"><?php echo $var_graba;?></span>
            <?php
        }
        break;
    case 6:
        $sw = false;
        $i=$_POST['contador'];
        for($j=0;$j<$i;$j++)
        {
            $var="codigo".$j;
            $var1="valor".$j;
            $var2="rubro".$j;
            $codigo=$_POST[$var];
            $cajatexto=$_POST[$var1];
            $var_rubro_id = $_POST[$var2];
            $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$cajatexto WHERE CODIGO_SKU=$codigo";
            Actualizar($query);
        }
        $sw = true;
        $var_graba = "SUS DATOS SE GRABARON Y VALIDARON CON ÉXITO";
        ?>
        <span class="Bien"><?php echo $var_graba;?></span>
        <?php
        break;
    case 7:
        $sw = false;
        $i=$_POST['contador'];
        for($j=0;$j<$i;$j++)
        {
            $var="codigo".$j;
            $var1="valor".$j;
            $var2="rubro".$j;
            $codigo=$_POST[$var];
            $cajatexto=$_POST[$var1];
            $var_rubro_id = $_POST[$var2];
            $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$cajatexto WHERE CODIGO_SKU=$codigo";
            Actualizar($query);
        }
        $sw = true;
        $var_graba = "SUS DATOS SE GRABARON Y VALIDARON CON ÉXITO";
        ?>
        <span class="Bien"><?php echo $var_graba;?></span>
        <?php
        break;
    case 8:
        $sw = false;
        $i=$_POST['contador'];
        for($j=0;$j<$i;$j++)
        {
            $var="codigo".$j;
            $var1="valor".$j;
            $var2="rubro".$j;
            $codigo=$_POST[$var];
            $cajatexto=$_POST[$var1];
            $var_rubro_id = $_POST[$var2];
            $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$cajatexto WHERE CODIGO_SKU=$codigo";
            Actualizar($query);
        }
        $sw = true;
        $var_graba = "SUS DATOS SE GRABARON Y VALIDARON CON ÉXITO";
        ?>
        <span class="Bien"><?php echo $var_graba;?></span>
        <?php
        break;
    case 10:
        $sw = false;
        $sw1 = false;
        $sw2 = false;
        $sw3 = false;
        $var_rubro_261 = 0.00;
        $var_rubro_262 = 0.00;
        $var_rubro_263 = 0.00;
        $var_rubro_270 = 0.00;
        $var_rubro_269 = 0.00;
        $i=$_POST['contador'];
        for($j=0;$j<$i;$j++)
        {
            $var="codigo".$j;
            $var1="valor".$j;
            $var2="rubro".$j;
            $codigo=$_POST[$var];
            $cajatexto=$_POST[$var1];
            $var_rubro_id = $_POST[$var2];
            switch ($var_rubro_id)
            {
                case 261:
                    $var_rubro_261 = $var_rubro_261 + $cajatexto;
                    break;
                case 262:
                    $var_rubro_262 = $var_rubro_262 + $cajatexto;
                    break;
                case 269:
                    $var_rubro_269 = $var_rubro_269 + $cajatexto;
                    break;				}
            if($var_rubro_id == 261 || $var_rubro_id == 262)
            {
                $var_rubro_263 = $var_rubro_263 + $cajatexto;
            }
            if($var_rubro_id == 264 || $var_rubro_id == 265 || $var_rubro_id == 266 || $var_rubro_id == 267 || $var_rubro_id == 268 || $var_rubro_id == 269)
            {
                $var_rubro_270 = $var_rubro_270 + $cajatexto;
            }
            switch ($var_rubro_id)
            {
                case 263:
                    $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$var_rubro_263 WHERE CODIGO_SKU=$codigo";
                    break;
                case 270:
                    $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$var_rubro_270 WHERE CODIGO_SKU=$codigo";
                    break;
                default:
                    $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$cajatexto WHERE CODIGO_SKU=$codigo";
                    break;
            }
            Actualizar($query);
        }

        if ($var_rubro_261 < 0 || $var_rubro_261 > 0)
        {
            $sw1 = true;
            $var_graba1 = "";
        }
        else
        {
            $sw1 = false;
            $var_graba1 = " EL TOTAL DEL PATRIMONIO TÉCNICO PRIMARIO DEBE SER INGRESADO ;";
        }

        if ($var_valida_patrimonio_secundario == 'N')
        {
            $sw2 = true;
            $var_graba2 = "";
        }
        else
        {
            if ($var_rubro_262 < 0 || $var_rubro_262 > 0)
            {
                $sw2 = true;
                $var_graba2 = "";
            }
            else
            {
                $sw2 = false;
                $var_graba2 = " EL TOTAL DEL PATRIMONIO TÉCNICO SECUNDARIO DEBE SER INGRESADO ;";
            }
        }

        if ($var_rubro_269 > 0)
        {
            $sw3 = true;
            $var_graba3 = "";
        }
        else
        {
            $sw3 = false;
            $var_graba3 = " LOS ACTIVOS PONDERADOS POR RIESGO DEBEN REGISTRAR VALOR  ;";
        }

        if($sw1 && $sw2 && $sw3)
        {
            $sw = true;
        }
        else
        {
            $sw = false;
        }

        if ($sw)
        {
            $var_graba = "SUS DATOS SE GRABARON Y VALIDARON CON ÉXITO";
            ?>
            <span class="Bien"><?php echo $var_graba;?></span>
            <?php
        }
        else
        {
            $var_graba = "SUS DATOS SE GRABARON EXISTE ERROR Y NO SERÁN PUBLICADOS".$var_graba1.$var_graba2.$var_graba3;
            $var_longitud = strlen($var_graba) - 2;
            $var_graba = substr($var_graba,0,$var_longitud);
            ?>
            <span class="Mal"><?php echo $var_graba;?></span>
            <?php
        }
        break;
    case 12:
        $sw = false;
        $i=$_POST['contador'];
        for($j=0;$j<$i;$j++)
        {
            $var="codigo".$j;
            $var1="valor".$j;
            $var2="rubro".$j;
            $codigo=$_POST[$var];
            $cajatexto=$_POST[$var1];
            $var_rubro_id = $_POST[$var2];
            $query="update C_RUBRO_DATOS SET RUBRO_VALOR=$cajatexto WHERE CODIGO_SKU=$codigo";
            Actualizar($query);
        }
        $sw = true;
        $var_graba = "SUS DATOS SE GRABARON Y VALIDARON CON ÉXITO";
        ?>
        <span class="Bien"><?php echo $var_graba;?></span>
        <?php
        break;
}
if($sw == true)
{
    $var_estado = 1;
}
else
{
    $var_estado = 2;
}
$query="update C_NOVEDAD SET 
			ESTADO_ID = $var_estado, USUARIO_ID = $var_usuario, HORA_NOVEDAD = '$fecha', DESCRIPCION_NOVEDAD = '$var_graba', NOMBRE_USUARIO = '$var_nombre_usuario' 
			WHERE 
			PERIODO_ID = $var_periodo AND 
			ORGANIZACION_ID = $var_organizacion AND 
			MENU_ID = $var_menu";
Actualizar($query);
Desconectar();
?>
<br>
<br />
<div><span class="Mensajes"><?php echo "GRABANDO Y CALCULANDO.....";?></span></div>
<br>
<br />
<meta http-equiv="refresh" content=3;url=IngresoRubroTodos.php?var_rubro=<?php echo $var_rubro ?>>
<table class="bd" width="100%"><tr><td class="hr"></td></tr></table>
</body>
</html>
