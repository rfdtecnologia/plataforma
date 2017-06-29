<?php
require ('include.php');
if ($_POST) {
  Conectar();
  $datos = array();
  $evento = $_POST['evento'];
  $query_p = "SELECT O.NOMBRE_ORGANIZACION, P.APELLIDO_PARTICIPANTE, P.NOMBRE_PARTICIPANTE, P.PARTICIPANTE_ID, C.DESCRIPCION_CARGO, G.NOMBRE_GENERO, P.CORREO_PARTICIPANTE, P.CELULAR_PARTICIPANTE, E.FECHA_REGISTRO
  FROM C_ORGANIZACION AS O
  INNER JOIN C_DATOS_EVENTO AS E ON E.ORGANIZACION_ID = O.ORGANIZACION_ID
  INNER JOIN C_PARTICIPANTE AS P ON E.PARTICIPANTE_ID = P.PARTICIPANTE_ID
  INNER JOIN C_GENERO AS G ON E.GENERO_ID = G.GENERO_ID
  INNER JOIN C_CARGO AS C ON E.CARGO_ID = C.CARGO_ID
  WHERE E.EVENTO_ID = $evento";
  $res_p = ConsultarTabla($query_p);
  $row_p = NumeroFilas($res_p);
  if ($row_p != 0) {
    for ($i = 0; $i < $row_p; ++$i){
      $datos[]=array(	"n_organizacion"=>mb_convert_encoding(mssql_result($res_p,$i,"NOMBRE_ORGANIZACION"),"UTF-8", "ISO-8859-1"),
      "apellido_p"=>mb_convert_encoding(mssql_result($res_p,$i,"APELLIDO_PARTICIPANTE"),"UTF-8", "ISO-8859-1"),
      "nombre_p"=>mb_convert_encoding(mssql_result($res_p,$i,"NOMBRE_PARTICIPANTE"),"UTF-8", "ISO-8859-1"),
      "participante_id"=>mb_convert_encoding(mssql_result($res_p,$i,"PARTICIPANTE_ID"),"UTF-8", "ISO-8859-1"),
      "desc_cargo"=>mb_convert_encoding(mssql_result($res_p,$i,"DESCRIPCION_CARGO"), "UTF-8", "ISO-8859-1"),
      "genero_p"=>mb_convert_encoding(mssql_result($res_p,$i,"NOMBRE_GENERO"), "UTF-8", "ISO-8859-1"),
      "correo_p"=>mb_convert_encoding(mssql_result($res_p,$i,"CORREO_PARTICIPANTE"),"UTF-8", "ISO-8859-1"),
      "celular_p"=>mb_convert_encoding(mssql_result($res_p,$i,"CELULAR_PARTICIPANTE"),"UTF-8", "ISO-8859-1"),
      "fecha_r"=>mb_convert_encoding(mssql_result($res_p,$i,"FECHA_REGISTRO"),"UTF-8", "ISO-8859-1"));
    }
  }
  echo json_encode($datos);
}
?>
