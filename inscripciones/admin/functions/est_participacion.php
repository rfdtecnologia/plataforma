<?php
require ('include.php');
Conectar();
if ($_POST) {
  $query = "SELECT ESTADO_PARTICIPACION_ID, DESCRIPCION_ESTADO_PARTICIPACION as 'desc_est_part' FROM C_ESTADO_PARTICIPACION";
  $res = ConsultarTabla($query);
  $rows = NumeroFilas($res);
  if ($rows != 0) {
    for ($i=0; $i < $rows; ++$i) {
      $col_nombre_c = mb_convert_encoding(mssql_result($res,$i,"desc_est_part"),"UTF-8", "ISO-8859-1");
      $col_id_c = mssql_result($res,$i,"ESTADO_PARTICIPACION_ID");
      echo "<option value='".$col_id_c."'>$col_nombre_c</option>";
    }
  }
}
?>
