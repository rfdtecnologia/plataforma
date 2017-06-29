<?php
include('../librerias/libs_sql.php');
include('functions/consultas.php');
if ($_POST) {
  Conectar();
  $respuesta_id = $_POST['res_id'];
  $pregunta_id= $_POST['preg_id'];
  if (!empty($respuesta_id) && !empty($pregunta_id)) {

      preguntaRespuestaSubrespuesta($pregunta_id, $respuesta_id);
      muestraGrupo($pregunta_id, $respuesta_id);
  }
  Desconectar();
}

?>
