<?php
$encuesta_id = base64_decode($_GET['enc']);
Conectar();
echo '<h3>';
nombreEncuesta($encuesta_id);
echo '</h3>';
Desconectar();
?>
