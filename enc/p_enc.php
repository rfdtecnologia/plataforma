<?php
$encuesta_id = base64_decode($_GET['enc']);
Conectar();
$var_grupo_pregunta = numGruposPreguntas($encuesta_id,intermediacionId($_SESSION['usuario_organizacion']));//variable total grupos de un tipo de pregunta
$var_pregunta_x_grupo = 0;//variable total de preguntas por grupo
for ($i=0; $i < $var_grupo_pregunta; $i++) {
?>
  <div class="panel panel-default content_ques" id="head_<?php echo $encuesta_id ?>">
  <div class="panel-heading">
    <?php
    if ($var_grupo_pregunta == 0) {
      $i = -1;
    }
    foreach (nombreGruposPreguntas($i, $encuesta_id,intermediacionId($_SESSION['usuario_organizacion'])) as $grupo_pregunta_id => $nombre_grupo_pregunta) {
      echo '<h3 class="panel-title">'.$nombre_grupo_pregunta.'</h3>';

    }
    ?>
  </div>
  <div class="panel-body" id="content-<?php echo $i ?>">
  <?php

  for ($j=0; $j < numPreguntasPorGrupo($grupo_pregunta_id); $j++) { ?>
      <div class="form-group type_<?php echo numPreguntasPorGrupo($grupo_pregunta_id); ?>" id="type-<?php echo $j; ?>">
        <?php
        foreach (nombrePreguntas($j, $grupo_pregunta_id) as $pregunta_id => $nombre_pregunta) {
        }
        echo '<label for="n_instruccion" class="col-sm-4 control-label preg" id="preg_'.$pregunta_id.'">'.$nombre_pregunta.'</label>';
        echo '<input type="hidden" class="no_read" name="group_id['.$pregunta_id.']" value="'.$grupo_pregunta_id.'">';
        ?>
        <div class="col-sm-8">
            <?php
                preguntaRespuesta($pregunta_id);
            ?>
            <div class="sub_r"></div>
        </div>
      </div>
  <?php
    } ?>
    </div>
  </div>
<?php
  }
Desconectar();
?>
