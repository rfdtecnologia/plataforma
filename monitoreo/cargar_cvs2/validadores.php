<?php
session_start();

function completa_query($agen){

  if (is_numeric($agen)) {
    $new_query = ($agen > -1) ? " and AGENCIA_ID = $agen" : "";
  }
  else {
    die('Algo salió mal, por favor vuelva a intentarlo');
  }
  return $new_query;
}
function tabla($agen){

  if (is_numeric($agen)) {
    $tabla = ($agen > -1) ? " C_CUC_CARGA_AGENCIAS" : " C_CUC_CARGA";
  }
  else {
    die('Algo salió mal, por favor vuelva a intentarlo');
  }
  return $tabla;
}

function numero_simple($numero, $agencia){
  $var_organizacion = $_SESSION["var_organizacion"];
  $var_periodo = $_SESSION["var_periodo"];
  $query ="SELECT * from".tabla($agencia)." where ORGANIZACION_ID = $var_organizacion and PERIODO_ID = $var_periodo and CC in ($numero)".completa_query($agencia);
  $res_val = ConsultarTabla($query);
  $row_val = NumeroFilas($res_val);
  for ($i=0; $i < $row_val; ++$i) {
    $var_val = mssql_result($res_val,$i,"SALDO_NUMERICO");
  }
  return $var_val;
}

function suma($numero, $agencia){
  $var_organizacion = $_SESSION["var_organizacion"];
  $var_periodo = $_SESSION["var_periodo"];
  $query ="SELECT sum(SALDO_NUMERICO) saldo from".tabla($agencia)." where ORGANIZACION_ID = $var_organizacion and PERIODO_ID = $var_periodo and CC in ($numero)".completa_query($agencia);
  $res_val = ConsultarTabla($query);
  $row_val = NumeroFilas($res_val);
  for ($i=0; $i < $row_val; ++$i) {
    $var_val = mssql_result($res_val,$i,"saldo");
  }
  return $var_val;
}

function positivo($numero, $agencia){
  $var_organizacion = $_SESSION["var_organizacion"];
  $var_periodo = $_SESSION["var_periodo"];
  $query ="SELECT * from".tabla($agencia)." where ORGANIZACION_ID = $var_organizacion and PERIODO_ID = $var_periodo and CC in ($numero) and SALDO_NUMERICO < 0".completa_query($agencia);
  $res_val = ConsultarTabla($query);
  $row_val = NumeroFilas($res_val);
  return $row_val;
}
function negativo($numero, $agencia){
  $var_organizacion = $_SESSION["var_organizacion"];
  $var_periodo = $_SESSION["var_periodo"];
  $query ="SELECT * from".tabla($agencia)." where ORGANIZACION_ID = $var_organizacion and PERIODO_ID = $var_periodo and CC in ($numero) and SALDO_NUMERICO > 0".completa_query($agencia);
  $res_val = ConsultarTabla($query);
  $row_val = NumeroFilas($res_val);
  return $row_val;
}

function resta($num_a, $num_b){
  return $num_a - $num_b;
}

function valida_suma_resta($num_a, $num_b, $num_c, $agencia){
  $num_dif = suma($num_b, $agencia) - numero_simple($num_c, $agencia);
  if (numero_simple(round($num_a,2), $agencia) == round($num_dif,2)) {
    return true;
  }
  return false;
}

function valida_positivos($num_a, $agencia){
  if (positivo($num_a, $agencia) > 0) {
    return false;
  }
  return true;
}
function valida_negativo($num_a, $agencia){
  if (negativo($num_a, $agencia) > 0) {
    return false;
  }
  return true;
}

function valida_suma($num_a, $num_b, $agencia){
  if (numero_simple($num_a,2, $agencia) == suma($num_b,2, $agencia)) {
    return true;
  }
  return false;
}

function valida_diferentes_y_cero($num_a, $num_b, $agencia){
  if (numero_simple($num_a, $agencia) == 0 && numero_simple($num_b, $agencia) == 0){
    return false;
  }
  else{
	if (numero_simple($num_a, $agencia) == numero_simple($num_b, $agencia)){
		return true;
	}
	else{
		return false;
	}
  }
}

function valida_diferentes($num_a, $num_b, $agencia){
  if (numero_simple($num_a, $agencia) == numero_simple($num_b, $agencia)) {
    return true;
  }
  return false;
}

?>
