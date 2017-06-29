<?php
require ('include.php');
Conectar();
if ($_POST) {
  $query_c_g = "SELECT * FROM C_GENERO";
  $res_c_g = ConsultarTabla($query_c_g);
  $rows_c_g = NumeroFilas($res_c_g);
  if ($rows_c_g == 0) {
    $mensaje = 'Ups!, algo sali� mal';
  }else {
    for ($i = 0; $i < $rows_c_g; ++$i){
      $col_cod_g = mssql_result($res_c_g,$i,"GENERO_ID");
      $col_desc_g = mb_convert_encoding(mssql_result($res_c_g,$i,"NOMBRE_GENERO"),"UTF-8", "ISO-8859-1");
      echo "<option value='".$col_cod_g."'>$col_desc_g</option>";
    }
  }
}
?>
