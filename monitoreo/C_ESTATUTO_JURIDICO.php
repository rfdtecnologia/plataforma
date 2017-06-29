<? session_start(); ?>
<html>
<head>
<title>RFD -- C_ESTATUTO_JURIDICO</title>
<meta name="generator" content="text/html">
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css">
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
    "TIPO_ORGANIZACION_ID" => "TIPO ORGANIZACION",
    "NOMBRE_TIPO_ORGANIZACION" => "NOMBRE TIPO ORGANIZACION",
    "MIEMBRO_comunicarse con RFD" => "MIEMBRO RFR",
    "FIN_DE_LUCRO_ID" => "FIN DE LUCRO",
    "INTERMEDIACION_ID" => "INTERMEDIACION",
    "ORDEN" => "ORDEN");
?>
<table class="bd" border="0" cellspacing="1" cellpadding="4">
<tr><td>C_ESTATUTO_JURIDICO</td></tr>
<tr><td>Registros <? echo $startrec + 1 ?> - <? echo $reccount ?> de <? echo $count ?></td></tr>
</table>
<hr size="1" noshade>
<form action="C_ESTATUTO_JURIDICO.php" method="post">
<table class="bd" border="0" cellspacing="1" cellpadding="4">
<tr>
<td><b>Escoja Un Campo:</b>&nbsp;</td>
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
<td><a href="C_ESTATUTO_JURIDICO.php?a=reset">Quitar Filtro</a></td>
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
<td class="hr"><a class="hr" href="C_ESTATUTO_JURIDICO.php?order=<? echo $val ?>&type=<? echo $ordtypestr ?>"><? echo htmlspecialchars($caption) ?></a></td>
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
<td class="<? echo $style ?>"><a href="C_ESTATUTO_JURIDICO.php?a=view&recid=<? echo $i ?>">Ver</a></td>
<td class="<? echo $style ?>"><a href="C_ESTATUTO_JURIDICO.php?a=edit&recid=<? echo $i ?>">Editar</a></td>
<td class="<? echo $style ?>"><a href="C_ESTATUTO_JURIDICO.php?a=del&recid=<? echo $i ?>">Borrar</a></td>
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
<td class="hr"><? echo htmlspecialchars("TIPO ORGANIZACION")."&nbsp;" ?></td>
<td class="dr"><? echo htmlspecialchars($row["TIPO_ORGANIZACION_ID"]) ?></td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("NOMBRE TIPO ORGANIZACION")."&nbsp;" ?></td>
<td class="dr"><? echo htmlspecialchars($row["NOMBRE_TIPO_ORGANIZACION"]) ?></td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("MIEMBRO RFR")."&nbsp;" ?></td>
<td class="dr"><? echo htmlspecialchars($row["MIEMBRO_RFR"]) ?></td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("FIN DE LUCRO")."&nbsp;" ?></td>
<td class="dr"><? echo htmlspecialchars($row["FIN_DE_LUCRO_ID"]) ?></td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("INTERMEDIACION")."&nbsp;" ?></td>
<td class="dr"><? echo htmlspecialchars($row["INTERMEDIACION_ID"]) ?></td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("ORDEN")."&nbsp;" ?></td>
<td class="dr"><? echo htmlspecialchars($row["ORDEN"]) ?></td>
</tr>
</table>
<? } ?>

<? function showrowadd($row)
  {
  global $conn;
?>
<table class="tbl" border="0" cellspacing="1" cellpadding="5"width="100%">
<!--<tr>
<td class="hr"><? echo htmlspecialchars("TIPO ORGANIZACION")."&nbsp;" ?></td>
<td class="dr"><input type="text" name="TIPO_ORGANIZACION_ID" value="<? echo str_replace('"', '&quot;', trim($row["TIPO_ORGANIZACION_ID"])) ?>"></td>
</tr>-->
<tr>
<td class="hr"><? echo htmlspecialchars("NOMBRE TIPO ORGANIZACION")."&nbsp;" ?></td>
<td class="dr">
<span id="sprytextarea1">
<label>
<textarea name="NOMBRE_TIPO_ORGANIZACION" id="textarea1" cols="35" rows="3" maxlength="80"><? echo str_replace('"', '&quot;', trim($row["NOMBRE_TIPO_ORGANIZACION"])) ?></textarea>
</label>
<span class="textareaRequiredMsg">Obligatorio ingresar algun dato</span></span>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("MIEMBRO RFR")."&nbsp;" ?></td>
<td class="dr"><select name="MIEMBRO_RFR">
<?
  $sql = "select RESPUESTA_ID, NOMBRE_RESPUESTA from dbo.C_RESPUESTA";
  $res = mssql_query($sql, $conn);

  while ($lp_row = mssql_fetch_assoc($res)){
  $val = $lp_row["RESPUESTA_ID"];
  $caption = $lp_row["NOMBRE_RESPUESTA"];
  if ($row["MIEMBRO_RFR"] == $lp_row["RESPUESTA_ID"]) {$selstr = " selected"; } else {$selstr = ""; }
 ?><option value="<? echo $val ?>"<? echo $selstr ?>><? echo $caption ?></option>
<? } ?></select>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("FIN DE LUCRO")."&nbsp;" ?></td>
<td class="dr"><select name="FIN_DE_LUCRO_ID">
<?
  $sql = "select FIN_DE_LUCRO_ID, NOMBRE_FIN_DE_LUCRO from dbo.C_LUCRO";
  $res = mssql_query($sql, $conn);

  while ($lp_row = mssql_fetch_assoc($res)){
  $val = $lp_row["FIN_DE_LUCRO_ID"];
  $caption = $lp_row["NOMBRE_FIN_DE_LUCRO"];
  if ($row["FIN_DE_LUCRO_ID"] == $lp_row["FIN_DE_LUCRO_ID"]) {$selstr = " selected"; } else {$selstr = ""; }
 ?><option value="<? echo $val ?>"<? echo $selstr ?>><? echo $caption ?></option>
<? } ?></select>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("INTERMEDIACION")."&nbsp;" ?></td>
<td class="dr"><select name="INTERMEDIACION_ID">
<?
  $sql = "select INTERMEDIACION_ID, NOMBRE_INTERMEDIACION from dbo.C_INTERMEDIACION";
  $res = mssql_query($sql, $conn);

  while ($lp_row = mssql_fetch_assoc($res)){
  $val = $lp_row["INTERMEDIACION_ID"];
  $caption = $lp_row["NOMBRE_INTERMEDIACION"];
  if ($row["INTERMEDIACION_ID"] == $lp_row["INTERMEDIACION_ID"]) {$selstr = " selected"; } else {$selstr = ""; }
 ?><option value="<? echo $val ?>"<? echo $selstr ?>><? echo $caption ?></option>
<? } ?></select>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("ORDEN")."&nbsp;" ?></td>
<td class="dr">
<span id="sprytextfield1">
<input type="text" name="ORDEN" value="<? echo str_replace('"', '&quot;', trim($row["ORDEN"])) ?>">
<span class="textfieldInvalidFormatMsg">Formato Incorrecto</span>
<span class="textfieldRequiredMsg">Obligatorio ingresar algun dato</span>
</span>
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
<td class="hr"><? echo htmlspecialchars("TIPO ORGANIZACION")."&nbsp;" ?></td>
<td class="dr"><input type="text" disabled name="TIPO_ORGANIZACION_ID" value="<? echo str_replace('"', '&quot;', trim($row["TIPO_ORGANIZACION_ID"])) ?>"></td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("NOMBRE TIPO ORGANIZACION")."&nbsp;" ?></td>
<td class="dr">
<span id="sprytextarea1">
<label>
<textarea name="NOMBRE_TIPO_ORGANIZACION" id="textarea1" cols="35" rows="3" maxlength="80"><? echo str_replace('"', '&quot;', trim($row["NOMBRE_TIPO_ORGANIZACION"])) ?></textarea>
</label>
<span class="textareaRequiredMsg">Obligatorio ingresar algun dato</span></span>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("MIEMBRO RFR")."&nbsp;" ?></td>
<td class="dr"><select name="MIEMBRO_RFR">
<?
  $sql = "select RESPUESTA_ID, NOMBRE_RESPUESTA from dbo.C_RESPUESTA";
  $res = mssql_query($sql, $conn);

  while ($lp_row = mssql_fetch_assoc($res)){
  $val = $lp_row["RESPUESTA_ID"];
  $caption = $lp_row["NOMBRE_RESPUESTA"];
  if ($row["MIEMBRO_RFR"] == $lp_row["RESPUESTA_ID"]) {$selstr = " selected"; } else {$selstr = ""; }
 ?><option value="<? echo $val ?>"<? echo $selstr ?>><? echo $caption ?></option>
<? } ?></select>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("FIN DE LUCRO")."&nbsp;" ?></td>
<td class="dr"><select name="FIN_DE_LUCRO_ID">
<?
  $sql = "select FIN_DE_LUCRO_ID, NOMBRE_FIN_DE_LUCRO from dbo.C_LUCRO";
  $res = mssql_query($sql, $conn);

  while ($lp_row = mssql_fetch_assoc($res)){
  $val = $lp_row["FIN_DE_LUCRO_ID"];
  $caption = $lp_row["NOMBRE_FIN_DE_LUCRO"];
  if ($row["FIN_DE_LUCRO_ID"] == $lp_row["FIN_DE_LUCRO_ID"]) {$selstr = " selected"; } else {$selstr = ""; }
 ?><option value="<? echo $val ?>"<? echo $selstr ?>><? echo $caption ?></option>
<? } ?></select>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("INTERMEDIACION")."&nbsp;" ?></td>
<td class="dr"><select name="INTERMEDIACION_ID">
<?
  $sql = "select INTERMEDIACION_ID, NOMBRE_INTERMEDIACION from dbo.C_INTERMEDIACION";
  $res = mssql_query($sql, $conn);

  while ($lp_row = mssql_fetch_assoc($res)){
  $val = $lp_row["INTERMEDIACION_ID"];
  $caption = $lp_row["NOMBRE_INTERMEDIACION"];
  if ($row["INTERMEDIACION_ID"] == $lp_row["INTERMEDIACION_ID"]) {$selstr = " selected"; } else {$selstr = ""; }
 ?><option value="<? echo $val ?>"<? echo $selstr ?>><? echo $caption ?></option>
<? } ?></select>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("ORDEN")."&nbsp;" ?></td>
<td class="dr">
<span id="sprytextfield1">
<input type="text" name="ORDEN" value="<? echo str_replace('"', '&quot;', trim($row["ORDEN"])) ?>">
<span class="textfieldInvalidFormatMsg">Formato Incorrecto</span>
<span class="textfieldRequiredMsg">Obligatorio ingresar algun dato</span>
</span>
</td>
</tr>
</table>
<? } ?>

<? function showpagenav($page, $pagecount)
{
?>
<table class="bd" border="0" cellspacing="1" cellpadding="4">
<tr>
<td><a href="C_ESTATUTO_JURIDICO.php?a=add" class="btn new blue2">Nuevo Registro</a>&nbsp;</td>
<? if ($page > 1) { ?>
<td><a href="C_ESTATUTO_JURIDICO.php?page=<? echo $page - 1 ?>">&lt;&lt;&nbsp;Anterior</a>&nbsp;</td>
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
<td><a href="C_ESTATUTO_JURIDICO.php?page=<? echo $j ?>"><? echo $j ?></a></td>
<? } } } else { ?>
<td><a href="C_ESTATUTO_JURIDICO.php?page=<? echo $startpage ?>"><? echo $startpage ."..." .$count ?></a></td>
<? } } } ?>
<? if ($page < $pagecount) { ?>
<td>&nbsp;<a href="C_ESTATUTO_JURIDICO.php?page=<? echo $page + 1 ?>">Siguiente&nbsp;&gt;&gt;</a>&nbsp;</td>
<? } ?>
</tr>
</table>
<? } ?>

<? function showrecnav($a, $recid, $count)
{
?>
<table class="bd" border="0" cellspacing="1" cellpadding="4">
<tr>
<td><a class="btn new blue2" href="C_ESTATUTO_JURIDICO.php">Pagina Principal</a></td>
<? if ($recid > 0) { ?>
<td><a href="C_ESTATUTO_JURIDICO.php?a=<? echo $a ?>&recid=<? echo $recid - 1 ?>">Anterior Registro</a></td>
<? } if ($recid < $count) { ?>
<td><a href="C_ESTATUTO_JURIDICO.php?a=<? echo $a ?>&recid=<? echo $recid + 1 ?>">Siguiente Registro</a></td>
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
<td><a class="btn new blue2" href="C_ESTATUTO_JURIDICO.php">Pagina Principal</a></td>
</tr>
</table>
<hr size="1" noshade>
<form action="C_ESTATUTO_JURIDICO.php" method="post">
<p><input type="hidden" name="sql" value="insert"></p>
<?
$row = array(
  "TIPO_ORGANIZACION_ID" => "",
  "NOMBRE_TIPO_ORGANIZACION" => "",
  "MIEMBRO_RFR" => "",
  "FIN_DE_LUCRO_ID" => "",
  "INTERMEDIACION_ID" => "",
  "ORDEN" => "");
showrowadd($row)
?>
<p><input type="submit" name="action" class="btn save green"  value="Guardar"></p>
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
<td><a class="btn new blue2" href="C_ESTATUTO_JURIDICO.php?a=add">Nuevo Registro</a></td>
<td><a class="btn edit dark" href="C_ESTATUTO_JURIDICO.php?a=edit&recid=<? echo $recid ?>">Editar Registro</a></td>
<td><a class="btn dele red" href="C_ESTATUTO_JURIDICO.php?a=del&recid=<? echo $recid ?>">Borrar Registro</a></td>
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
<form action="C_ESTATUTO_JURIDICO.php" method="post">
<input type="hidden" name="sql" value="update">
<input type="hidden" name="xTIPO_ORGANIZACION_ID" value="<? echo $row["TIPO_ORGANIZACION_ID"] ?>">
<? showroweditor($row) ?>
<p><input type="submit" name="action" class="btn save green" value="Guardar"></p>
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
<form action="C_ESTATUTO_JURIDICO.php" method="post">
<input type="hidden" name="sql" value="delete">
<input type="hidden" name="xTIPO_ORGANIZACION_ID" value="<? echo $row["TIPO_ORGANIZACION_ID"] ?>">
<? showrow($row) ?>
<p><input type="submit" name="action" class="btn save green" value="Confirmar"></p>
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
  $sql = "select TIPO_ORGANIZACION_ID, NOMBRE_TIPO_ORGANIZACION, MIEMBRO_RFR, FIN_DE_LUCRO_ID, INTERMEDIACION_ID, ORDEN from dbo.C_ESTATUTO_JURIDICO";
  if (isset($filterstr) && $filterstr!='' && isset($filterfield) && $filterfield!='') {
    $sql .= " where " .sqlstr($filterfield) ." like '" .$filterstr ."'";
  } elseif (isset($filterstr) && $filterstr!='') {
    $sql .= " where (TIPO_ORGANIZACION_ID like '" .$filterstr ."') or (NOMBRE_TIPO_ORGANIZACION like '" .$filterstr ."') or (MIEMBRO_RFR like '" .$filterstr ."') or (FIN_DE_LUCRO_ID like '" .$filterstr ."') or (INTERMEDIACION_ID like '" .$filterstr ."') or (ORDEN like '" .$filterstr ."')";
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
  $sql = "select count(*) from dbo.C_ESTATUTO_JURIDICO";
  if (isset($filterstr) && $filterstr!='' && isset($filterfield) && $filterfield!='') {
    $sql .= " where " .sqlstr($filterfield) ." like '" .$filterstr ."'";
  } elseif (isset($filterstr) && $filterstr!='') {
    $sql .= " where (TIPO_ORGANIZACION_ID like '" .$filterstr ."') or (NOMBRE_TIPO_ORGANIZACION like '" .$filterstr ."') or (MIEMBRO_RFR like '" .$filterstr ."') or (FIN_DE_LUCRO_ID like '" .$filterstr ."') or (INTERMEDIACION_ID like '" .$filterstr ."') or (ORDEN like '" .$filterstr ."')";
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

/*   $sql = "insert into dbo.C_ESTATUTO_JURIDICO (TIPO_ORGANIZACION_ID, NOMBRE_TIPO_ORGANIZACION, MIEMBRO_RFR, FIN_DE_LUCRO_ID, INTERMEDIACION_ID, ORDEN) values (" .sqlvalue(@$_POST["TIPO_ORGANIZACION_ID"], false) .", " .sqlvalue(@$_POST["NOMBRE_TIPO_ORGANIZACION"], true) .", " .sqlvalue(@$_POST["MIEMBRO_RFR"], true) .", " .sqlvalue(@$_POST["FIN_DE_LUCRO_ID"], true) .", " .sqlvalue(@$_POST["INTERMEDIACION_ID"], true) .", " .sqlvalue(@$_POST["ORDEN"], false) .")"; */

  $sql = "insert into dbo.C_ESTATUTO_JURIDICO (NOMBRE_TIPO_ORGANIZACION, MIEMBRO_RFR, FIN_DE_LUCRO_ID, INTERMEDIACION_ID, ORDEN) values (" .sqlvalue(@$_POST["NOMBRE_TIPO_ORGANIZACION"], true) .", " .sqlvalue(@$_POST["MIEMBRO_RFR"], true) .", " .sqlvalue(@$_POST["FIN_DE_LUCRO_ID"], true) .", " .sqlvalue(@$_POST["INTERMEDIACION_ID"], true) .", " .sqlvalue(@$_POST["ORDEN"], false) .")";

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

/*   $sql = "update dbo.C_ESTATUTO_JURIDICO set TIPO_ORGANIZACION_ID=" .sqlvalue(@$_POST["TIPO_ORGANIZACION_ID"], false) .", NOMBRE_TIPO_ORGANIZACION=" .sqlvalue(@$_POST["NOMBRE_TIPO_ORGANIZACION"], true) .", MIEMBRO_RFR=" .sqlvalue(@$_POST["MIEMBRO_RFR"], true) .", FIN_DE_LUCRO_ID=" .sqlvalue(@$_POST["FIN_DE_LUCRO_ID"], true) .", INTERMEDIACION_ID=" .sqlvalue(@$_POST["INTERMEDIACION_ID"], true) .", ORDEN=" .sqlvalue(@$_POST["ORDEN"], false) ." where " ."(TIPO_ORGANIZACION_ID=" .sqlvalue(@$_POST["xTIPO_ORGANIZACION_ID"], false) .")"; */

  $sql = "update dbo.C_ESTATUTO_JURIDICO set NOMBRE_TIPO_ORGANIZACION=" .sqlvalue(@$_POST["NOMBRE_TIPO_ORGANIZACION"], true) .", MIEMBRO_RFR=" .sqlvalue(@$_POST["MIEMBRO_RFR"], true) .", FIN_DE_LUCRO_ID=" .sqlvalue(@$_POST["FIN_DE_LUCRO_ID"], true) .", INTERMEDIACION_ID=" .sqlvalue(@$_POST["INTERMEDIACION_ID"], true) .", ORDEN=" .sqlvalue(@$_POST["ORDEN"], false) ." where " ."(TIPO_ORGANIZACION_ID=" .sqlvalue(@$_POST["xTIPO_ORGANIZACION_ID"], false) .")";

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

  $sql = "delete from dbo.C_ESTATUTO_JURIDICO where " ."(TIPO_ORGANIZACION_ID=" .sqlvalue(@$_POST["xTIPO_ORGANIZACION_ID"], false) .")";
  if (@mssql_query($sql, $conn) == false)
  {
    echo '<span class="Mensajes">NO SE ELIMINO EL REGISTRO</span>';
    echo "<br></br>";
  }

} ?>

<script type="text/javascript">
<!--
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {validateOn:["blur"]});
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer",{allowNegative:false,validateOn:["blur"], useCharacterMasking:true});
//-->
</script>
