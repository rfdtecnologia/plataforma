
<? session_start(); ?>
<html>
<head>
<script type="text/javascript" src="select_dependientes.js"></script>
<title>RFD -- C_COBERTURA_GEOGRAFICA</title>
<meta name="generator" content="text/html">
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<link href="SpryAssets/HojasEstilos.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
include ('head.php');
?>
<table width="100%" border="0">
  <tr>
    <td><div align="center"><a href="MenuPrincipal.php" class="btn_menu">Menu Principal</a></div></td>
  </tr>
</table>
<?
  include("../librerias/libs_sql.php");
  Conectar();
  $showrecs = 20;
  $pagerange = 10;

  $a = @$_GET["a"];
  $recid = @$_GET["recid"];
  if (isset($_GET["order"])) $order = @$_GET["order"];
  if (isset($_GET["type"])) $ordtype = @$_GET["type"];

  if (isset($_POST["filter"])) $filter = @$_POST["filter"];
  if (isset($_POST["filter_field"])) $filterfield = @$_POST["filter_field"];
  $wholeonly = false;
  if (isset($_POST["wholeonly"])) $wholeonly = @$_POST["wholeonly"];

  if (!isset($order) && isset($_SESSION["order"])) $order = $_SESSION["order"];
  if (!isset($ordtype) && isset($_SESSION["type"])) $ordtype = $_SESSION["type"];
  if (!isset($filter) && isset($_SESSION["filter"])) $filter = $_SESSION["filter"];
  if (!isset($filterfield) && isset($_SESSION["filter_field"])) $filterfield = $_SESSION["filter_field"];

  $page = @$_GET["page"];
  if (!isset($page)) $page = 1;

  $sql = @$_POST["sql"];

  switch ($sql) {
    case "insert":
      sql_insert();
      break;
    case "update":
      sql_update();
      break;
    case "delete":
      sql_delete();
      break;
  }

  switch ($a) {
    case "add":
      addrec();
      break;
    case "view":
      viewrec($recid);
      break;
    case "edit":
      editrec($recid);
      break;
    case "del":
      deleterec($recid);
      break;
    default:
      select();
      break;
  }

  if (isset($order)) $_SESSION["order"] = $order;
  if (isset($ordtype)) $_SESSION["type"] = $ordtype;
  if (isset($filter)) $_SESSION["filter"] = $filter;
  if (isset($filterfield)) $_SESSION["filter_field"] = $filterfield;
  if (isset($wholeonly)) $_SESSION["wholeonly"] = $wholeonly;

  mssql_close($conn);
?>
<table width="100%" border="0">
  <tr>
    <td><div align="center"><a href="MenuPrincipal.php" class="btn_menu">Menu Principal</a></div></td>
  </tr>
</table>
<table class="bd" width="100%"><tr><td class="hr"></td></tr></table>
</body>
</html>

<? function select()
  {
  global $a;
  global $showrecs;
  global $page;
  global $filter;
  global $filterfield;
  global $wholeonly;
  global $order;
  global $ordtype;


  if ($a == "reset") {
    $filter = "";
    $filterfield = "";
    $wholeonly = "";
    $order = "";
    $ordtype = "";
  }

  $checkstr = "";
  if ($wholeonly) $checkstr = " checked";
  if ($ordtype == "asc") { $ordtypestr = "desc"; } else { $ordtypestr = "asc"; }
  $res = sql_select();
  $count = sql_getrecordcount();
  if ($count % $showrecs != 0) {
    $pagecount = intval($count / $showrecs) + 1;
  }
  else {
    $pagecount = intval($count / $showrecs);
  }
  $startrec = $showrecs * ($page - 1);
  if ($startrec < $count) {mssql_data_seek($res, $startrec);}
  $reccount = min($showrecs * $page, $count);
  $fields = array(
    "PERIODO_ID" => "PERIODO",
    "NOMBRE_PERIODO" => "NOMBRE PERIODO",
    //"ORGANIZACION_ID" => "ORGANIZACION_ID",
    "NOMBRE_ORGANIZACION" => "ORGANIZACION",
    "NOMBRE_PROVINCIA" => "PROVINCIA",
    "NOMBRE_CANTON" => "CANTON",
    //"PROVINCIA_ID" => "PROVINCIA_ID",
    //"CANTON_ID" => "CANTON_ID",
    "NUMERO_OFICINAS" => "NRO. OFICINAS",
    "MONTO_CARTERA" => "MONTO CARTERA",
    "CLIENTES_ACTIVOS_CREDITOS" => "CLIENTES ACTIVOS CREDITOS",
    "ESTADO_ID" => "ESTADO");
?>
<table class="bd" border="0" cellspacing="1" cellpadding="4">
<tr><td>TABLA: dbo.C_COBERTURA_GEOGRAFICA</td></tr>
<tr><td>Records shown <? echo $startrec + 1 ?> - <? echo $reccount ?> of <? echo $count ?></td></tr>
</table>
<hr size="1" noshade>
<form action="C_COBERTURA_GEOGRAFICA.php" method="post">
<table class="bd" border="0" cellspacing="1" cellpadding="4">
<tr>
<td><b>Escoja un Campo:</b>&nbsp;</td>
<td><input type="text" name="filter" value="<? echo $filter ?>"></td>
<td><select name="filter_field">
<!-- <option value="">Todos los Campos</option> -->
<?
  reset($fields);
  foreach($fields as $val => $caption) {
    if ($val == $filterfield) {$selstr = " selected"; } else {$selstr = ""; }
?>
<option value="<? echo $val ?>"<? echo $selstr ?>><? echo htmlspecialchars($caption) ?></option>
<? } ?>
</select></td>
<td><input type="checkbox" name="wholeonly"<? echo $checkstr ?>>Solo la Palabra</td>
</td></tr>
<tr>
<td>&nbsp;</td>
<td><input type="submit" name="action" value="Filtrar"></td>
<td><a href="C_COBERTURA_GEOGRAFICA.php?a=reset">Quitar Filtro</a></td>
</tr>
</table>
</form>
<hr size="1" noshade>
<? showpagenav($page, $pagecount); ?>
<br>
<table class="tbl" border="0" cellspacing="1" cellpadding="5"width="100%">
<tr>
<?
  reset($fields);
  foreach($fields as $val => $caption) {
?>
<td class="hr"><a class="hr" href="C_COBERTURA_GEOGRAFICA.php?order=<? echo $val ?>&type=<? echo $ordtypestr ?>"><? echo htmlspecialchars($caption) ?></a></td>
<? } ?>
<td class="hr">&nbsp;</td>
<td class="hr">&nbsp;</td>
<td class="hr">&nbsp;</td>
</tr>
<?
  for ($i = $startrec; $i < $reccount; $i++)
  {
    $row = mssql_fetch_assoc($res);
    $style = "dr";
    if ($i % 2 != 0) {
      $style = "sr";
    }
?>
<tr>
<?
  reset($fields);
  foreach($fields as $val => $caption) {
?>
<td class="<? echo $style ?>"><? echo htmlspecialchars($row[$val]) ?></td>
<? } ?>
<td class="<? echo $style ?>"><a href="C_COBERTURA_GEOGRAFICA.php?a=view&recid=<? echo $i ?>">Ver</a></td>
<td class="<? echo $style ?>"><a href="C_COBERTURA_GEOGRAFICA.php?a=edit&recid=<? echo $i ?>">Editar</a></td>
<td class="<? echo $style ?>"><a href="C_COBERTURA_GEOGRAFICA.php?a=del&recid=<? echo $i ?>">Borrar</a></td>
</tr>
<?
  }
  mssql_free_result($res);
?>
</table>
<br>
<? } ?>

<? function showrow($row)
  {
?>
<table class="tbl" border="0" cellspacing="1" cellpadding="5"width="100%">
<tr>
<td class="hr"><? echo htmlspecialchars("PERIODO")."&nbsp;" ?></td>
<td class="dr"><? echo htmlspecialchars($row["PERIODO_ID"]) ?></td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("ORGANIZACION")."&nbsp;" ?></td>
<td class="dr"><? echo htmlspecialchars($row["ORGANIZACION_ID"]) ?></td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("PROVINCIA")."&nbsp;" ?></td>
<td class="dr"><? echo htmlspecialchars($row["PROVINCIA_ID"]) ?></td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("CANTON")."&nbsp;" ?></td>
<td class="dr"><? echo htmlspecialchars($row["CANTON_ID"]) ?></td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("NRO. OFICINAS")."&nbsp;" ?></td>
<td class="dr"><? echo htmlspecialchars($row["NUMERO_OFICINAS"]) ?></td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("MONTO CARTERA")."&nbsp;" ?></td>
<td class="dr"><? echo htmlspecialchars($row["MONTO_CARTERA"]) ?></td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("CLIENTES ACTIVOS CREDITOS")."&nbsp;" ?></td>
<td class="dr"><? echo htmlspecialchars($row["CLIENTES_ACTIVOS_CREDITOS"]) ?></td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("ESTADO")."&nbsp;" ?></td>
<td class="dr"><? echo htmlspecialchars($row["ESTADO_ID"]) ?></td>
</tr>
</table>
<? } ?>

<? function showroweditor($row)
  {
  global $conn;
  $var_provincia = $row["PROVINCIA_ID"];
  $var_canton = $row["CANTON_ID"];
?>
<table class="tbl" border="0" cellspacing="1" cellpadding="5"width="100%">
<tr>
<td class="hr"><? echo htmlspecialchars("PERIODO")."&nbsp;" ?></td>
<td class="dr"><select name="PERIODO_ID" disabled>
<?
  $sql = "select PERIODO_ID, NOMBRE_PERIODO from dbo.C_PERIODO";
  $res = mssql_query($sql, $conn);

  while ($lp_row = mssql_fetch_assoc($res)){
  $val = $lp_row["PERIODO_ID"];
  $caption = $lp_row["NOMBRE_PERIODO"];
  if ($row["PERIODO_ID"] == $lp_row["PERIODO_ID"]) {$selstr = " selected"; } else {$selstr = ""; }
 ?><option value="<? echo $val ?>"<? echo $selstr ?>><? echo $caption ?></option>
<? } ?></select>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("ORGANIZACION")."&nbsp;" ?></td>
<td class="dr"><select name="ORGANIZACION_ID" disabled>
<?
  $sql = "select ORGANIZACION_ID, NOMBRE_ORGANIZACION from dbo.C_ORGANIZACION";
  $res = mssql_query($sql, $conn);

  while ($lp_row = mssql_fetch_assoc($res)){
  $val = $lp_row["ORGANIZACION_ID"];
  $caption = $lp_row["NOMBRE_ORGANIZACION"];
  if ($row["ORGANIZACION_ID"] == $lp_row["ORGANIZACION_ID"]) {$selstr = " selected"; } else {$selstr = ""; }
 ?><option value="<? echo $val ?>"<? echo $selstr ?>><? echo $caption ?></option>
<? } ?></select>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("PROVINCIA")."&nbsp;" ?></td>
<td class="dr"><select name="PROVINCIA_ID" disabled>
<?
  $sql = "select PROVINCIA_ID, NOMBRE_PROVINCIA from dbo.C_PROVINCIA";
  $res = mssql_query($sql, $conn);

  while ($lp_row = mssql_fetch_assoc($res)){
  $val = $lp_row["PROVINCIA_ID"];
  $caption = $lp_row["NOMBRE_PROVINCIA"];
  if ($row["PROVINCIA_ID"] == $lp_row["PROVINCIA_ID"]) {$selstr = " selected"; } else {$selstr = ""; }
 ?><option value="<? echo $val ?>"<? echo $selstr ?>><? echo $caption ?></option>
<? } ?></select>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("CANTON")."&nbsp;" ?></td>
<td class="dr"><select name="CANTON_ID" disabled>
<?
  $sql = "select CANTON_ID, NOMBRE_CANTON from dbo.C_CANTON WHERE PROVINCIA_ID = $var_provincia AND CANTON_ID = $var_canton";
  $res = mssql_query($sql, $conn);

  while ($lp_row = mssql_fetch_assoc($res)){
  $val = $lp_row["CANTON_ID"];
  $caption = $lp_row["NOMBRE_CANTON"];
  if ($row["CANTON_ID"] == $lp_row["CANTON_ID"]) {$selstr = " selected"; } else {$selstr = ""; }
 ?><option value="<? echo $val ?>"<? echo $selstr ?>><? echo $caption ?></option>
<? } ?></select>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("NRO. OFICINAS")."&nbsp;" ?></td>
<td class="dr">
<span id="sprytextfield1">
<input type="text" name="NUMERO_OFICINAS" value="<? echo str_replace('"', '&quot;', trim($row["NUMERO_OFICINAS"])) ?>">
<span class="textfieldRequiredMsg">Obligatorio ingresar algun dato</span><span class="textfieldInvalidFormatMsg">Formato Incorrecto</span></span>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("MONTO CARTERA")."&nbsp;" ?></td>
<td class="dr">
<span id="sprytextfield3">
<input type="text" name="MONTO_CARTERA" value="<? echo str_replace('"', '&quot;', trim($row["MONTO_CARTERA"])) ?>">
<span class="textfieldRequiredMsg">Obligatorio ingresar algun dato</span><span class="textfieldInvalidFormatMsg">Formato Incorrecto</span><span class="textfieldMinValueMsg">Formato Incorrecto</span></span>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("CLIENTES ACTIVOS CREDITOS")."&nbsp;" ?></td>
<td class="dr">
<span id="sprytextfield2">
<input type="text" name="CLIENTES_ACTIVOS_CREDITOS" value="<? echo str_replace('"', '&quot;', trim($row["CLIENTES_ACTIVOS_CREDITOS"])) ?>">
<span class="textfieldRequiredMsg">Obligatorio ingresar algun dato</span><span class="textfieldInvalidFormatMsg">Formato Incorrecto</span></span>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("ESTADO")."&nbsp;" ?></td>
<td class="dr"><select name="ESTADO_ID">
<?
  $sql = "select ESTADO_ID, NOMBRE_ESTADO from dbo.C_ESTADO";
  $res = mssql_query($sql, $conn);

  while ($lp_row = mssql_fetch_assoc($res)){
  $val = $lp_row["ESTADO_ID"];
  $caption = $lp_row["NOMBRE_ESTADO"];
  if ($row["ESTADO_ID"] == $lp_row["ESTADO_ID"]) {$selstr = " selected"; } else {$selstr = ""; }
 ?><option value="<? echo $val ?>"<? echo $selstr ?>><? echo $caption ?></option>
<? } ?></select>
</td>
</tr>
</table>
<? } ?>


<? function showrowadd($row)
  {
  global $conn;
?>
<table class="tbl" border="0" cellspacing="1" cellpadding="5"width="100%">
<tr>
<td class="hr"><? echo htmlspecialchars("PERIODO")."&nbsp;" ?></td>
<td class="dr"><select name="PERIODO_ID">
<?
  $sql = "select PERIODO_ID, NOMBRE_PERIODO from dbo.C_PERIODO ORDER BY PERIODO_ID DESC";
  $res = mssql_query($sql, $conn);

  while ($lp_row = mssql_fetch_assoc($res)){
  $val = $lp_row["PERIODO_ID"];
  $caption = $lp_row["NOMBRE_PERIODO"];
  if ($row["PERIODO_ID"] == $lp_row["PERIODO_ID"]) {$selstr = " selected"; } else {$selstr = ""; }
 ?><option value="<? echo $val ?>"<? echo $selstr ?>><? echo $caption ?></option>
<? } ?></select>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("ORGANIZACION")."&nbsp;" ?></td>
<td class="dr"><select name="ORGANIZACION_ID">
<?
  $sql = "select ORGANIZACION_ID, NOMBRE_ORGANIZACION from dbo.C_ORGANIZACION";
  $res = mssql_query($sql, $conn);

  while ($lp_row = mssql_fetch_assoc($res)){
  $val = $lp_row["ORGANIZACION_ID"];
  $caption = $lp_row["NOMBRE_ORGANIZACION"];
  if ($row["ORGANIZACION_ID"] == $lp_row["ORGANIZACION_ID"]) {$selstr = " selected"; } else {$selstr = ""; }
 ?><option value="<? echo $val ?>"<? echo $selstr ?>><? echo $caption ?></option>
<? } ?></select>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("PROVINCIA")."&nbsp;" ?></td>
<td class="dr">
<select name='paises' id='paises' onChange='cargaContenido(this.id)'>
<?
  $sql = "select PROVINCIA_ID, NOMBRE_PROVINCIA from dbo.C_PROVINCIA";
  $res = mssql_query($sql, $conn);

  while ($lp_row = mssql_fetch_assoc($res)){
  $val = $lp_row["PROVINCIA_ID"];
  $caption = $lp_row["NOMBRE_PROVINCIA"];
  if ($row["PROVINCIA_ID"] == $lp_row["PROVINCIA_ID"]) {$selstr = " selected"; } else {$selstr = ""; }
 ?><option value="<? echo $val ?>"<? echo $selstr ?>><? echo $caption ?></option>
<? } ?>
</select>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("CANTON")."&nbsp;" ?></td>
<td class="dr">
<select name='estados' id='estados'>
<?
  $sql = "select CANTON_ID, NOMBRE_CANTON from dbo.C_CANTON WHERE PROVINCIA_ID = 1";
  $res = mssql_query($sql, $conn);

  while ($lp_row = mssql_fetch_assoc($res)){
  $val = $lp_row["CANTON_ID"];
  $caption = $lp_row["NOMBRE_CANTON"];
  if ($row["CANTON_ID"] == $lp_row["CANTON_ID"]) {$selstr = " selected"; } else {$selstr = ""; }
 ?><option value="<? echo $val ?>"<? echo $selstr ?>><? echo $caption ?></option>
<? } ?>
</select>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("NRO. OFICINAS")."&nbsp;" ?></td>
<td class="dr">
<span id="sprytextfield1">
<input type="text" name="NUMERO_OFICINAS" value="<? echo str_replace('"', '&quot;', trim($row["NUMERO_OFICINAS"])) ?>">
<span class="textfieldRequiredMsg">Obligatorio ingresar algun dato</span><span class="textfieldInvalidFormatMsg">Formato Incorrecto</span></span>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("MONTO CARTERA")."&nbsp;" ?></td>
<td class="dr">
<span id="sprytextfield3">
<input type="text" name="MONTO_CARTERA" value="<? echo str_replace('"', '&quot;', trim($row["MONTO_CARTERA"])) ?>">
<span class="textfieldRequiredMsg">Obligatorio ingresar algun dato</span><span class="textfieldInvalidFormatMsg">Formato Incorrecto</span><span class="textfieldMinValueMsg">Formato Incorrecto</span></span>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("CLIENTES ACTIVOS CREDITOS")."&nbsp;" ?></td>
<td class="dr">
<span id="sprytextfield2">
<input type="text" name="CLIENTES_ACTIVOS_CREDITOS" value="<? echo str_replace('"', '&quot;', trim($row["CLIENTES_ACTIVOS_CREDITOS"])) ?>">
<span class="textfieldRequiredMsg">Obligatorio ingresar algun dato</span><span class="textfieldInvalidFormatMsg">Formato Incorrecto</span></span>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("ESTADO")."&nbsp;" ?></td>
<td class="dr"><select name="ESTADO_ID">
<?
  $sql = "select ESTADO_ID, NOMBRE_ESTADO from dbo.C_ESTADO";
  $res = mssql_query($sql, $conn);

  while ($lp_row = mssql_fetch_assoc($res)){
  $val = $lp_row["ESTADO_ID"];
  $caption = $lp_row["NOMBRE_ESTADO"];
  if ($row["ESTADO_ID"] == $lp_row["ESTADO_ID"]) {$selstr = " selected"; } else {$selstr = ""; }
 ?><option value="<? echo $val ?>"<? echo $selstr ?>><? echo $caption ?></option>
<? } ?></select>
</td>
</tr>
</table>
<? } ?>




<? function showpagenav($page, $pagecount)
{
?>
<table class="bd" border="0" cellspacing="1" cellpadding="4">
<tr>
<td><a href="C_COBERTURA_GEOGRAFICA.php?a=add">Nuevo Registro</a>&nbsp;</td>
<? if ($page > 1) { ?>
<td><a href="C_COBERTURA_GEOGRAFICA.php?page=<? echo $page - 1 ?>">&lt;&lt;&nbsp;Anterior</a>&nbsp;</td>
<? } ?>
<?
  global $pagerange;

  if ($pagecount > 1) {

  if ($pagecount % $pagerange != 0) {
    $rangecount = intval($pagecount / $pagerange) + 1;
  }
  else {
    $rangecount = intval($pagecount / $pagerange);
  }
  for ($i = 1; $i < $rangecount + 1; $i++) {
    $startpage = (($i - 1) * $pagerange) + 1;
    $count = min($i * $pagerange, $pagecount);

    if ((($page >= $startpage) && ($page <= ($i * $pagerange)))) {
      for ($j = $startpage; $j < $count + 1; $j++) {
        if ($j == $page) {
?>
<td><b><? echo $j ?></b></td>
<? } else { ?>
<td><a href="C_COBERTURA_GEOGRAFICA.php?page=<? echo $j ?>"><? echo $j ?></a></td>
<? } } } else { ?>
<td><a href="C_COBERTURA_GEOGRAFICA.php?page=<? echo $startpage ?>"><? echo $startpage ."..." .$count ?></a></td>
<? } } } ?>
<? if ($page < $pagecount) { ?>
<td>&nbsp;<a href="C_COBERTURA_GEOGRAFICA.php?page=<? echo $page + 1 ?>">Siguiente&nbsp;&gt;&gt;</a>&nbsp;</td>
<? } ?>
</tr>
</table>
<? } ?>

<? function showrecnav($a, $recid, $count)
{
?>
<table class="bd" border="0" cellspacing="1" cellpadding="4">
<tr>
<td><a href="C_COBERTURA_GEOGRAFICA.php">Pagina Principal</a></td>
<? if ($recid > 0) { ?>
<td><a href="C_COBERTURA_GEOGRAFICA.php?a=<? echo $a ?>&recid=<? echo $recid - 1 ?>">Anterior Registro</a></td>
<? } if ($recid < $count) { ?>
<td><a href="C_COBERTURA_GEOGRAFICA.php?a=<? echo $a ?>&recid=<? echo $recid + 1 ?>">Siguiente Registro</a></td>
<? } ?>
</tr>
</table>
<hr size="1" noshade>
<? } ?>

<? function addrec()
{
?>
<table class="bd" border="0" cellspacing="1" cellpadding="4">
<tr>
<td><a href="C_COBERTURA_GEOGRAFICA.php">Pagina Principal</a></td>
</tr>
</table>
<hr size="1" noshade>
<form action="C_COBERTURA_GEOGRAFICA.php" method="post">
<p><input type="hidden" name="sql" value="insert"></p>
<?
$row = array(
  "PERIODO_ID" => "",
  "ORGANIZACION_ID" => "",
  "PROVINCIA_ID" => "",
  "CANTON_ID" => "",
  "NUMERO_OFICINAS" => "",
  "MONTO_CARTERA" => "",
  "CLIENTES_ACTIVOS_CREDITOS" => "",
  "ESTADO_ID" => "");
showrowadd($row)
?>
<p><input type="submit" name="action" value="Guardar"></p>
</form>
<? } ?>

<? function viewrec($recid)
{
  $res = sql_select();
  $count = sql_getrecordcount();
  @mssql_data_seek($res, $recid);
  $row = mssql_fetch_assoc($res);
  showrecnav("view", $recid, $count);
?>
<br>
<? showrow($row) ?>
<br>
<hr size="1" noshade>
<table class="bd" border="0" cellspacing="1" cellpadding="4">
<tr>
<td><a href="C_COBERTURA_GEOGRAFICA.php?a=add">Nuevo Registro</a></td>
<td><a href="C_COBERTURA_GEOGRAFICA.php?a=edit&recid=<? echo $recid ?>">Editar Registro</a></td>
<td><a href="C_COBERTURA_GEOGRAFICA.php?a=del&recid=<? echo $recid ?>">Borrar Registro</a></td>
</tr>
</table>
<?
  mssql_free_result($res);
} ?>

<? function editrec($recid)
{
  $res = sql_select();
  $count = sql_getrecordcount();
  @mssql_data_seek($res, $recid);
  $row = mssql_fetch_assoc($res);
  showrecnav("edit", $recid, $count);
?>
<br>
<form action="C_COBERTURA_GEOGRAFICA.php" method="post">
<input type="hidden" name="sql" value="update">
<input type="hidden" name="xPERIODO_ID" value="<? echo $row["PERIODO_ID"] ?>">
<input type="hidden" name="xORGANIZACION_ID" value="<? echo $row["ORGANIZACION_ID"] ?>">
<input type="hidden" name="xPROVINCIA_ID" value="<? echo $row["PROVINCIA_ID"] ?>">
<input type="hidden" name="xCANTON_ID" value="<? echo $row["CANTON_ID"] ?>">
<? showroweditor($row) ?>
<p><input type="submit" name="action" value="Guardar"></p>
</form>
<?
  mssql_free_result($res);
} ?>

<? function deleterec($recid)
{
  $res = sql_select();
  $count = sql_getrecordcount();
  @mssql_data_seek($res, $recid);
  $row = mssql_fetch_assoc($res);
  showrecnav("del", $recid, $count);
?>
<br>
<form action="C_COBERTURA_GEOGRAFICA.php" method="post">
<input type="hidden" name="sql" value="delete">
<input type="hidden" name="xPERIODO_ID" value="<? echo $row["PERIODO_ID"] ?>">
<input type="hidden" name="xORGANIZACION_ID" value="<? echo $row["ORGANIZACION_ID"] ?>">
<input type="hidden" name="xPROVINCIA_ID" value="<? echo $row["PROVINCIA_ID"] ?>">
<input type="hidden" name="xCANTON_ID" value="<? echo $row["CANTON_ID"] ?>">
<? showrow($row) ?>
<p><input type="submit" name="action" value="Confirmar"></p>
</form>
<?
  mssql_free_result($res);
} ?>

<?

function sqlvalue($val, $quote)
{
  if ($quote)
    $tmp = sqlstr($val);
  else
    $tmp = $val;
  if ($tmp == "")
    $tmp = "NULL";
  elseif ($quote)
    $tmp = "'".$tmp."'";
  return $tmp;
}

function sqlstr($val)
{
  return str_replace("'", "''", $val);
}

function sql_select()
{
  global $conn;
  global $order;
  global $ordtype;
  global $filter;
  global $filterfield;
  global $wholeonly;

  $filterstr = sqlstr($filter);
  if (!$wholeonly && isset($wholeonly) && $filterstr!='') $filterstr = "%" .$filterstr ."%";
  $consulta="SELECT MAX(PERIODO_ID) AS MAXIMO_PERIODO FROM dbo.C_PERIODO";
  $resultado=ConsultarTabla($consulta);
  $var_maximo_periodo = mssql_result($resultado,0,"MAXIMO_PERIODO");
  $sql = "SELECT
			CONVERT(VARCHAR(6),CBR.PERIODO_ID) AS PERIODO_ID,
			CONVERT(VARCHAR(30),PER.NOMBRE_PERIODO) AS NOMBRE_PERIODO,
			CBR.ORGANIZACION_ID,
			CONVERT(VARCHAR(80),ORG.NOMBRE_ORGANIZACION) AS NOMBRE_ORGANIZACION,
			CBR.PROVINCIA_ID,
			CONVERT(VARCHAR(50),PRO.NOMBRE_PROVINCIA) AS NOMBRE_PROVINCIA,
			CBR.CANTON_ID,
			CONVERT(VARCHAR(50),CAN.NOMBRE_CANTON)AS NOMBRE_CANTON,
			CBR.NUMERO_OFICINAS,
			CBR.MONTO_CARTERA,
			CBR.CLIENTES_ACTIVOS_CREDITOS,
			CONVERT(VARCHAR(4),CBR.ESTADO_ID ) AS ESTADO_ID
			from
			dbo.C_COBERTURA_GEOGRAFICA CBR,
			dbo.C_PERIODO PER,
			dbo.C_ORGANIZACION ORG,
			dbo.C_PROVINCIA PRO,
			dbo.C_CANTON CAN
			WHERE
			CBR.PERIODO_ID = PER.PERIODO_ID AND
			CBR.ORGANIZACION_ID = ORG.ORGANIZACION_ID AND
			PRO.PROVINCIA_ID = CAN.PROVINCIA_ID AND
			CBR.PROVINCIA_ID = CAN.PROVINCIA_ID AND
			CBR.CANTON_ID = CAN.CANTON_ID AND
			CBR.PERIODO_ID = $var_maximo_periodo";
  switch ($filterfield) {
    case "NOMBRE_PERIODO":
		$var_tmp = "PER.";
        break;
    case "NOMBRE_ORGANIZACION":
		$var_tmp = "ORG.";
        break;
    case "NOMBRE_PROVINCIA":
		$var_tmp = "PRO.";
        break;
    case "NOMBRE_CANTON":
		$var_tmp = "CAN.";
        break;
    default:
		$var_tmp = "CBR.";
	    break;
  }
  if (isset($filterstr) && $filterstr!='' && isset($filterfield) && $filterfield!='') {
    $sql .= " AND " .$var_tmp.sqlstr($filterfield) ." like '" .$filterstr ."'";
  } elseif (isset($filterstr) && $filterstr!='') {
    $sql .= " where (PERIODO_ID like '" .$filterstr ."') or (ORGANIZACION_ID like '" .$filterstr ."') or (PROVINCIA_ID like '" .$filterstr ."') or (CANTON_ID like '" .$filterstr ."') or (NUMERO_OFICINAS like '" .$filterstr ."') or (MONTO_CARTERA like '" .$filterstr ."') or (CLIENTES_ACTIVOS_CREDITOS like '" .$filterstr ."') or (ESTADO_ID like '" .$filterstr ."')";
  }
  if (isset($order) && $order!='') $sql .= " order by \"" .sqlstr($order) ."\"";
  if (isset($ordtype) && $ordtype!='') $sql .= " " .sqlstr($ordtype);
  $res = mssql_query($sql, $conn);
  return $res;
}

function sql_getrecordcount()
{
  global $conn;
  global $order;
  global $ordtype;
  global $filter;
  global $filterfield;
  global $wholeonly;

  $filterstr = sqlstr($filter);
  if (!$wholeonly && isset($wholeonly) && $filterstr!='') $filterstr = "%" .$filterstr ."%";
  $consulta="SELECT MAX(PERIODO_ID) AS MAXIMO_PERIODO FROM dbo.C_PERIODO";
  $resultado=ConsultarTabla($consulta);
  $var_maximo_periodo = mssql_result($resultado,0,"MAXIMO_PERIODO");
  $sql = "select count(*)
  			from
			dbo.C_COBERTURA_GEOGRAFICA CBR,
			dbo.C_PERIODO PER,
			dbo.C_ORGANIZACION ORG,
			dbo.C_PROVINCIA PRO,
			dbo.C_CANTON CAN
			WHERE
			CBR.PERIODO_ID = PER.PERIODO_ID AND
			CBR.ORGANIZACION_ID = ORG.ORGANIZACION_ID AND
			PRO.PROVINCIA_ID = CAN.PROVINCIA_ID AND
			CBR.PROVINCIA_ID = CAN.PROVINCIA_ID AND
			CBR.CANTON_ID = CAN.CANTON_ID AND
			CBR.PERIODO_ID = $var_maximo_periodo";
  switch ($filterfield) {
    case "NOMBRE_PERIODO":
		$var_tmp = "PER.";
        break;
    case "NOMBRE_ORGANIZACION":
		$var_tmp = "ORG.";
        break;
    case "NOMBRE_PROVINCIA":
		$var_tmp = "PRO.";
        break;
    case "NOMBRE_CANTON":
		$var_tmp = "CAN.";
        break;
    default:
		$var_tmp = "CBR.";
	    break;
  }
  if (isset($filterstr) && $filterstr!='' && isset($filterfield) && $filterfield!='') {
    $sql .= " AND " .$var_tmp.sqlstr($filterfield) ." like '" .$filterstr ."'";
  } elseif (isset($filterstr) && $filterstr!='') {
    $sql .= " where (PERIODO_ID like '" .$filterstr ."') or (ORGANIZACION_ID like '" .$filterstr ."') or (PROVINCIA_ID like '" .$filterstr ."') or (CANTON_ID like '" .$filterstr ."') or (NUMERO_OFICINAS like '" .$filterstr ."') or (MONTO_CARTERA like '" .$filterstr ."') or (CLIENTES_ACTIVOS_CREDITOS like '" .$filterstr ."') or (ESTADO_ID like '" .$filterstr ."')";
  }
  $res = mssql_query($sql, $conn);
  $row = mssql_fetch_assoc($res);
  reset($row);
  return current($row);
}

function sql_insert()
{
  global $conn;
  global $_POST;

//  $sql = "insert into dbo.C_COBERTURA_GEOGRAFICA (PERIODO_ID, ORGANIZACION_ID, PROVINCIA_ID, CANTON_ID, NUMERO_OFICINAS, MONTO_CARTERA, CLIENTES_ACTIVOS_CREDITOS, ESTADO_ID) values (" .sqlvalue(@$_POST["PERIODO_ID"], false) .", " .sqlvalue(@$_POST["ORGANIZACION_ID"], false) .", " .sqlvalue(@$_POST["PROVINCIA_ID"], false) .", " .sqlvalue(@$_POST["CANTON_ID"], false) .", " .sqlvalue(@$_POST["NUMERO_OFICINAS"], false) .", " .sqlvalue(@$_POST["MONTO_CARTERA"], false) .", " .sqlvalue(@$_POST["CLIENTES_ACTIVOS_CREDITOS"], false) .", " .sqlvalue(@$_POST["ESTADO_ID"], false) .")";
  $sql = "insert into dbo.C_COBERTURA_GEOGRAFICA (PERIODO_ID, ORGANIZACION_ID, PROVINCIA_ID, CANTON_ID, NUMERO_OFICINAS, MONTO_CARTERA, CLIENTES_ACTIVOS_CREDITOS, ESTADO_ID) values (" .sqlvalue(@$_POST["PERIODO_ID"], false) .", " .sqlvalue(@$_POST["ORGANIZACION_ID"], false) .", " .sqlvalue(@$_POST["paises"], false) .", " .sqlvalue(@$_POST["estados"], false) .", " .sqlvalue(@$_POST["NUMERO_OFICINAS"], false) .", " .sqlvalue(@$_POST["MONTO_CARTERA"], false) .", " .sqlvalue(@$_POST["CLIENTES_ACTIVOS_CREDITOS"], false) .", " .sqlvalue(@$_POST["ESTADO_ID"], false) .")";
  if (@mssql_query($sql, $conn) == false)
  {
    echo '<span class="Mensajes">NO SE GUARDO EL REGISTRO</span>';
	echo "<br></br>";
  }
}

function sql_update()
{
  global $conn;
  global $_POST;

//  $sql = "update dbo.C_COBERTURA_GEOGRAFICA set PERIODO_ID=" .sqlvalue(@$_POST["PERIODO_ID"], false) .", ORGANIZACION_ID=" .sqlvalue(@$_POST["ORGANIZACION_ID"], false) .", PROVINCIA_ID=" .sqlvalue(@$_POST["PROVINCIA_ID"], false) .", CANTON_ID=" .sqlvalue(@$_POST["CANTON_ID"], false) .", NUMERO_OFICINAS=" .sqlvalue(@$_POST["NUMERO_OFICINAS"], false) .", MONTO_CARTERA=" .sqlvalue(@$_POST["MONTO_CARTERA"], false) .", CLIENTES_ACTIVOS_CREDITOS=" .sqlvalue(@$_POST["CLIENTES_ACTIVOS_CREDITOS"], false) .", ESTADO_ID=" .sqlvalue(@$_POST["ESTADO_ID"], false) ." where " ."(PERIODO_ID=" .sqlvalue(@$_POST["xPERIODO_ID"], false) .") and (ORGANIZACION_ID=" .sqlvalue(@$_POST["xORGANIZACION_ID"], false) .") and (PROVINCIA_ID=" .sqlvalue(@$_POST["xPROVINCIA_ID"], false) .") and (CANTON_ID=" .sqlvalue(@$_POST["xCANTON_ID"], false) .")";
  $sql = "update dbo.C_COBERTURA_GEOGRAFICA set NUMERO_OFICINAS=" .sqlvalue(@$_POST["NUMERO_OFICINAS"], false) .", MONTO_CARTERA=" .sqlvalue(@$_POST["MONTO_CARTERA"], false) .", CLIENTES_ACTIVOS_CREDITOS=" .sqlvalue(@$_POST["CLIENTES_ACTIVOS_CREDITOS"], false) .", ESTADO_ID=" .sqlvalue(@$_POST["ESTADO_ID"], false) ." where " ."(PERIODO_ID=" .sqlvalue(@$_POST["xPERIODO_ID"], false) .") and (ORGANIZACION_ID=" .sqlvalue(@$_POST["xORGANIZACION_ID"], false) .") and (PROVINCIA_ID=" .sqlvalue(@$_POST["xPROVINCIA_ID"], false) .") and (CANTON_ID=" .sqlvalue(@$_POST["xCANTON_ID"], false) .")";
  if (@mssql_query($sql, $conn) == false)
  {
    echo '<span class="Mensajes">NO SE MODIFICO EL REGISTRO</span>';
	echo "<br></br>";
  }
}

function sql_delete()
{
  global $conn;
  global $_POST;
  $sql = "delete from dbo.C_COBERTURA_GEOGRAFICA where " ."(PERIODO_ID=" .sqlvalue(@$_POST["xPERIODO_ID"], false) .") and (ORGANIZACION_ID=" .sqlvalue(@$_POST["xORGANIZACION_ID"], false) .") and (PROVINCIA_ID=" .sqlvalue(@$_POST["xPROVINCIA_ID"], false) .") and (CANTON_ID=" .sqlvalue(@$_POST["xCANTON_ID"], false) .")";
  if (@mssql_query($sql, $conn) == false)
  {
    echo '<span class="Mensajes">NO SE ELIMINO EL REGISTRO</span>';
	echo "<br></br>";
  }
}
?>


<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer", {allowNegative:false,useCharacterMasking:true, validateOn:["blur"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "integer", {allowNegative:false,useCharacterMasking:true, validateOn:["blur"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "real", {allowNegative:false, validateOn:["blur"], minValue:0});
//-->
</script>
