<?php
session_start();
function itemsMenu(){

  $query = "SELECT ID_ITEM, NOMBRE_ITEM FROM C_MENU_INGRESO_GENERAL WHERE ESTADO_ITEM = 1 AND ACCESO_ITEM = 'e'";
  $res = ConsultarTabla($query);
  $filas = NumeroFilas($res);
  if ($filas == 0) {
    return false;
  }else {
    for ($i=0; $i < $filas; $i++) {
      $col_id = mssql_result($res,$i,"ID_ITEM");
      $col_nombre = mssql_result($res,$i,"NOMBRE_ITEM");
      echo '<div class="button">';
        echo '<a href="ingreso.php?v='.base64_encode($col_id).'">'.$col_nombre.'</a>';
      echo '</div>';
    }
  }
}
function itemsMenuInterno(){
  $query = "SELECT ID_ITEM, NOMBRE_ITEM, LINK_ITEM, VENTANA_ITEM FROM C_MENU_INGRESO_GENERAL WHERE ESTADO_ITEM = 1 AND ACCESO_ITEM = 'i'";
  $res = ConsultarTabla($query);
  $filas = NumeroFilas($res);
  if ($filas == 0) {
    return false;
  }else {
    for ($i=0; $i < $filas; $i++) {
      $col_id = mssql_result($res,$i,"ID_ITEM");
      $col_nombre = mssql_result($res,$i,"NOMBRE_ITEM");
      $col_link = mssql_result($res,$i,"LINK_ITEM");
      $col_ventana = mssql_result($res,$i,"VENTANA_ITEM");
      echo '<li>';
      if ($col_ventana == '_self') {
        echo '<a href="ingreso.php?v='.base64_encode($col_id).'">'.$col_nombre.'</a>';
      }elseif ($col_ventana == '_blank') {
          echo '<a href="'.$col_link.'" target="'.$col_ventana.'">'.$col_nombre.'</a>';
      }
      echo '</li>';
    }
  }
}
function infoAcceso($id){
  $query = "SELECT NOMBRE_ITEM, LINK_ITEM FROM C_MENU_INGRESO_GENERAL WHERE ESTADO_ITEM = 1 AND VENTANA_ITEM = '_self' AND ID_ITEM = $id";
  $res = ConsultarTabla($query);
  $filas = NumeroFilas($res);
  if ($filas == 0) {
    return false;
  }else {
    for ($i=0; $i < $filas; $i++) {
      $col_nombre = mssql_result($res,$i,"NOMBRE_ITEM");
      $col_link = mssql_result($res,$i,"LINK_ITEM");
      return array($col_nombre, $col_link);
      
    }
  }
}
function consultaUsuario($u, $p, $b){
  $query = "SELECT * FROM $b WHERE USUARIO_ID = '$u' AND  CLAVE_USUARIO = '$p' AND ESTADO_ID = 1";
  $res = ConsultarTabla($query);
  $filas = NumeroFilas($res);
  if ($filas == 0) {
    return false;
  }else {
    return true;
  }
}
function datosUsuario($u, $b){
  $query = "SELECT * FROM $b WHERE USUARIO_ID = '$u' AND ESTADO_ID = 1";
  $res = ConsultarTabla($query);
  $filas = NumeroFilas($res);
  if ($filas == 0) {
    return false;
  }else {
    for ($i=0; $i < $filas; $i++) {
      $col_id = mssql_result($res,$i,"USUARIO_ID");
      $col_nombre = mssql_result($res,$i,"NOMBRE_USUARIO");
      $col_organizacion = mssql_result($res,$i,"ORGANIZACION_ID");
      return array($col_id,$col_nombre, $col_organizacion);
    }
  }
}
?>
