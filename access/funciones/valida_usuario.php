<?php
$error = '';
if($_POST){
  $datos = array();
  $usuario = $_POST['user'];
  $contrasena = $_POST['pass'];
  if (strlen($usuario) !== 0 && strlen($contrasena)!== 0) {
    require_once ('consultas.php');
    Conectar();
    if(consultaUsuario($usuario, $contrasena, $base)){
      $datos = datosUsuario($usuario, $base);
      $_SESSION['usuario_id'] = $datos[0];
      $_SESSION['usuario_nombre'] = $datos[1];
      $_SESSION['usuario_organizacion'] = $datos[2];
    }else {
      $error = 'Usuario y/o Contraseña no coinciden';
    }
  }else{
    $error = 'Ingrese el usuario y/o contraseña';
  }
  if(isset( $_SESSION['usuario_id'] )) {
    http_redirect($redirect);
  }
  Desconectar();
}
?>
