<?php
include('../../librerias/libs_sql.php');
include('validadores.php');
$error = 0;
if (!empty($_POST)) {
  $arrayCodigo = $_POST['cod_'];
  $arrayValor = $_POST['val_'];
  $num_filas = $_POST['num_rows'];
  $var_rubro = 13;
  $var_graba = '';
  $var_sw1 = '';
  $var_estado = "2";

  Conectar();
  $fecha = fecha();
  $var_usuario = $_SESSION['usuario_id'];
  $var_nombre_usuario = $_SESSION["nombre_usuario"];
  $var_organizacion = $_SESSION["var_organizacion"];
  $var_periodo = $_SESSION["var_periodo"];
  $var_valida_fondos_irrepartibles = $_SESSION["var_valida_fondos_irrepartibles"];
  $var_valida_gastos_personal = $_SESSION["var_valida_gastos_personal"];
  $var_valida_gastos_servicios = $_SESSION["var_valida_gastos_servicios"];
  $var_valida_otros_gastos = $_SESSION["var_valida_otros_gastos"];
  $var_valida_gastos_impuestos = $_SESSION["var_valida_gastos_impuestos"];
  $query_encera = "update C_CUC_CARGA set
            SALDO_NUMERICO = 0 where ORGANIZACION_ID = $var_organizacion and
            PERIODO_ID = $var_periodo";

  Actualizar($query_encera);
  for ($i=0; $i < $num_filas - 1; $i++) {
    $query="update C_CUC_CARGA SET
        SALDO_NUMERICO = $arrayValor[$i]
        WHERE
        PERIODO_ID = $var_periodo AND
        ORGANIZACION_ID = $var_organizacion AND
        CC = $arrayCodigo[$i]";
    Actualizar($query);
    $error = 1;
  }
  if ($error == 0) {
    $mensaje1 = "Ups! ocurri&oacute; alg&uacute;n problema. Por favor vuelva a cargar el documento e intente nuevamente guardarlo";
    $mensaje = $mensaje1;
      header('refresh:1; url=../MenuPrincipal.php');
  }else {
/*----------------------Ejecutar Script-------------------------------------------*/
    $script = 'consulta/script_rfr_online.sql';
    $nuevo_script = $var_usuario.'.sql';
    $a_buscar = array('@ORGANIZACION', '@PERIODO');
    $reemplaza_por = array($var_organizacion, $var_periodo);
    $fila = '';
    if (copy($script, $nuevo_script)) {
      $sub_cadena = explode(";", file_get_contents($nuevo_script));
      foreach ($sub_cadena as $key) {
        $cadena = str_replace($a_buscar, $reemplaza_por, $key);
        if ($cadena !== '') {
          $fila .= $cadena.';';
        }
      }
    }
    $fp = fopen($nuevo_script, 'w');
    fwrite($fp, $fila);
    fclose($fp);
    if (file_exists('/var/www/html/plataforma/monitoreo/cargar_cvs/'.$nuevo_script)) {
      $sub_cadena_script = explode(";", file_get_contents($nuevo_script));
      foreach ($sub_cadena_script as $row) {
        $query_1 = $row;
        ConsultarTabla($query_1);
      }
    }

    unlink($nuevo_script);
    $update_select = "SELECT * FROM AUX_CARGA_CUC_PASS02 where ORGANIZACION_ID = $var_organizacion AND PERIODO_ID = $var_periodo";
    $res = ConsultarTabla($update_select);
    $rows_c = NumeroFilas($res);
    for ($j = 0; $j < $rows_c; ++$j){
      $row_v = mssql_result($res,$j,"SALDO_NUMERICO");
      $row_r = mssql_result($res,$j,"RUBRO_ID");
      $update = "UPDATE C_RUBRO_DATOS SET RUBRO_VALOR = $row_v WHERE ORGANIZACION_ID = $var_organizacion AND PERIODO_ID = $var_periodo AND RUBRO_ID = $row_r";

      Actualizar($update);
    }
/*----------------------Fin Ejecutar Script-------------------------------------------*/
	if(substr("$var_periodo", -2)=='12')
	{
		$var_val_1_izq = '1';
		$var_val_1_suma = '2,3';
		if (!valida_suma($var_val_1_izq, $var_val_1_suma)) {
		  $var_graba .='EL BALANCE NO CUADRA, TOTAL ACTIVO DEBE SER IGUAL AL PASIVO MÁS PATRIMONIO; ';
		  $var_sw1 = 'error';
		}
	}
	else
	{
		$var_val_1_izq = '1';
		$var_val_1_suma = '2,3,5';
		$var_val_1_resta = '4';
		if (!valida_suma_resta($var_val_1_izq, $var_val_1_suma, $var_val_1_resta)) {
		  $var_graba .='EL BALANCE NO CUADRA, TOTAL ACTIVO DEBE SER IGUAL AL PASIVO MÁS PATRIMONIO; ';
		  $var_sw1 = 'error';
		}
	}

    $var_val_2_positivo = '11,12,13,14,15,16,17,18,19';
    if (!valida_positivos($var_val_2_positivo)) {
      $var_graba .= 'LAS CUENTAS GENERALES DEL ACTIVO DEBEN SER PRESENTADAS CON SIGNO POSITIVO; ';
      $var_sw1 = 'error';
    }

    $var_val_3_izq = '11';
    $var_val_3_suma = '1101,1102,1103,1104,1105';
    if (!valida_suma($var_val_3_izq, $var_val_3_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS DE FONDOS DISPONIBLES NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_4_izq = '13';
    $var_val_4_suma = '1301,1302,1303,1304,1305,1306,1307,1399';
    if (!valida_suma($var_val_4_izq, $var_val_4_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS DE INVERSIONES NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_5_izq = '14';
    $var_val_5_suma = '1401,1402,1403,1404,1405,1406,1407,1408,1409,1410,1411,1412,1413,1414,1415,1416,1417,1418,1419,1420,1421,1422,1423,1424,1425,1426,1427,1428,1429,1430,1431,1432,1433,1434,1435,1436,1437,1438,1439,1440,1441,1442,1443,1444,1445,1446,1447,1448,1449,1450,1451,1452,1453,1454,1455,1456,1457,1458,1459,1460,1461,1462,1463,1464,1465,1466,1467,1468,1469,1470,1471,1472,1473,1474,1475,1476,1477,1478,1479,1480,1481,1482,1483,1484,1485,1486,1487,1488,1489,1490,1499';
    if (!valida_suma($var_val_5_izq, $var_val_5_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS DE CARTERA DE CRÉDITO NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_6_suma = '1401,1402,1403,1404,1405,1406,1407,1408,1409,1410,1411,1412,1413,1414,1415,1416,1417,1418,1419,1420,1421,1422,1423,1424,1425,1426,1427,1428,1429,1430,1431,1432,1433,1434,1435,1436,1437,1438,1439,1440,1441,1442,1443,1444,1445,1446,1447,1448,1449,1450,1451,1452,1453,1454,1455,1456,1457,1458,1459,1460,1461,1462,1463,1464,1465,1466,1467,1468,1469,1470,1471,1472,1473,1474,1475,1476,1477,1478,1479,1480,1481,1482,1483,1484,1485,1486,1487,1488,1489,1490';
    if (!valida_positivos($var_val_6_suma)) {
      $var_graba .= 'LAS SUBCUENTAS GENERALES DE CARTERA DEBEN SER PRESENTADAS CON SIGNO POSITIVO; ';
      $var_sw1 = 'error';
    }

    $var_val_7_negativo = '1499';
    if (!valida_negativo($var_val_7_negativo)) {
      $var_graba .= 'LA CUENTA GENERAL DE PROVISIONES DE CARTERA DEBEN SER PRESENTADAS CON SIGNO NEGATIVO; ';
      $var_sw1 = 'error';
    }

    $var_val_8_izq = '1499';
    $var_val_8_suma = '149905,149910,149915,149920,149925,149930,149935,149940,149945,149950,149955,149960,149980,149985,149987,149989';
    if (!valida_suma($var_val_8_izq, $var_val_8_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS DE PROVISIONES PARA CRÉDITOS INCOBRABLES NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_9_positivo = '1603';
    if (!valida_positivos($var_val_9_positivo)) {
      $var_graba .= 'LA CUENTA DE INTERESES DE CARTERA POR COBRAR  DEBEN SER PRESENTADAS CON SIGNO POSITIVO; ';
      $var_sw1 = 'error';
    }

    $var_val_10_izq = '1603';
    $var_val_10_suma = '160305,160310,160315,160320,160325,160330,160335,160340,160341,160342,160345,160350';
    if (!valida_suma($var_val_10_izq, $var_val_10_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS DE INTERESES DE LA CARTERA POR COBRAR NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_11_negativo = '1699';
    if (!valida_negativo($var_val_11_negativo)) {
      $var_graba .= 'LA CUENTA GENERAL DE PROVISIONES DE CUENTAS POR COBRAR DEBEN SER PRESENTADAS CON SIGNO NEGATIVO; ';
      $var_sw1 = 'error';
    }

    $var_val_12_izq = '18';
    $var_val_12_suma = '1801,1802,1803,1804,1805,1806,1807,1808,1809,1890,1899';
    if (!valida_suma($var_val_12_izq, $var_val_12_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS DE PROPIEDAD, PLANTA Y EQUIPO NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_13_izq = '1899';
    $var_val_13_suma = '189905,189910,189915,189920,189925,189930,189935,189940';
    if (!valida_suma($var_val_13_izq, $var_val_13_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS DE DEPRECIACIONES DE PROPIEDAD, PLANTA Y EQUIPO NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_14_negativo = '1899';
    if (!valida_negativo($var_val_14_negativo)) {
      $var_graba .= 'LA CUENTA GENERAL DE DEPRECIACIONES DE PROPIEDAD, PLANTA Y EQUIPO DEBEN SER PRESENTADAS CON SIGNO NEGATIVO; ';
      $var_sw1 = 'error';
    }

    $var_val_15_simple = '1908';
    if (numero_simple($var_val_15_simple) != 0) {
      $var_graba .= 'LA CUENTA POR TRANSFERENCIAS INTERNAS DEBE PRESENTARSE NETEADAS EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_16_positivo = '21,22,23,24,25,26,27,28,29';
    if (!valida_positivos($var_val_16_positivo)) {
      $var_graba .= 'LAS CUENTAS GENERALES DEL PASIVO DEBEN SER PRESENTADAS CON SIGNO POSITIVO; ';
      $var_sw1 = 'error';
    }

    $var_val_17_izq = '21';
    $var_val_17_suma = '2101,2102,2103,2104,2105';
    if (!valida_suma($var_val_17_izq, $var_val_17_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS DE OBLIGACIONES CON EL PÚBLICO NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }
    $var_val_18_izq = '2103';
    $var_val_18_suma = '210305,210310,210315,210320,210325,210330';
    if (!valida_suma($var_val_18_izq, $var_val_18_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS DE DEPÓSITOS A PLAZO NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_19_izq = '26';
    $var_val_19_suma = '2601,2602,2603,2604,2605,2606,2607,2608,2609,2610,2690';
    if (!valida_suma($var_val_19_izq, $var_val_19_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS DE OBLIGACIONES FINANCIERAS NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_20_simple = '2908';
    if (numero_simple($var_val_20_simple) != 0) {
      $var_graba .= 'LA CUENTA POR TRANSFERENCIAS INTERNAS DEBE PRESENTARSE NETEADAS EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_21_izq = '2';
    $var_val_21_suma = '21,22,23,24,25,26,27,28,29';
    if (!valida_suma($var_val_21_izq, $var_val_21_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS DE  PASIVO NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_22_positivo = '31,32,33,34,35';
    if (!valida_positivos($var_val_22_positivo)) {
      $var_graba .= 'LAS CUENTAS GENERALES DEL PATRIMONIO DEBEN SER PRESENTADAS CON SIGNO POSITIVO; ';
      $var_sw1 = 'error';
    }

    $var_val_23_izq = '31';
    $var_val_23_suma = '3101,3102,3103';
    if (!valida_suma($var_val_23_izq, $var_val_23_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS DE CAPITAL SOCIAL NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_24_izq = '33';
    $var_val_24_suma = '3301,3302,3303,3304,3305,3306,3310';
    if (!valida_suma($var_val_24_izq, $var_val_24_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS DE RESERVAS  NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_25_izq = '3402';
    $var_val_25_suma = '340205,340210';
    if (!valida_suma($var_val_25_izq, $var_val_25_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS DE DONACIONES NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_26_negativo = '3602,3604';
    if (!valida_negativo($var_val_26_negativo)) {
      $var_graba .= 'LAS CUENTAS DE PÉRDIDAS DEBEN PRESENTARSE CON SIGNO NEGATIVO; ';
      $var_sw1 = 'error';
    }

    $var_val_27_izq = '3';
    $var_val_27_suma = '31,32,33,34,35,36,37';
    if (!valida_suma($var_val_27_izq, $var_val_27_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS DE PATRIMONIO NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_28_positivo = '41,42,43,44,45,46,47,48';
    if (!valida_positivos($var_val_28_positivo)) {
      $var_graba .= 'LAS CUENTAS GENERALES DEL GASTO DEBEN SER PRESENTADAS CON SIGNO POSITIVO; ';
      $var_sw1 = 'error';
    }

    $var_val_29_izq = '4402';
    $var_val_29_suma = '440205,440210,440215,440220,440225,440230,440235,440240,440245,440250';
    if (!valida_suma($var_val_29_izq, $var_val_29_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS DE GASTO PROVISIONES DE CARTERA DE CRÉDITO NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_30_izq = '4';
    $var_val_30_suma = '41,42,43,44,45,46,47,48';
    if (!valida_suma($var_val_30_izq, $var_val_30_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS DE GASTO NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_31_positivo = '51,52,53,54,55,56';
    if (!valida_positivos($var_val_31_positivo)) {
      $var_graba .= 'LAS CUENTAS GENERALES DEL INGRESO DEBEN SER PRESENTADAS CON SIGNO POSITIVO; ';
      $var_sw1 = 'error';
    }

    $var_val_32_izq = '5104';
    $var_val_32_suma = '510405,510410,510415,510420,510421,510425,510426,510427,510428,510429,510430,510435,510450,510455';
    if (!valida_suma($var_val_32_izq, $var_val_32_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS DE INGRESOS POR INTERESES DE LA CARTERA DE CRÉDITOS NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_33_izq = '54';
    $var_val_33_suma = '5401,5404,5405,5490';
    if (!valida_suma($var_val_33_izq, $var_val_33_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS DE INGRESOS POR SERVICIOS NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_34_izq = '5604';
    $var_val_34_suma = '560405,560410,560415,560420';
    if (!valida_suma($var_val_34_izq, $var_val_34_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS DE INGRESOS POR RECUPERACIONES DE ACTIVOS FINANCIEROS NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_35_izq = '5';
    $var_val_35_suma = '51,52,53,54,55,56';
    if (!valida_suma($var_val_35_izq, $var_val_35_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS DE INGRESOS NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_36_izq = '25';
    $var_val_36_suma = '2501,2502,2503,2504,2505,2506,2507,2508,2510,2511,2590';
    if (!valida_suma($var_val_36_izq, $var_val_36_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS DE CUENTAS POR PAGAR NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    if ($var_valida_fondos_irrepartibles == 'S') {
      $var_val_37_izq = '3301';
      $var_val_37_suma = '330105,330110,330115';
      if (!valida_suma($var_val_37_izq, $var_val_37_suma)) {
        $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS DE FONDOS IRREPARTIBLES NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
        $var_sw1 = 'error';
      }
    }

    $var_val_38_izq = '45';
    $var_val_38_suma = '4501,4502,4503,4504,4505,4506,4507';
    if (!valida_suma($var_val_38_izq, $var_val_38_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS DE GASTOS DE OPERACIÓN NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    if ($var_valida_gastos_personal == 'S') {
	    $var_val_39_izq = '4501';
	    $var_val_39_suma = '450105,450110,450115,450120,450125,450130,450135,450190';
	    if (!valida_suma($var_val_39_izq, $var_val_39_suma)) {
	      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS DE GASTOS DE PERSONAL NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
	      $var_sw1 = 'error';
	    }
	}

    $var_val_40_izq = '47';
    $var_val_40_suma = '4701,4702,4703,4790';
    if (!valida_suma($var_val_40_izq, $var_val_40_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS DE OTROS GASTOS Y PÉRDIDAS NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_41_izq = '48';
    $var_val_41_suma = '4810,4815,4890';
    if (!valida_suma($var_val_41_izq, $var_val_41_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS IMPUESTOS Y PARTICIPACIÓN EMPLEADOS NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_42_izq = '5490';
    $var_val_42_suma = '549005,549010';
    if (!valida_suma($var_val_42_izq, $var_val_42_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS DE INGRESOS POR SERVICIOS NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_43_izq = '55';
    $var_val_43_suma = '5501,5502,5503,5505,5506,5590';
    if (!valida_suma($var_val_43_izq, $var_val_43_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS DE OTROS INGRESOS OPERACIONALES NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_44_izq = '56';
    $var_val_44_suma = '5601,5602,5603,5604,5690';
    if (!valida_suma($var_val_44_izq, $var_val_44_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS DE OTROS INGRESOS NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_45_izq = '7414';
    $var_val_45_suma = '741401,741402,741403,741404,741405,741406,741409,741410,741411,741412,741413,741414,741417,741418,741419,741420,741421,741422,741423,741424,741425,741428,741429,741430,741431,741432,741433,741434,741435,741436,741437,741438,741439,741440,741441,741442,741443,741444';
    if (!valida_suma($var_val_45_izq, $var_val_45_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS DE ORDEN POR PROVISIONES CONSTITUIDAS NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_46_izq = '410190';
    $var_val_46_der = '519090';
    if (valida_diferentes_y_cero($var_val_46_izq, $var_val_46_der)) {
      $var_graba .= 'LA CUENTA POR INTERESES INTERNOS DEBE PRESENTARSE NETEADAS EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_47_izq = '410590';
    $var_val_47_der = '519090';
    if (valida_diferentes_y_cero($var_val_47_izq, $var_val_47_der)) {
      $var_graba .= 'LA CUENTA POR INTERESES INTERNOS DEBE PRESENTARSE NETEADAS EN BALANCE; ';
      $var_sw1 = 'error';
    }

   	if(substr("$var_periodo", -2)!='12'){
	    $var_val_48_simple = '3603';
	    if (numero_simple($var_val_48_simple) != 0) {
	      $var_graba .= 'LOS RESULTADOS GENERADOS DEBEN REGISTRARSE EN EL PATRIMONIO EN DICIEMBRE; ';
	      $var_sw1 = 'error';
	    }
	}

   	if(substr("$var_periodo", -2)!='12'){
	    $var_val_49_simple = '3604';
	    if (numero_simple($var_val_49_simple) != 0) {
	      $var_graba .= 'LOS RESULTADOS GENERADOS DEBEN REGISTRARSE EN EL PATRIMONIO EN DICIEMBRE; ';
	      $var_sw1 = 'error';
	    }
	}

    $var_val_50_izq = '1101';
    $var_val_50_suma = '110105,110110';
    if (!valida_suma($var_val_50_izq, $var_val_50_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS DE CAJA NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_51_izq = '1902';
    $var_val_51_suma = '190205,190210,190215,190220,190221,190225,190226,190230,190231,190235,190240,190245,190250,190255,190260,190265,190270,190275,190280,
    					190285,190286';
    if (!valida_suma($var_val_51_izq, $var_val_51_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS POR OTROS ACTIVOS NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_52_izq = '2505';
    $var_val_52_suma = '250505,250510,250590';
    if (!valida_suma($var_val_52_izq, $var_val_52_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS DE CUENTAS POR PAGAR POR CONTRIBUCIONES, IMPUESTOS Y MULTAS NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    if ($var_valida_gastos_servicios == 'S') {
	    $var_val_53_izq = '4503';
	    $var_val_53_suma = '450305,450310,450315,450320,450325,450330,450390';
	    if (!valida_suma($var_val_53_izq, $var_val_53_suma)) {
	      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS DE GASTOS POR SERVICIOS VARIOS NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
	      $var_sw1 = 'error';
	    }
	}

    $var_val_54_izq = '4103';
    $var_val_54_suma = '410305,410310,410315,410320,410325,410330,410335,410340,410345,410350';
    if (!valida_suma($var_val_54_izq, $var_val_54_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS POR GASTOS DE OBLIGACIONES FINANCIERAS NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }
   
    $var_val_55_izq = '4105';
    $var_val_55_der = '5190';
    if (valida_diferentes_y_cero($var_val_55_izq, $var_val_55_der)) {
      $var_graba .= 'LA CUENTA POR INTERESES INTERNOS DEBE PRESENTARSE NETEADAS EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_56_izq = '410305';
    $var_val_56_der = '519090';
    if (valida_diferentes_y_cero($var_val_56_izq, $var_val_56_der)) {
      $var_graba .= 'LA CUENTA POR INTERESES INTERNOS DEBE PRESENTARSE NETEADAS EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_57_izq = '410350';
    $var_val_57_der = '519090';
    if (valida_diferentes_y_cero($var_val_57_izq, $var_val_57_der)) {
      $var_graba .= 'LA CUENTA POR INTERESES INTERNOS DEBE PRESENTARSE NETEADAS EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_58_izq = '4103';
    $var_val_58_der = '5190';
    if (valida_diferentes_y_cero($var_val_58_izq, $var_val_58_der)) {
      $var_graba .= 'LA CUENTA POR INTERESES INTERNOS DEBE PRESENTARSE NETEADAS EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_59_izq = '51';
    $var_val_59_suma = '5101,5102,5103,5104,5190';
    if (!valida_suma($var_val_59_izq, $var_val_59_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS DE INTERESES Y DESCUENTOS GANADOS NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    if ($var_valida_otros_gastos == 'S') {
	    $var_val_60_izq = '4790';
	    $var_val_60_suma = '479005,479010';
	    if (!valida_suma($var_val_60_izq, $var_val_60_suma)) {
	      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS OTROS GASTOS OPERATIVOS NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
	      $var_sw1 = 'error';
	    }
	}

    if ($var_valida_gastos_impuestos == 'S') {
	    $var_val_61_izq = '4504';
	    $var_val_61_suma = '450405,450410,450415,450420,450421,450425,450430,450490';
	    if (!valida_suma($var_val_61_izq, $var_val_61_suma)) {
	      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS DE  GASTOS POR IMPUESTOS, CONTRIBUCIONES Y MULTAS NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
	      $var_sw1 = 'error';
	    }
	}

    $var_val_62_positivo = '4703';
    if (!valida_positivos($var_val_62_positivo)) {
      $var_graba .= 'LA SUMATORIA DE LA CUENTA DE GASTOS POR INTERESES DEVENGADOS DE EJERCICIOS ANTERIORES NO DEBEN PRESENTARSE EN NEGATIVO; ';
      $var_sw1 = 'error';
    }

    $var_val_63_positivo = '560420';
    if (!valida_positivos($var_val_63_positivo)) {
      $var_graba .= 'LA SUMATORIA DE LA CUENTA DE INGRESOS POR INTERESES DEVENGADOS DE EJERCICIOS ANTERIORES NO DEBEN PRESENTARSE EN NEGATIVO; ';
      $var_sw1 = 'error';
    }

    $var_val_64_izq = '1';
    $var_val_64_suma = '11,12,13,14,15,16,17,18,19';
    if (!valida_suma($var_val_64_izq, $var_val_64_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS DE  ACTIVO NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_65_izq = '1103';
    $var_val_65_suma = '110305,110310,110315,110320';
    if (!valida_suma($var_val_65_izq, $var_val_65_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS DE BANCOS Y OTRAS INSTITUCIONES FINANCIERAS NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_66_izq = '1614';
    $var_val_66_suma = '161405,161410,161415,161420,161425,161430,161490';
    if (!valida_suma($var_val_66_izq, $var_val_66_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS POR PAGO POR CUENTA DE CLIENTES / SOCIOS NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_67_izq = '1690';
    $var_val_67_suma = '169005,169010,169015,169020,169025,169030,169035,169040,169090';
    if (!valida_suma($var_val_67_izq, $var_val_67_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS POR CUENTAS POR COBRAR VARIAS NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_68_izq = '1401';
    $var_val_68_suma = '140105,140110,140115,140120,140125';
    if (!valida_suma($var_val_68_izq, $var_val_68_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS DE CARTERA DE CRÉDITO COMERCIAL PRIORITARIO POR VENCER NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_69_izq = '1452';
    $var_val_69_suma = '145205,145210,145215,145220,145225';
    if (!valida_suma($var_val_69_izq, $var_val_69_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS DE CARTERA DE CRÉDITO MICROCRÉDITO VENCIDA NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_70_izq = '1905';
    $var_val_70_suma = '190505,190510,190515,190520,190525,190530,190590,190599';
    if (!valida_suma($var_val_70_izq, $var_val_70_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS GASTOS DIFERIDOS NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_71_izq = '1906';
    $var_val_71_suma = '190605,190610,190615';
    if (!valida_suma($var_val_71_izq, $var_val_71_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS DE OTROS ACTIVOS POR MATERIALES NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_72_izq = '34';
    $var_val_72_suma = '3401,3402,3490';
    if (!valida_suma($var_val_72_izq, $var_val_72_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS DE OTROS APORTES PATRIMONIALES NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_73_positivo = '1614';
    if (!valida_positivos($var_val_73_positivo)) {
      $var_graba .= 'LAS CUENTAS POR PAGOS DE CUENTAS DE CLIENTES / SOCIOS DEL ACTIVO DEBEN SER PRESENTADAS CON SIGNO POSITIVO; ';
      $var_sw1 = 'error';
    }

    $var_val_74_izq = '2602';
    $var_val_74_suma = '260205,260210,260215,260220,260225,260250,260255,260260,260265,260270';
    if (!valida_suma($var_val_74_izq, $var_val_74_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS DE  OBLIGACIONES FINANCIERAS CON INSTITUCIONES DEL PAÍS Y SECTOR FINANCIERO POPULAR Y SOLIDARIO NO CORRESPONDEN A LA  DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_75_izq = '2606';
    $var_val_75_suma = '260605,260610,260615,260620,260625';
    if (!valida_suma($var_val_75_izq, $var_val_75_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS DE  OBLIGACIONES FINANCIERAS CON ENTIDADES FINANCIERAS DEL SECTOR PÚBLICO NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_76_izq = '2607';
    $var_val_76_suma = '260705,260710,260715,260720,260725';
    if (!valida_suma($var_val_76_izq, $var_val_76_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS DE  OBLIGACIONES FINANCIERAS CON ORGANISMOS MULTILATERALES NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_77_izq = '2690';
    $var_val_77_suma = '269005,269010,269015,269020,269025';
    if (!valida_suma($var_val_77_izq, $var_val_77_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS DE  OTRAS OBLIGACIONES FINANCIERAS NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_77_izq = '2690';
    $var_val_77_suma = '269005,269010,269015,269020,269025';
    if (!valida_suma($var_val_77_izq, $var_val_77_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS DE  OTRAS OBLIGACIONES FINANCIERAS NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_78_positivo = '5';
    if (!valida_positivos($var_val_78_positivo)) {
      $var_graba .= 'LAS CUENTAS DE INGRESO DEBEN REGISTRAR VALORES PARA DETERMINAR UTILIDAD O PÉRDIDA DEL EJERCICIO; ';
      $var_sw1 = 'error';
    }

    $var_val_79_positivo = '4';
    if (!valida_positivos($var_val_79_positivo)) {
      $var_graba .= 'LAS CUENTAS DE GASTOS DEBEN REGISTRAR VALORES PARA DETERMINAR UTILIDAD O PÉRDIDA DEL EJERCICIO; ';
      $var_sw1 = 'error';
    }

    $var_val_80_izq = '5201';
    $var_val_80_suma = '520105,520110,520115,520120,520125';
    if (!valida_suma($var_val_80_izq, $var_val_80_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS POR COMISIONES GANADAS EN CARTERA DE CRÉDITOS NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_81_izq = '5101';
    $var_val_81_suma = '510105,510110,510115';
    if (!valida_suma($var_val_81_izq, $var_val_81_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS POR INTERESES Y DESCUENTOS GANADOS EN DEPÓSITOS NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_82_izq = '1402';
    $var_val_82_suma = '140205,140210,140215,140220,140225';
    if (!valida_suma($var_val_82_izq, $var_val_82_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS DE CARTERA DE CRÉDITO CONSUMO PRIORITARIO POR VENCER NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_83_izq = '1403';
    $var_val_83_suma = '140305,140310,140315,140320,140325';
    if (!valida_suma($var_val_83_izq, $var_val_83_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS DE CARTERA DE CRÉDITO INMOBILIARIO POR VENCER NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_84_izq = '1404';
    $var_val_84_suma = '140405,140410,140415,140420,140425';
    if (!valida_suma($var_val_84_izq, $var_val_84_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS DE CARTERA DE CRÉDITO MICROCRÉDITO POR VENCER NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_85_izq = '1426';
    $var_val_85_suma = '142605,142610,142615,142620,142625';
    if (!valida_suma($var_val_85_izq, $var_val_85_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS DE CARTERA DE CRÉDITO CONSUMO PRIORITARIO QUE NO DEVENGA INTERES NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_86_izq = '2990';
    $var_val_86_suma = '299005,299090';
    if (!valida_suma($var_val_86_izq, $var_val_86_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS DE OTROS PASIVOS NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_87_izq = '4101';
    $var_val_87_suma = '410105,410110,410115,410120,410125,410130,410135,410140,410190';
    if (!valida_suma($var_val_87_izq, $var_val_87_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS POR INTERESES CAUSADOS EN OBLIGACIONES CON EL PÚBLICO NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_88_izq = '5103';
    $var_val_88_suma = '510305,510310,510315,510320';
    if (!valida_suma($var_val_88_izq, $var_val_88_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS POR INTERESES GANADOS DE INVERSIONES NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_89_izq = '4505';
    $var_val_89_suma = '450505,450510,450515,450520,450525,450530,450535,450540,450545,450590';
    if (!valida_suma($var_val_89_izq, $var_val_89_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS POR GASTOS EN DEPRECIACIONES NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_90_izq = '1104';
    $var_val_90_suma = '110401';
    if (!valida_suma($var_val_90_izq, $var_val_90_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS POR EFECTOS DE COBRO INMEDIATO DEL ACTIVO NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_91_positivo = '1990,199005,199010,199015,199025,199090';
    if (!valida_positivos($var_val_91_positivo)) {
      $var_graba .= 'LA CUENTA Y SUBCUENTAS DE OTROS ACTIVOS DEBEN SER PRESENTADAS CON SIGNO POSITIVO; ';
      $var_sw1 = 'error';
    }

    $var_val_92_negativo = '149905,149910,149915,149920,149925,149930,149935,149940,149945,149950,149955,149960,149980, 149985, 149987,149989';
    if (!valida_negativo($var_val_92_negativo)) {
      $var_graba .= 'LAS SUBCUENTAS DE PROVISIONES DE CARTERA DEBEN SER PRESENTADAS CON SIGNO NEGATIVO; ';
      $var_sw1 = 'error';
    }

    $var_val_93_izq = '2505';
    $var_val_93_suma = '250505,250510,250590';
    if (!valida_suma($var_val_93_izq, $var_val_93_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS DE PASIVOS POR CONTRIBUCIONES IMPUESTOS Y MULTAS NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_94_izq = '2501';
    $var_val_94_suma = '250105,250110,250115,250120,250125,250130,250135,250140,250145,250150,250190';
    if (!valida_suma($var_val_94_izq, $var_val_94_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS DE PASIVOS POR INTERESES POR PAGAR NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_95_izq = '2503';
    $var_val_95_suma = '250305,250310+250315+250320+250325+250330+250390';
    if (!valida_suma($var_val_95_izq, $var_val_95_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS DE PASIVOS POR CUENTAS POR PAGAR VARIAS NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_96_izq = '2590';
    $var_val_96_suma = '259005,259010,259015,259090';
    if (!valida_suma($var_val_96_izq, $var_val_96_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS DE PASIVOS POR CUENTAS POR PAGAR VARIAS NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_97_izq = '4507';
    $var_val_97_suma = '450705,450710,450715,450790';
    if (!valida_suma($var_val_97_izq, $var_val_97_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS POR OTROS GASTOS NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_98_izq = '4790';
    $var_val_98_suma = '479005,479010';
    if (!valida_suma($var_val_98_izq, $var_val_98_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS POR OTROS GASTOS NO OPERACIONALES NO CORRESPONDEN A LA DETALLADA EN BALANCE; ';
      $var_sw1 = 'error';
    }

    $var_val_99_izq = '25';
    $var_val_99_suma = '2501,2502,2503,2504,2505,2506,2507,2508,2510,2511,2590';
    if (!valida_suma($var_val_99_izq, $var_val_99_suma)) {
      $var_graba .= 'LA SUMATORIA DE LAS SUBCUENTAS PASIVO POR CUENTAS POR PAGAR NO CORRESPONDEN A LA DETALLADA EN BALANCE, POR FAVOR REVISAR; ';
      $var_sw1 = 'error';
    }

  if(substr("$var_periodo", -2)=='12')
  {
    $var_val_100_suma = '3603,3604';
    $var_val_100_resta = '5,4';
    if (!valida_suma_resta_simple($var_val_100_suma, $var_val_100_resta)) {
      $var_graba .='EL VALOR REGISTRADO COMO RESULTADO DEL EJERCICIO NO CORRESPONDE AL DETALLADO EN LOS RESULTADOS GENERADOS; ';
      $var_sw1 = 'error';
    }
  }

    $consultar="SELECT *
          FROM dbo.C_NOVEDAD
          WHERE
          PERIODO_ID = $var_periodo AND
          ORGANIZACION_ID = $var_organizacion AND
          MENU_ID = $var_rubro";
    $resultado=ConsultarTabla($consultar);
    $filas=NumeroFilas($resultado);
    if ($filas != 0)
    {
      if ($var_sw1 == '') {
        $query1="update C_NOVEDAD SET
    				ESTADO_ID = 1, USUARIO_ID = $var_usuario, HORA_NOVEDAD = '$fecha', DESCRIPCION_NOVEDAD = 'SUS DATOS SE GRABARON Y VALIDARON CON &Eacute;XITO', NOMBRE_USUARIO = '$var_nombre_usuario'
    				WHERE
    				PERIODO_ID = $var_periodo AND
    				ORGANIZACION_ID = $var_organizacion AND
    				MENU_ID = $var_rubro";
        $mensaje2 = "<p class='bien'>Valores enviados con  &eacute;xito</p>";
      }else {
        $query1="update C_NOVEDAD SET
    				ESTADO_ID = 2, USUARIO_ID = $var_usuario, HORA_NOVEDAD = '$fecha', DESCRIPCION_NOVEDAD = '$var_graba', NOMBRE_USUARIO = '$var_nombre_usuario'
    				WHERE
    				PERIODO_ID = $var_periodo AND
    				ORGANIZACION_ID = $var_organizacion AND
    				MENU_ID = $var_rubro";
        $mensaje2 = "<p class='error'>Valores enviados con  error</p>";
      }
      Actualizar($query1);
    }
    header('refresh:1; url=../MenuPrincipal.php');
    $mensaje = $mensaje2;
  }
  Desconectar();
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Carga</title>
<link rel="stylesheet" href="css/style.css" type="text/css">
<link href="../SpryAssets/HojasEstilos.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
include ('../head.php');
?>
<div class="content">
  <?php if ($mensaje1) {?>
  <p class='carg_error'><?php echo $mensaje; ?></p>
  <?php }
  if ($mensaje2) {
    echo $mensaje;
  } ?>
</div>
</body>
</html>
