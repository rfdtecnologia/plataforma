<? session_start(); ?>
<html>
<head>
<title>RFD -- C_TASA</title>
<meta name="generator" content="text/html">
<link href="SpryAssets/HojasEstilos.css" rel="stylesheet" type="text/css">
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
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

<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "real", {validateOn:["blur"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "real", {validateOn:["blur"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "real", {validateOn:["blur"]});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "real", {validateOn:["blur"]});
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "real", {validateOn:["blur"]});
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "real", {validateOn:["blur"]});
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "real", {validateOn:["blur"]});
var sprytextfield8 = new Spry.Widget.ValidationTextField("sprytextfield8", "real", {validateOn:["blur"]});
//-->
</script>
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
    "NOMBRE_PERIODO" => "NOMBRE DEL PERIODO",
    "TASA_MERCADO" => "TASA DE MERCADO",
    "INFLACION" => "INFLACION",
    "RESERVA_NORMAL" => "RESERVA NORMAL",
    "RESERVA_POTENCIAL" => "RESERVA POTENCIAL",
    "RESERVA_DEFICIENTE" => "RESERVA DEFICIENTE",
    "RESERVA_DUDOSO_RECAUDO" => "RESERVA DUDOSO RECAUDO",
    "RESERVA_PERDIDA" => "RESERVA PERDIDA",
    "RESERVA_VARIOS" => "RESERVA VARIOS");
?>
<table class="bd" border="0" cellspacing="1" cellpadding="4">
<tr><td>TABLA: dbo.C_TASA</td></tr>
<tr><td>Records shown <? echo $startrec + 1 ?> - <? echo $reccount ?> of <? echo $count ?></td></tr>
</table>
<hr size="1" noshade>
<form action="C_TASA.php" method="post">
<table class="bd" border="0" cellspacing="1" cellpadding="4">
<tr>
<td><b>Escoja un Campo:</b>&nbsp;</td>
<td><input type="text" name="filter" value="<? echo $filter ?>"></td>
<td><select name="filter_field">
<!--<option value="">Todos los Campos</option>-->
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
<td><a href="C_TASA.php?a=reset">Quitar Filtro</a></td>
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
<td class="hr"><a class="hr" href="C_TASA.php?order=<? echo $val ?>&type=<? echo $ordtypestr ?>"><? echo htmlspecialchars($caption) ?></a></td>
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
<td class="<? echo $style ?>"><a href="C_TASA.php?a=view&recid=<? echo $i ?>">Ver</a></td>
<td class="<? echo $style ?>"><a href="C_TASA.php?a=edit&recid=<? echo $i ?>">Editar</a></td>
<td class="<? echo $style ?>"><a href="C_TASA.php?a=del&recid=<? echo $i ?>">Borrar</a></td>
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
<td class="hr"><? echo htmlspecialchars("TASA DE MERCADO")."&nbsp;" ?></td>
<td class="dr"><? echo htmlspecialchars($row["TASA_MERCADO"]) ?></td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("INFLACION")."&nbsp;" ?></td>
<td class="dr"><? echo htmlspecialchars($row["INFLACION"]) ?></td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("RESERVA NORMAL")."&nbsp;" ?></td>
<td class="dr"><? echo htmlspecialchars($row["RESERVA_NORMAL"]) ?></td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("RESERVA POTENCIAL")."&nbsp;" ?></td>
<td class="dr"><? echo htmlspecialchars($row["RESERVA_POTENCIAL"]) ?></td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("RESERVA DEFICIENTE")."&nbsp;" ?></td>
<td class="dr"><? echo htmlspecialchars($row["RESERVA_DEFICIENTE"]) ?></td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("RESERVA DUDOSO RECAUDO")."&nbsp;" ?></td>
<td class="dr"><? echo htmlspecialchars($row["RESERVA_DUDOSO_RECAUDO"]) ?></td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("RESERVA PERDIDA")."&nbsp;" ?></td>
<td class="dr"><? echo htmlspecialchars($row["RESERVA_PERDIDA"]) ?></td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("RESERVA VARIOS")."&nbsp;" ?></td>
<td class="dr"><? echo htmlspecialchars($row["RESERVA_VARIOS"]) ?></td>
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
  $sql = "select PERIODO_ID, NOMBRE_PERIODO from dbo.C_PERIODO order by PERIODO_ID desc";
  $res = mssql_query($sql, $conn);

  while ($lp_row = mssql_fetch_assoc($res)){
  $val = $lp_row["PERIODO_ID"];
  $caption = $lp_row["NOMBRE_PERIODO"];
  if ($row["PERIODO_ID"] == $lp_row["PERIODO_ID"]) {$selstr = " selected"; } else {$selstr = ""; }
 ?><option value="<? echo $val ?>" <? echo $selstr ?>><? echo $caption ?></option>
<? } ?></select>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("TASA DE MERCADO")."&nbsp;" ?></td>

<td class="dr">
<span id="sprytextfield1">
  <input name="TASA_MERCADO" type="text" value="<? echo str_replace('"', '&quot;', trim($row["TASA_MERCADO"])) ?>" size="35">
<span class="textfieldRequiredMsg">Obligatorio ingresar algun dato</span><span class="textfieldInvalidFormatMsg">Formato Incorrecto</span></span></td></tr>
<tr>
<td class="hr"><? echo htmlspecialchars("INFLACION")."&nbsp;" ?></td>
<td class="dr">
<span id="sprytextfield2">
  <input name="INFLACION" type="text" value="<? echo str_replace('"', '&quot;', trim($row["INFLACION"])) ?>" size="35">
<span class="textfieldRequiredMsg">Obligatorio ingresar algun dato</span><span class="textfieldInvalidFormatMsg">Formato Incorrecto</span></span></td></tr>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("RESERVA NORMAL")."&nbsp;" ?></td>
<td class="dr">
<span id="sprytextfield3">
  <input name="RESERVA_NORMAL" type="text" value="<? echo str_replace('"', '&quot;', trim($row["RESERVA_NORMAL"])) ?>" size="35">
<span class="textfieldRequiredMsg">Obligatorio ingresar algun dato</span><span class="textfieldInvalidFormatMsg">Formato Incorrecto</span></span></td></tr>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("RESERVA POTENCIAL")."&nbsp;" ?></td>
<td class="dr">
<span id="sprytextfield4">
  <input name="RESERVA_POTENCIAL" type="text" value="<? echo str_replace('"', '&quot;', trim($row["RESERVA_POTENCIAL"])) ?>" size="35">
<span class="textfieldRequiredMsg">Obligatorio ingresar algun dato</span><span class="textfieldInvalidFormatMsg">Formato Incorrecto</span></span></td></tr>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("RESERVA DEFICIENTE")."&nbsp;" ?></td>
<td class="dr">
<span id="sprytextfield5">
  <input name="RESERVA_DEFICIENTE" type="text" value="<? echo str_replace('"', '&quot;', trim($row["RESERVA_DEFICIENTE"])) ?>" size="35">
<span class="textfieldRequiredMsg">Obligatorio ingresar algun dato</span><span class="textfieldInvalidFormatMsg">Formato Incorrecto</span></span></td></tr>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("RESERVA DUDOSO RECAUDO")."&nbsp;" ?></td>
<td class="dr">
<span id="sprytextfield6">
  <input name="RESERVA_DUDOSO_RECAUDO" type="text" value="<? echo str_replace('"', '&quot;', trim($row["RESERVA_DUDOSO_RECAUDO"])) ?>" size="35">
<span class="textfieldRequiredMsg">Obligatorio ingresar algun dato</span><span class="textfieldInvalidFormatMsg">Formato Incorrecto</span></span></td></tr>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("RESERVA PERDIDA")."&nbsp;" ?></td>
<td class="dr">
<span id="sprytextfield7">
  <input name="RESERVA_PERDIDA" type="text" value="<? echo str_replace('"', '&quot;', trim($row["RESERVA_PERDIDA"])) ?>" size="35">
<span class="textfieldRequiredMsg">Obligatorio ingresar algun dato</span><span class="textfieldInvalidFormatMsg">Formato Incorrecto</span></span></td></tr>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("RESERVA VARIOS")."&nbsp;" ?></td>
<td class="dr">
<span id="sprytextfield8">
  <input name="RESERVA_VARIOS" type="text" value="<? echo str_replace('"', '&quot;', trim($row["RESERVA_VARIOS"])) ?>" size="35">
<span class="textfieldRequiredMsg">Obligatorio ingresar algun dato</span><span class="textfieldInvalidFormatMsg">Formato Incorrecto</span></span></td></tr>
</td>
</tr>
</table>
<? } ?>

<? function showroweditor($row)
  {
  global $conn;
?>
<table class="tbl" border="0" cellspacing="1" cellpadding="5"width="100%">
<tr>
<td class="hr"><? echo htmlspecialchars("PERIODO")."&nbsp;" ?></td>
<td class="dr"><select name="PERIODO_ID">
<?
  $sql = "select PERIODO_ID, NOMBRE_PERIODO from dbo.C_PERIODO";
  $res = mssql_query($sql, $conn);

  while ($lp_row = mssql_fetch_assoc($res)){
  $val = $lp_row["PERIODO_ID"];
  $caption = $lp_row["NOMBRE_PERIODO"];
  if ($row["PERIODO_ID"] == $lp_row["PERIODO_ID"]) {$selstr = " selected"; } else {$selstr = ""; }
 ?><option value="<? echo $val ?>" disabled<? echo $selstr ?>><? echo $caption ?></option>
<? } ?></select>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("TASA DE MERCADO")."&nbsp;" ?></td>

<td class="dr">
<span id="sprytextfield1">
  <input name="TASA_MERCADO" type="text" value="<? echo str_replace('"', '&quot;', trim($row["TASA_MERCADO"])) ?>" size="35">
<span class="textfieldRequiredMsg">Obligatorio ingresar algun dato</span><span class="textfieldInvalidFormatMsg">Formato Incorrecto</span></span></td></tr>
<tr>
<td class="hr"><? echo htmlspecialchars("INFLACION")."&nbsp;" ?></td>
<td class="dr">
<span id="sprytextfield2">
  <input name="INFLACION" type="text" value="<? echo str_replace('"', '&quot;', trim($row["INFLACION"])) ?>" size="35">
<span class="textfieldRequiredMsg">Obligatorio ingresar algun dato</span><span class="textfieldInvalidFormatMsg">Formato Incorrecto</span></span></td></tr>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("RESERVA NORMAL")."&nbsp;" ?></td>
<td class="dr">
<span id="sprytextfield3">
  <input name="RESERVA_NORMAL" type="text" value="<? echo str_replace('"', '&quot;', trim($row["RESERVA_NORMAL"])) ?>" size="35">
<span class="textfieldRequiredMsg">Obligatorio ingresar algun dato</span><span class="textfieldInvalidFormatMsg">Formato Incorrecto</span></span></td></tr>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("RESERVA POTENCIAL")."&nbsp;" ?></td>
<td class="dr">
<span id="sprytextfield4">
  <input name="RESERVA_POTENCIAL" type="text" value="<? echo str_replace('"', '&quot;', trim($row["RESERVA_POTENCIAL"])) ?>" size="35">
<span class="textfieldRequiredMsg">Obligatorio ingresar algun dato</span><span class="textfieldInvalidFormatMsg">Formato Incorrecto</span></span></td></tr>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("RESERVA DEFICIENTE")."&nbsp;" ?></td>
<td class="dr">
<span id="sprytextfield5">
  <input name="RESERVA_DEFICIENTE" type="text" value="<? echo str_replace('"', '&quot;', trim($row["RESERVA_DEFICIENTE"])) ?>" size="35">
<span class="textfieldRequiredMsg">Obligatorio ingresar algun dato</span><span class="textfieldInvalidFormatMsg">Formato Incorrecto</span></span></td></tr>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("RESERVA DUDOSO RECAUDO")."&nbsp;" ?></td>
<td class="dr">
<span id="sprytextfield6">
  <input name="RESERVA_DUDOSO_RECAUDO" type="text" value="<? echo str_replace('"', '&quot;', trim($row["RESERVA_DUDOSO_RECAUDO"])) ?>" size="35">
<span class="textfieldRequiredMsg">Obligatorio ingresar algun dato</span><span class="textfieldInvalidFormatMsg">Formato Incorrecto</span></span></td></tr>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("RESERVA PERDIDA")."&nbsp;" ?></td>
<td class="dr">
<span id="sprytextfield7">
  <input name="RESERVA_PERDIDA" type="text" value="<? echo str_replace('"', '&quot;', trim($row["RESERVA_PERDIDA"])) ?>" size="35">
<span class="textfieldRequiredMsg">Obligatorio ingresar algun dato</span><span class="textfieldInvalidFormatMsg">Formato Incorrecto</span></span></td></tr>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("RESERVA VARIOS")."&nbsp;" ?></td>
<td class="dr">
<span id="sprytextfield8">
  <input name="RESERVA_VARIOS" type="text" value="<? echo str_replace('"', '&quot;', trim($row["RESERVA_VARIOS"])) ?>" size="35">
<span class="textfieldRequiredMsg">Obligatorio ingresar algun dato</span><span class="textfieldInvalidFormatMsg">Formato Incorrecto</span></span></td></tr>
</td>
</tr>
</table>
<? } ?>


<? function showpagenav($page, $pagecount)
{
?>
<table class="bd" border="0" cellspacing="1" cellpadding="4">
<tr>
<td><a href="C_TASA.php?a=add">Nuevo Registro</a>&nbsp;</td>
<? if ($page > 1) { ?>
<td><a href="C_TASA.php?page=<? echo $page - 1 ?>">&lt;&lt;&nbsp;Anterior</a>&nbsp;</td>
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
<td><a href="C_TASA.php?page=<? echo $j ?>"><? echo $j ?></a></td>
<? } } } else { ?>
<td><a href="C_TASA.php?page=<? echo $startpage ?>"><? echo $startpage ."..." .$count ?></a></td>
<? } } } ?>
<? if ($page < $pagecount) { ?>
<td>&nbsp;<a href="C_TASA.php?page=<? echo $page + 1 ?>">Siguiente&nbsp;&gt;&gt;</a>&nbsp;</td>
<? } ?>
</tr>
</table>
<? } ?>

<? function showrecnav($a, $recid, $count)
{
?>
<table class="bd" border="0" cellspacing="1" cellpadding="4">
<tr>
<td><a href="C_TASA.php">Pagina Principal</a></td>
<? if ($recid > 0) { ?>
<td><a href="C_TASA.php?a=<? echo $a ?>&recid=<? echo $recid - 1 ?>">Anterior Registro</a></td>
<? } if ($recid < $count) { ?>
<td><a href="C_TASA.php?a=<? echo $a ?>&recid=<? echo $recid + 1 ?>">Siguiente Registro</a></td>
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
<td><a href="C_TASA.php">Pagina Principal</a></td>
</tr>
</table>
<hr size="1" noshade>
<form action="C_TASA.php" method="post">
<p><input type="hidden" name="sql" value="insert"></p>
<?
$row = array(
  "PERIODO_ID" => "",
  "TASA_MERCADO" => "",
  "INFLACION" => "",
  "RESERVA_NORMAL" => "",
  "RESERVA_POTENCIAL" => "",
  "RESERVA_DEFICIENTE" => "",
  "RESERVA_DUDOSO_RECAUDO" => "",
  "RESERVA_PERDIDA" => "",
  "RESERVA_VARIOS" => "");
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
<td><a href="C_TASA.php?a=add">Nuevo Registro</a></td>
<td><a href="C_TASA.php?a=edit&recid=<? echo $recid ?>">Editar Registro</a></td>
<td><a href="C_TASA.php?a=del&recid=<? echo $recid ?>">Borrar Registro</a></td>
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
<form action="C_TASA.php" method="post">
<input type="hidden" name="sql" value="update">
<input type="hidden" name="xPERIODO_ID" value="<? echo $row["PERIODO_ID"] ?>">
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
<form action="C_TASA.php" method="post">
<input type="hidden" name="sql" value="delete">
<input type="hidden" name="xPERIODO_ID" value="<? echo $row["PERIODO_ID"] ?>">
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
  $sql = "select
  			CONVERT(VARCHAR(6),TAS.PERIODO_ID) AS PERIODO_ID,
			CONVERT(VARCHAR(30),PER.NOMBRE_PERIODO) AS NOMBRE_PERIODO,
			CONVERT(VARCHAR(10),TAS.TASA_MERCADO) AS TASA_MERCADO,
			CONVERT(VARCHAR(10),TAS.INFLACION) AS INFLACION,
			CONVERT(VARCHAR(10),TAS.RESERVA_NORMAL) as RESERVA_NORMAL,
			CONVERT(VARCHAR(10),TAS.RESERVA_POTENCIAL) as RESERVA_POTENCIAL,
			CONVERT(VARCHAR(10),TAS.RESERVA_DEFICIENTE) as RESERVA_DEFICIENTE,
			CONVERT(VARCHAR(10),TAS.RESERVA_DUDOSO_RECAUDO) as RESERVA_DUDOSO_RECAUDO,
			CONVERT(VARCHAR(10),TAS.RESERVA_PERDIDA) as RESERVA_PERDIDA,
			CONVERT(VARCHAR(10),TAS.RESERVA_VARIOS) as RESERVA_VARIOS
			from
			dbo.C_TASA TAS,
			dbo.C_PERIODO PER
			where
			tas.PERIODO_ID = per.PERIODO_ID";
  switch ($filterfield) {
    case "NOMBRE_PERIODO":
		$var_tmp = "PER.";
        break;
    default:
		$var_tmp = "TAS.";
        break;
  }
  if (isset($filterstr) && $filterstr!='' && isset($filterfield) && $filterfield!='') {
    $sql .= " AND " .$var_tmp.sqlstr($filterfield) ." like '" .$filterstr ."'";
  } elseif (isset($filterstr) && $filterstr!='') {
    $sql .= " where (PERIODO_ID like '" .$filterstr ."') or (TASA_MERCADO like '" .$filterstr ."') or (INFLACION like '" .$filterstr ."') or (RESERVA_NORMAL like '" .$filterstr ."') or (RESERVA_POTENCIAL like '" .$filterstr ."') or (RESERVA_DEFICIENTE like '" .$filterstr ."') or (RESERVA_DUDOSO_RECAUDO like '" .$filterstr ."') or (RESERVA_PERDIDA like '" .$filterstr ."') or (RESERVA_VARIOS like '" .$filterstr ."')";
  }
  if (isset($order) && $order!='') $sql .= " order by \"" .sqlstr($order) ."\"";
  if (isset($ordtype) && $ordtype!='') $sql .= " " .sqlstr($ordtype);
  if ($order == '' and $ordtype == '')
  {
  	$sql = $sql." order by PERIODO_ID desc";
  }
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
  $sql = "select count(*)
			from
			dbo.C_TASA tas,
			dbo.C_PERIODO per
			where
			tas.PERIODO_ID = per.PERIODO_ID";
  switch ($filterfield) {
    case "NOMBRE_PERIODO":
		$var_tmp = "PER.";
        break;
    default:
		$var_tmp = "TAS.";
        break;
  }
  if (isset($filterstr) && $filterstr!='' && isset($filterfield) && $filterfield!='') {
    $sql .= " AND " .$var_tmp.sqlstr($filterfield) ." like '" .$filterstr ."'";
  } elseif (isset($filterstr) && $filterstr!='') {
    $sql .= " where (PERIODO_ID like '" .$filterstr ."') or (TASA_MERCADO like '" .$filterstr ."') or (INFLACION like '" .$filterstr ."') or (RESERVA_NORMAL like '" .$filterstr ."') or (RESERVA_POTENCIAL like '" .$filterstr ."') or (RESERVA_DEFICIENTE like '" .$filterstr ."') or (RESERVA_DUDOSO_RECAUDO like '" .$filterstr ."') or (RESERVA_PERDIDA like '" .$filterstr ."') or (RESERVA_VARIOS like '" .$filterstr ."')";
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

  $sql = "insert into dbo.C_TASA (PERIODO_ID, TASA_MERCADO, INFLACION, RESERVA_NORMAL, RESERVA_POTENCIAL, RESERVA_DEFICIENTE, RESERVA_DUDOSO_RECAUDO, RESERVA_PERDIDA, RESERVA_VARIOS) values (" .sqlvalue(@$_POST["PERIODO_ID"], false) .", " .sqlvalue(@$_POST["TASA_MERCADO"], false) .", " .sqlvalue(@$_POST["INFLACION"], false) .", " .sqlvalue(@$_POST["RESERVA_NORMAL"], false) .", " .sqlvalue(@$_POST["RESERVA_POTENCIAL"], false) .", " .sqlvalue(@$_POST["RESERVA_DEFICIENTE"], false) .", " .sqlvalue(@$_POST["RESERVA_DUDOSO_RECAUDO"], false) .", " .sqlvalue(@$_POST["RESERVA_PERDIDA"], false) .", " .sqlvalue(@$_POST["RESERVA_VARIOS"], false) .")";
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

  $sql = "update dbo.C_TASA set TASA_MERCADO=" .sqlvalue(@$_POST["TASA_MERCADO"], false) .", INFLACION=" .sqlvalue(@$_POST["INFLACION"], false) .", RESERVA_NORMAL=" .sqlvalue(@$_POST["RESERVA_NORMAL"], false) .", RESERVA_POTENCIAL=" .sqlvalue(@$_POST["RESERVA_POTENCIAL"], false) .", RESERVA_DEFICIENTE=" .sqlvalue(@$_POST["RESERVA_DEFICIENTE"], false) .", RESERVA_DUDOSO_RECAUDO=" .sqlvalue(@$_POST["RESERVA_DUDOSO_RECAUDO"], false) .", RESERVA_PERDIDA=" .sqlvalue(@$_POST["RESERVA_PERDIDA"], false) .", RESERVA_VARIOS=" .sqlvalue(@$_POST["RESERVA_VARIOS"], false) ." where " ."(PERIODO_ID=" .sqlvalue(@$_POST["xPERIODO_ID"], false) .")";
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

  $sql = "delete from dbo.C_TASA where " ."(PERIODO_ID=" .sqlvalue(@$_POST["xPERIODO_ID"], false) .")";
  if (@mssql_query($sql, $conn) == false)
  {
    echo '<span class="Mensajes">NO SE ELIMINO EL REGISTRO</span>';
    echo "<br></br>";
  }
} ?>
