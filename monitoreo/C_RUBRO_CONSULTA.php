<? session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html>
<head>
<title>RFD -- C_RUBRO_CONSULTA</title>
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
<div align="center"><a href="MenuPrincipal.php" class="btn_menu">Menu Principal</a></div>
<table width="100%" border="0">
  <tr>
  	<?php
	$var_imagen = "../imagenes/".$_SESSION["var_organizacion"].".jpg";
	$var_titulo = "RUBROS";
	$var_logo_ancho = $_SESSION["var_logo_ancho"];
	$var_logo_alto = $_SESSION["var_logo_alto"];
	if (empty($_SESSION["var_web_organizacion"]))
	{
		?><td width="50%" height="102"><div align="left"><img src="<?php echo $var_imagen; ?>" alt="" width="<?php echo $var_logo_ancho?>" height="<?php echo $var_logo_alto?>" /></a></div></td><?php
	}
	else
	{
		echo '<td width="50%" height="102"><div align="left"><a href="'.$_SESSION["var_web_organizacion"].'" target="_blank"><img src="'.$var_imagen.'" alt="" width="'.$var_logo_ancho.'" height="'.$var_logo_alto.'" /></a></a></div></td>';
	}
	?>
	<td width="0%">
	  <p align="center" class="Mensajes"><?php echo $var_titulo; ?></p>
	</td>
	<td width="50%"><div align="right"><a href="http://www.rfr.org.ec/" target="_blank"><img src="../imagenes/logo_rfr.jpg" alt="" width="95" height="95" /></a></div></td>
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
      sql_insert_identity();
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
    "NOMBRE_GRUPO" => "GRUPO RUBRO",
//   "RUBRO_ID" => "RUBRO",
    "NOMBRE_RUBRO" => "NOMBRE RUBRO",
    "DESCRIPCION_RUBRO" => "DESCRIPCION RUBRO",
    "DESCRIPCION_CUENTA_CONTABLE" => "DESCRIPCION CUENTA CONTABLE"
//    "GRUPO_ID" => "GRUPO_ID",
//    "SECUENCIAL_DESPLIEGUE_RUBRO" => "ORDEN RUBRO",
//    "ESTADO_ID" => "ESTADO",
//    "TIPO_RUBRO" => "TIPO RUBRO"
	);
?>
<table class="bd" border="0" cellspacing="1" cellpadding="4">
<!--<tr><td>TABLA: dbo.C_RUBRO</td></tr>
<tr><td>Records shown <? echo $startrec + 1 ?> - <? echo $reccount ?> of <? echo $count ?></td></tr>
-->
</table>
<hr size="1" noshade>
<form action="C_RUBRO_CONSULTA.php" method="post">
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
<td><a href="C_RUBRO_CONSULTA.php?a=reset">Quitar Filtro</a></td>
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
<td class="hr"><a class="hr" href="C_RUBRO_CONSULTA.php?order=<? echo $val ?>&type=<? echo $ordtypestr ?>"><? echo htmlspecialchars($caption) ?></a></td>
<? } ?>
<!--<td class="hr">&nbsp;</td>
<td class="hr">&nbsp;</td>
<td class="hr">&nbsp;</td>-->
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
<!--<td class="<? echo $style ?>"><a href="C_RUBRO_CONSULTA.php?a=view&recid=<? echo $i ?>">Ver</a></td>
<td class="<? echo $style ?>"><a href="C_RUBRO_CONSULTA.php?a=edit&recid=<? echo $i ?>">Editar</a></td>
<td class="<? echo $style ?>"><a href="C_RUBRO_CONSULTA.php?a=del&recid=<? echo $i ?>">Borrar</a></td>-->
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
<td class="hr"><? echo htmlspecialchars("RUBRO")."&nbsp;" ?></td>
<td class="dr"><? echo htmlspecialchars($row["RUBRO_ID"]) ?></td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("NOMBRE RUBRO")."&nbsp;" ?></td>
<td class="dr"><? echo htmlspecialchars($row["NOMBRE_RUBRO"]) ?></td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("DESCRIPCION RUBRO")."&nbsp;" ?></td>
<td class="dr"><? echo htmlspecialchars($row["DESCRIPCION_RUBRO"]) ?></td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("DESCRIPCION CUENTA CONTABLE")."&nbsp;" ?></td>
<td class="dr"><? echo htmlspecialchars($row["DESCRIPCION_CUENTA_CONTABLE"]) ?></td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("TIPO RUBRO")."&nbsp;" ?></td>
<td class="dr"><? echo htmlspecialchars($row["TIPO_RUBRO"]) ?></td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("ORDEN RUBRO")."&nbsp;" ?></td>
<td class="dr"><? echo htmlspecialchars($row["SECUENCIAL_DESPLIEGUE_RUBRO"]) ?></td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("GRUPO RUBRO")."&nbsp;" ?></td>
<td class="dr"><? echo htmlspecialchars($row["GRUPO_ID"]) ?></td>
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
?>
<table class="tbl" border="0" cellspacing="1" cellpadding="5"width="100%">
<tr>
<td class="hr"><? echo htmlspecialchars("RUBRO")."&nbsp;" ?></td>
<td class="dr">
<input type="text" name="RUBRO_ID" disabled = "true" value="<? echo str_replace('"', '&quot;', trim($row["RUBRO_ID"])) ?>">
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("NOMBRE RUBRO")."&nbsp;" ?></td>
<td class="dr">
<span id="sprytextarea1">
<label>
<textarea name="NOMBRE_RUBRO" id="textarea1" cols="35" rows="3" maxlength="80"><? echo str_replace('"', '&quot;', trim($row["NOMBRE_RUBRO"])) ?></textarea>
</label>
<span class="textareaRequiredMsg">Obligatorio ingresar algun dato</span></span>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("DESCRIPCION RUBRO")."&nbsp;" ?></td>
<td class="dr">
<span id="sprytextarea2">
<label>
<textarea name="DESCRIPCION_RUBRO" id="textarea1" cols="50" rows="4" maxlength="255"><? echo str_replace('"', '&quot;', trim($row["DESCRIPCION_RUBRO"])) ?></textarea>
</label>
<span class="textareaRequiredMsg">Obligatorio ingresar algun dato</span></span>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("DESCRIPCION CUENTA CONTABLE")."&nbsp;" ?></td>
<td class="dr">
<span id="sprytextarea3">
<label>
<textarea name="DESCRIPCION_CUENTA_CONTABLE" id="textarea1" cols="50" rows="4" maxlength="200"><? echo str_replace('"', '&quot;', trim($row["DESCRIPCION_CUENTA_CONTABLE"])) ?></textarea>
</label>
<span class="textareaRequiredMsg">Obligatorio ingresar algun dato</span></span>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("TIPO RUBRO")."&nbsp;" ?></td>
<td class="dr">
<span id="sprytextfield2">
<input type="text" name="TIPO_RUBRO" maxlength="1" disabled value="<? echo str_replace('"', '&quot;', trim($row["TIPO_RUBRO"])) ?>">
<span class="textfieldInvalidFormatMsg">Formato Incorrecto</span>
<span class="textfieldRequiredMsg">Obligatorio ingresar algun dato</span>
</span>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("ORDEN RUBRO")."&nbsp;" ?></td>
<td class="dr">
<span id="sprytextfield3">
<input type="text" name="SECUENCIAL_DESPLIEGUE_RUBRO" value="<? echo str_replace('"', '&quot;', trim($row["SECUENCIAL_DESPLIEGUE_RUBRO"])) ?>">
<span class="textfieldInvalidFormatMsg">Formato Incorrecto</span>
<span class="textfieldRequiredMsg">Obligatorio ingresar algun dato</span>
</span>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("GRUPO RUBRO")."&nbsp;" ?></td>
<td class="dr"><select name="GRUPO_ID">
<?
  $sql = "select GRUPO_ID, NOMBRE_GRUPO from dbo.C_GRUPO";
  $res = mssql_query($sql, $conn);

  while ($lp_row = mssql_fetch_assoc($res)){
  $val = $lp_row["GRUPO_ID"];
  $caption = $lp_row["NOMBRE_GRUPO"];
  if ($row["GRUPO_ID"] == $lp_row["GRUPO_ID"]) {$selstr = " selected"; } else {$selstr = ""; }
 ?><option value="<? echo $val ?>"<? echo $selstr ?>><? echo $caption ?></option>
<? } ?></select>
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
<!-- <tr>
<td class="hr"><? echo htmlspecialchars("RUBRO")."&nbsp;" ?></td>
<td class="dr">
<input type="text" name="RUBRO_ID" disabled = "true" value="<? echo str_replace('"', '&quot;', trim($row["RUBRO_ID"])) ?>">
</td>
</tr> -->
<tr>
<td class="hr"><? echo htmlspecialchars("NOMBRE RUBRO")."&nbsp;" ?></td>
<td class="dr">
<span id="sprytextarea1">
<label>
<textarea name="NOMBRE_RUBRO" id="textarea1" cols="35" rows="3" maxlength="80"><? echo str_replace('"', '&quot;', trim($row["NOMBRE_RUBRO"])) ?></textarea>
</label>
<span class="textareaRequiredMsg">Obligatorio ingresar algun dato</span></span>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("DESCRIPCION RUBRO")."&nbsp;" ?></td>
<td class="dr">
<span id="sprytextarea2">
<label>
<textarea name="DESCRIPCION_RUBRO" id="textarea1" cols="50" rows="4" maxlength="500"><? echo str_replace('"', '&quot;', trim($row["DESCRIPCION_RUBRO"])) ?></textarea>
</label>
<span class="textareaRequiredMsg">Obligatorio ingresar algun dato</span></span>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("DESCRIPCION CUENTA CONTABLE")."&nbsp;" ?></td>
<td class="dr">
<span id="sprytextarea3">
<label>
<textarea name="DESCRIPCION_CUENTA_CONTABLE" id="textarea1" cols="50" rows="4" maxlength="200"><? echo str_replace('"', '&quot;', trim($row["DESCRIPCION_CUENTA_CONTABLE"])) ?></textarea>
</label>
<span class="textareaRequiredMsg">Obligatorio ingresar algun dato</span></span>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("TIPO RUBRO")."&nbsp;" ?></td>
<td class="dr">
<span id="sprytextfield2">
<input type="text" name="TIPO_RUBRO" maxlength="1" disabled value="<? echo str_replace('"', '&quot;', trim($row["TIPO_RUBRO"])) ?>">
<span class="textfieldInvalidFormatMsg">Formato Incorrecto</span>
<span class="textfieldRequiredMsg">Obligatorio ingresar algun dato</span>
</span>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("ORDEN RUBRO")."&nbsp;" ?></td>
<td class="dr">
<span id="sprytextfield3">
<input type="text" name="SECUENCIAL_DESPLIEGUE_RUBRO" value="<? echo str_replace('"', '&quot;', trim($row["SECUENCIAL_DESPLIEGUE_RUBRO"])) ?>">
<span class="textfieldInvalidFormatMsg">Formato Incorrecto</span>
<span class="textfieldRequiredMsg">Obligatorio ingresar algun dato</span>
</span>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("GRUPO RUBRO")."&nbsp;" ?></td>
<td class="dr"><select name="GRUPO_ID">
<?
  $sql = "select GRUPO_ID, NOMBRE_GRUPO from dbo.C_GRUPO";
  $res = mssql_query($sql, $conn);

  while ($lp_row = mssql_fetch_assoc($res)){
  $val = $lp_row["GRUPO_ID"];
  $caption = $lp_row["NOMBRE_GRUPO"];
  if ($row["GRUPO_ID"] == $lp_row["GRUPO_ID"]) {$selstr = " selected"; } else {$selstr = ""; }
 ?><option value="<? echo $val ?>"<? echo $selstr ?>><? echo $caption ?></option>
<? } ?></select>
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
<!--<td><a href="C_RUBRO_CONSULTA.php?a=add">Nuevo Registro</a>&nbsp;</td>-->
<? if ($page > 1) { ?>
<td><a href="C_RUBRO_CONSULTA.php?page=<? echo $page - 1 ?>">&lt;&lt;&nbsp;Anterior</a>&nbsp;</td>
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
<td><a href="C_RUBRO_CONSULTA.php?page=<? echo $j ?>"><? echo $j ?></a></td>
<? } } } else { ?>
<td><a href="C_RUBRO_CONSULTA.php?page=<? echo $startpage ?>"><? echo $startpage ."..." .$count ?></a></td>
<? } } } ?>
<? if ($page < $pagecount) { ?>
<td>&nbsp;<a href="C_RUBRO_CONSULTA.php?page=<? echo $page + 1 ?>">Siguiente&nbsp;&gt;&gt;</a>&nbsp;</td>
<? } ?>
</tr>
</table>
<? } ?>

<? function showrecnav($a, $recid, $count)
{
?>
<table class="bd" border="0" cellspacing="1" cellpadding="4">
<tr>
<td><a href="C_RUBRO_CONSULTA.php">Pagina Principal</a></td>
<? if ($recid > 0) { ?>
<td><a href="C_RUBRO_CONSULTA.php?a=<? echo $a ?>&recid=<? echo $recid - 1 ?>">Anterior Registro</a></td>
<? } if ($recid < $count) { ?>
<td><a href="C_RUBRO_CONSULTA.php?a=<? echo $a ?>&recid=<? echo $recid + 1 ?>">Siguiente Registro</a></td>
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
<td><a href="C_RUBRO_CONSULTA.php">Pagina Principal</a></td>
</tr>
</table>
<hr size="1" noshade>
<form action="C_RUBRO_CONSULTA.php" method="post">
<p><input type="hidden" name="sql" value="insert"></p>
<?
$row = array(
  "RUBRO_ID" => "",
  "NOMBRE_RUBRO" => "",
  "DESCRIPCION_RUBRO" => "",
  "DESCRIPCION_CUENTA_CONTABLE" => "",
  "TIPO_RUBRO" => "",
  "SECUENCIAL_DESPLIEGUE_RUBRO" => "",
  "GRUPO_ID" => "",
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
<td><a href="C_RUBRO_CONSULTA.php?a=add">Nuevo Registro</a></td>
<td><a href="C_RUBRO_CONSULTA.php?a=edit&recid=<? echo $recid ?>">Editar Registro</a></td>
<td><a href="C_RUBRO_CONSULTA.php?a=del&recid=<? echo $recid ?>">Borrar Registro</a></td>
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
<form action="C_RUBRO_CONSULTA.php" method="post">
<input type="hidden" name="sql" value="update">
<input type="hidden" name="xRUBRO_ID" value="<? echo $row["RUBRO_ID"] ?>">
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
<form action="C_RUBRO_CONSULTA.php" method="post">
<input type="hidden" name="sql" value="delete">
<input type="hidden" name="xRUBRO_ID" value="<? echo $row["RUBRO_ID"] ?>">
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
			RUBRO_ID AS RUBRO,
			CONVERT(varchar(9),RUB.RUBRO_ID) AS RUBRO_ID,
			CONVERT(varchar(120),RUB.NOMBRE_RUBRO) AS NOMBRE_RUBRO,
			CONVERT(varchar(MAX),RUB.DESCRIPCION_RUBRO) AS DESCRIPCION_RUBRO,
			CONVERT(varchar(200),RUB.DESCRIPCION_CUENTA_CONTABLE) AS DESCRIPCION_CUENTA_CONTABLE,
			CONVERT(varchar(1),RUB.TIPO_RUBRO) AS TIPO_RUBRO,
			CONVERT(varchar(4),RUB.SECUENCIAL_DESPLIEGUE_RUBRO) AS SECUENCIAL_DESPLIEGUE_RUBRO,
			RUB.SECUENCIAL_DESPLIEGUE_RUBRO AS ORDEN,
			RUB.GRUPO_ID,
			CONVERT(varchar(30),GRU.NOMBRE_GRUPO) AS NOMBRE_GRUPO,
			CONVERT(varchar(4),RUB.ESTADO_ID) AS ESTADO_ID
			from
			dbo.C_RUBRO RUB,
			dbo.C_GRUPO GRU
			WHERE
			RUB.GRUPO_ID = GRU.GRUPO_ID AND
			RUB.GRUPO_ID <> 4";
  switch ($filterfield) {
    case "NOMBRE_GRUPO":
		$var_tmp = "GRU.";
        break;
    default:
		$var_tmp = "RUB.";
	    break;
  }
  if (isset($filterstr) && $filterstr!='' && isset($filterfield) && $filterfield!='') {
    $sql .= " AND " .$var_tmp.sqlstr($filterfield) ." like '" .$filterstr ."'";
  } elseif (isset($filterstr) && $filterstr!='') {
    $sql .= " where (RUBRO_ID like '" .$filterstr ."') or (NOMBRE_RUBRO like '" .$filterstr ."') or (DESCRIPCION_RUBRO like '" .$filterstr ."') or (TIPO_RUBRO like '" .$filterstr ."') or (SECUENCIAL_DESPLIEGUE_RUBRO like '" .$filterstr ."') or (GRUPO_ID like '" .$filterstr ."') or (ESTADO_ID like '" .$filterstr ."')";
  }
  if (isset($order) && $order!='') $sql .= " order by \"" .sqlstr($order) ."\"";
  if (isset($ordtype) && $ordtype!='') $sql .= " " .sqlstr($ordtype);
  if ($order == '' and $ordtype == '')
  {
  	$sql = $sql." ORDER BY RUB.GRUPO_ID,ORDEN";
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
  $sql = "select
			COUNT(*)
			from
			dbo.C_RUBRO RUB,
			dbo.C_GRUPO GRU
			WHERE
			RUB.GRUPO_ID = GRU.GRUPO_ID AND
			RUB.GRUPO_ID <> 4";
  switch ($filterfield) {
    case "NOMBRE_GRUPO":
		$var_tmp = "GRU.";
        break;
    default:
		$var_tmp = "RUB.";
	    break;
  }
  if (isset($filterstr) && $filterstr!='' && isset($filterfield) && $filterfield!='') {
    $sql .= " AND " .$var_tmp.sqlstr($filterfield) ." like '" .$filterstr ."'";
  } elseif (isset($filterstr) && $filterstr!='') {
    $sql .= " where (RUBRO_ID like '" .$filterstr ."') or (NOMBRE_RUBRO like '" .$filterstr ."') or (DESCRIPCION_RUBRO like '" .$filterstr ."') or (TIPO_RUBRO like '" .$filterstr ."') or (SECUENCIAL_DESPLIEGUE_RUBRO like '" .$filterstr ."') or (GRUPO_ID like '" .$filterstr ."') or (ESTADO_ID like '" .$filterstr ."')";
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

  $sql = "insert into dbo.C_RUBRO (RUBRO_ID, NOMBRE_RUBRO, DESCRIPCION_RUBRO, DESCRIPCION_CUENTA_CONTABLE,TIPO_RUBRO, SECUENCIAL_DESPLIEGUE_RUBRO, GRUPO_ID, ESTADO_ID) values (" .sqlvalue(@$_POST["RUBRO_ID"], false) .", " .sqlvalue(@$_POST["NOMBRE_RUBRO"], true) .", " .sqlvalue(@$_POST["DESCRIPCION_RUBRO"], true) .", " .sqlvalue(@$_POST["DESCRIPCION_CUENTA_CONTABLE"], true) .", " .sqlvalue(@$_POST["TIPO_RUBRO"], true) .", " .sqlvalue(@$_POST["SECUENCIAL_DESPLIEGUE_RUBRO"], false) .", " .sqlvalue(@$_POST["GRUPO_ID"], false) .", " .sqlvalue(@$_POST["ESTADO_ID"], false) .")";
  if (@mssql_query($sql, $conn) == false)
  {
    echo '<span class="Mensajes">NO SE GUARDO EL REGISTRO</span>';
    echo "<br></br>";
  }
}

function sql_insert_identity()
{
  global $conn;
  global $_POST;

  $sql = "insert into dbo.C_RUBRO values (".sqlvalue(@$_POST["NOMBRE_RUBRO"], true) .", " .sqlvalue(@$_POST["DESCRIPCION_RUBRO"], true) .", " .sqlvalue(@$_POST["TIPO_RUBRO"], true) .", " .sqlvalue(@$_POST["SECUENCIAL_DESPLIEGUE_RUBRO"], false) .", " .sqlvalue(@$_POST["GRUPO_ID"], false) .", " .sqlvalue(@$_POST["ESTADO_ID"], false) .", " .sqlvalue(@$_POST["DESCRIPCION_CUENTA_CONTABLE"], true) .")";
  if (@mssql_query($sql, $conn) == false)
  {
    echo '<span class="Mensajes">NO SE GUARDO EL REGISTRO</span>';
    echo "<br></br>";
    echo $sql;
  }
}


function sql_update()
{
  global $conn;
  global $_POST;

  $sql = "update dbo.C_RUBRO set NOMBRE_RUBRO=" .sqlvalue(@$_POST["NOMBRE_RUBRO"], true) .", DESCRIPCION_RUBRO=" .sqlvalue(@$_POST["DESCRIPCION_RUBRO"], true) .", DESCRIPCION_CUENTA_CONTABLE=" .sqlvalue(@$_POST["DESCRIPCION_CUENTA_CONTABLE"], true).", TIPO_RUBRO=" .sqlvalue(@$_POST["TIPO_RUBRO"], true) .", SECUENCIAL_DESPLIEGUE_RUBRO=" .sqlvalue(@$_POST["SECUENCIAL_DESPLIEGUE_RUBRO"], false) .", GRUPO_ID=" .sqlvalue(@$_POST["GRUPO_ID"], false) .", ESTADO_ID=" .sqlvalue(@$_POST["ESTADO_ID"], false) ." where " ."(RUBRO_ID=" .sqlvalue(@$_POST["xRUBRO_ID"], false) .")";
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

  $sql = "delete from dbo.C_RUBRO where " ."(RUBRO_ID=" .sqlvalue(@$_POST["xRUBRO_ID"], false) .")";
  if (@mssql_query($sql, $conn) == false)
  {
    echo '<span class="Mensajes">NO SE ELIMINO EL REGISTRO</span>';
    echo "<br></br>";
  }
} ?>

<script type="text/javascript">
<!--
	var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {validateOn:["blur"]});
	var sprytextarea2 = new Spry.Widget.ValidationTextarea("sprytextarea2", {validateOn:["blur"]});
	var sprytextarea3 = new Spry.Widget.ValidationTextarea("sprytextarea3", {validateOn:["blur"], isRequired:false});
	var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "custom",{pattern:"A",validateOn:["blur"], useCharacterMasking:true});
	var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "integer",{allowNegative:false,validateOn:["blur"], useCharacterMasking:true});
//-->
</script>
