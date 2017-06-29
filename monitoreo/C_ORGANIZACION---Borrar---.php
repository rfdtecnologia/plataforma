<? session_start(); ?>
<html>
<head>
    <title>RFD -- C_ORGANIZACION</title>
    <meta name="generator" content="text/html">
    <link href="SpryAssets/HojasEstilos.css" rel="stylesheet" type="text/css">
    <script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
    <script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
    <link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css">
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

Desconectar();
?>
<table width="100%" border="0">
    <tr>
        <td><div align="center"><a href="MenuPrincipal.php" class="btn_menu">Menu Principal</a></div></td>
    </tr>
</table>
<table class="bd" width="100%"><tr><td class="hr"></td></tr></table>
</body>
</html>

<script type="text/javascript">
    <!--
    var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {validateOn:["blur"]});
    var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["blur"]});
    var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "date", {format:"yyyy/mm/dd",hint:"yyyy/mm/dd",validateOn:["blur"], useCharacterMasking:true});
    var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "url", {validateOn:["blur"], isRequired:false});
    var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "email", {validateOn:["blur"], isRequired:false});
    var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "integer", {allowNegative:false,validateOn:["blur"], useCharacterMasking:true});
    var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "integer", {allowNegative:false,validateOn:["blur"], useCharacterMasking:true});
    var ruc = new Spry.Widget.ValidationTextField("ruc", "integer", {allowNegative:false, validateOn:["blur"],useCharacterMasking:true, minChars:13, maxChars:13});
    //-->
</script>




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
        "NOMBRE_TIPO_ORGANIZACION" => "TIPO ORGANIZACION",
        "ORGANIZACION_ID" => "ORGANIZACION",
        //"TIPO_ORGANIZACION_ID" => "TIPO_ORGANIZACION_ID",
        "NOMBRE_ORGANIZACION" => "NOMBRE ORGANIZACION",
        "NOMBRE_GRAFICO" => "NOMBRE ABREVIADO",
        "FECHA_CREACION" => "FECHA CREACION",
        "WEB_ORGANIZACION" => "WEB ORGANIZACION",
        "EMAIL_ORGANIZACION" => "EMAIL ORGANIZACION",
        "FIN_DE_LUCRO_ID" => "FIN DE LUCRO",
        "INTERMEDIACION_ID" => "INTERMEDIACION",
        "ESTADO_ID" => "ESTADO",
        "CARGA_CUC" => "CARGA CUC",
        "SOLO_CARTERA" => "SOLO CARTERA",
        "LOGO_ANCHO" => "LOGO ANCHO",
        "LOGO_ALTO" => "LOGO ALTO",
        "RUC_ORGANIZACION" => "RUC");
    ?>
    <table class="bd" border="0" cellspacing="1" cellpadding="4">
        <tr><td>TABLA: dbo.C_ORGANIZACION</td></tr>
        <tr><td>Records shown <? echo $startrec + 1 ?> - <? echo $reccount ?> of <? echo $count ?></td></tr>
    </table>
    <hr size="1" noshade>
    <form action="C_ORGANIZACION.php" method="post">
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
                <td><a href="C_ORGANIZACION.php?a=reset">Quitar Filtro</a></td>
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
                <td class="hr"><a class="hr" href="C_ORGANIZACION.php?order=<? echo $val ?>&type=<? echo $ordtypestr ?>"><? echo htmlspecialchars($caption) ?></a></td>
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
                    <!--ESTO ES LO QUE SE IMPRIME EN LA TABLA-->
                    <td class="<? echo $style ?>"><? echo htmlspecialchars($row[$val]) ?></td>
                <? } ?>
                <td class="<? echo $style ?>"><a href="C_ORGANIZACION.php?a=view&recid=<? echo $i ?>">Ver</a></td>
                <td class="<? echo $style ?>"><a href="C_ORGANIZACION.php?a=edit&recid=<? echo $i ?>">Editar</a></td>
                <td class="<? echo $style ?>"><a href="C_ORGANIZACION.php?a=del&recid=<? echo $i ?>">Borrar</a></td>
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
            <td class="hr"><? echo htmlspecialchars("ORGANIZACION")."&nbsp;" ?></td>
            <td class="dr"><? echo htmlspecialchars($row["ORGANIZACION_ID"]) ?></td>
        </tr>
        <tr>
            <td class="hr"><? echo htmlspecialchars("TIPO ORGANIZACION")."&nbsp;" ?></td>
            <td class="dr"><? echo htmlspecialchars($row["TIPO_ORGANIZACION_ID"]) ?></td>
        </tr>
        <tr>
            <td class="hr"><? echo htmlspecialchars("NOMBRE ORGANIZACION")."&nbsp;" ?></td>
            <td class="dr"><? echo htmlspecialchars($row["NOMBRE_ORGANIZACION"]) ?></td>
        </tr>
        <tr>
            <td class="hr"><? echo htmlspecialchars("NOMBRE ABREVIADO")."&nbsp;" ?></td>
            <td class="dr"><? echo htmlspecialchars($row["NOMBRE_GRAFICO"]) ?></td>
        </tr>
        <tr>
            <td class="hr"><? echo htmlspecialchars("FECHA CREACION")."&nbsp;" ?></td>
            <td class="dr"><? echo htmlspecialchars($row["FECHA_CREACION"]) ?></td>
        </tr>
        <tr>
            <td class="hr"><? echo htmlspecialchars("WEB ORGANIZACION")."&nbsp;" ?></td>
            <td class="dr"><? echo htmlspecialchars($row["WEB_ORGANIZACION"]) ?></td>
        </tr>
        <tr>
            <td class="hr"><? echo htmlspecialchars("EMAIL ORGANIZACION")."&nbsp;" ?></td>
            <td class="dr"><? echo htmlspecialchars($row["EMAIL_ORGANIZACION"]) ?></td>
        </tr>
        <tr>
            <td class="hr"><? echo htmlspecialchars("MISION")."&nbsp;" ?></td>
            <td class="dr"><? echo htmlspecialchars($row["MISION"]) ?></td>
        </tr>
        <tr>
            <td class="hr"><? echo htmlspecialchars("VISION")."&nbsp;" ?></td>
            <td class="dr"><? echo htmlspecialchars($row["VISION"]) ?></td>
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
            <td class="hr"><? echo htmlspecialchars("ESTADO")."&nbsp;" ?></td>
            <td class="dr"><? echo htmlspecialchars($row["ESTADO_ID"]) ?></td>
        </tr>
        <tr>
            <td class="hr"><? echo htmlspecialchars("CARGA CUC")."&nbsp;" ?></td>
            <td class="dr"><? echo htmlspecialchars($row["CARGA_CUC"]) ?></td>
        </tr>
        <tr>
            <td class="hr"><? echo htmlspecialchars("SOLO CARTERA")."&nbsp;" ?></td>
            <td class="dr"><? echo htmlspecialchars($row["SOLO_CARTERA"]) ?></td>
        </tr>
        <tr>
            <td class="hr"><? echo htmlspecialchars("LOGO ANCHO")."&nbsp;" ?></td>
            <td class="dr"><? echo htmlspecialchars($row["LOGO_ANCHO"]) ?></td>
        </tr>
        <tr>
            <td class="hr"><? echo htmlspecialchars("LOGO ALTO")."&nbsp;" ?></td>
            <td class="dr"><? echo htmlspecialchars($row["LOGO_ALTO"]) ?></td>
        </tr>
        <tr>
            <td class="hr"><? echo htmlspecialchars("RUC")."&nbsp;" ?></td>
            <td class="dr"><? echo htmlspecialchars($row["RUC_ORGANIZACION"]) ?></td>
        </tr>
    </table>
<? } ?>

<? function showroweditor($row)
{
    global $conn;
    ?>
    <table class="tbl" border="0" cellspacing="1" cellpadding="5"width="100%">
        <tr>
            <td class="hr"><? echo htmlspecialchars("ORGANIZACION")."&nbsp;" ?></td>
            <td class="dr"><input type="text" disabled name="ORGANIZACION_ID" value="<? echo str_replace('"', '&quot;', trim($row["ORGANIZACION_ID"])) ?>"></td>
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
            <td class="hr"><? echo htmlspecialchars("NOMBRE ORGANIZACION")."&nbsp;" ?></td>
            <td class="dr">
<span id="sprytextarea1">
<label>
<textarea cols="35" rows="4" name="NOMBRE_ORGANIZACION"
          maxlength="80" <?php echo $editable; ?>><? echo str_replace('"', '&quot;', trim($row["NOMBRE_ORGANIZACION"])) ?></textarea>
</label>
<span class="textareaRequiredMsg">Obligatorio ingresar algun dato</span></span>
            </td>
        </tr>
        <tr>
            <td class="hr"><? echo htmlspecialchars("NOMBRE ABREVIADO")."&nbsp;" ?></td>
            <td class="dr">
<span id="sprytextfield1">
<label>
<input type="text" name="NOMBRE_GRAFICO" maxlength="10" value="<? echo str_replace('"', '&quot;', trim($row["NOMBRE_GRAFICO"])) ?>">
</label>
<span class="textfieldRequiredMsg">Obligatorio ingresar algun dato</span></span>
            </td>
        </tr>
        <tr>
            <td class="hr"><? echo htmlspecialchars("FECHA CREACION")."&nbsp;" ?></td>
            <td class="dr">
<span id="sprytextfield2">
<input type="text" name="FECHA_CREACION" value="<? echo str_replace('"', '&quot;', trim($row["FECHA_CREACION"])) ?>">
<span class="textfieldRequiredMsg">Obligatorio ingresar algun dato</span><span class="textfieldInvalidFormatMsg">Formato Incorrecto</span></span></td></tr>
        <tr>
            <td class="hr"><? echo htmlspecialchars("WEB ORGANIZACION")."&nbsp;" ?></td>
            <td class="dr">
<span id="sprytextfield4">
<input type="text" name="WEB_ORGANIZACION" maxlength="50" value="<? echo str_replace('"', '&quot;', trim($row["WEB_ORGANIZACION"])) ?>">
<span class="textfieldInvalidFormatMsg">Formato Incorrecto</span></span>
            </td>
        </tr>
        <tr>
            <td class="hr"><? echo htmlspecialchars("EMAIL ORGANIZACION")."&nbsp;" ?></td>
            <td class="dr">
<span id="sprytextfield5">
<input type="text" name="EMAIL_ORGANIZACION" maxlength="50" value="<? echo str_replace('"', '&quot;', trim($row["EMAIL_ORGANIZACION"])) ?>">
<span class="textfieldInvalidFormatMsg">Formato Incorrecto</span></span>
            </td>
        </tr>
        <tr>
            <td class="hr"><? echo htmlspecialchars("MISION")."&nbsp;" ?></td>
            <td class="dr">
<span id="sprytextarea1">
<label>
<textarea cols="35" rows="4" name="MISION"><? echo str_replace('"', '&quot;', trim($row["MISION"])) ?></textarea>
</label>
<span class="textareaRequiredMsg">Obligatorio ingresar algun dato</span></span>
            </td>
        </tr>
        <tr>
            <td class="hr"><? echo htmlspecialchars("VISION")."&nbsp;" ?></td>
            <td class="dr">
<span id="sprytextarea1">
<label>
<textarea cols="35" rows="4" name="VISION"><? echo str_replace('"', '&quot;', trim($row["VISION"])) ?></textarea>
</label>
<span class="textareaRequiredMsg">Obligatorio ingresar algun dato</span></span>
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
        <tr>
            <td class="hr"><? echo htmlspecialchars("CARGA CUC")."&nbsp;" ?></td>
            <td class="dr"><select name="CARGA_CUC">
                    <?
                    $sql = "select RESPUESTA_ID, NOMBRE_RESPUESTA from dbo.C_RESPUESTA";
                    $res = mssql_query($sql, $conn);

                    while ($lp_row = mssql_fetch_assoc($res)){
                        $val = $lp_row["RESPUESTA_ID"];
                        $caption = $lp_row["NOMBRE_RESPUESTA"];
                        if ($row["CARGA_CUC"] == $lp_row["RESPUESTA_ID"]) {$selstr = " selected"; } else {$selstr = ""; }
                        ?><option value="<? echo $val ?>"<? echo $selstr ?>><? echo $caption ?></option>
                    <? } ?></select>
            </td>
        </tr>
        <tr>
            <td class="hr"><? echo htmlspecialchars("SOLO CARTERA")."&nbsp;" ?></td>
            <td class="dr"><select name="SOLO_CARTERA">
                    <?
                    $sql = "select RESPUESTA_ID, NOMBRE_RESPUESTA from dbo.C_RESPUESTA";
                    $res = mssql_query($sql, $conn);

                    while ($lp_row = mssql_fetch_assoc($res)){
                        $val = $lp_row["RESPUESTA_ID"];
                        $caption = $lp_row["NOMBRE_RESPUESTA"];
                        if ($row["SOLO_CARTERA"] == $lp_row["RESPUESTA_ID"]) {$selstr = " selected"; } else {$selstr = ""; }
                        ?><option value="<? echo $val ?>"<? echo $selstr ?>><? echo $caption ?></option>
                    <? } ?></select>
            </td>
        </tr>
        <tr>
            <td class="hr"><? echo htmlspecialchars("LOGO ANCHO")."&nbsp;" ?></td>
            <td class="dr">
<span id="sprytextfield6">
<input type="text" name="LOGO_ANCHO" value="<? echo str_replace('"', '&quot;', trim($row["LOGO_ANCHO"])) ?>">
<span class="textfieldInvalidFormatMsg">Formato Incorrecto</span>
<span class="textfieldRequiredMsg">Obligatorio ingresar algun dato</span>
</span>
            </td>
        </tr>
        <tr>
            <td class="hr"><? echo htmlspecialchars("LOGO ALTO")."&nbsp;" ?></td>
            <td class="dr">
<span id="sprytextfield7">
<input type="text" name="LOGO_ALTO" value="<? echo str_replace('"', '&quot;', trim($row["LOGO_ALTO"])) ?>">
<span class="textfieldInvalidFormatMsg">Formato Incorrecto</span>
<span class="textfieldRequiredMsg">Obligatorio ingresar algun dato</span>
</span>
            </td>
        </tr>
        <tr>
            <td class="hr"><? echo htmlspecialchars("RUC")."&nbsp;" ?></td>
            <td class="dr">
<span id="ruc">
<input type="text" name="RUC_ORGANIZACION" value="<? echo str_replace('"', '&quot;', trim($row["RUC_ORGANIZACION"])) ?>">
<span class="textfieldRequiredMsg">Ingrese RUC</span> 
<span class="textfieldInvalidFormatMsg">RUC Incorrecto</span> 
<span class="textfieldMinCharsMsg">RUC Incorrecto</span> 
<span class="textfieldMaxCharsMsg">RUC Incorrecto</span>
            </td>
        </tr></table>
<? } ?>

<? function showrowadd($row)
{
    global $conn;
    ?>
    <table class="tbl" border="0" cellspacing="1" cellpadding="5"width="100%">
        <!--<tr>
<td class="hr"><? echo htmlspecialchars("ORGANIZACION")."&nbsp;" ?></td>
<td class="dr"><input type="text" name="ORGANIZACION_ID" value="<? echo str_replace('"', '&quot;', trim($row["ORGANIZACION_ID"])) ?>"></td>
</tr>
-->
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
            <td class="hr"><? echo htmlspecialchars("NOMBRE ORGANIZACION")."&nbsp;" ?></td>
            <td class="dr">
<span id="sprytextarea1">
<label>
<textarea cols="35" rows="4" name="NOMBRE_ORGANIZACION"
          maxlength="80"><? echo str_replace('"', '&quot;', trim($row["NOMBRE_ORGANIZACION"])) ?></textarea>
</label>
<span class="textareaRequiredMsg">Obligatorio ingresar algun dato</span></span>
            </td>
        </tr>
        <tr>
            <td class="hr"><? echo htmlspecialchars("NOMBRE ABREVIADO")."&nbsp;" ?></td>
            <td class="dr">
<span id="sprytextfield1">
<label>
<input type="text" name="NOMBRE_GRAFICO" maxlength="10" value="<? echo str_replace('"', '&quot;', trim($row["NOMBRE_GRAFICO"])) ?>">
</label>
<span class="textfieldRequiredMsg">Obligatorio ingresar algun dato</span></span>
            </td>
        </tr>
        <tr>
            <td class="hr"><? echo htmlspecialchars("FECHA CREACION")."&nbsp;" ?></td>
            <td class="dr">
<span id="sprytextfield2">
<input type="text" name="FECHA_CREACION" value="<? echo str_replace('"', '&quot;', trim($row["FECHA_CREACION"])) ?>">
<span class="textfieldRequiredMsg">Obligatorio ingresar algun dato</span><span class="textfieldInvalidFormatMsg">Formato Incorrecto</span></span></td></tr>
        <tr>
            <td class="hr"><? echo htmlspecialchars("WEB ORGANIZACION")."&nbsp;" ?></td>
            <td class="dr">
<span id="sprytextfield4">
<input type="text" name="WEB_ORGANIZACION" maxlength="50" value="<? echo str_replace('"', '&quot;', trim($row["WEB_ORGANIZACION"])) ?>">
<span class="textfieldInvalidFormatMsg">Formato Incorrecto</span></span>
            </td>
        </tr>
        <tr>
            <td class="hr"><? echo htmlspecialchars("EMAIL ORGANIZACION")."&nbsp;" ?></td>
            <td class="dr">
<span id="sprytextfield5">
<input type="text" name="EMAIL_ORGANIZACION" maxlength="50" value="<? echo str_replace('"', '&quot;', trim($row["EMAIL_ORGANIZACION"])) ?>">
<span class="textfieldInvalidFormatMsg">Formato Incorrecto</span></span>
            </td>
        </tr>
        <tr>
            <td class="hr"><? echo htmlspecialchars("MISION")."&nbsp;" ?></td>
            <td class="dr">
<span id="sprytextarea1">
<label>
<textarea cols="35" rows="4" name="MISION"><? echo str_replace('"', '&quot;', trim($row["MISION"])) ?></textarea>
</label>
<span class="textareaRequiredMsg">Obligatorio ingresar algun dato</span></span>
            </td>
        </tr>
        <tr>
            <td class="hr"><? echo htmlspecialchars("VISION")."&nbsp;" ?></td>
            <td class="dr">
<span id="sprytextarea1">
<label>
<textarea cols="35" rows="4" name="VISION"><? echo str_replace('"', '&quot;', trim($row["VISION"])) ?></textarea>
</label>
<span class="textareaRequiredMsg">Obligatorio ingresar algun dato</span></span>
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
        <tr>
            <td class="hr"><? echo htmlspecialchars("CARGA CUC")."&nbsp;" ?></td>
            <td class="dr"><select name="CARGA_CUC">
                    <?
                    $sql = "select RESPUESTA_ID, NOMBRE_RESPUESTA from dbo.C_RESPUESTA";
                    $res = mssql_query($sql, $conn);

                    while ($lp_row = mssql_fetch_assoc($res)){
                        $val = $lp_row["RESPUESTA_ID"];
                        $caption = $lp_row["NOMBRE_RESPUESTA"];
                        if ($row["CARGA_CUC"] == $lp_row["RESPUESTA_ID"]) {$selstr = " selected"; } else {$selstr = ""; }
                        ?><option value="<? echo $val ?>"<? echo $selstr ?>><? echo $caption ?></option>
                    <? } ?></select>
            </td>
        </tr>
        <tr>
            <td class="hr"><? echo htmlspecialchars("SOLO CARTERA")."&nbsp;" ?></td>
            <td class="dr"><select name="SOLO_CARTERA">
                    <?
                    $sql = "select RESPUESTA_ID, NOMBRE_RESPUESTA from dbo.C_RESPUESTA";
                    $res = mssql_query($sql, $conn);

                    while ($lp_row = mssql_fetch_assoc($res)){
                        $val = $lp_row["RESPUESTA_ID"];
                        $caption = $lp_row["NOMBRE_RESPUESTA"];
                        if ($row["SOLO_CARTERA"] == $lp_row["RESPUESTA_ID"]) {$selstr = " selected"; } else {$selstr = ""; }
                        ?><option value="<? echo $val ?>"<? echo $selstr ?>><? echo $caption ?></option>
                    <? } ?></select>
            </td>
        </tr>
        <tr>
            <td class="hr"><? echo htmlspecialchars("LOGO ANCHO")."&nbsp;" ?></td>
            <td class="dr">
<span id="sprytextfield6">
<input type="text" name="LOGO_ANCHO" value="<? echo str_replace('"', '&quot;', trim($row["LOGO_ANCHO"])) ?>">
<span class="textfieldInvalidFormatMsg">Formato Incorrecto</span>
<span class="textfieldRequiredMsg">Obligatorio ingresar algun dato</span>
</span>
            </td>
        </tr>
        <tr>
            <td class="hr"><? echo htmlspecialchars("LOGO ALTO")."&nbsp;" ?></td>
            <td class="dr">
<span id="sprytextfield7">
<input type="text" name="LOGO_ALTO" value="<? echo str_replace('"', '&quot;', trim($row["LOGO_ALTO"])) ?>">
<span class="textfieldInvalidFormatMsg">Formato Incorrecto</span>
<span class="textfieldRequiredMsg">Obligatorio ingresar algun dato</span>
</span>
            </td>
        </tr>
        <tr>
            <td class="hr"><? echo htmlspecialchars("RUC")."&nbsp;" ?></td>
            <td class="dr">
<span id="ruc">
<input type="text" name="RUC_ORGANIZACION" value="<? echo str_replace('"', '&quot;', trim($row["RUC_ORGANIZACION"])) ?>">
<span class="textfieldRequiredMsg">Ingrese RUC</span> 
<span class="textfieldInvalidFormatMsg">RUC Incorrecto</span> 
<span class="textfieldMinCharsMsg">RUC Incorrecto</span> 
<span class="textfieldMaxCharsMsg">RUC Incorrecto</span>
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
            <td><a href="C_ORGANIZACION.php?a=add">Nuevo Registro</a>&nbsp;</td>
            <? if ($page > 1) { ?>
                <td><a href="C_ORGANIZACION.php?page=<? echo $page - 1 ?>">&lt;&lt;&nbsp;Anterior</a>&nbsp;</td>
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
                                <td><a href="C_ORGANIZACION.php?page=<? echo $j ?>"><? echo $j ?></a></td>
                            <? } } } else { ?>
                        <td><a href="C_ORGANIZACION.php?page=<? echo $startpage ?>"><? echo $startpage ."..." .$count ?></a></td>
                    <? } } } ?>
            <? if ($page < $pagecount) { ?>
                <td>&nbsp;<a href="C_ORGANIZACION.php?page=<? echo $page + 1 ?>">Siguiente&nbsp;&gt;&gt;</a>&nbsp;</td>
            <? } ?>
        </tr>
    </table>
<? } ?>

<? function showrecnav($a, $recid, $count)
{
    ?>
    <table class="bd" border="0" cellspacing="1" cellpadding="4">
        <tr>
            <td><a href="C_ORGANIZACION.php">Pagina Principal</a></td>
            <? if ($recid > 0) { ?>
                <td><a href="C_ORGANIZACION.php?a=<? echo $a ?>&recid=<? echo $recid - 1 ?>">Anterior Registro</a></td>
            <? } if ($recid < $count) { ?>
                <td><a href="C_ORGANIZACION.php?a=<? echo $a ?>&recid=<? echo $recid + 1 ?>">Siguiente Registro</a></td>
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
            <td><a href="C_ORGANIZACION.php">Pagina Principal</a></td>
        </tr>
    </table>
    <hr size="1" noshade>
    <form action="C_ORGANIZACION.php" method="post">
        <p><input type="hidden" name="sql" value="insert"></p>
        <?
        $row = array(
            "ORGANIZACION_ID" => "",
            "TIPO_ORGANIZACION_ID" => "",
            "NOMBRE_ORGANIZACION" => "",
            "NOMBRE_GRAFICO" => "",
            "FECHA_CREACION" => "",
            "WEB_ORGANIZACION" => "",
            "EMAIL_ORGANIZACION" => "",
            "MISION" => "",
            "VISION" => "",
            "FIN_DE_LUCRO_ID" => "",
            "INTERMEDIACION_ID" => "",
            "ESTADO_ID" => "",
            "CARGA_CUC" => "",
            "SOLO_CARTERA" => "",
            "LOGO_ANCHO" => "",
            "LOGO_ALTO" => "",
            "RUC_ORGANIZACION" => "");
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
            <td><a href="C_ORGANIZACION.php?a=add">Nuevo Registro</a></td>
            <td><a href="C_ORGANIZACION.php?a=edit&recid=<? echo $recid ?>">Editar Registro</a></td>
            <td><a href="C_ORGANIZACION.php?a=del&recid=<? echo $recid ?>">Borrar Registro</a></td>
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
    <form action="C_ORGANIZACION.php" method="post">
        <input type="hidden" name="sql" value="update">
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
    <form action="C_ORGANIZACION.php" method="post">
        <input type="hidden" name="sql" value="delete">
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
			ORG.ORGANIZACION_ID AS ORDEN,
			ORG.ORGANIZACION_ID AS ORGANIZACION_ID,
			ORG.TIPO_ORGANIZACION_ID,
			EST.NOMBRE_TIPO_ORGANIZACION,
			ORG.NOMBRE_ORGANIZACION,
			ORG.NOMBRE_GRAFICO,
			convert(varchar(10),ORG.FECHA_CREACION,111) AS FECHA_CREACION,
			ORG.WEB_ORGANIZACION,
			ORG.EMAIL_ORGANIZACION,
			ORG.MISION AS MISION,
			ORG.VISION AS VISION,
			ORG.FIN_DE_LUCRO_ID,
			ORG.INTERMEDIACION_ID,
			ORG.ESTADO_ID,
			ORG.CARGA_CUC,
			ORG.SOLO_CARTERA,
			ORG.LOGO_ANCHO,
			ORG.LOGO_ALTO,
			ORG.RUC_ORGANIZACION
			from
			dbo.C_ORGANIZACION ORG,
			dbo.C_ESTATUTO_JURIDICO EST
			WHERE
			ORG.TIPO_ORGANIZACION_ID = EST.TIPO_ORGANIZACION_ID";
    switch ($filterfield) {
        case "NOMBRE_TIPO_ORGANIZACION":
            $var_tmp = "EST.";
            break;
        default:
            $var_tmp = "ORG.";
            break;
    }
    if (isset($filterstr) && $filterstr!='' && isset($filterfield) && $filterfield!='') {
        $sql .= " AND " .$var_tmp.sqlstr($filterfield) ." like '" .$filterstr ."'";
    } elseif (isset($filterstr) && $filterstr!='') {
        $sql .= " where (ORGANIZACION_ID like '" .$filterstr ."') or (TIPO_ORGANIZACION_ID like '" .$filterstr ."') or (NOMBRE_ORGANIZACION like '" .$filterstr ."') or (NOMBRE_GRAFICO like '" .$filterstr ."') or (FECHA_CREACION like '" .$filterstr ."') or (WEB_ORGANIZACION like '" .$filterstr ."') or (EMAIL_ORGANIZACION like '" .$filterstr ."') or (FIN_DE_LUCRO_ID like '" .$filterstr ."') or (INTERMEDIACION_ID like '" .$filterstr ."') or (ESTADO_ID like '" .$filterstr ."') or (CARGA_CUC like '" .$filterstr ."') or (SOLO_CARTERA like '" .$filterstr ."') or (LOGO_ANCHO like '" .$filterstr ."') or (LOGO_ALTO like '" .$filterstr ."') or (RUC_ORGANIZACION like '" .$filterstr ."')";
    }
    if (isset($order) && $order!='') $sql .= " order by \"" .sqlstr($order) ."\"";
    if (isset($ordtype) && $ordtype!='') $sql .= " " .sqlstr($ordtype);
    if ($order == '' and $ordtype == '')
    {
        $sql = $sql." ORDER BY ORDEN";
    }
    $res = mssql_query($sql, $conn);
    return $res;
}

function corta_texto($texto, $num) {
    $txt = (strlen($texto) > $num) ? substr($texto,0,$num)."..." : $texto;
    return $txt;
}
//$titulo = "hola me llamo Ramón y follo un montón XD";
//$limitado = "30";

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
			dbo.C_ORGANIZACION ORG,
			dbo.C_ESTATUTO_JURIDICO EST
			WHERE
			ORG.TIPO_ORGANIZACION_ID = EST.TIPO_ORGANIZACION_ID";
    switch ($filterfield) {
        case "NOMBRE_TIPO_ORGANIZACION":
            $var_tmp = "EST.";
            break;
        default:
            $var_tmp = "ORG.";
            break;
    }
    if (isset($filterstr) && $filterstr!='' && isset($filterfield) && $filterfield!='') {
        $sql .= " AND " .$var_tmp.sqlstr($filterfield) ." like '" .$filterstr ."'";
    } elseif (isset($filterstr) && $filterstr!='') {
        $sql .= " where (ORGANIZACION_ID like '" .$filterstr ."') or (TIPO_ORGANIZACION_ID like '" .$filterstr ."') or (NOMBRE_ORGANIZACION like '" .$filterstr ."') or (NOMBRE_GRAFICO like '" .$filterstr ."') or (FECHA_CREACION like '" .$filterstr ."') or (WEB_ORGANIZACION like '" .$filterstr ."') or (EMAIL_ORGANIZACION like '" .$filterstr ."') or (FIN_DE_LUCRO_ID like '" .$filterstr ."') or (INTERMEDIACION_ID like '" .$filterstr ."') or (ESTADO_ID like '" .$filterstr ."') or (CARGA_CUC like '" .$filterstr ."') or (SOLO_CARTERA like '" .$filterstr ."') or (LOGO_ANCHO like '" .$filterstr ."') or (LOGO_ALTO like '" .$filterstr ."') or (RUC_ORGANIZACION like '" .$filterstr ."')";
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
    /* $sql = "insert into dbo.C_ORGANIZACION (ORGANIZACION_ID, TIPO_ORGANIZACION_ID, NOMBRE_ORGANIZACION, NOMBRE_GRAFICO, FECHA_CREACION, WEB_ORGANIZACION, EMAIL_ORGANIZACION, FIN_DE_LUCRO_ID, INTERMEDIACION_ID, ESTADO_ID, CARGA_CUC, SOLO_CARTERA, LOGO_ANCHO, LOGO_ALTO) values (" .sqlvalue(@$_POST["ORGANIZACION_ID"], false) .", " .sqlvalue(@$_POST["TIPO_ORGANIZACION_ID"], false) .", " .sqlvalue(@$_POST["NOMBRE_ORGANIZACION"], true) .", " .sqlvalue(@$_POST["NOMBRE_GRAFICO"], true) .", " .sqlvalue(@$_POST["FECHA_CREACION"], true) .", " .sqlvalue(@$_POST["WEB_ORGANIZACION"], true) .", " .sqlvalue(@$_POST["EMAIL_ORGANIZACION"], true) .", " .sqlvalue(@$_POST["FIN_DE_LUCRO_ID"], true) .", " .sqlvalue(@$_POST["INTERMEDIACION_ID"], true) .", " .sqlvalue(@$_POST["ESTADO_ID"], false) .", " .sqlvalue(@$_POST["CARGA_CUC"], true) .", " .sqlvalue(@$_POST["SOLO_CARTERA"], true) .", " .sqlvalue(@$_POST["LOGO_ANCHO"], false) .", " .sqlvalue(@$_POST["LOGO_ALTO"], false) .")"; */
    $sql = "insert into dbo.C_ORGANIZACION (TIPO_ORGANIZACION_ID, NOMBRE_ORGANIZACION, NOMBRE_GRAFICO, FECHA_CREACION, WEB_ORGANIZACION, EMAIL_ORGANIZACION, MISION, VISION, FIN_DE_LUCRO_ID, INTERMEDIACION_ID, ESTADO_ID, CARGA_CUC, SOLO_CARTERA, LOGO_ANCHO, LOGO_ALTO, RUC_ORGANIZACION) values (" .sqlvalue(@$_POST["TIPO_ORGANIZACION_ID"], false) .", " .sqlvalue(@$_POST["NOMBRE_ORGANIZACION"], true) .", " .sqlvalue(@$_POST["NOMBRE_GRAFICO"], true) .", " .sqlvalue(@$_POST["FECHA_CREACION"], true) .", " .sqlvalue(@$_POST["WEB_ORGANIZACION"], true) .", " .sqlvalue(@$_POST["EMAIL_ORGANIZACION"], true) .", " .sqlvalue(@$_POST["MISION"], true) .", ".sqlvalue(@$_POST["VISION"], true) .", " .sqlvalue(@$_POST["FIN_DE_LUCRO_ID"], true) .", " .sqlvalue(@$_POST["INTERMEDIACION_ID"], true) .", " .sqlvalue(@$_POST["ESTADO_ID"], false) .", " .sqlvalue(@$_POST["CARGA_CUC"], true) .", " .sqlvalue(@$_POST["SOLO_CARTERA"], true) .", " .sqlvalue(@$_POST["LOGO_ANCHO"], false) .", " .sqlvalue(@$_POST["LOGO_ALTO"], false).", " .sqlvalue(@$_POST["RUC_ORGANIZACION"], true) .")";
    if (@mssql_query($sql, $conn) == false)
    {
        echo '<span class="Mensajes">NO SE GUARDO EL REGISTRO</span>';
        //echo $sql;
        echo "<br></br>";
    }
}

function sql_update()
{
    global $conn;
    global $_POST;
    /* $sql = "update dbo.C_ORGANIZACION set ORGANIZACION_ID=" .sqlvalue(@$_POST["ORGANIZACION_ID"], false) .", TIPO_ORGANIZACION_ID=" .sqlvalue(@$_POST["TIPO_ORGANIZACION_ID"], false) .", NOMBRE_ORGANIZACION=" .sqlvalue(@$_POST["NOMBRE_ORGANIZACION"], true) .", NOMBRE_GRAFICO=" .sqlvalue(@$_POST["NOMBRE_GRAFICO"], true) .", FECHA_CREACION=" .sqlvalue(@$_POST["FECHA_CREACION"], true) .", WEB_ORGANIZACION=" .sqlvalue(@$_POST["WEB_ORGANIZACION"], true) .", EMAIL_ORGANIZACION=" .sqlvalue(@$_POST["EMAIL_ORGANIZACION"], true) .", FIN_DE_LUCRO_ID=" .sqlvalue(@$_POST["FIN_DE_LUCRO_ID"], true) .", INTERMEDIACION_ID=" .sqlvalue(@$_POST["INTERMEDIACION_ID"], true) .", ESTADO_ID=" .sqlvalue(@$_POST["ESTADO_ID"], false) .", CARGA_CUC=" .sqlvalue(@$_POST["CARGA_CUC"], true) .", SOLO_CARTERA=" .sqlvalue(@$_POST["SOLO_CARTERA"], true) .", LOGO_ANCHO=" .sqlvalue(@$_POST["LOGO_ANCHO"], false) .", LOGO_ALTO=" .sqlvalue(@$_POST["LOGO_ALTO"], false) ." where " ."(ORGANIZACION_ID=" .sqlvalue(@$_POST["xORGANIZACION_ID"], false) .*/
    $sql = "update dbo.C_ORGANIZACION set TIPO_ORGANIZACION_ID=" .sqlvalue(@$_POST["TIPO_ORGANIZACION_ID"], false) .", NOMBRE_ORGANIZACION=" .sqlvalue(@$_POST["NOMBRE_ORGANIZACION"], true) .", NOMBRE_GRAFICO=" .sqlvalue(@$_POST["NOMBRE_GRAFICO"], true) .", FECHA_CREACION=" .sqlvalue(@$_POST["FECHA_CREACION"], true) .", WEB_ORGANIZACION=" .sqlvalue(@$_POST["WEB_ORGANIZACION"], true) .", EMAIL_ORGANIZACION=" .sqlvalue(@$_POST["EMAIL_ORGANIZACION"], true) .", MISION=" .sqlvalue(@$_POST["MISION"], true) .", VISION=" .sqlvalue(@$_POST["VISION"], true) .", FIN_DE_LUCRO_ID=" .sqlvalue(@$_POST["FIN_DE_LUCRO_ID"], true) .", INTERMEDIACION_ID=" .sqlvalue(@$_POST["INTERMEDIACION_ID"], true) .", ESTADO_ID=" .sqlvalue(@$_POST["ESTADO_ID"], false) .", CARGA_CUC=" .sqlvalue(@$_POST["CARGA_CUC"], true) .", SOLO_CARTERA=" .sqlvalue(@$_POST["SOLO_CARTERA"], true) .", LOGO_ANCHO=" .sqlvalue(@$_POST["LOGO_ANCHO"], false) .", LOGO_ALTO=" .sqlvalue(@$_POST["LOGO_ALTO"], false) .", RUC_ORGANIZACION=" .sqlvalue(@$_POST["RUC_ORGANIZACION"], true) ." where " ."(ORGANIZACION_ID=" .sqlvalue(@$_POST["xORGANIZACION_ID"], false) .")";

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

    $sql = "delete from dbo.C_ORGANIZACION where " ."(ORGANIZACION_ID=" .sqlvalue(@$_POST["xORGANIZACION_ID"], false) .")";
    if (@mssql_query($sql, $conn) == false)
    {
        echo '<span class="Mensajes">NO SE ELIMINO EL REGISTRO</span>';
        echo "<br></br>";
    }
} ?>
