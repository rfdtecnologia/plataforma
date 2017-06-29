<div class="cont_l">
  <div class="cont_l_in">
      <div class="cont_logo">
        <a href="index.php"><img src="../imagenes/logo_rfd.png" alt="Logo RFD" title="RFD"/></a>
      </div>
      <div class="cont_buttons">
        <?php
        Conectar();
          itemsMenu();
        Desconectar();
        ?>
      </div>
      <div class="cont_int">
        <ul class="menu_cont_int nav nav-tabs">
          <li role="presentation" class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Sistemas Internos <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <?php
              Conectar();
                itemsMenuInterno();
              Desconectar();
              ?>
            </ul>
          </li>
        </ul>
      </div>
  </div>
</div>
