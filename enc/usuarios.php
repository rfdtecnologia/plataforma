<?php
include('functions/include.php');
$mensaje = '';
head('RFD - Usuarios');
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
      <form id="form_usuario" class="form-horizontal" action="" method="post">
        <div class="page-header">
          <h3>Usuarios</h3>
        </div>
        <div class="form-group">
          <label for="identificacion" class="col-sm-2 control-label">Cédula</label>
          <div class="col-sm-10">
            <div class="input-group">
              <input type="text" class="form-control" id="identificacion" name="identificacion" placeholder="Cédula" aria-describedby="basic-addon2">
              <span class="input-group-addon" id="basic-addon2"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span></span>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <button class="btn btn-default" id="button_buscar">Buscar</button>
          </div>
        </div>
      </form>
      <hr>
      <div class="container-fluid">
        <div class="row" id="content_form">
          <div class="col-md-8">
            <form class="form-horizontal" id="usuario_inf" action="">
              <div class="form-group">
                <label for="user_ci" class="col-sm-2 control-label">Cédula</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control info_usuario readonly" id="user_ci" name="user_ci" placeholder="Cédula" value="">
                </div>
              </div>
              <div class="form-group">
                <label for="user_org" class="col-sm-2 control-label">Institución</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control info_usuario readonly" id="user_org" name="user_org" placeholder="Institución" value="">
                </div>
              </div>
              <div class="form-group">
                <button type="button" class="btn btn-danger" disabled="disabled" id="button_rest_pass">Restablecer contraseña</button>
              </div>
              <div class="form-group">
                <label for="user_nombre" class="col-sm-2 control-label">Nombre</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control info_usuario" id="user_nombre" name="user_nombre" placeholder="Nombre" value="">
                </div>
              </div>
              <div class="form-group">
                <label for="user_correo" class="col-sm-2 control-label">Correo Electrónico</label>
                <div class="col-sm-10">
                  <input type="email" class="form-control info_usuario" id="user_correo" name="user_correo" placeholder="Correo Electrónico" value="">
                </div>
              </div>
              <div class="form-group">
                <label for="user_estado" class="col-sm-2 control-label">Estado</label>
                <div class="col-sm-10">
                  <label class="switch">
                    <input type="checkbox" name="user_estado" id="user_estado" >
                    <div class="slider round"></div>
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label for="user_fec_nac" class="col-sm-2 control-label">Fecha Nacimiento</label>
                <div class="col-sm-10">
                  <input type="date" class="form-control info_usuario" id="user_fec_nac" name="user_fec_nac" placeholder="Fecha de Nacimiento" value="">
                </div>
              </div>
              <div class="form-group">
                <button id="guardar">Guardar</button>
              </div>
            </div>
          </form>
          <div class="col-md-4">
            <img src="../imagenes/default.jpg" alt="Logo Institución Usuario" id="logo_user">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<?php foot(); ?>
