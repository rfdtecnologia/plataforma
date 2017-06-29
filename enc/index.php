<?php
include('functions/include.php');
head('RFD - Encuestas - Inicio');
$id = $_SESSION['usuario_organizacion'];
?>
<div class="row affix-row">
  <?php menu(); ?>
  <div class="col-sm-9 col-md-10 affix-content">
    <div class="container">
      <div class="page-header">
        <h3>Bienvenido a la herramienta de encuestas, sus novedades son las siguientes:</h3>
      </div>
      <p>Su institución ha completado <span class="inf_import org"><?php encuestasLlenas($id); ?></span> de un total de <?php totalMuestras($id); ?></p>
      <div class="row">
        <?php
        numEncuestaPorEncuesta($id);
        ?>
      </div>
    </div>
  </div>
</div>
<?php foot(); ?>
