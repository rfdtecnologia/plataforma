<? session_start(); ?>
<html>
<head>
<title>RFD -- dbo.C_ESTATUTO_JURIDICO_HISTORICO</title>
<meta name="generator" content="text/html">
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
	//"TIPO_ORGANIZACION_ID" => "TIPO_ORGANIZACION_ID",
    "NOMBRE_TIPO_ORGANIZACION" => "TIPO ORGANIZACION",
    //"ORGANIZACION_ID" => "ORGANIZACION_ID",
    "NOMBRE_ORGANIZACION" => "ORGANIZACION");
?>
<table class="bd" border="0" cellspacing="1" cellpadding="4">
<tr><td>TABLA: dbo.C_ESTATUTO_JURIDICO_HISTORICO</td></tr>
<tr><td>Records shown <? echo $startrec + 1 ?> - <? echo $reccount ?> of <? echo $count ?></td></tr>
</table>
<hr size="1" noshade>
<form action="C_ESTATUTO_JURIDICO_HISTORICO.php" method="post">
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
<td><a href="C_ESTATUTO_JURIDICO_HISTORICO.php?a=reset">Quitar Filtro</a></td>
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
<td class="hr"><a class="hr" href="C_ESTATUTO_JURIDICO_HISTORICO.php?order=<? echo $val ?>&type=<? echo $ordtypestr ?>"><? echo htmlspecialchars($caption) ?></a></td>
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
<td class="<? echo $style ?>"><a href="C_ESTATUTO_JURIDICO_HISTORICO.php?a=view&recid=<? echo $i ?>">Ver</a></td>
<td class="<? echo $style ?>"><a href="C_ESTATUTO_JURIDICO_HISTORICO.php?a=edit&recid=<? echo $i ?>">Editar</a></td>
<td class="<? echo $style ?>"><a href="C_ESTATUTO_JURIDICO_HISTORICO.php?a=del&recid=<? echo $i ?>">Borrar</a></td>
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
<td class="hr"><? echo htmlspecialchars("TIPO ORGANIZACION")."&nbsp;" ?></td>
<td class="dr"><? echo htmlspecialchars($row["TIPO_ORGANIZACION_ID"]) ?></td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("ORGANIZACION")."&nbsp;" ?></td>
<td class="dr"><? echo htmlspecialchars($row["ORGANIZACION_ID"]) ?></td>
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
<td class="dr"><select name="PERIODO_ID" disabled>
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
<td class="hr"><? echo htmlspecialchars("TIPO ORGANIZACION")."&nbsp;" ?></td>
<td class="dr"><select name="TIPO_ORGANIZACION_ID" disabled>
<?
  $sql = "select TIPO_ORGANIZACION_ID, NOMBRE_TIPO_ORGANIZACION from dbo.C_ESTATUTO_JURIDICO";
  $res = mssql_query($sql, $conn);

  while ($lp_row = mssql_fetch_assoc($res)){
  $val = $lp_row["TIPO_ORGANIZACION_ID"];
  $caption = $lp_row["NOMBRE_TIPO_ORGANIZACION"];
  if ($row["TIPO_ORGANIZACION_ID"] == $lp_row["TIPO_ORGANIZACION_ID"]) {$selstr = " selected"; } else {$selstr = ""; }
 ?><option value="<? echo $val ?>" disabled<? echo $selstr ?>><? echo $caption ?></option>
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
 ?><option value="<? echo $val ?>" disabled<? echo $selstr ?>><? echo $caption ?></option>
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
<td class="hr"><? echo htmlspecialchars("TIPO ORGANIZACION")."&nbsp;" ?></td>
<td class="dr"><select name="TIPO_ORGANIZACION_ID">
<?
  $sql = "select TIPO_ORGANIZACION_ID, NOMBRE_TIPO_ORGANIZACION from dbo.C_ESTATUTO_JURIDICO";
  $res = mssql_query($sql, $conn);

  while ($lp_row = mssql_fetch_assoc($res)){
  $val = $lp_row["TIPO_ORGANIZACION_ID"];
  $caption = $lp_row["NOMBRE_TIPO_ORGANIZACION"];
  if ($row["TIPO_ORGANIZACION_ID"] == $lp_row["TIPO_ORGANIZACION_ID"]) {$selstr = " selected"; } else {$selstr = ""; }
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
</table>
<? } ?>



<? function showpagenav($page, $pagecount)
{
?>
<table class="bd" border="0" cellspacing="1" cellpadding="4">
<tr>
<td><a href="C_ESTATUTO_JURIDICO_HISTORICO.php?a=add">Nuevo Registro</a>&nbsp;</td>
<? if ($page > 1) { ?>
<td><a href="C_ESTATUTO_JURIDICO_HISTORICO.php?page=<? echo $page - 1 ?>">&lt;&lt;&nbsp;Anterior</a>&nbsp;</td>
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
<td><a href="C_ESTATUTO_JURIDICO_HISTORICO.php?page=<? echo $j ?>"><? echo $j ?></a></td>
<? } } } else { ?>
<td><a href="C_ESTATUTO_JURIDICO_HISTORICO.php?page=<? echo $startpage ?>"><? echo $startpage ."..." .$count ?></a></td>
<? } } } ?>
<? if ($page < $pagecount) { ?>
<td>&nbsp;<a href="C_ESTATUTO_JURIDICO_HISTORICO.php?page=<? echo $page + 1 ?>">Siguiente&nbsp;&gt;&gt;</a>&nbsp;</td>
<? } ?>
</tr>
</table>
<? } ?>

<? function showrecnav($a, $recid, $count)
{
?>
<table class="bd" border="0" cellspacing="1" cellpadding="4">
<tr>
<td><a href="C_ESTATUTO_JURIDICO_HISTORICO.php">Pagina Principal</a></td>
<? if ($recid > 0) { ?>
<td><a href="C_ESTATUTO_JURIDICO_HISTORICO.php?a=<? echo $a ?>&recid=<? echo $recid - 1 ?>">Anterior Registro</a></td>
<? } if ($recid < $count) { ?>
<td><a href="C_ESTATUTO_JURIDICO_HISTORICO.php?a=<? echo $a ?>&recid=<? echo $recid + 1 ?>">Siguiente Registro</a></td>
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
<td><a href="C_ESTATUTO_JURIDICO_HISTORICO.php">Pagina Principal</a></td>
</tr>
</table>
<hr size="1" noshade>
<form action="C_ESTATUTO_JURIDICO_HISTORICO.php" method="post">
<p><input type="hidden" name="sql" value="insert"></p>
<?
$row = array(
  "PERIODO_ID" => "",
  "TIPO_ORGANIZACION_ID" => "",
  "ORGANIZACION_ID" => "");
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
<td><a href="C_ESTATUTO_JURIDICO_HISTORICO.php?a=add">Nuevo Registro</a></td>
<td><a href="C_ESTATUTO_JURIDICO_HISTORICO.php?a=edit&recid=<? echo $recid ?>">Editar Registro</a></td>
<td><a href="C_ESTATUTO_JURIDICO_HISTORICO.php?a=del&recid=<? echo $recid ?>">Borrar Registro</a></td>
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
<form action="C_ESTATUTO_JURIDICO_HISTORICO.php" method="post">
<input type="hidden" name="sql" value="update">
<input type="hidden" name="xPERIODO_ID" value="<? echo $row["PERIODO_ID"] ?>">
<input type="hidden" name="xTIPO_ORGANIZACION_ID" value="<? echo $row["TIPO_ORGANIZACION_ID"] ?>">
<input type="hidden" name="xORGANIZACION_ID" value="<? echo $row["ORGANIZACION_ID"] ?>">
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
<form action="C_ESTATUTO_JURIDICO_HISTORICO.php" method="post">
<input type="hidden" name="sql" value="delete">
<input type="hidden" name="xPERIODO_ID" value="<? echo $row["PERIODO_ID"] ?>">
<input type="hidden" name="xTIPO_ORGANIZACION_ID" value="<? echo $row["TIPO_ORGANIZACION_ID"] ?>">
<input type="hidden" name="xORGANIZACION_ID" value="<? echo $row["ORGANIZACION_ID"] ?>">
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
			convert(varchar(6),HIS.PERIODO_ID) AS PERIODO_ID,
			convert(varchar(30),PER.NOMBRE_PERIODO) AS NOMBRE_PERIODO,
			HIS.TIPO_ORGANIZACION_ID,
			convert(varchar(80),EST.NOMBRE_TIPO_ORGANIZACION) AS NOMBRE_TIPO_ORGANIZACION,
			HIS.ORGANIZACION_ID,
			convert(varchar(80),ORG.NOMBRE_ORGANIZACION) AS NOMBRE_ORGANIZACION
			from
			dbo.C_PERIODO PER,
			dbo.C_ESTATUTO_JURIDICO EST,
			dbo.C_ORGANIZACION ORG,
			dbo.C_ESTATUTO_JURIDICO_HISTORICO HIS
			WHERE
			HIS.PERIODO_ID = PER.PERIODO_ID AND
			HIS.TIPO_ORGANIZACION_ID = EST.TIPO_ORGANIZACION_ID AND
			HIS.ORGANIZACION_ID = ORG.ORGANIZACION_ID";
  switch ($filterfield) {
    case "NOMBRE_ORGANIZACION":
		$var_tmp = "ORG.";
        break;
    case "NOMBRE_TIPO_ORGANIZACION":
		$var_tmp = "EST.";
        break;
    case "NOMBRE_PERIODO":
		$var_tmp = "PER.";
        break;
    default:
		$var_tmp = "HIS.";
	    break;
  }
  if (isset($filterstr) && $filterstr!='' && isset($filterfield) && $filterfield!='') {
    $sql .= " AND " .$var_tmp.sqlstr($filterfield) ." like '" .$filterstr ."'";
  } elseif (isset($filterstr) && $filterstr!='') {
    $sql .= " where (PERIODO_ID like '" .$filterstr ."') or (TIPO_ORGANIZACION_ID like '" .$filterstr ."') or (ORGANIZACION_ID like '" .$filterstr ."')";
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
  $sql = "select
			COUNT (*)
			from
			dbo.C_PERIODO PER,
			dbo.C_ESTATUTO_JURIDICO EST,
			dbo.C_ORGANIZACION ORG,
			dbo.C_ESTATUTO_JURIDICO_HISTORICO HIS
			WHERE
			HIS.PERIODO_ID = PER.PERIODO_ID AND
			HIS.TIPO_ORGANIZACION_ID = EST.TIPO_ORGANIZACION_ID AND
			HIS.ORGANIZACION_ID = ORG.ORGANIZACION_ID";
  switch ($filterfield) {
    case "NOMBRE_ORGANIZACION":
		$var_tmp = "ORG.";
        break;
    case "NOMBRE_TIPO_ORGANIZACION":
		$var_tmp = "EST.";
        break;
    case "NOMBRE_PERIODO":
		$var_tmp = "PER.";
        break;
    default:
		$var_tmp = "HIS.";
	    break;
  }
  if (isset($filterstr) && $filterstr!='' && isset($filterfield) && $filterfield!='') {
    $sql .= " AND " .$var_tmp.sqlstr($filterfield) ." like '" .$filterstr ."'";
  } elseif (isset($filterstr) && $filterstr!='') {
    $sql .= " where (PERIODO_ID like '" .$filterstr ."') or (TIPO_ORGANIZACION_ID like '" .$filterstr ."') or (ORGANIZACION_ID like '" .$filterstr ."')";
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

  $sql = "insert into dbo.C_ESTATUTO_JURIDICO_HISTORICO (PERIODO_ID, TIPO_ORGANIZACION_ID, ORGANIZACION_ID) values (" .sqlvalue(@$_POST["PERIODO_ID"], false) .", " .sqlvalue(@$_POST["TIPO_ORGANIZACION_ID"], false) .", " .sqlvalue(@$_POST["ORGANIZACION_ID"], false) .")";

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

  /*  $sql = "update dbo.C_ESTATUTO_JURIDICO_HISTORICO set PERIODO_ID=" .sqlvalue(@$_POST["PERIODO_ID"], false) .", TIPO_ORGANIZACION_ID=" .sqlvalue(@$_POST["TIPO_ORGANIZACION_ID"], false) .", ORGANIZACION_ID=" .sqlvalue(@$_POST["ORGANIZACION_ID"], false) ." where " ."(PERIODO_ID=" .sqlvalue(@$_POST["xPERIODO_ID"], false) .") and (TIPO_ORGANIZACION_ID=" .sqlvalue(@$_POST["xTIPO_ORGANIZACION_ID"], false) .") and (ORGANIZACION_ID=" .sqlvalue(@$_POST["xORGANIZACION_ID"], false) .")";
  if (@mssql_query($sql, $conn) == false)
  {
  	echo "NO SE MODIFICO EL REGISTRO EL REGISTRO";
  }*/
}

function sql_delete()
{
  global $conn;
  global $_POST;

  $sql = "delete from dbo.C_ESTATUTO_JURIDICO_HISTORICO where " ."(PERIODO_ID=" .sqlvalue(@$_POST["xPERIODO_ID"], false) .") and (TIPO_ORGANIZACION_ID=" .sqlvalue(@$_POST["xTIPO_ORGANIZACION_ID"], false) .") and (ORGANIZACION_ID=" .sqlvalue(@$_POST["xORGANIZACION_ID"], false) .")";
  if (@mssql_query($sql, $conn) == false)
  {
    echo '<span class="Mensajes">NO SE ELIMINO EL REGISTRO</span>';
    echo "<br></br>";
  }
} ?>
