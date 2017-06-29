<?php
if ($_POST) {
  Conectar();
  $organizacion_id = $_SESSION['usuario_organizacion'];
  $usuario_id = $_SESSION['usuario_id'];
  $genero = $_POST['genero'];
  $est_civil = $_POST['est_civil'];
  $area_vivienda = $_POST['a_vivienda'];
  $act_economica = $_POST['a_economica'];
  $n_instruccion = $_POST['n_instruccion'];
  $agencia_id = $_POST['agencia'];
  $pregunta_id = $_POST['preg_id'];
  $encuesta_id = base64_decode($_GET['enc']);
  $var_fecha = Fecha();
  $cod_enc = '';
  if ($encuesta_id == 6) {
    $cod_enc = get_client_ip();
  } else {
    $cod_enc = intFecha();
  }

  foreach ($_POST['group_id'] as $key => $gr_pr_id) {
    foreach ($_POST['resp'] as $pr => $resp) {
      if ($key == $pr) {
        $ingresa_sub_respuesta = explode('_', $resp);
        $respuesta_id = $ingresa_sub_respuesta[0];
        if ($ingresa_sub_respuesta[1] == 'N') {
          if (isset($_POST['text_'.$pr])) {
            foreach ($_POST['text_'.$pr] as $respuesta_id => $texto) {
              $text_mayus = mb_strtoupper($texto);
              $query1 = "INSERT INTO C_RESULTADO_ENCUESTA VALUES('$cod_enc','$organizacion_id','$usuario_id', '$genero','$est_civil','$area_vivienda','$act_economica','$n_instruccion','$agencia_id','$encuesta_id','$gr_pr_id','$pr','$respuesta_id',1,1,'$text_mayus', '$var_fecha')";
              ConsultarTabla($query1);
            }
          }else {
            $query2 = "INSERT INTO C_RESULTADO_ENCUESTA VALUES('$cod_enc','$organizacion_id','$usuario_id', '$genero','$est_civil','$area_vivienda','$act_economica','$n_instruccion','$agencia_id','$encuesta_id','$gr_pr_id','$pr','$respuesta_id',1,1,'', '$var_fecha')";
            ConsultarTabla($query2);
          }
        }else {
          if (isset($_POST[$pr])) {
            foreach ($_POST[$pr] as $sub_pr=> $sub_resp) {
              $query3 = "INSERT INTO C_RESULTADO_ENCUESTA VALUES('$cod_enc','$organizacion_id','$usuario_id', '$genero','$est_civil','$area_vivienda','$act_economica','$n_instruccion','$agencia_id','$encuesta_id','$gr_pr_id','$pr','$respuesta_id','$sub_resp',1,'', '$var_fecha')";
              ConsultarTabla($query3);
            }
          }
        }
      }
    }
  }
  $mensaje = 'Datos enviados con éxito';
  Desconectar();
}
?>
