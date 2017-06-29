<?php
require ('include.php');
Conectar();
if ($_POST) {
  $query_cargo = "SELECT * FROM C_TIPO_CERTIFICADO";
  $res_cargo = ConsultarTabla($query_cargo);
  $rows_cargo = NumeroFilas($res_cargo);
  if ($rows_cargo != 0) {
    for ($i=0; $i < $rows_cargo; ++$i) {
      $col_nombre_c = mb_convert_encoding(mssql_result($res_cargo,$i,"DESCRIPCION_TIPO_CERTIFICADO"),"UTF-8", "ISO-8859-1");
      $col_id_c = mssql_result($res_cargo,$i,"TIPO_CERTIFICADO_ID");
      echo "<option value='".$col_id_c."'>$col_nombre_c</option>";
    }
  }
}
?>
