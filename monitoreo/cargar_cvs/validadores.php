<?php
session_start();


function numero_simple($numero){
  $var_organizacion = $_SESSION["var_organizacion"];
  $var_periodo = $_SESSION["var_periodo"];
  $query ="SELECT * from C_CUC_CARGA where ORGANIZACION_ID = $var_organizacion and PERIODO_ID = $var_periodo and CC in ($numero)";
  $res_val = ConsultarTabla($query);
  $row_val = NumeroFilas($res_val);
  for ($i=0; $i < $row_val; ++$i) {
    $var_val = mssql_result($res_val,$i,"SALDO_NUMERICO");
  }
  return $var_val;
}

function suma($numero){
  $var_organizacion = $_SESSION["var_organizacion"];
  $var_periodo = $_SESSION["var_periodo"];
  $query ="SELECT sum(SALDO_NUMERICO) saldo from C_CUC_CARGA where ORGANIZACION_ID = $var_organizacion and PERIODO_ID = $var_periodo and CC in ($numero)";
  $res_val = ConsultarTabla($query);
  $row_val = NumeroFilas($res_val);
  for ($i=0; $i < $row_val; ++$i) {
    $var_val = mssql_result($res_val,$i,"saldo");
  }
  return $var_val;
}

function positivo($numero){
  $var_organizacion = $_SESSION["var_organizacion"];
  $var_periodo = $_SESSION["var_periodo"];
  $query ="SELECT * from C_CUC_CARGA where ORGANIZACION_ID = $var_organizacion and PERIODO_ID = $var_periodo and CC in ($numero) and SALDO_NUMERICO < 0";
  $res_val = ConsultarTabla($query);
  $row_val = NumeroFilas($res_val);
  return $row_val;
}

function negativo($numero){
  $var_organizacion = $_SESSION["var_organizacion"];
  $var_periodo = $_SESSION["var_periodo"];
  $query ="SELECT * from C_CUC_CARGA where ORGANIZACION_ID = $var_organizacion and PERIODO_ID = $var_periodo and CC in ($numero) and SALDO_NUMERICO > 0";
  $res_val = ConsultarTabla($query);
  $row_val = NumeroFilas($res_val);
  return $row_val;
}

function resta($num_a, $num_b){
  return $num_a - $num_b;
}

function valida_suma_resta_simple($num_a, $num_b){
  if (suma(round($num_a,2)) == resta($num_b,2)) {
    return true;
  }
  return false;
}

function valida_suma_resta($num_a, $num_b, $num_c){
  $num_dif = suma($num_b) - numero_simple($num_c);
  if (numero_simple(round($num_a,2)) == round($num_dif,2)) {
    return true;
  }
  return false;
}

function valida_positivos($num_a){
  if (positivo($num_a) > 0) {
    return false;
  }
  return true;
}

function valida_negativo($num_a){
  if (negativo($num_a) > 0) {
    return false;
  }
  return true;
}

function valida_suma($num_a, $num_b){
  if (numero_simple($num_a,2)  == suma($num_b,2)) {
    return true;
  }
  return false;
}

function valida_diferentes_y_cero($num_a, $num_b){
  if (numero_simple($num_a) == 0 && numero_simple($num_b) == 0){
    return false;
  }
  else{
  	if (numero_simple($num_a) == numero_simple($num_b)){
  		return true;
  	}
  	else{
  		return false;
  	}
  }
}

function valida_diferentes($num_a, $num_b){
  if (numero_simple($num_a) == numero_simple($num_b)) {
    return true;
  }
  return false;
}

?>
