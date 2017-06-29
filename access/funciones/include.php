<?php
function head($title){
  $name_title = $title;
  $var_includ = include('header.php');
  return $var_includ;
}
function login($name){
  $nombre_ingreso = $name;
  $var_includ = include('form.php');
  return $var_includ;
}
function footer(){
  $var_includ = include('footer.php');
  return $var_includ;
}
?>
