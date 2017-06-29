<?php
	Conectar();
	$consultar="SELECT datediff(dd,getdate(),FECHA_LIMITE_PERIODO) DIAS FROM dbo.C_PERIODO WHERE ESTADO_ID = 1 AND convert(char(10),getdate(),111) <= convert(char(10),FECHA_LIMITE_PERIODO,111)";
	$resultado=ConsultarTabla($consultar);
	$filas=NumeroFilas($resultado);
	$var_dias = @mssql_result($resultado,0,"DIAS");
	if($filas == 1)
	{
		switch ($var_dias) {
			case 0:
				$var_descripcion = "Recuerde que tiene el día de hoy para ingresar o enviar la informacion";
				break;
			case 1:
				$var_descripcion = "Recuerde que queda - ".$var_dias." - dia para ingresar o enviar la informacion";
				break;
			default:
				$var_descripcion = "Recuerde que quedan - ".$var_dias." - dias para ingresar o enviar la informacion";
				break;
		}
	}
	else
	{
		$var_descripcion = "El período para ingresar o enviar la información ha concluido.!";
	}
	Desconectar();

?>