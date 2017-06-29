<nav class="navbar navbar-default" id="main_menu">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="home.php">INICIO</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">PARTICIPANTES <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="list.php">Listados</a></li>
                        <li><a href="certified.php">Certificados</a></li>
                        <li><a href="invoices.php">Datos Facturas</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="/registro/" target="_blank">Abrir formulario de inscripciones <span
                                class="glyphicon glyphicon-link"></span></a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">BIENVENIDO <?php echo $_SESSION['usuario_nombre'] ?><span
                                class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="functions/cerrar_sesion.php">Cerrar Sesión</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
