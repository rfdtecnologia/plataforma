<?php
include ('../../librerias/libs_sql.php');
Conectar();
function llenarEvento(){
  //$query = "SELECT * FROM C_EVENTO WHERE ESTADO_EVENTO_ID = 1 ORDER BY FECHA_INICIO_EVENTO";
  $query = "SELECT * FROM C_EVENTO ORDER BY FECHA_INICIO_EVENTO";
  $res_e = ConsultarTabla($query);
  $rows = NumeroFilas($res_e);
  if ($rows == 0) {
    echo "<option value='-2'>NO HAY EVENTOS ACTIVOS</option>";
  }else {
    for ($i = 0; $i < $rows; ++$i){
      $col_nombre_e = mssql_result($res_e,$i,"DESCRIPCION_2_EVENTO");
      $col_id_e = mssql_result($res_e,$i,"EVENTO_ID");
      echo "<option value='".$col_id_e."'>$col_nombre_e</option>";
    }
  }
}
function consultaUsuario($u, $p){
  $query = "SELECT * FROM C_USUARIO_GENERAL WHERE USUARIO_ID = $u AND  CLAVE_USUARIO = $p";
  $res = ConsultarTabla($query);
  $rows = NumeroFilas($res);
  if ($rows == 0) {
    return false;
  }else {
    return true;
  }
}
function datosUsuario($u){
  $query = "SELECT * FROM C_USUARIO_GENERAL WHERE USUARIO_ID = $u";
  $res = ConsultarTabla($query);
  $rows = NumeroFilas($res);
  if ($rows == 0) {
    return false;
  }else {
    $nombre_u = mssql_result($res,0,"NOMBRE_USUARIO");
    return $nombre_u;
  }
}
function participantesPorEvento(){
  $query = "SELECT E.FECHA_INICIO_EVENTO, E.DESCRIPCION_EVENTO, COUNT(DE.PARTICIPANTE_ID)AS NUM
  FROM C_EVENTO AS E INNER JOIN C_DATOS_EVENTO AS DE
  ON E.EVENTO_ID = DE.EVENTO_ID
  WHERE E.ESTADO_EVENTO_ID = 1 GROUP BY E.FECHA_INICIO_EVENTO, E.DESCRIPCION_EVENTO ORDER BY E.FECHA_INICIO_EVENTO, E.DESCRIPCION_EVENTO";
  $res = ConsultarTabla($query);
  $rows = NumeroFilas($res);
  if ($rows == 0) {
    echo "<tr><td colspan='2'></td></tr>";
  }else {
    for ($i = 0; $i < $rows; ++$i){
      $col_nombre_pxe = mssql_result($res,$i,"DESCRIPCION_EVENTO");
      $col_num_pxe = mssql_result($res,$i,"NUM");
      echo "<tr><td>$col_nombre_pxe</td><td>$col_num_pxe</td></tr>";
    }
  }
}
function listaCapacitadores(){
  $query = "SELECT * FROM C_FACILITADOR";
  $res = ConsultarTabla($query);
  $rows = NumeroFilas($res);
  if ($rows == 0) {
    echo "<p>No existen Facilitadores registrados</p>";
  }else {
    for ($i = 0; $i < $rows; ++$i){
      $col_id_facilitador = mssql_result($res,$i,"FACILITADOR_ID");
      $col_nombre_facilitador = mssql_result($res,$i,"NOMBRE_FACILITADOR");
      $col_correo_facilitador = mssql_result($res,$i,"CORREO_FACILITADOR");
      $col_telefono_facilitador = mssql_result($res,$i,"TELEFONO_FACILITADOR");
      echo "<li><a class='fac_name' data-toggle='modal' data-target='#modal_$col_id_facilitador'>$col_nombre_facilitador</a></li>";
      echo "<div class='modal fade' id='modal_".$col_id_facilitador."' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>";
      echo "<div class='modal-dialog' role='document'>";
      echo "<div class='modal-content'>";
      echo "<div class='modal-header'>";
      echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>";
      echo "</div>";
      echo "<div class='modal-body'>";
      echo "<p>Nombre: $col_nombre_facilitador</p>";
      echo "<p>Correo: $col_correo_facilitador</p>";
      echo "<p>Teléfono: $col_telefono_facilitador</p>";
      echo "</div>";
      echo "</div>";
      echo "</div>";
      echo "</div>";
    }
  }
}
Desconectar();
?>
