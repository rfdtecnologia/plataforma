<?php
$estado = 1;
if ($_POST):
	foreach($_POST['nom_'] as $nom => $nombre){
			if (!validaRequerido($nombre)) {
	    		$errores[] = 'El campo nombre es incorrecto.';
	    		$estado = 0;
			}
	}
    foreach($_POST['cod_'] as $cod => $codigo){
        if (!validaRequerido($codigo)) {
            $errores[] = 'El campo código es incorrecto.';
            $estado = 0;
        }
         if (!validarEntero($codigo)) {
            $errores[] = 'El campo código es incorrecto.';
            $estado = 0;
        }
    }
    foreach($_POST['val_'] as $val => $valor){
              if (!preg_match("/^-?(\d{1,})(?:\.(\d{2}))?$/", $valor)){
            $errores[] = 'El campo valor debe ser de la forma xxxx.xx';
            $estado = 0;
        }
    }
    echo $estado;	
else:
	 echo 'No se envió ningún dato';
endif;

?>