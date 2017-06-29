<?php
require ('include.php');
Conectar();
if ($_POST) {
  $query_cargo = "SELECT ENTREGA_CERTIFICADO_ID, DESCRIPCION_ENTREGA_CERTIFICADO as 'desc_ent_cert' FROM C_ENTREGA_CERTIFICADO";
  $res_cargo = ConsultarTabla($query_cargo);
  $rows_cargo = NumeroFilas($res_cargo);
  if ($rows_cargo != 0) {
    for ($i=0; $i < $rows_cargo; ++$i) {
      $col_nombre_c = mb_convert_encoding(mssql_result($res_cargo,$i,"desc_ent_cert"),"UTF-8", "ISO-8859-1");
      $col_id_c = mssql_result($res_cargo,$i,"ENTREGA_CERTIFICADO_ID");
      echo "<option value='".$col_id_c."'>$col_nombre_c</option>";
    }
  }
}
?>
