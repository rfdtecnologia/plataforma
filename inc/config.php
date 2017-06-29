<?php
session_start();
//echo $_SESSION["nombre_usuario"];
define('DOCUMENT_ROOT_RELATIVA', '/');
define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT']);

include_once( 'utils.php' );

  if (!preg_match('/'.urlencode(DOCUMENT_ROOT_RELATIVA). 'index.php[\?\w*]?/', urlencode($_SERVER['REQUEST_URI']))
      && $_SERVER['REQUEST_URI'] != DOCUMENT_ROOT_RELATIVA . 'plataforma/access/ingreso.php?v=MQ=='//MONITOREO
      && $_SERVER['REQUEST_URI'] != DOCUMENT_ROOT_RELATIVA . 'plataforma/access/ingreso.php?v=Mg=='//ENCUESTAS
      && $_SERVER['REQUEST_URI'] != DOCUMENT_ROOT_RELATIVA . 'plataforma/access/ingreso.php?v=NA=='//INSCRIPCIONES ADMIN
  ){
	if (!isset($_SESSION["usuario_nombre"])) {
		http_redirect('plataforma/access/index.php');
	}elseif ($_SERVER['REQUEST_URI'] == DOCUMENT_ROOT_RELATIVA) {
		http_redirect('plataforma/access/index.php');
	}
  }else{
  	if (isset($_SESSION["usuario_nombre"])) {
  		http_redirect($_SESSION['principal']);
  	}
  }

?>