<?php
include('functions/conexion.php');
include('functions/include.php');
include('functions/consultas.php');

if ($_POST) {
  Conectar();
  $id_usuario = $_POST['cedula'];
  existeUsuario($id_usuario);
  echo json_encode(existeUsuario($id_usuario));
  Desconectar();
}
?>
