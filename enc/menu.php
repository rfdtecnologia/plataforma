<div class="col-sm-3 col-md-2 affix-sidebar">
  <div class="sidebar-nav">
    <div class="navbar navbar-default" role="navigation">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-navbar-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <div class="navbar-header">
          <a class="navbar-brand" href="index.php">
            <img class="img-responsive" alt="Encuestas RFD" src="../imagenes/<?php echo $_SESSION["usuario_organizacion"] ?>.jpg">
          </a>
        </div>

      </div>
      <div class="navbar-collapse collapse sidebar-navbar-collapse">
        <ul class="nav navbar-nav" id="sidenav01">
          <li>
            <a href="index.php">
                <span class="glyphicon glyphicon-home"></span> Inicio
            </a>
          </li>
          <li>
            <a href="#" data-toggle="collapse" data-target="#toggleDemo" data-parent="#sidenav01" class="collapsed">
              <span class="glyphicon glyphicon-list-alt"></span> Encuestas <span class="caret"></span>
            </a>
            <div class="collapse" id="toggleDemo" style="height: 0px;">
              <ul class="nav nav-list">
                <?php
                Conectar();
                listaEncuesta($_SESSION['usuario_organizacion']);
                Desconectar();
                ?>
              </ul>
            </div>
          </li>
        </ul>
        <div class="content_logo">
          <img src="images/logo_rfd.png" alt="RFD ENCUESTAS">
          <p>
            Psj. El Jardín E10-06 y Av. 6 de Diciembre Edif. Century Plaza<br>
            23333550 / 23333551<br>
            <a href="mailto:info@rfd.org.ec">info@rfd.org.ec</a><br>
            www.rfd.org.ec
          </p>
        </div>
      </div><!--/.nav-collapse -->
    </div>
  </div>
</div>
