<?php
function consultaUsuario($u, $p)
{
    $query = 'SELECT * FROM C_USUARIO_GENERAL WHERE USUARIO_ID = "' . $u . '" AND  CLAVE_USUARIO = "' . $p . '" AND ESTADO_ID = 1';
    $res = ConsultarTabla($query);
    $filas = NumeroFilas($res);
    if ($filas == 0) {
        return false;
    } else {
        return true;
    }
}

function datosUsuario($u)
{
    $query = 'SELECT * FROM C_USUARIO_GENERAL WHERE USUARIO_ID = "' . $u . '" AND ESTADO_ID = 1';
    $res = ConsultarTabla($query);
    $filas = NumeroFilas($res);
    if ($filas == 0) {
        return false;
    } else {
        for ($i = 0; $i < $filas; $i++) {
            $col_id = mssql_result($res, $i, "USUARIO_ID");
            $col_nombre = mssql_result($res, $i, "NOMBRE_USUARIO");
            $col_organizacion = mssql_result($res, $i, "ORGANIZACION_ID");
            return array($col_id, $col_nombre, $col_organizacion);
        }
    }
}

function listaEncuesta($organizacion)
{
    /*$query = "SELECT * FROM C_ENCUESTA WHERE ESTADO_ENCUESTA = 1";*/
    $query = "SELECT * FROM C_ENCUESTA E INNER JOIN
            C_ENCUESTA_ORGANIZACION EO ON EO.ENCUESTA_ID = E.ENCUESTA_ID
            WHERE ESTADO_ENCUESTA = 1 AND EO.ORGANIZACION_ID = $organizacion";
    $res = ConsultarTabla($query);
    $filas = NumeroFilas($res);
    if ($filas == 0) {
        echo "<li><a href='#'>No hay encuestas habilitadas</a></li>";
    } else {
        for ($i = 0; $i < $filas; $i++) {
            $col_nombre = mssql_result($res, $i, "NOMBRE_ENCUESTA");
            $col_valor = mssql_result($res, $i, "ENCUESTA_ID");
            echo '<li><a href="' . urlString($col_nombre) . '.php?enc=' . base64_encode($col_valor) . '">' . $col_nombre . '</a></li>';
        }
    }
}

function nombreEncuesta($id)
{
    $query = "SELECT DESCRIPCION_ENCUESTA FROM C_ENCUESTA WHERE ENCUESTA_ID = $id";
    $res = ConsultarTabla($query);
    $filas = NumeroFilas($res);
    if ($filas == 0) {
        echo "No hay datos";
    } else {
        for ($i = 0; $i < $filas; $i++) {
            $col_nombre = mssql_result($res, $i, "DESCRIPCION_ENCUESTA");
            echo $col_nombre;
        }
    }
}

function encuestasLlenas($id)
{
    $query_f_i_m = "SELECT FECHA_INICIO_MUESTRA FROM C_MUESTRA_ENCUESTA WHERE ORGANIZACION_ID = $id AND ESTADO_MUESTRA = 1";
    $query_f_f_m = "SELECT FECHA_FIN_MUESTRA FROM C_MUESTRA_ENCUESTA WHERE ORGANIZACION_ID = $id AND ESTADO_MUESTRA = 1";
    $query = "SELECT count(distinct CODIGO_ENCUESTA) AS TOTAL
  FROM C_RESULTADO_ENCUESTA WHERE
  ORGANIZACION_ID = $id AND
  convert(varchar(10), FECHA, 111) between ($query_f_i_m) and ($query_f_f_m)";
    //echo $query;
    $res = ConsultarTabla($query);
    $filas = NumeroFilas($res);
    if ($filas == 0) {
        echo "No hay datos 1";
    } else {
        for ($i = 0; $i < $filas; $i++) {
            $col_total = mssql_result($res, $i, "TOTAL");
            echo $col_total;
        }
    }
}

function totalMuestras($id, $aux)
{//$aux: devuelve completo o solo las fechas
    $query = "SELECT CONVERT(varchar(10), FECHA_INICIO_MUESTRA, 111) FECHA_I, CONVERT(varchar(10), FECHA_FIN_MUESTRA, 111) FECHA_F, MUESTRA
  FROM C_MUESTRA_ENCUESTA WHERE ORGANIZACION_ID = $id AND ESTADO_MUESTRA = 1";
    $res = ConsultarTabla($query);
    $filas = NumeroFilas($res);
    
    if ($filas == 0) {
        echo "No hay datos";
    } else {
        for ($i = 0; $i < $filas; $i++) {
            $col_muestra = mssql_result($res, $i, "MUESTRA");
            $query_f_i_m = mssql_result($res, $i, "FECHA_I");
            $query_f_f_m = mssql_result($res, $i, "FECHA_F");
            if ($aux == 0) {
                echo "$col_muestra encuestas para el período <b>$query_f_i_m - $query_f_f_m.</b>";
            } elseif ($aux == 1) {
                $regresa = array($query_f_i_m, $query_f_f_m);
                return $regresa;
            }
        }
    }
}

function numEncuestaPorEncuesta($organizacion)
{
    /*$query = "SELECT * FROM C_ENCUESTA e, C_MUESTRA_ENCUESTA m
              WHERE m.ORGANIZACION_ID = $id
              and m.ESTADO_MUESTRA = 1
              and e.ESTADO_ENCUESTA = 1";*/

    $query = "SELECT e.NOMBRE_ENCUESTA, e.ENCUESTA_ID, e.PORCENTAJE_ENCUESTA, m.MUESTRA, CONVERT(varchar(10), m.FECHA_INICIO_MUESTRA, 111) as FECHA_INICIO_MUESTRA , CONVERT(varchar(10), m.FECHA_FIN_MUESTRA, 111) as FECHA_FIN_MUESTRA
            FROM C_ENCUESTA e, C_MUESTRA_ENCUESTA m, C_ENCUESTA_ORGANIZACION eo
            WHERE m.ORGANIZACION_ID = $organizacion
            and m.ESTADO_MUESTRA = 1
            and e.ESTADO_ENCUESTA = 1
            and eo.ENCUESTA_ID = e.ENCUESTA_ID
            and m.ORGANIZACION_ID = eo.ORGANIZACION_ID";

    $res = ConsultarTabla($query);
    $filas = NumeroFilas($res);
    if ($filas == 0) {
        echo "<li>No hay datos</li>";
    } else {
        for ($i = 0; $i < $filas; $i++) {
            $col_nombre = mssql_result($res, $i, "NOMBRE_ENCUESTA");
            $col_valor = mssql_result($res, $i, "ENCUESTA_ID");
            $col_porcentaje = mssql_result($res, $i, "PORCENTAJE_ENCUESTA");
            $col_muestra = mssql_result($res, $i, "MUESTRA");
            $query_f_i_m = mssql_result($res, $i, "FECHA_INICIO_MUESTRA");
            $query_f_f_m = mssql_result($res, $i, "FECHA_FIN_MUESTRA");
            $query_enc_llenas = "SELECT COUNT(distinct CODIGO_ENCUESTA) TOTAL
                          FROM C_RESULTADO_ENCUESTA
                          WHERE ENCUESTA_ID = $col_valor AND
                          ORGANIZACION_ID = $organizacion AND
                          CONVERT(varchar(10), FECHA, 111) between '$query_f_i_m' and '$query_f_f_m'";
            $res_enc_llenas = ConsultarTabla($query_enc_llenas);
            $filas_enc_llenas = NumeroFilas($res_enc_llenas);
            if ($filas_enc_llenas == 0) {
                echo "<li>No hay datos</li>";
            } else {
                for ($j = 0; $j < $filas_enc_llenas; $j++) {
                    $col_total = mssql_result($res_enc_llenas, $j, "TOTAL");
                    $enc_minima = multiplica($col_porcentaje, $col_muestra);
                    echo '<div class="col-xs-6 col-sm-4"><div class="panel panel-default">';
                    echo '<div class="panel-heading"><a href="' . urlString($col_nombre) . '.php?enc=' . base64_encode($col_valor) . '">' . $col_nombre . '</a></div>';
                    echo '<div class="panel-body">';
                    echo '<span class="inf_import red">' . $col_total . ' </span> de ' . $enc_minima . ', encuestas mínimas';
                    echo '</div></div></div>';
                }
            }
        }
    }
}

function multiplica($a, $b)
{
    return $a * $b;
}

function listaGenero()
{
    $query = "SELECT * FROM C_GENERO";
    $res = ConsultarTabla($query);
    $filas = NumeroFilas($res);
    if ($filas == 0) {
        echo "<option value='-1'>No hay datos</option>";
    } else {
        for ($i = 0; $i < $filas; $i++) {
            $col_nombre = mssql_result($res, $i, "NOMBRE_GENERO");
            $col_valor = mssql_result($res, $i, "GENERO_ID");
            echo '<option value="' . $col_valor . '">' . $col_nombre . '</option>';
        }
    }
}

function listaEstadoCivil()
{
    $query = "SELECT * FROM C_ESTADO_CIVIL";
    $res = ConsultarTabla($query);
    $filas = NumeroFilas($res);
    if ($filas == 0) {
        echo "<option value='-1'>No hay datos</option>";
    } else {
        for ($i = 0; $i < $filas; $i++) {
            $col_nombre = mssql_result($res, $i, "NOMBRE_ESTADO_CIVIL");
            $col_valor = mssql_result($res, $i, "ESTADO_CIVIL_ID");
            echo '<option value="' . $col_valor . '">' . $col_nombre . '</option>';
        }
    }
}

function listaAreaVivienda()
{
    $query = "SELECT * FROM C_AREA_VIVIENDA";
    $res = ConsultarTabla($query);
    $filas = NumeroFilas($res);
    if ($filas == 0) {
        echo "<option value='-1'>No hay datos</option>";
    } else {
        for ($i = 0; $i < $filas; $i++) {
            $col_nombre = mssql_result($res, $i, "NOMBRE_AREA_VIVIENDA");
            $col_valor = mssql_result($res, $i, "AREA_VIVIENDA_ID");
            echo '<option value="' . $col_valor . '">' . $col_nombre . '</option>';
        }
    }
}

function listaActividadEconomica()
{
    $query = "SELECT * FROM C_ACTIVIDAD_ECONOMICA ORDER BY NOMBRE_ACTIVIDAD_ECONOMICA";
    $res = ConsultarTabla($query);
    $filas = NumeroFilas($res);
    if ($filas == 0) {
        echo "<option value='-1'>No hay datos</option>";
    } else {
        for ($i = 0; $i < $filas; $i++) {
            $col_nombre = mssql_result($res, $i, "NOMBRE_ACTIVIDAD_ECONOMICA");
            $col_valor = mssql_result($res, $i, "ACTIVIDAD_ECONOMICA_ID");
            echo '<option value="' . $col_valor . '">' . $col_nombre . '</option>';
        }
    }
}

function listaInstruccion()
{
    $query = "SELECT * FROM C_INSTRUCCION";
    $res = ConsultarTabla($query);
    $filas = NumeroFilas($res);
    if ($filas == 0) {
        echo "<option value='-1'>No hay datos</option>";
    } else {
        for ($i = 0; $i < $filas; $i++) {
            $col_nombre = mssql_result($res, $i, "NOMBRE_INSTRUCCION");
            $col_valor = mssql_result($res, $i, "INSTRUCCION_ID");
            echo '<option value="' . $col_valor . '">' . $col_nombre . '</option>';
        }
    }
}

function listaAgencias($organizacion)
{
    $query = "SELECT * FROM C_AGENCIAS WHERE ORGANIZACION_ID = $organizacion AND ESTADO_ID = 1";
    $res = ConsultarTabla($query);
    $filas = NumeroFilas($res);
    if ($filas == 0) {
        echo "<option value='-1'>No hay datos</option>";
    } else {
        for ($i = 0; $i < $filas; $i++) {
            $col_nombre = mssql_result($res, $i, "NOMBRE_AGENCIA");
            $col_valor = mssql_result($res, $i, "AGENCIA_ID");
            echo '<option value="' . $col_valor . '">' . $col_nombre . '</option>';
        }
    }
}

function intermediacionId($organizacion)
{
    $query = "SELECT * FROM C_ORGANIZACION WHERE ORGANIZACION_ID = $organizacion";
    $res = ConsultarTabla($query);
    $filas = NumeroFilas($res);
    if ($filas == 0) {
        echo "<option value='-1'>No hay datos</option>";
    } else {
        for ($i = 0; $i < $filas; $i++) {
            $col_intermediacion = mssql_result($res, $i, "INTERMEDIACION_ID");
            return $col_intermediacion;
        }
    }
}

function numGruposPreguntas($encuesta_id, $intermediacion_id)
{
//  $query = '';
    if ($intermediacion_id == 'S') {
        $query = "SELECT * FROM C_GRUPO_PREGUNTA_ENCUESTA WHERE ENCUESTA_ID = $encuesta_id";
    } elseif ($intermediacion_id == 'N') {
        $query = "SELECT * FROM C_GRUPO_PREGUNTA_ENCUESTA WHERE ENCUESTA_ID = $encuesta_id and MUESTRA_GRUPO_PREGUNTA_ONG = 'S'";
    }
    $res = ConsultarTabla($query);
    $filas = NumeroFilas($res);
    return $filas;
}

function nombreGruposPreguntas($numFila, $encuesta_id, $intermediacion_id)
{
    if ($intermediacion_id == 'S') {
        $query = "SELECT * FROM C_GRUPO_PREGUNTA_ENCUESTA WHERE ENCUESTA_ID = $encuesta_id";
    } elseif ($intermediacion_id == 'N') {
        $query = "SELECT * FROM C_GRUPO_PREGUNTA_ENCUESTA WHERE ENCUESTA_ID = $encuesta_id and MUESTRA_GRUPO_PREGUNTA_ONG = 'S'";
    }
    $res = ConsultarTabla($query);
    $campo = array();
    if ($numFila == -1) {
        //echo "<option value='-1'>No hay datos</option>";
        $campo[0] = 'No hay datos';
    } else {
        $col_nombre = mssql_result($res, $numFila, "NOMBE_GRUPO_PREGUNTA");
        $col_valor = mssql_result($res, $numFila, "GRUPO_PREGUNTA_ID");
        $campo[$col_valor] = $col_nombre;
        //echo '<h3 class="panel-title" id="title_'.$col_valor.'">'.$col_nombre.'</h3>';
        return $campo;
    }
}

function numPreguntasPorGrupo($grupo_pregunta_id)
{
    $query = "SELECT * FROM C_PREGUNTA_ENCUESTA WHERE 
  GRUPO_PREGUNTA_ID = $grupo_pregunta_id 
  AND ESTADO_PREGUNTA = 1" ;

    $res = ConsultarTabla($query);
    $filas = NumeroFilas($res);
    return $filas;
}

function nombrePreguntas($numFila, $grupo_pregunta_id)
{
    $query = "SELECT * FROM C_PREGUNTA_ENCUESTA WHERE 
  GRUPO_PREGUNTA_ID = $grupo_pregunta_id AND 
  ESTADO_PREGUNTA = 1 ORDER BY 
  ORDEN_PREGUNTA";

    $res = ConsultarTabla($query);
    $campo = array();
    if ($numFila == -1) {
        //echo "<option value='-1'>No hay datos</option>";
        $campo[0] = 'No hay datos';
    } else {
        $col_nombre = mssql_result($res, $numFila, "NOMBRE_PREGUNTA");
        $col_valor = mssql_result($res, $numFila, "PREGUNTA_ID");
        $campo[$col_valor] = $col_nombre;
        //echo '<h3 class="panel-title" id="title_'.$col_valor.'">'.$col_nombre.'</h3>';
        return $campo;
    }
}

function preguntaRespuesta($pregunta_id)
{
    $query = "SELECT * FROM
            C_PREGUNTA_RESPUESTA_ENCUESTA AS PR INNER JOIN
            C_RESPUESTA_ENCUESTA AS R ON
            PR.RESPUESTA_ID = R.RESPUESTA_ID WHERE
            PR.PREGUNTA_ID = $pregunta_id";
    $res = ConsultarTabla($query);
    $filas = NumeroFilas($res);
    if ($filas == 0) {
        echo "<span>No hay datos</span>";
    } else {
        for ($i = 0; $i < $filas; $i++) {
            $col_nombre = mssql_result($res, $i, "NOMBRE_RESPUESTA");
            $col_valor = mssql_result($res, $i, "RESPUESTA_ID");
            $col_gsi = mssql_result($res, $i, "GRUPO_SUBRESPUESTA_ID");
            $col_subresp = mssql_result($res, $i, "INGRESA_SUBRESPUESTA");

            echo '<label class="radio-inline">';
            echo '<input class="input_radio" type="radio" name="resp[' . $pregunta_id . ']" id="option_' . $i . '" value="' . $col_valor . '_' . $col_subresp . '">' . cambiaEncodeString($col_nombre);
            //echo '<input class="no_read" type="hidden" value="'.$col_gsi.'" name="'.$col_valor.'['.$pregunta_id.']">';
            echo '</label>';
        }
    }
}

function preguntaRespuestaSubrespuesta($pregunta_id, $respuesta_id)
{
    include('include.php');
    $query = "SELECT * FROM
            C_PREGUNTA_RESPUESTA_ENCUESTA AS PR INNER JOIN
            C_SUBRESPUESTA_ENCUESTA AS SR ON
            PR.GRUPO_SUBRESPUESTA_ID = SR.GRUPO_SUBRESPUESTA_ID WHERE
            PR.PREGUNTA_ID = $pregunta_id AND
            PR.RESPUESTA_ID = $respuesta_id";
    $res = ConsultarTabla($query);
    $filas = NumeroFilas($res);
    if ($filas == 0) {
        echo "";
    } else {
        for ($i = 0; $i < $filas; $i++) {
            $col_nombre = mssql_result($res, $i, "NOMBRE_SUBRESPUESTA");
            $col_valor = mssql_result($res, $i, "SUBRESPUESTA_ID");
            $col_subresp = mssql_result($res, $i, "INGRESA_SUBRESPUESTA");
            $col_texto = mssql_result($res, $i, "INGRESA_TEXTO");
            if ($col_subresp == 'S') {
                echo '<div class="radio">';
                echo '<label>';
                echo '<input type="radio" name="' . $pregunta_id . '[' . $respuesta_id . ']" id="option_' . $i . '" value="' . $col_valor . '">' . cambiaEncodeString($col_nombre);
                echo '</label>';
                echo '</div>';
            } elseif ($col_texto == 'S') {
                echo '<textarea class="form-control" rows="3" name="text_' . $pregunta_id . '[' . $respuesta_id . ']"></textarea>';
            }
        }
    }
}
function muestraGrupo($pregunta_id, $respuesta_id){
    $query = "SELECT PRE.SECUENCIA_PREGUNTA_ID, GPE.SECUENCIA_GRUPO_PREGUNTA_ID FROM
      C_PREGUNTA_ENCUESTA as PE JOIN 
      C_PREGUNTA_RESPUESTA_ENCUESTA AS PRE
      ON PE.PREGUNTA_ID = PRE.PREGUNTA_ID JOIN 
      C_GRUPO_PREGUNTA_ENCUESTA AS GPE
      ON GPE.GRUPO_PREGUNTA_ID = PE.GRUPO_PREGUNTA_ID
      WHERE PE.PREGUNTA_ID = $pregunta_id AND PRE.RESPUESTA_ID = $respuesta_id";

    $res = ConsultarTabla($query);
    $filas = NumeroFilas($res);
    if ($filas == 0) {
        echo "";
    } else {
        for ($i = 0; $i < $filas; $i++) {
            $col_secuencia_grupo_pregunta = mssql_result($res, $i, "SECUENCIA_GRUPO_PREGUNTA_ID");
            $col_secuencia_pregunta = mssql_result($res, $i, "SECUENCIA_PREGUNTA_ID");
            echo 'gid_ynam'.$col_secuencia_grupo_pregunta.'sec_ynam'.$col_secuencia_pregunta;
        }
    }
}
?>