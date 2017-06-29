<?php
include('../librerias/libs_sql.php');
include('functions/consultas.php');
include('../inc/config.php');
?>

<html lang="en">
<head>
  <meta charset="iso-8859-1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title><?php echo $inicio; ?></title>
  <link href="css/bootstrap.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body>
  <nav class="navbar top navbar-default navbar-fixed-top">
    <ul class="nav navbar-nav navbar-right user_menu">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Hola, <span class="login"><?php echo $_SESSION['usuario_nombre']; ?></span> <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">Configuración</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="salir.php">Salir</a></li>
          </ul>
        </li>
      </ul>
  </nav>