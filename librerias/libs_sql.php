<?php
$conn;
$baseDatos = 'RFR-DESARROLLO';
function Conectar()
{
    global $conn;
    global $baseDatos;
    $conn = mssql_connect("192.168.0.102", "sa", "adminsql");
    if (!$conn || !mssql_select_db('RFR-DESARROLLO', $conn)) {
        die('No se puede conectar o seleccionar una base de datos!');
    }
}

function ConsultarTabla($consulta)
{
    global $conn;
    $res = mssql_query($consulta, $conn) /*or die ('error' .$consulta) */;
    //echo 'Consultar '.$res;
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
    global $conn;
    $res = mssql_query($query, $conn) or die ('error' .$query);
    //echo 'Actualizar '.$res;
    return $res;

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
    $fecha = $hoy[year] . "/" . $hoy[mon] . "/" . $hoy[mday] . " " . $hora;
    return $fecha;
}

function Ftp()
{
    $_SESSION['ip'] = "192.168.0.100";
    $_SESSION['puerto'] = "21";
    $_SESSION['usuario'] = "tecnologia";
    $_SESSION['clave'] = "rfr2013";
}

function intFecha()
{
    date_default_timezone_set("America/Bogota");
    $hoy = date("YmdHis");
    $rand = rand(10000, 99999);
    $num = $hoy . $rand;
    return $num;
}

?>
