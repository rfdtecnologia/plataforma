<?
session_start();
?>
<html>
<head>
<title>RFD -- C_USUARIO_ORGANIZACION</title>
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
    "Usuario_ID" => "CEDULA",
//    "ORGANIZACION_ID" => "ORGANIZACION_ID",
    "NOMBRE_ORGANIZACION" => "ORGANIZACION",
//    "CLAVE_USUARIO" => "CLAVE_USUARIO",
    "NOMBRE_USUARIO" => "NOMBRE USUARIO",
    "EMAIL_USUARIO" => "EMAIL USUARIO",
//    "PERFIL_ID" => "PERFIL_ID",
    "NOMBRE_PERFIL" => "PERFIL",
    "NUMERO_VECES_USUARIO" => "NRO. VECES INGRESA",
    "ESTADO_ID" => "ESTADO");
?>
<table class="bd" border="0" cellspacing="1" cellpadding="4">
<tr><td>TABLA: dbo.C_USUARIO_ORGANIZACION</td></tr>
<tr><td>Records shown <? echo $startrec + 1 ?> - <? echo $reccount ?> of <? echo $count ?></td></tr>
</table>
<hr size="1" noshade>
<form action="C_USUARIO_ORGANIZACION.php" method="post">
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
<td><a href="C_USUARIO_ORGANIZACION.php?a=reset">Quitar Filtro</a></td>
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
<td class="hr"><a class="hr" href="C_USUARIO_ORGANIZACION.php?order=<? echo $val ?>&type=<? echo $ordtypestr ?>"><? echo htmlspecialchars($caption) ?></a></td>
<? } ?>
<td class="hr">&nbsp;</td>
<td class="hr">&nbsp;</td>
<!--<td class="hr">&nbsp;</td>-->
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
<td class="<? echo $style ?>"><a href="C_USUARIO_ORGANIZACION.php?a=view&recid=<? echo $i ?>">Ver</a></td>
<td class="<? echo $style ?>"><a href="C_USUARIO_ORGANIZACION.php?a=edit&recid=<? echo $i ?>">Editar</a></td>
<!--<td class="<? echo $style ?>"><a href="C_USUARIO_ORGANIZACION.php?a=del&recid=<? echo $i ?>">Borrar</a></td>-->
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
<td class="hr"><? echo htmlspecialchars("CEDULA")."&nbsp;" ?></td>
<td class="dr"><? echo htmlspecialchars($row["Usuario_ID"]) ?></td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("ORGANIZACION")."&nbsp;" ?></td>
<td class="dr"><? echo htmlspecialchars($row["ORGANIZACION_ID"]) ?></td>
</tr>
<!--<tr>
<td class="hr"><? echo htmlspecialchars("CLAVE USUARIO")."&nbsp;" ?></td>
<td class="dr"><? echo htmlspecialchars($row["CLAVE_USUARIO"]) ?></td>
</tr>-->
<tr>
<td class="hr"><? echo htmlspecialchars("NOMBRE USUARIO")."&nbsp;" ?></td>
<td class="dr"><? echo htmlspecialchars($row["NOMBRE_USUARIO"]) ?></td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("EMAIL USUARIO")."&nbsp;" ?></td>
<td class="dr"><? echo htmlspecialchars($row["EMAIL_USUARIO"]) ?></td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("PERFIL")."&nbsp;" ?></td>
<td class="dr"><? echo htmlspecialchars($row["PERFIL_ID"]) ?></td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("NRO. VECES INGRESA")."&nbsp;" ?></td>
<td class="dr"><? echo htmlspecialchars($row["NUMERO_VECES_USUARIO"]) ?></td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("ESTADO")."&nbsp;" ?></td>
<td class="dr"><? echo htmlspecialchars($row["ESTADO_ID"]) ?></td>
</tr>
</table>
<? } ?>

<? function showrowadd($row)
  {
  global $conn;
?>
<table class="tbl" border="0" cellspacing="1" cellpadding="5"width="100%">
<tr>
<td class="hr"><? echo htmlspecialchars("CEDULA")."&nbsp;" ?></td>
<td class="dr">
<span id="cedula">
<input type="text" name="Usuario_ID" maxlength="10" value="<? echo str_replace('"', '&quot;', trim($row["Usuario_ID"])) ?>">
<span class="textfieldRequiredMsg">Ingrese su Cedula</span>
<span class="textfieldInvalidFormatMsg">Cedula Incorrecta</span>
<span class="textfieldMinCharsMsg">Cedula Incorrecta</span>
<span class="textfieldMaxCharsMsg">Cedula Incorrecta</span>
</span>
</td>

</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("ORGANIZACION")."&nbsp;" ?></td>
<td class="dr"><select name="ORGANIZACION_ID">
<?
  $sql = "select ORGANIZACION_ID, NOMBRE_ORGANIZACION from dbo.C_ORGANIZACION ORDER BY NOMBRE_ORGANIZACION";
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
<td class="hr"><? echo htmlspecialchars("CLAVE USUARIO")."&nbsp;" ?></td>
<td class="dr">
<span id="sprytextfield2">
<input type="password" name="CLAVE_USUARIO" maxlength="50" value="<? echo str_replace('"', '&quot;', trim($row["CLAVE_USUARIO"])) ?>">
<span class="textfieldInvalidFormatMsg">Formato Incorrecto</span>
<span class="textfieldRequiredMsg">Obligatorio ingresar algun dato</span>
</span>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("NOMBRE USUARIO")."&nbsp;" ?></td>
<td class="dr">
<span id="sprytextarea1">
<label>
<textarea name="NOMBRE_USUARIO" id="textarea1" cols="35" rows="2" maxlength="50" ><? echo str_replace('"', '&quot;', trim($row["NOMBRE_USUARIO"])) ?></textarea>
</label>
<span class="textareaRequiredMsg">Obligatorio ingresar algun dato</span></span>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("EMAIL USUARIO")."&nbsp;" ?></td>
<td class="dr">
<span id="sprytextfield4">
<input type="text" name="EMAIL_USUARIO" maxlength="50" value="<? echo str_replace('"', '&quot;', trim($row["EMAIL_USUARIO"])) ?>">
<span class="textfieldInvalidFormatMsg">Formato Incorrecto</span>
<span class="textfieldRequiredMsg">Obligatorio ingresar algun dato</span>
</span>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("PERFIL")."&nbsp;" ?></td>
<td class="dr"><select name="PERFIL_ID">
<?
  $sql = "select PERFIL_ID, NOMBRE_PERFIL from dbo.C_PERFIL";
  $res = mssql_query($sql, $conn);

  while ($lp_row = mssql_fetch_assoc($res)){
  $val = $lp_row["PERFIL_ID"];
  $caption = $lp_row["NOMBRE_PERFIL"];
  if ($row["PERFIL_ID"] == $lp_row["PERFIL_ID"]) {$selstr = " selected"; } else {$selstr = ""; }
 ?><option value="<? echo $val ?>"<? echo $selstr ?>><? echo $caption ?></option>
<? } ?></select>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("NRO. VECES INGRESA")."&nbsp;" ?></td>
<td class="dr">
<span id="sprytextfield5">
<input type="text" name="NUMERO_VECES_USUARIO" value="<? echo str_replace('"', '&quot;', trim($row["NUMERO_VECES_USUARIO"])) ?>">
<span class="textfieldInvalidFormatMsg">Formato Incorrecto</span>
<span class="textfieldRequiredMsg">Obligatorio ingresar algun dato</span>
</span>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("ESTADO_ID")."&nbsp;" ?></td>
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


<? function showroweditor($row)
  {
  global $conn;
?>
<table class="tbl" border="0" cellspacing="1" cellpadding="5"width="100%">
<tr>
<td class="hr"><? echo htmlspecialchars("CEDULA")."&nbsp;" ?></td>
<td class="dr">
<span id="cedula">
<input type="text" name="Usuario_ID" maxlength="10" disabled = "true" value="<? echo str_replace('"', '&quot;', trim($row["Usuario_ID"])) ?>">
<span class="textfieldRequiredMsg">Ingrese su Cedula</span>
<span class="textfieldInvalidFormatMsg">Cedula Incorrecta</span>
<span class="textfieldMinCharsMsg">Cedula Incorrecta</span>
<span class="textfieldMaxCharsMsg">Cedula Incorrecta</span>
</span>
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
 ?><option value="<? echo $val ?>" disabled="disabled"<? echo $selstr ?>><? echo $caption ?></option>
<? } ?></select>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("CLAVE USUARIO")."&nbsp;" ?></td>
<td class="dr">
<span id="sprytextfield2">
<input type="password" name="CLAVE_USUARIO" maxlength="50" value="<? echo str_replace('"', '&quot;', trim($row["CLAVE_USUARIO"])) ?>">
<span class="textfieldInvalidFormatMsg">Formato Incorrecto</span>
<span class="textfieldRequiredMsg">Obligatorio ingresar algun dato</span>
</span>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("NOMBRE USUARIO")."&nbsp;" ?></td>
<td class="dr">
<span id="sprytextarea1">
<label>
<textarea name="NOMBRE_USUARIO" id="textarea1" cols="35" rows="2" maxlength="50" ><? echo str_replace('"', '&quot;', trim($row["NOMBRE_USUARIO"])) ?></textarea>
</label>
<span class="textareaRequiredMsg">Obligatorio ingresar algun dato</span></span>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("EMAIL USUARIO")."&nbsp;" ?></td>
<td class="dr">
<span id="sprytextfield4">
<input type="text" name="EMAIL_USUARIO" maxlength="50" value="<? echo str_replace('"', '&quot;', trim($row["EMAIL_USUARIO"])) ?>">
<span class="textfieldInvalidFormatMsg">Formato Incorrecto</span>
<span class="textfieldRequiredMsg">Obligatorio ingresar algun dato</span>
</span>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("PERFIL")."&nbsp;" ?></td>
<td class="dr"><select name="PERFIL_ID">
<?
  $sql = "select PERFIL_ID, NOMBRE_PERFIL from dbo.C_PERFIL";
  $res = mssql_query($sql, $conn);

  while ($lp_row = mssql_fetch_assoc($res)){
  $val = $lp_row["PERFIL_ID"];
  $caption = $lp_row["NOMBRE_PERFIL"];
  if ($row["PERFIL_ID"] == $lp_row["PERFIL_ID"]) {$selstr = " selected"; } else {$selstr = ""; }
 ?><option value="<? echo $val ?>"<? echo $selstr ?>><? echo $caption ?></option>
<? } ?></select>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("NRO. VECES INGRESA")."&nbsp;" ?></td>
<td class="dr">
<span id="sprytextfield5">
<input type="text" name="NUMERO_VECES_USUARIO" value="<? echo str_replace('"', '&quot;', trim($row["NUMERO_VECES_USUARIO"])) ?>">
<span class="textfieldInvalidFormatMsg">Formato Incorrecto</span>
<span class="textfieldRequiredMsg">Obligatorio ingresar algun dato</span>
</span>
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
<td><a href="C_USUARIO_ORGANIZACION.php?a=add">Nuevo Registro</a>&nbsp;</td>
<? if ($page > 1) { ?>
<td><a href="C_USUARIO_ORGANIZACION.php?page=<? echo $page - 1 ?>">&lt;&lt;&nbsp;Anterior</a>&nbsp;</td>
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
<td><a href="C_USUARIO_ORGANIZACION.php?page=<? echo $j ?>"><? echo $j ?></a></td>
<? } } } else { ?>
<td><a href="C_USUARIO_ORGANIZACION.php?page=<? echo $startpage ?>"><? echo $startpage ."..." .$count ?></a></td>
<? } } } ?>
<? if ($page < $pagecount) { ?>
<td>&nbsp;<a href="C_USUARIO_ORGANIZACION.php?page=<? echo $page + 1 ?>">Siguiente&nbsp;&gt;&gt;</a>&nbsp;</td>
<? } ?>
</tr>
</table>
<? } ?>

<? function showrecnav($a, $recid, $count)
{
?>
<table class="bd" border="0" cellspacing="1" cellpadding="4">
<tr>
<td><a href="C_USUARIO_ORGANIZACION.php">Pagina Principal</a></td>
<? if ($recid > 0) { ?>
<td><a href="C_USUARIO_ORGANIZACION.php?a=<? echo $a ?>&recid=<? echo $recid - 1 ?>">Anterior Registro</a></td>
<? } if ($recid < $count) { ?>
<td><a href="C_USUARIO_ORGANIZACION.php?a=<? echo $a ?>&recid=<? echo $recid + 1 ?>">Siguiente Registro</a></td>
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
<td><a href="C_USUARIO_ORGANIZACION.php">Pagina Principal</a></td>
</tr>
</table>
<hr size="1" noshade>
<form action="C_USUARIO_ORGANIZACION.php" method="post">
<p><input type="hidden" name="sql" value="insert"></p>
<?
$row = array(
  "Usuario_ID" => "",
  "ORGANIZACION_ID" => "",
  "CLAVE_USUARIO" => "",
  "NOMBRE_USUARIO" => "",
  "EMAIL_USUARIO" => "",
  "PERFIL_ID" => "",
  "NUMERO_VECES_USUARIO" => 0,
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
<td><a href="C_USUARIO_ORGANIZACION.php?a=add">Nuevo Registro</a></td>
<td><a href="C_USUARIO_ORGANIZACION.php?a=edit&recid=<? echo $recid ?>">Editar Registro</a></td>
<!--<td><a href="C_USUARIO_ORGANIZACION.php?a=del&recid=<? echo $recid ?>">Borrar Registro</a></td>-->
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
<form action="C_USUARIO_ORGANIZACION.php" method="post">
<input type="hidden" name="sql" value="update">
<input type="hidden" name="xUsuario_ID" value="<? echo $row["Usuario_ID"] ?>">
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
<form action="C_USUARIO_ORGANIZACION.php" method="post">
<input type="hidden" name="sql" value="delete">
<input type="hidden" name="xUsuario_ID" value="<? echo $row["Usuario_ID"] ?>">
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
			CONVERT(varchar(10),USU.Usuario_ID) AS Usuario_ID,
			USU.ORGANIZACION_ID,
			CONVERT(varchar(80),ORG.NOMBRE_ORGANIZACION) AS NOMBRE_ORGANIZACION,
			CONVERT(varchar(50),USU.CLAVE_USUARIO) AS CLAVE_USUARIO,
			CONVERT(varchar(50),USU.NOMBRE_USUARIO) AS NOMBRE_USUARIO,
			CONVERT(varchar(50),USU.EMAIL_USUARIO) AS EMAIL_USUARIO,
			CONVERT(varchar(4),USU.PERFIL_ID) AS PERFIL_ID,
			CONVERT(varchar(50),PER.NOMBRE_PERFIL) AS NOMBRE_PERFIL,
			CONVERT(varchar(4),USU.NUMERO_VECES_USUARIO) AS NUMERO_VECES_USUARIO,
			CONVERT(varchar(4),USU.ESTADO_ID) AS ESTADO_ID
			from
			dbo.C_USUARIO_ORGANIZACION USU,
			dbo.C_ORGANIZACION ORG,
			dbo.C_PERFIL PER
			WHERE
			USU.ORGANIZACION_ID = ORG.ORGANIZACION_ID AND USU.PERFIL_ID = PER.PERFIL_ID";
  switch ($filterfield) {
    case "NOMBRE_ORGANIZACION":
		$var_tmp = "ORG.";
        break;
    case "NOMBRE_PERFIL":
		$var_tmp = "PER.";
        break;
    default:
		$var_tmp = "USU.";
	    break;
  }
  if (isset($filterstr) && $filterstr!='' && isset($filterfield) && $filterfield!='') {
    $sql .= " AND " .$var_tmp.sqlstr($filterfield) ." like '" .$filterstr ."'";
  } elseif (isset($filterstr) && $filterstr!='') {
    $sql .= " where (Usuario_ID like '" .$filterstr ."') or (ORGANIZACION_ID like '" .$filterstr ."') or (CLAVE_USUARIO like '" .$filterstr ."') or (NOMBRE_USUARIO like '" .$filterstr ."') or (EMAIL_USUARIO like '" .$filterstr ."') or (PERFIL_ID like '" .$filterstr ."') or (NUMERO_VECES_USUARIO like '" .$filterstr ."') or (ESTADO_ID like '" .$filterstr ."')";
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
			COUNT(*)
			from
			dbo.C_USUARIO_ORGANIZACION USU,
			dbo.C_ORGANIZACION ORG,
			dbo.C_PERFIL PER
			WHERE
			USU.ORGANIZACION_ID = ORG.ORGANIZACION_ID AND USU.PERFIL_ID = PER.PERFIL_ID";
  switch ($filterfield) {
    case "NOMBRE_ORGANIZACION":
		$var_tmp = "ORG.";
        break;
    case "NOMBRE_PERFIL":
		$var_tmp = "PER.";
        break;
    default:
		$var_tmp = "USU.";
	    break;
  }
  if (isset($filterstr) && $filterstr!='' && isset($filterfield) && $filterfield!='') {
    $sql .= " AND " .$var_tmp.sqlstr($filterfield) ." like '" .$filterstr ."'";
  } elseif (isset($filterstr) && $filterstr!='') {
    $sql .= " where (Usuario_ID like '" .$filterstr ."') or (ORGANIZACION_ID like '" .$filterstr ."') or (CLAVE_USUARIO like '" .$filterstr ."') or (NOMBRE_USUARIO like '" .$filterstr ."') or (EMAIL_USUARIO like '" .$filterstr ."') or (PERFIL_ID like '" .$filterstr ."') or (NUMERO_VECES_USUARIO like '" .$filterstr ."') or (ESTADO_ID like '" .$filterstr ."')";
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

  $sql = "insert into dbo.C_USUARIO_ORGANIZACION (Usuario_ID, ORGANIZACION_ID, CLAVE_USUARIO, NOMBRE_USUARIO, EMAIL_USUARIO, PERFIL_ID, NUMERO_VECES_USUARIO, ESTADO_ID) values (" .sqlvalue(@$_POST["Usuario_ID"], true) .", " .sqlvalue(@$_POST["ORGANIZACION_ID"], false) .", " .sqlvalue(@$_POST["CLAVE_USUARIO"], true) .", " .sqlvalue(@$_POST["NOMBRE_USUARIO"], true) .", " .sqlvalue(@$_POST["EMAIL_USUARIO"], true) .", " .sqlvalue(@$_POST["PERFIL_ID"], false) .", " .sqlvalue(@$_POST["NUMERO_VECES_USUARIO"], false) .", " .sqlvalue(@$_POST["ESTADO_ID"], false) .")";
  if (@mssql_query($sql, $conn) == false)
  {
    echo '<span class="Mensajes">NO SE GUARDO EL REGISTRO</span>';
    echo "<br></br>";
  }}

function sql_update()
{
  global $conn;
  global $_POST;

  $sql = "update dbo.C_USUARIO_ORGANIZACION set CLAVE_USUARIO=" .sqlvalue(@$_POST["CLAVE_USUARIO"], true) .", NOMBRE_USUARIO=" .sqlvalue(@$_POST["NOMBRE_USUARIO"], true) .", EMAIL_USUARIO=" .sqlvalue(@$_POST["EMAIL_USUARIO"], true) .", PERFIL_ID=" .sqlvalue(@$_POST["PERFIL_ID"], false) .", NUMERO_VECES_USUARIO=" .sqlvalue(@$_POST["NUMERO_VECES_USUARIO"], false) .", ESTADO_ID=" .sqlvalue(@$_POST["ESTADO_ID"], false) ." where " ."(Usuario_ID=" .sqlvalue(@$_POST["xUsuario_ID"], true) .") and (ORGANIZACION_ID=" .sqlvalue(@$_POST["xORGANIZACION_ID"], false) .")";
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

  $sql = "delete from dbo.C_USUARIO_ORGANIZACION where " ."(Usuario_ID=" .sqlvalue(@$_POST["xUsuario_ID"], true) .") and (ORGANIZACION_ID=" .sqlvalue(@$_POST["xORGANIZACION_ID"], false) .")";
  if (@mssql_query($sql, $conn) == false)
  {
    echo '<span class="Mensajes">NO SE ELIMINO EL REGISTRO</span>';
    echo "<br></br>";
  }} ?>


<script type="text/javascript">
<!--
	var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {validateOn:["blur"]});
	var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none",{validateOn:["blur"]});
	var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "email",{validateOn:["blur"]});
	var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "integer",{isRequired:true,allowNegative:false,useCharacterMasking:true,validateOn:["blur"]});
	var cedula = new Spry.Widget.ValidationTextField("cedula", "integer", {allowNegative:false, validateOn:["blur"], useCharacterMasking:true, minChars:10, maxChars:10});
//-->
</script>
