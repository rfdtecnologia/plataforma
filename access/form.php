<div class="content_form">
  <div class="panel panel-default" id="content_login">
    <div class="panel-heading">
      <h1><?php echo $nombre_ingreso ?></h1>
      <hr>
      <h2>Ingreso</h2>
    </div>
    <div class="panel-body">
      <form class="form-horizontal" action="" method="post">
        <div class="form-group">
          <!--<label for="user" class="col-sm-2 control-label">Usuario</label>-->
            <span class="glyphicon glyphicon-user col-sm-2 user" aria-hidden="true"></span>
          <div class="col-sm-10">
              <input type="text" class="form-control" id="user" name="user" placeholder="Usuario">
          </div>
        </div>
        <div class="form-group">
          <!--<label for="pass" class="col-sm-2 control-label">ContraseÃ±a</label>-->
          <span class="glyphicon glyphicon-lock col-sm-2 user" aria-hidden="true"></span>
          <div class="col-sm-10">
            <input type="password" class="form-control" id="pass" name="pass" placeholder="Contrase�a">
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">Entrar</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
