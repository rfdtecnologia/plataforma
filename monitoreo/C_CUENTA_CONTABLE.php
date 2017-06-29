<? session_start(); ?>
<html>
<head>
<title>RFD -- C_CUENTA_CONTABLE</title>
<meta name="generator" content="text/html">
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/HojasEstilos.css" rel="stylesheet" type="text/css">
<link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css">
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
    "CUENTA_CONTABLE_ID" => "CUENTA",
    "NOMBRE_CUENTA_CONTABLE" => "NOMBRE CUENTA",
    "TIPO_CUENTA_CONTABLE" => "TIPO CUENTA",
    "ESTATUS_CUENTA_CONTABLE" => "ESTADO CUENTA",
    "CUENTA_CON_PUNTOSLS" => "CUENTA CON PUNTOS",
    "PADRE_CUENTA_CONTABLE_ID" => "PADRE CUENTA",
    "NIVEL_CUENTA_ID" => "NIVEL CUENTA");
?>
<table class="bd" border="0" cellspacing="1" cellpadding="4">
<tr><td>TABLA: dbo.C_CUENTA_CONTABLE</td></tr>
<tr><td>Records shown <? echo $startrec + 1 ?> - <? echo $reccount ?> of <? echo $count ?></td></tr>
</table>
<hr size="1" noshade>
<form action="C_CUENTA_CONTABLE.php" method="post">
<table class="bd" border="0" cellspacing="1" cellpadding="4">
<tr>
<td><b>Escoja un Campo:</b>&nbsp;</td>
<td><input type="text" name="filter" value="<? echo $filter ?>"></td>
<td><select name="filter_field">
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
<td><a href="C_CUENTA_CONTABLE.php?a=reset">Quitar Filtro</a></td>
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
<td class="hr"><a class="hr" href="C_CUENTA_CONTABLE.php?order=<? echo $val ?>&type=<? echo $ordtypestr ?>"><? echo htmlspecialchars($caption) ?></a></td>
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
<td class="<? echo $style ?>"><a href="C_CUENTA_CONTABLE.php?a=view&recid=<? echo $i ?>">Ver</a></td>
<td class="<? echo $style ?>"><a href="C_CUENTA_CONTABLE.php?a=edit&recid=<? echo $i ?>">Editar</a></td>
<td class="<? echo $style ?>"><a href="C_CUENTA_CONTABLE.php?a=del&recid=<? echo $i ?>">Borrar</a></td>
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
<td class="hr"><? echo htmlspecialchars("CUENTA")."&nbsp;" ?></td>
<td class="dr"><? echo htmlspecialchars($row["CUENTA_CONTABLE_ID"]) ?></td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("NOMBRE CUENTA")."&nbsp;" ?></td>
<td class="dr"><? echo htmlspecialchars($row["NOMBRE_CUENTA_CONTABLE"]) ?></td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("TIPO CUENTA")."&nbsp;" ?></td>
<td class="dr"><? echo htmlspecialchars($row["TIPO_CUENTA_CONTABLE"]) ?></td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("ESTADO CUENTA")."&nbsp;" ?></td>
<td class="dr"><? echo htmlspecialchars($row["ESTATUS_CUENTA_CONTABLE"]) ?></td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("CUENTA CON PUNTOS")."&nbsp;" ?></td>
<td class="dr"><? echo htmlspecialchars($row["CUENTA_CON_PUNTOSLS"]) ?></td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("PADRE CUENTA")."&nbsp;" ?></td>
<td class="dr"><? echo htmlspecialchars($row["PADRE_CUENTA_CONTABLE_ID"]) ?></td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("NIVEL CUENTA")."&nbsp;" ?></td>
<td class="dr"><? echo htmlspecialchars($row["NIVEL_CUENTA_ID"]) ?></td>
</tr>
</table>
<? } ?>

<? function showroweditor($row)
  {
  global $conn;
?>
<table class="tbl" border="0" cellspacing="1" cellpadding="5"width="100%">
<tr>
<td class="hr"><? echo htmlspecialchars("CUENTA")."&nbsp;" ?></td>
<td class="dr">


<span id="sprytextfield1">
<input type="text" name="CUENTA_CONTABLE_ID" maxlength="15"  disabled value="<? echo str_replace('"', '&quot;', trim($row["CUENTA_CONTABLE_ID"])) ?>">
<span class="textfieldInvalidFormatMsg">Formato Incorrecto</span>
<span class="textfieldRequiredMsg">Obligatorio ingresar algun dato</span>
</span>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("NOMBRE CUENTA")."&nbsp;" ?></td>
<td class="dr">
<span id="sprytextarea1">
<label>
<textarea name="NOMBRE_CUENTA_CONTABLE" id="textarea1" cols="35" rows="2" maxlength="50"><? echo str_replace('"', '&quot;', trim($row["NOMBRE_CUENTA_CONTABLE"])) ?></textarea>
</label>
<span class="textareaRequiredMsg">Obligatorio ingresar algun dato</span></span>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("TIPO CUENTA")."&nbsp;" ?></td>
<td class="dr">
<span id="sprytextfield3">
<input type="text" name="TIPO_CUENTA_CONTABLE" maxlength="1" value="<? echo str_replace('"', '&quot;', trim($row["TIPO_CUENTA_CONTABLE"])) ?>">
<span class="textfieldInvalidFormatMsg">Formato Incorrecto</span>
<span class="textfieldRequiredMsg">Obligatorio ingresar algun dato</span>
</span>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("ESTADO CUENTA")."&nbsp;" ?></td>
<td class="dr">
<span id="sprytextfield4">
<input type="text" name="ESTATUS_CUENTA_CONTABLE" maxlength="1" value="<? echo str_replace('"', '&quot;', trim($row["ESTATUS_CUENTA_CONTABLE"])) ?>">
<span class="textfieldInvalidFormatMsg">Formato Incorrecto</span>
<span class="textfieldRequiredMsg">Obligatorio ingresar algun dato</span>
</span>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("CUENTA CON PUNTOS")."&nbsp;" ?></td>
<td class="dr">
<span id="sprytextfield5">
<input type="text" name="CUENTA_CON_PUNTOSLS" maxlength="50" value="<? echo str_replace('"', '&quot;', trim($row["CUENTA_CON_PUNTOSLS"])) ?>">
<span class="textfieldInvalidFormatMsg">Formato Incorrecto</span>
<span class="textfieldRequiredMsg">Obligatorio ingresar algun dato</span>
</span>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("PADRE CUENTA")."&nbsp;" ?></td>
<td class="dr">
<span id="sprytextfield7">
<input type="text" name="PADRE_CUENTA_CONTABLE_ID" maxlength="15" value="<? echo str_replace('"', '&quot;', trim($row["PADRE_CUENTA_CONTABLE_ID"])) ?>">
<span class="textfieldInvalidFormatMsg">Formato Incorrecto</span>
<span class="textfieldRequiredMsg">Obligatorio ingresar algun dato</span>
</span>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("NIVEL CUENTA")."&nbsp;" ?></td>
<td class="dr">
<span id="sprytextfield6">
<input type="text" name="NIVEL_CUENTA_ID" value="<? echo str_replace('"', '&quot;', trim($row["NIVEL_CUENTA_ID"])) ?>">
<span class="textfieldInvalidFormatMsg">Formato Incorrecto</span>
<span class="textfieldRequiredMsg">Obligatorio ingresar algun dato</span>
</span>
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
<td class="hr"><? echo htmlspecialchars("CUENTA")."&nbsp;" ?></td>
<td class="dr">
<span id="sprytextfield1">
<input type="text" name="CUENTA_CONTABLE_ID" maxlength="15" value="<? echo str_replace('"', '&quot;', trim($row["CUENTA_CONTABLE_ID"])) ?>">
<span class="textfieldInvalidFormatMsg">Formato Incorrecto</span>
<span class="textfieldRequiredMsg">Obligatorio ingresar algun dato</span>
</span>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("NOMBRE CUENTA")."&nbsp;" ?></td>
<td class="dr">
<span id="sprytextarea1">
<label>
<textarea name="NOMBRE_CUENTA_CONTABLE" id="textarea1" cols="35" rows="2" maxlength="50"><? echo str_replace('"', '&quot;', trim($row["NOMBRE_CUENTA_CONTABLE"])) ?></textarea>
</label>
<span class="textareaRequiredMsg">Obligatorio ingresar algun dato</span></span>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("TIPO CUENTA")."&nbsp;" ?></td>
<td class="dr">
<span id="sprytextfield3">
<input type="text" name="TIPO_CUENTA_CONTABLE" maxlength="1" value="<? echo str_replace('"', '&quot;', trim($row["TIPO_CUENTA_CONTABLE"])) ?>">
<span class="textfieldInvalidFormatMsg">Formato Incorrecto</span>
<span class="textfieldRequiredMsg">Obligatorio ingresar algun dato</span>
</span>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("ESTADO CUENTA")."&nbsp;" ?></td>
<td class="dr">
<span id="sprytextfield4">
<input type="text" name="ESTATUS_CUENTA_CONTABLE" maxlength="1" value="<? echo str_replace('"', '&quot;', trim($row["ESTATUS_CUENTA_CONTABLE"])) ?>">
<span class="textfieldInvalidFormatMsg">Formato Incorrecto</span>
<span class="textfieldRequiredMsg">Obligatorio ingresar algun dato</span>
</span>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("CUENTA CON PUNTOS")."&nbsp;" ?></td>
<td class="dr">
<span id="sprytextfield5">
<input type="text" name="CUENTA_CON_PUNTOSLS" maxlength="50" value="<? echo str_replace('"', '&quot;', trim($row["CUENTA_CON_PUNTOSLS"])) ?>">
<span class="textfieldInvalidFormatMsg">Formato Incorrecto</span>
<span class="textfieldRequiredMsg">Obligatorio ingresar algun dato</span>
</span>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("PADRE CUENTA")."&nbsp;" ?></td>
<td class="dr">
<span id="sprytextfield7">
<input type="text" name="PADRE_CUENTA_CONTABLE_ID" maxlength="15" value="<? echo str_replace('"', '&quot;', trim($row["PADRE_CUENTA_CONTABLE_ID"])) ?>">
<span class="textfieldInvalidFormatMsg">Formato Incorrecto</span>
<span class="textfieldRequiredMsg">Obligatorio ingresar algun dato</span>
</span>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("NIVEL CUENTA")."&nbsp;" ?></td>
<td class="dr">
<span id="sprytextfield6">
<input type="text" name="NIVEL_CUENTA_ID" value="<? echo str_replace('"', '&quot;', trim($row["NIVEL_CUENTA_ID"])) ?>">
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
<td><a href="C_CUENTA_CONTABLE.php?a=add">Nuevo Registro</a>&nbsp;</td>
<? if ($page > 1) { ?>
<td><a href="C_CUENTA_CONTABLE.php?page=<? echo $page - 1 ?>">&lt;&lt;&nbsp;Anterior</a>&nbsp;</td>
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
<td><a href="C_CUENTA_CONTABLE.php?page=<? echo $j ?>"><? echo $j ?></a></td>
<? } } } else { ?>
<td><a href="C_CUENTA_CONTABLE.php?page=<? echo $startpage ?>"><? echo $startpage ."..." .$count ?></a></td>
<? } } } ?>
<? if ($page < $pagecount) { ?>
<td>&nbsp;<a href="C_CUENTA_CONTABLE.php?page=<? echo $page + 1 ?>">Siguiente&nbsp;&gt;&gt;</a>&nbsp;</td>
<? } ?>
</tr>
</table>
<? } ?>

<? function showrecnav($a, $recid, $count)
{
?>
<table class="bd" border="0" cellspacing="1" cellpadding="4">
<tr>
<td><a href="C_CUENTA_CONTABLE.php">Pagina Principal</a></td>
<? if ($recid > 0) { ?>
<td><a href="C_CUENTA_CONTABLE.php?a=<? echo $a ?>&recid=<? echo $recid - 1 ?>">Anterior Registro</a></td>
<? } if ($recid < $count) { ?>
<td><a href="C_CUENTA_CONTABLE.php?a=<? echo $a ?>&recid=<? echo $recid + 1 ?>">Siguiente Registro</a></td>
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
<td><a href="C_CUENTA_CONTABLE.php">Pagina Principal</a></td>
</tr>
</table>
<hr size="1" noshade>
<form action="C_CUENTA_CONTABLE.php" method="post">
<p><input type="hidden" name="sql" value="insert"></p>
<?
$row = array(
  "CUENTA_CONTABLE_ID" => "",
  "NOMBRE_CUENTA_CONTABLE" => "",
  "TIPO_CUENTA_CONTABLE" => "",
  "ESTATUS_CUENTA_CONTABLE" => "",
  "CUENTA_CON_PUNTOSLS" => "",
  "PADRE_CUENTA_CONTABLE_ID" => "",
  "NIVEL_CUENTA_ID" => "");
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
<td><a href="C_CUENTA_CONTABLE.php?a=add">Nuevo Registro</a></td>
<td><a href="C_CUENTA_CONTABLE.php?a=edit&recid=<? echo $recid ?>">Editar Registro</a></td>
<td><a href="C_CUENTA_CONTABLE.php?a=del&recid=<? echo $recid ?>">Borrar Registro</a></td>
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
<form action="C_CUENTA_CONTABLE.php" method="post">
<input type="hidden" name="sql" value="update">
<input type="hidden" name="xCUENTA_CONTABLE_ID" value="<? echo $row["CUENTA_CONTABLE_ID"] ?>">
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
<form action="C_CUENTA_CONTABLE.php" method="post">
<input type="hidden" name="sql" value="delete">
<input type="hidden" name="xCUENTA_CONTABLE_ID" value="<? echo $row["CUENTA_CONTABLE_ID"] ?>">
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
			CONVERT(VARCHAR(15),CUENTA_CONTABLE_ID) AS CUENTA_CONTABLE_ID,
			CONVERT(VARCHAR(50),NOMBRE_CUENTA_CONTABLE) AS NOMBRE_CUENTA_CONTABLE,
			CONVERT(VARCHAR(1),TIPO_CUENTA_CONTABLE) AS TIPO_CUENTA_CONTABLE,
			CONVERT(VARCHAR(1),ESTATUS_CUENTA_CONTABLE) AS ESTATUS_CUENTA_CONTABLE,
			CONVERT(VARCHAR(50),CUENTA_CON_PUNTOSLS) AS CUENTA_CON_PUNTOSLS,
			CONVERT(VARCHAR(15),PADRE_CUENTA_CONTABLE_ID) AS PADRE_CUENTA_CONTABLE_ID,
			CONVERT(VARCHAR(9),NIVEL_CUENTA_ID) AS  NIVEL_CUENTA_ID
			from
			dbo.C_CUENTA_CONTABLE";
  if (isset($filterstr) && $filterstr!='' && isset($filterfield) && $filterfield!='') {
    $sql .= " where " .sqlstr($filterfield) ." like '" .$filterstr ."'";
  } elseif (isset($filterstr) && $filterstr!='') {
    $sql .= " where (CUENTA_CONTABLE_ID like '" .$filterstr ."') or (NOMBRE_CUENTA_CONTABLE like '" .$filterstr ."') or (TIPO_CUENTA_CONTABLE like '" .$filterstr ."') or (ESTATUS_CUENTA_CONTABLE like '" .$filterstr ."') or (CUENTA_CON_PUNTOSLS like '" .$filterstr ."') or (PADRE_CUENTA_CONTABLE_ID like '" .$filterstr ."') or (NIVEL_CUENTA_ID like '" .$filterstr ."')";
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
  $sql = "select count(*) from dbo.C_CUENTA_CONTABLE";
  if (isset($filterstr) && $filterstr!='' && isset($filterfield) && $filterfield!='') {
    $sql .= " where " .sqlstr($filterfield) ." like '" .$filterstr ."'";
  } elseif (isset($filterstr) && $filterstr!='') {
    $sql .= " where (CUENTA_CONTABLE_ID like '" .$filterstr ."') or (NOMBRE_CUENTA_CONTABLE like '" .$filterstr ."') or (TIPO_CUENTA_CONTABLE like '" .$filterstr ."') or (ESTATUS_CUENTA_CONTABLE like '" .$filterstr ."') or (CUENTA_CON_PUNTOSLS like '" .$filterstr ."') or (PADRE_CUENTA_CONTABLE_ID like '" .$filterstr ."') or (NIVEL_CUENTA_ID like '" .$filterstr ."')";
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

  $sql = "insert into dbo.C_CUENTA_CONTABLE (CUENTA_CONTABLE_ID, NOMBRE_CUENTA_CONTABLE, TIPO_CUENTA_CONTABLE, ESTATUS_CUENTA_CONTABLE, CUENTA_CON_PUNTOSLS, PADRE_CUENTA_CONTABLE_ID, NIVEL_CUENTA_ID) values (" .sqlvalue(@$_POST["CUENTA_CONTABLE_ID"], true) .", " .sqlvalue(@$_POST["NOMBRE_CUENTA_CONTABLE"], true) .", " .sqlvalue(@$_POST["TIPO_CUENTA_CONTABLE"], true) .", " .sqlvalue(@$_POST["ESTATUS_CUENTA_CONTABLE"], true) .", " .sqlvalue(@$_POST["CUENTA_CON_PUNTOSLS"], true) .", " .sqlvalue(@$_POST["PADRE_CUENTA_CONTABLE_ID"], true) .", " .sqlvalue(@$_POST["NIVEL_CUENTA_ID"], false) .")";
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

  //$sql = "update dbo.C_CUENTA_CONTABLE set CUENTA_CONTABLE_ID=" .sqlvalue(@$_POST["CUENTA_CONTABLE_ID"], true) .", NOMBRE_CUENTA_CONTABLE=" .sqlvalue(@$_POST["NOMBRE_CUENTA_CONTABLE"], true) .", TIPO_CUENTA_CONTABLE=" .sqlvalue(@$_POST["TIPO_CUENTA_CONTABLE"], true) .", ESTATUS_CUENTA_CONTABLE=" .sqlvalue(@$_POST["ESTATUS_CUENTA_CONTABLE"], true) .", CUENTA_CON_PUNTOSLS=" .sqlvalue(@$_POST["CUENTA_CON_PUNTOSLS"], true) .", PADRE_CUENTA_CONTABLE_ID=" .sqlvalue(@$_POST["PADRE_CUENTA_CONTABLE_ID"], true) .", NIVEL_CUENTA_ID=" .sqlvalue(@$_POST["NIVEL_CUENTA_ID"], false) ." where " ."(CUENTA_CONTABLE_ID=" .sqlvalue(@$_POST["xCUENTA_CONTABLE_ID"], true) .")";
  $sql = "update dbo.C_CUENTA_CONTABLE set NOMBRE_CUENTA_CONTABLE=" .sqlvalue(@$_POST["NOMBRE_CUENTA_CONTABLE"], true) .", TIPO_CUENTA_CONTABLE=" .sqlvalue(@$_POST["TIPO_CUENTA_CONTABLE"], true) .", ESTATUS_CUENTA_CONTABLE=" .sqlvalue(@$_POST["ESTATUS_CUENTA_CONTABLE"], true) .", CUENTA_CON_PUNTOSLS=" .sqlvalue(@$_POST["CUENTA_CON_PUNTOSLS"], true) .", PADRE_CUENTA_CONTABLE_ID=" .sqlvalue(@$_POST["PADRE_CUENTA_CONTABLE_ID"], true) .", NIVEL_CUENTA_ID=" .sqlvalue(@$_POST["NIVEL_CUENTA_ID"], false) ." where " ."(CUENTA_CONTABLE_ID=" .sqlvalue(@$_POST["xCUENTA_CONTABLE_ID"], true) .")";
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

  $sql = "delete from dbo.C_CUENTA_CONTABLE where " ."(CUENTA_CONTABLE_ID=" .sqlvalue(@$_POST["xCUENTA_CONTABLE_ID"], true) .")";
  if (@mssql_query($sql, $conn) == false)
  {
    echo '<span class="Mensajes">NO SE ELIMINO EL REGISTRO</span>';
    echo "<br></br>";
  }
  } ?>

<script type="text/javascript">
<!--
	var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {validateOn:["blur"]});
	var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer", {allowNegative:false,validateOn:["blur"], useCharacterMasking:true});
	var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "custom",{format:"custom",pattern:"X",validateOn:["blur"], useCharacterMasking:true});
	var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "custom",{format:"custom",pattern:"X",validateOn:["blur"], useCharacterMasking:true});
	var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "none",{validateOn:["blur"]});
	var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "custom", {allowNegative:false, validateOn:["blur"], useCharacterMasking:true, pattern:"0"});
	var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "integer", {allowNegative:false,isrequerid:false, validateOn:["blur"], useCharacterMasking:true, isRequired:false});
//-->
</script>
