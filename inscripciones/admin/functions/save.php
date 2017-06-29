<?php
require ('include.php');
Conectar();
if ($_POST) {
    $campo_editar = $_POST['campo'];
    $id_participante = $_POST['id'];
    $id_evento = $_POST['evento'];
    $nuevo_valor = $_POST['valor'];
    $hoy = FECHA();
    switch ($campo_editar) {
        case 'apellido_p':
            $campo = 'APELLIDO_PARTICIPANTE';
            break;
        case 'nombre_p':
            $campo = 'NOMBRE_PARTICIPANTE';
            break;
        case 'cargo':
            $campo = 'CARGO_ID';
            break;
        case 'correo_p':
            $campo = 'CORREO_PARTICIPANTE';
            break;
        case 'celular_p':
            $campo = 'CELULAR_PARTICIPANTE';
            break;
        case 'genero':
            $campo = 'GENERO_ID';
            break;
        case 'est_participacion':
            $campo = 'ESTADO_PARTICIPACION_ID';
            break;
        case 'tip_certificado':
            $campo = 'TIPO_CERTIFICADO_ID';
            break;
        case 'entr_certificado':
            $campo = 'ENTREGA_CERTIFICADO_ID';
            break;
        case 'val_factura':
            $campo = 'VALOR_FACTURA';
            break;
        case 'num_factura':
            $campo = 'NUMERO_FACTURA';
            break;
    }
    $query_consulta_participante = "SELECT * FROM C_DATOS_EVENTO WHERE PARTICIPANTE_ID = '$id_participante' AND EVENTO_ID = $id_evento";
    $res_consulta_participante = ConsultarTabla($query_consulta_participante);
    $rows_consulta_participante = NumeroFilas($res_consulta_participante);
    $datos_evento = '';
    $datos_participante = '';
    if ($rows_consulta_participante > 0) {
        switch ($campo) {
            case 'CARGO_ID':
            case 'GENERO_ID':
                $datos_participante = "UPDATE C_PARTICIPANTE SET $campo = '$nuevo_valor', FECHA_ACTUALIZACION = '$hoy' WHERE PARTICIPANTE_ID = '$id_participante'";
                $datos_evento = "UPDATE C_DATOS_EVENTO SET $campo = '$nuevo_valor', FECHA_ACTUALIZACION = '$hoy' WHERE PARTICIPANTE_ID = '$id_participante' AND EVENTO_ID = $id_evento";
                break;

            case 'ESTADO_PARTICIPACION_ID':
            case 'TIPO_CERTIFICADO_ID':
            case 'ENTREGA_CERTIFICADO_ID':
            case 'VALOR_FACTURA':
            case 'NUMERO_FACTURA':
                $datos_evento = "UPDATE C_DATOS_EVENTO SET $campo = '$nuevo_valor', FECHA_ACTUALIZACION = '$hoy' WHERE PARTICIPANTE_ID = '$id_participante' AND EVENTO_ID = $id_evento";
                break;

            default:
                $datos_participante = "UPDATE C_PARTICIPANTE SET $campo = '$nuevo_valor', FECHA_ACTUALIZACION = '$hoy' WHERE PARTICIPANTE_ID = '$id_participante'";
                break;
        }
        if ($datos_evento !== '') {
            Actualizar($datos_evento);
        }
        Actualizar($datos_participante);
        echo "<span class='ok'>Valores modificados correctamente.</span>";
    }else {
        echo "<span class='ko'>Algo salió mal.</span>";
    }
}
?>