<? session_start(); ?>
<html>
<head>
<title>RFD -- C_RUBRO_DATOS</title>
<meta name="generator" content="text/html">
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
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
  $var_span2 = 0;
  $showrecs = 20;
  $pagerange = 10;

  $a = @$_GET["a"];
  $recid = @$_GET["recid"];

  $page = @$_GET["page"];
  if (!isset($page)) $page = 1;

  $sql = @$_POST["sql"];

  switch ($sql) {
    case "update":
      sql_update();
      break;
  }

  switch ($a) {
    case "edit":
      editrec($recid);
      break;
    default:
      select();
      break;
  }
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
	"ORGANIZACION_ID" => "ORGANIZACION_ID",
	"PERIODO_ID" => "PERIODO_ID",
    "RUBRO_ID" => "RUBRO_ID",
	"RUBRO_VALOR" => "RUBRO_VALOR");
?>
<table class="bd" border="0" cellspacing="1" cellpadding="4">
<tr><td>TABLA: dbo.C_RUBRO_DATOS</td></tr>
<tr><td>Records shown <? echo $startrec + 1 ?> - <? echo $reccount ?> of <? echo $count ?></td></tr>
</table>
<hr size="1" noshade>
<? showpagenav($page, $pagecount); ?>
<br>
<table class="tbl" border="0" cellspacing="1" cellpadding="5"width="100%">
<tr>
<?
  reset($fields);
  foreach($fields as $val => $caption) {
?>
<td class="hr"><? echo $caption ?></td>
<? } ?>
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
  $var_fila = 2;
  reset($fields);
  foreach($fields as $val => $caption) {
?>
<td class="<? echo $style ?>"><? echo htmlspecialchars($row[$val]) ?></td>
<? } ?>
<? //editrec($recid);
editrec($i);
//showroweditor1($row); ?>
<!-- </td>
<!-- <td class="<? echo $style ?>"><a href="C_RUBRO_DATOS.php?a=edit&recid=<? echo $i ?>">Editar</a></td>  -->
<!-- <td class="<? echo $style ?>"><a href="C_RUBRO_DATOS.php?a=edit&recid=<? echo $i ?>">Editar</a></td> -->
</tr>
<?
  }
  mssql_free_result($res);
?>
</table>
<br>
<? } ?>

<? function showroweditor($row)
  {
  global $conn;
?>
<table class="tbl" border="0" cellspacing="1" cellpadding="5"width="100%">
<tr>
<td class="hr"><? echo htmlspecialchars("ORGANIZACION_ID")."&nbsp;" ?></td>
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
<td class="hr"><? echo htmlspecialchars("PERIODO_ID")."&nbsp;" ?></td>
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
<td class="hr"><? echo htmlspecialchars("RUBRO_ID")."&nbsp;" ?></td>
<td class="dr"><select name="RUBRO_ID">
<?
  $sql = "select RUBRO_ID, NOMBRE_RUBRO from dbo.C_RUBRO";
  $res = mssql_query($sql, $conn);

  while ($lp_row = mssql_fetch_assoc($res)){
  $val = $lp_row["RUBRO_ID"];
  $caption = $lp_row["NOMBRE_RUBRO"];
  if ($row["RUBRO_ID"] == $lp_row["RUBRO_ID"]) {$selstr = " selected"; } else {$selstr = ""; }
 ?><option value="<? echo $val ?>"<? echo $selstr ?>><? echo $caption ?></option>
<? } ?></select>
</td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("RUBRO_VALOR")."&nbsp;" ?></td>
<td class="dr"><input type="text" name="RUBRO_VALOR" value="<? echo str_replace('"', '&quot;', trim($row["RUBRO_VALOR"])) ?>"></td>
</tr>
</table>
<? } ?>

<? function showroweditor1($row)
  {
  global $conn;
  global $var_span2;
?>
<td class="dr">
<?php
	$var_span = "";
	$var_span1 = "var_"  ;
	$var_span = $var_span1.$var_span2;
	//echo $var_span;
?>
<span id="<?php echo $var_span ;?>">
<input type="text" name="RUBRO_VALOR" value="<? echo str_replace('"', '&quot;', trim($row["RUBRO_VALOR"])) ?>">
<span class="textfieldInvalidFormatMsg">Formato Incorrecto</span>
<span class="textfieldRequiredMsg">Obligatorio ingresar algun dato</span>
</span>
<script type="text/javascript">
	var <?php echo $var_span ;?> = new Spry.Widget.ValidationTextField("<?php echo $var_span ;?>", "currency",{isRequired:true,validateOn:["blur","submit"], useCharacterMasking:true});
</script>
</td>
<!-- <td class="dr"><input type="submit" name="action" value="Guardar"></td> -->
<? } ?>



<? function showpagenav($page, $pagecount)
{
?>
<table class="bd" border="0" cellspacing="1" cellpadding="4">
<tr>
<? if ($page > 1) { ?>
<td><a href="C_RUBRO_DATOS.php?page=<? echo $page - 1 ?>">&lt;&lt;&nbsp;Anterior</a>&nbsp;</td>
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
<td><a href="C_RUBRO_DATOS.php?page=<? echo $j ?>"><? echo $j ?></a></td>
<? } } } else { ?>
<td><a href="C_RUBRO_DATOS.php?page=<? echo $startpage ?>"><? echo $startpage ."..." .$count ?></a></td>
<? } } } ?>
<? if ($page < $pagecount) { ?>
<td>&nbsp;<a href="C_RUBRO_DATOS.php?page=<? echo $page + 1 ?>">Siguiente&nbsp;&gt;&gt;</a>&nbsp;</td>
<? } ?>
</tr>
</table>
<? } ?>

<? function showrecnav($a, $recid, $count)
{
?>
<table class="bd" border="0" cellspacing="1" cellpadding="4">
<tr>
<td><a href="C_RUBRO_DATOS.php">Pagina Principal</a></td>
<? if ($recid > 0) { ?>
<td><a href="C_RUBRO_DATOS.php?a=<? echo $a ?>&recid=<? echo $recid - 1 ?>">Anterior Registro</a></td>
<? } if ($recid < $count) { ?>
<td><a href="C_RUBRO_DATOS.php?a=<? echo $a ?>&recid=<? echo $recid + 1 ?>">Siguiente Registro</a></td>
<? } ?>
</tr>
</table>
<hr size="1" noshade>
<? } ?>

<? function editrec($recid)
{
  global $var_span2;
  $res = sql_select();
  $count = sql_getrecordcount();
  mssql_data_seek($res, $recid);
  $row = mssql_fetch_assoc($res);
  $var_span2 = $recid;
  //showrecnav("edit", $recid, $count);
  //echo $var_span2;
?>
<form action="C_RUBRO_DATOS.php" method="post">
<input type="hidden" name="sql" value="update">
<input name="xORGANIZACION_ID" type="hidden" value="<? echo $row["ORGANIZACION_ID"] ?>">
<input type="hidden" name="xPERIODO_ID" value="<? echo $row["PERIODO_ID"] ?>">
<input type="hidden" name="xRUBRO_ID" value="<? echo $row["RUBRO_ID"] ?>">
<? showroweditor1($row) ?>
<!-- <p><input type="submit" name="action" value="Guardar"></p> -->
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
  $sql = "select ORGANIZACION_ID, PERIODO_ID, RUBRO_ID, RUBRO_VALOR
			from dbo.C_RUBRO_DATOS
			WHERE
			ORGANIZACION_ID = 1 AND
			PERIODO_ID = 200809";
  $res = mssql_query($sql, $conn);
  return $res;
}

function sql_getrecordcount()
{
  global $conn;
  $sql = "select count(*)
			from dbo.C_RUBRO_DATOS
			WHERE
			ORGANIZACION_ID = 1 AND
			PERIODO_ID = 200809";
  $res = mssql_query($sql, $conn);
  $row = mssql_fetch_assoc($res);
  reset($row);
  return current($row);
}

function sql_update()
{
  global $conn;
  global $_POST;

//  $sql = "update dbo.C_RUBRO_DATOS set ORGANIZACION_ID=" .sqlvalue(@$_POST["ORGANIZACION_ID"], false) .", PERIODO_ID=" .sqlvalue(@$_POST["PERIODO_ID"], false) .", RUBRO_ID=" .sqlvalue(@$_POST["RUBRO_ID"], false) .", RUBRO_VALOR=" .sqlvalue(@$_POST["RUBRO_VALOR"], false) ." where " ."(ORGANIZACION_ID=" .sqlvalue(@$_POST["xORGANIZACION_ID"], false) .") and (PERIODO_ID=" .sqlvalue(@$_POST["xPERIODO_ID"], false) .") and (RUBRO_ID=" .sqlvalue(@$_POST["xRUBRO_ID"], false) .")";
  $sql = "update dbo.C_RUBRO_DATOS set RUBRO_VALOR=" .sqlvalue(@$_POST["RUBRO_VALOR"], false) ." where " ."(ORGANIZACION_ID=" .sqlvalue(@$_POST["xORGANIZACION_ID"], false) .") and (PERIODO_ID=" .sqlvalue(@$_POST["xPERIODO_ID"], false) .") and (RUBRO_ID=" .sqlvalue(@$_POST["xRUBRO_ID"], false) .")";
  if (@mssql_query($sql, $conn) == false)
  {
  	echo "INGRESE ALGUN VALOR";
  }
} ?>
