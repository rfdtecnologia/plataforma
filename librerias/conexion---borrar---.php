<? function connect()
{
  $conn = mssql_connect("192.168.0.102", "sa", "adminsql");
  mssql_select_db("BORRAR");
  return $conn;
}
?>
