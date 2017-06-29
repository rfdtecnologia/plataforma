<?php
$error = '';
if($_POST){
  $usuario = $_POST['user'];
  $contrasena = $_POST['pass'];
  if (strlen($usuario) !== 0 && strlen($contrasena)!== 0) {
    require_once ('consultas.php');
    if(consultaUsuario($usuario, $contrasena)){
      $_SESSION['usuario_inscripciones_id'] = $usuario;
      $_SESSION['usuario_inscripciones_nombre'] = datosUsuario($usuario);
    }else {
      $error = 'Usuario y/o Contraseña no coinciden';
    }
  }else{
    $error = 'Ingrese el usuario y/o contraseña';
  }
  if(isset( $_SESSION['usuario_inscripciones_id'] )) {
    http_redirect_int('home.php');
  }
}
?>
