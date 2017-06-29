<?php
require ('include.php');
if ($_POST) {
    Conectar();
    $datos = array();
    $evento = $_POST['evento'];
    $query_p = "SELECT O.NOMBRE_ORGANIZACION, P.APELLIDO_PARTICIPANTE, P.NOMBRE_PARTICIPANTE, P.PARTICIPANTE_ID, 
EP.DESCRIPCION_ESTADO_PARTICIPACION AS DESC_EST_PART, TC.DESCRIPCION_TIPO_CERTIFICADO, EC.DESCRIPCION_ENTREGA_CERTIFICADO AS DESC_ENT_CERT
FROM C_ORGANIZACION AS O
  INNER JOIN C_DATOS_EVENTO AS E ON E.ORGANIZACION_ID = O.ORGANIZACION_ID
  INNER JOIN C_PARTICIPANTE AS P ON E.PARTICIPANTE_ID = P.PARTICIPANTE_ID
  INNER JOIN C_ESTADO_PARTICIPACION AS EP ON E.ESTADO_PARTICIPACION_ID = EP.ESTADO_PARTICIPACION_ID
  INNER JOIN C_TIPO_CERTIFICADO AS TC ON E.TIPO_CERTIFICADO_ID = TC.TIPO_CERTIFICADO_ID
  INNER JOIN C_ENTREGA_CERTIFICADO AS EC ON E.ENTREGA_CERTIFICADO_ID = EC.ENTREGA_CERTIFICADO_ID
  WHERE E.EVENTO_ID = $evento";

    $res_p = ConsultarTabla($query_p);
    $row_p = NumeroFilas($res_p);
    if ($row_p != 0) {
        for ($i = 0; $i < $row_p; ++$i) {
            $datos= array(
                "n_organizacion" => mb_convert_encoding(mssql_result($res_p, $i, "NOMBRE_ORGANIZACION"), "UTF-8", "ISO-8859-1"),
                "apellido_p" => mb_convert_encoding(mssql_result($res_p, $i, "APELLIDO_PARTICIPANTE"), "UTF-8", "ISO-8859-1"),
                "nombre_p" => mb_convert_encoding(mssql_result($res_p, $i, "NOMBRE_PARTICIPANTE"), "UTF-8", "ISO-8859-1"),
                "participante_id" => mb_convert_encoding(mssql_result($res_p, $i, "PARTICIPANTE_ID"), "UTF-8", "ISO-8859-1"),
                "est_participacion" => mb_convert_encoding(mssql_result($res_p, $i, "DESC_EST_PART"), "UTF-8", "ISO-8859-1"),
                "tip_certificado" => mb_convert_encoding(mssql_result($res_p, $i, "DESCRIPCION_TIPO_CERTIFICADO"), "UTF-8", "ISO-8859-1"),
                "entr_certificado" => mb_convert_encoding(mssql_result($res_p, $i, "DESC_ENT_CERT"), "UTF-8", "ISO-8859-1")
            );
        }
    }
    echo json_encode($datos);
}
?>
