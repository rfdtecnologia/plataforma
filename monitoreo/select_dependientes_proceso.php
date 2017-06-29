<?php
// Array que vincula los IDs de los selects declarados en el HTML con el nombre de la tabla donde se encuentra su contenido
$listadoSelects=array(
"paises"=>"C_PROVINCIA",
"estados"=>"C_CANTON"
);

function validaSelect($selectDestino)
{
	// Se valida que el select enviado via GET exista
	global $listadoSelects;
	if(isset($listadoSelects[$selectDestino])) return true;
	else return false;
}

function validaOpcion($opcionSeleccionada)
{
	// Se valida que la opcion seleccionada por el usuario en el select tenga un valor numerico
	if(is_numeric($opcionSeleccionada)) return true;
	else return false;
}

$selectDestino=$_GET["select"]; $opcionSeleccionada=$_GET["opcion"];

if(validaSelect($selectDestino) && validaOpcion($opcionSeleccionada))
{
	$tabla=$listadoSelects[$selectDestino];
	include("../librerias/conexion.php");
	$conn = connect();
	$sql = "SELECT CANTON_ID, NOMBRE_CANTON FROM $tabla WHERE PROVINCIA_ID='$opcionSeleccionada'";
  	$res = mssql_query($sql, $conn);
	mssql_close($conn);

	// Comienzo a imprimir el select
	echo "<select name='".$selectDestino."' id='".$selectDestino."' onChange='cargaContenido(this.id)'>";
	//echo "<option value='0'>Elige</option>";
	while($registro=mssql_fetch_row($res))
	{
		// Convierto los caracteres conflictivos a sus entidades HTML correspondientes para su correcta visualizacion
		$registro[1]=htmlentities($registro[1]);
		// Imprimo las opciones del select
		echo "<option value='".$registro[0]."'>".$registro[1]."</option>";
	}
	echo "</select>";
}
?>
