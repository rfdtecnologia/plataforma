<?php
include('functions/valida_usuario.php');
?>
<html lang="en">
  <head>
    <meta charset="iso-8859-1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>RFD - INGRESO</title>
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body id="bck_log">
    <div class="container">
      <div class="panel panel-default" id="content_login">
        <div class="panel-heading">
          <h3 class="panel-title">Ingreso</h3>
        </div>
        <div class="panel-body">
          <?php
          if ($error !== '') {
            echo "<div class='alert alert-danger' role='alert'><p>$error</p></div>";
          }
          ?>
          <form class="form-horizontal" action="" method="post">
            <div class="form-group">
              <label for="user" class="col-sm-2 control-label">Usuario</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="user" name="user" placeholder="Usuario">
              </div>
            </div>
            <div class="form-group">
              <label for="pass" class="col-sm-2 control-label">Contraseña</label>
              <div class="col-sm-10">
                <input type="password" class="form-control" id="pass" name="pass" placeholder="Contraseï¿½a">
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
    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.min.js"></script>
  </body>
</html>
