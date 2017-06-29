<?php
require ('include.php');

if ($_POST) {
	Conectar();
	$id_fac = $_POST['id'];
	$query = "SELECT * FROM C_FACILITADOR WHERE FACILITADOR_ID = $id_fac";
	$res = ConsultarTabla($query);
	$rows = NumeroFilas($res);
	if ($rows == 0) {
	echo "ALGO SALIO MAL";
	}else {
		for ($i = 0; $i < $rows; ++$i){
		  $col_nombre_facilitador = mssql_result($res,$i,"NOMBRE_FACILITADOR");
		  $col_correo_facilitador = mssql_result($res,$i,"CORREO_FACILITADOR");
		  $col_telefono_facilitador = mssql_result($res,$i,"TELEFONO_FACILITADOR");
		  echo "<div class='modal fade' id='modal_".$id_fac."' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>";
		  echo "<div class='modal-dialog' role='document'>";
		  echo "<div class='modal-content'>";
		  echo "<div class='modal-header'>";
		  echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>";
		  echo "</div>";
		  echo "<div class='modal-body'>";
		  echo "<p>Nombre: $col_nombre_facilitador</p>";
		  echo "<p>Correo: $col_correo_facilitador</p>";
		  echo "<p>Teléfono: $col_telefono_facilitador</p>";
		  echo "</div>";
		  echo "</div>";
		  echo "</div>";
		  echo "</div>";
		}
	}
	Desconectar();
}
?>