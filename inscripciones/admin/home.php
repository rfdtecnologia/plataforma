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
    <title>RFD - ADMINISTRADOR</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body id="bck_desk">
    <?php include("menu.php"); ?>
    <div class="container">
      <div class="row">
        <div class="col-md-8">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Participantes x evento</h3>
            </div>
            <div class="panel-body">
              <table class="table">
                <tr>
                  <th>
                    Evento
                  </th>
                  <th>
                    Participantes
                  </th>
                </tr>
                <?php participantesPorEvento(); ?>
              </table>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Información capacitadores</h3>
            </div>
            <div class="panel-body">
              <ul>
                <?php listaCapacitadores(); ?>
              </ul>
            </div>
          </div>
        </div>
        <div id="content_modal"></div>
      </div>
    </div>
    <?php include("footer.php"); ?>
