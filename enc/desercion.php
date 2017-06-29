<?php
include('functions/include.php');
$mensaje = '';
head('RFD - Encuestas - Satisfacción del Cliente');
include('guardar.php');
?>
<div class="row affix-row">
  <?php menu(); ?>
  <div class="col-sm-9 col-md-10 affix-content">
    <div class="container">
      <?php if ($mensaje != ''): ?>
        <ul class="list-group">
          <li class="list-group-item list-group-item-success"><?php echo $mensaje; ?></li>
        </ul>
      <?php endif; ?>
      <form id="form_enviar" class="form-horizontal" action="" method="post">
      <div class="page-header">
        <?php nameEnc(); ?>
      </div>
      <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        <div class="panel panel-default">
          <div class="panel-heading" role="tab" id="headingOne">
            <h4 class="panel-title">
              <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                PERFIL DEL CLIENTE/SOCIO
              </a>
            </h4>
          </div>
          <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
            <div class="panel-body">
                <?php datosCliente(); ?>
            </div>
          </div>
        </div>
        <div class="panel panel-default">
          <div class="panel-heading" role="tab" id="headingTwo">
            <h4 class="panel-title">
              <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                PREGUNTAS
              </a>
            </h4>
          </div>
          <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
            <div class="panel-body">
                <?php pregEnc(); ?>

            </div>
          </div>
        </div>
      </div>
      <?php btnEnviar(); ?>
      </form>
    </div>
  </div>
</div>
<?php foot(); ?>
