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
      <p>Su institución ha completado <span class="inf_import org"><?php encuestasLlenas($id); ?></span> de un total de <?php totalMuestras($id, 0); ?></p>
      <div class="row">
        <?php
        numEncuestaPorEncuesta($id);
        ?>
      </div>
        <div class="reports_content">
          <?php $tmp = totalMuestras($id, 1);
          $fi = $tmp[0]; 
          $ff = $tmp[1]; 
          ?>
            <a  href="reporte_excel.php?o=<?php echo base64_encode($id); ?>&fi=<?php echo $fi; ?>&ff=<?php echo $ff; ?>" class="btn btn-info" id="btn_d_r"> Descargar Resúmen</a>
        </div>
    </div>
  </div>
</div>
<?php foot(); 

