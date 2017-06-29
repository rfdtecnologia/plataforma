<?php
require ('include.php');
if ($_POST) {
    Conectar();
    $datos = array();
    $evento = $_POST['evento'];
    $query_p = "SELECT O.NOMBRE_ORGANIZACION, P.APELLIDO_PARTICIPANTE, P.NOMBRE_PARTICIPANTE, P.PARTICIPANTE_ID, E.NUMERO_FACTURA, E.VALOR_FACTURA
FROM C_ORGANIZACION AS O
  INNER JOIN C_DATOS_EVENTO AS E ON E.ORGANIZACION_ID = O.ORGANIZACION_ID
  INNER JOIN C_PARTICIPANTE AS P ON E.PARTICIPANTE_ID = P.PARTICIPANTE_ID
  WHERE E.EVENTO_ID = $evento";

    $res_p = ConsultarTabla($query_p);
    $row_p = NumeroFilas($res_p);
    if ($row_p != 0) {
        for ($i = 0; $i < $row_p; ++$i){
            $datos[]=array(	"n_organizacion"=>mb_convert_encoding(mssql_result($res_p,$i,"NOMBRE_ORGANIZACION"),"UTF-8", "ISO-8859-1"),
                "apellido_p"=>mb_convert_encoding(mssql_result($res_p,$i,"APELLIDO_PARTICIPANTE"),"UTF-8", "ISO-8859-1"),
                "nombre_p"=>mb_convert_encoding(mssql_result($res_p,$i,"NOMBRE_PARTICIPANTE"),"UTF-8", "ISO-8859-1"),
                "participante_id"=>mb_convert_encoding(mssql_result($res_p,$i,"PARTICIPANTE_ID"),"UTF-8", "ISO-8859-1"),
                "num_factura"=>mb_convert_encoding(mssql_result($res_p,$i,"NUMERO_FACTURA"),"UTF-8", "ISO-8859-1"),
                "val_factura"=>mb_convert_encoding(mssql_result($res_p,$i,"VALOR_FACTURA"),"UTF-8", "ISO-8859-1"));
        }
    }
    echo json_encode($datos);
}
?>
