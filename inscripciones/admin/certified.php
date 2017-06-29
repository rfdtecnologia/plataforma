<?php
require( 'functions/config.php' );
include('functions/consultas.php');
?>
<html lang="en">
  <head>
    <meta charset="iso-8859-1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>RFD - CERTIFICADOS</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body id="bck_desk">
    <?php include("menu.php"); ?>
    <div class="container">
      <form class="" action="" method="post">
        <div class="form-group">
          <select class="form-control required" id="curso_cert" name="curso_cert">
            <option value="-1">-- SELECCIONE EL EVENTO--</option>
            <?php
            llenarEvento();
            ?>
          </select>
        </div>
        </form>
        <div class="mensaje"></div>
        <div class="table-responsive">
          <table class="table table-striped" id="datos_evento">
            <thead>
            <tr>
                <th>No.</th>
                <th>ORGANIZACION</th>
                <th>APELLIDOS</th>
                <th>NOMBRES</th>
                <th>CÉDULA</th>
                <th>ESTADO PARTICIPACIÓN</th>
                <th>TIPO CERTIFICADO</th>
                <th>ENTREGA CERTIFICADO</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
          </table>
        </div>
    </div>
  <?php include("footer.php"); ?>
