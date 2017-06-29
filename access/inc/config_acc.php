<?php
define("URL_RELATIVA_ENC", "/");
define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT']);
//
// // incluimos las utilidades
require_once('utils_acc.php');


  // if(!preg_match('/'. urlencode(URL_RELATIVA_ENC).'admin[\?\w*]?/', urlencode($_SERVER['REQUEST_URI'])) &&
  // $_SERVER['REQUEST_URI'] != URL_RELATIVA_ENC . 'admin/login.php'){
  //     if( !isset( $_SESSION['usuario_id'] ) ) {
  //       http_redirect_enc( 'admin' );
  //     }
  // }elseif( !preg_match('/'. urlencode(URL_RELATIVA_ENC).'admin/index.php', urlencode($_SERVER['REQUEST_URI'])) &&
  // $_SERVER['REQUEST_URI'] != URL_RELATIVA_ENC . 'admin'){
  //   //if( !isset( $_SESSION['usuario_id'] ) ) {
  //     http_redirect_enc( 'admin/login.php' );
  //   //}
  // }elseif( !preg_match('/'. urlencode(URL_RELATIVA_ENC).'admin/index.php', urlencode($_SERVER['REQUEST_URI'])) &&
  // $_SERVER['REQUEST_URI'] != URL_RELATIVA_ENC . 'admin/login.php'){
  //   //if( !isset( $_SESSION['usuario_id'] ) ) {
  //     http_redirect_enc( 'admin/login.php' );
  //   //}
  // }elseif( !preg_match('/'. urlencode(URL_RELATIVA_ENC).'admin/index.php[\?\w*]?/', urlencode($_SERVER['REQUEST_URI'])) &&
  //  $_SERVER['REQUEST_URI'] != URL_RELATIVA_ENC . 'admin/login.php'){
  //    //if( !isset( $_SESSION['usuario_id'] ) ) {
  //      http_redirect_enc( 'admin/login.php' );
  //    //}
  //}

?>
