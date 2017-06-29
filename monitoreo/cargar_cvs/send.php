<?php
include('conn.php');
Conectar();
//Definimos la codificación de la cabecera.
header('Content-Type: text/html; charset=utf-8');
//Importamos el archivo con las validaciones.
require_once 'funciones/validaciones.php';
//Guarda los valores de los campos en variables, siempre y cuando se haya enviado el formulario, sino se guardará null.
/*$codigo = isset($_POST['cod_']) ? $_POST['cod_'] : null;
$nombre = isset($_POST['nom_']) ? $_POST['nom_'] : null;
$valor = isset($_POST['cod_'] as $cod => $val);*/
//$email = isset($_POST['email']) ? $_POST['email'] : null;
//Este array guardará los errores de validación que surjan.
$errores = array();
$aux = 1;
//Pregunta si está llegando una petición por POST, lo que significa que el usuario envió el formulario.
    //Valida que el campo nombre no esté vacío.
    foreach($_POST['nom_'] as $nom => $nombre){
        if (!validaRequerido($nombre)) {
            $errores[] = 'El campo nombre es incorrecto.';
            $aux = 0;
        }
    }
    foreach($_POST['cod_'] as $cod => $codigo){
        if (!validaRequerido($codigo)) {
            $errores[] = 'El campo código es incorrecto.';
            $aux = 0;
        }
         if (!validarEntero($codigo)) {
            $errores[] = 'El campo código es incorrecto.';
            $aux = 0;
        }
    }
    foreach($_POST['val_'] as $val => $valor){
              if (!preg_match("/^-?(\d{1,})(?:\.(\d{2}))?$/", $valor)){
            $errores[] = 'El campo valor debe ser de la forma xxxx.xx';
            $aux = 0;
        }
    }

    if( !$errores){
        //$query = "insert into cuc (cod, nombre, valor) values ('".$_POST['cod_']."', '".$_POST['nom_']."', '".$_POST['val_']."')";
        Insertar($query);
        echo 'se guardó';
    }
    else
        echo 'no se guarda';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<link rel="stylesheet" href="css/style.css" type="text/css">
</head>

<body>
    <div class="content">
    	<?php if ($errores): ?>
            <ul class="list_error">
                <?php foreach ($errores as $error): ?>
                    <li> <?php echo $error ?> </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <p>Archivo cargado con éxito!!!</p>
    </div>
</body>
</html>
