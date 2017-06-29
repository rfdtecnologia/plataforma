<?php
	//global $conn;
	//global $baseDatos;
	//$conn;
	//$baseDatos='RFR-DESARROLLO';
	//$conn = mssql_connect("192.168.0.102", "sa", "adminsql");
	function Conectar(){
		global $conn;
		global $baseDatos;
		$baseDatos='RFR-DESARROLLO';
		$conn = mssql_connect("192.168.0.102", "sa", "adminsql");
	  	//$conn = mssql_connect("192.168.0.91", "sa", "Rfrarp37ra2");
		//$conn = mssql_connect("192.168.0.207", "sa", "arp37ra2");
		if (!$conn || !mssql_select_db($baseDatos, $conn)) {
			die('No se puede conectar o seleccionar una base de datos!');
		}
	}
	function ConsultarTabla($consulta){
		global $conn;
		$res=mssql_query($consulta, $conn);
		return $res;

	}
	function NumeroFilas($resultado)
	{
		return mssql_num_rows($resultado);
	}
	function NumeroColumnas($resultado)
	{
		return mssql_num_fields($resultado);
	}
	function Actualizar($query)
	{
		return mssql_query($query);
	}
	function Desconectar()
	{
		global $conn;
		mssql_close($conn);
	}
	function Fecha()
	{
		date_default_timezone_set("America/Bogota");
		$hoy = getdate();
    $hora = date("H:i:s");
		$fecha = $hoy[year]."/".$hoy[mon]."/".$hoy[mday]." ".$hora;
		return $fecha;
	}
	function intFecha(){
		date_default_timezone_set("America/Bogota");
    $hoy = date("YmdHis");
		$rand = rand(10000, 99999);
		$num = $hoy.$rand;
		return $num;
	}
	function Ftp()
	{
		$_SESSION['ip'] = "192.168.0.103";
		$_SESSION['puerto'] = "21";
		$_SESSION['usuario'] = "tecnologia";
		$_SESSION['clave'] = "rfr2013";
	}
?>
