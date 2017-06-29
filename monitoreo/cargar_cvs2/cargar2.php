<?php
include('../../librerias/libs_sql.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <title>Cargar archivo</title>
  <link rel="stylesheet" href="css/style.css" type="text/css">
  <script type="text/javascript" src="js/jquery.js"></script>
  <script type="text/javascript">
  $(document).ready(function(){
    $('.ir-arriba').click(function(){
      $('body, html').animate({
        scrollTop: '0px'
      }, 300);
    });

    $(window).scroll(function(){
      if( $(this).scrollTop() > 0 ){
        $('.ir-arriba').attr('style', 'display:block');
      } else {
        $('.ir-arriba').attr('style', 'display:none');
      }
    });

  });
  </script>
  <script src="../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
  <link href="../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
  <link href="../SpryAssets/HojasEstilos.css" rel="stylesheet" type="text/css">
  <link href="../SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />
  <script href="../js/jquery.js" type="text/javascript"></script>
</head>

<body>
  <?php
  Conectar();
  $var_nombre_usuario = $_SESSION["nombre_usuario"];
  $fecha = fecha();
  $var_usuario = $_SESSION['usuario_id'];
  $var_organizacion = $_SESSION["var_organizacion"];
  $var_periodo = $_SESSION["var_periodo"];
  $var_imagen = "../../imagenes/".$_SESSION["var_organizacion"].".jpg";
  $var_cuc = @$_GET["var_cuc"];
  $var_descripcion = "INGRESÓ Y NO ENVIÓ";
  $var_titulo = "CARGAR CUC por Agencias";
  $var_rubro = $var_cuc;
  $consultar="SELECT *
  FROM dbo.C_NOVEDAD
  WHERE
  PERIODO_ID = $var_periodo AND
  ORGANIZACION_ID = $var_organizacion AND
  MENU_ID = $var_rubro";
  $resultado=ConsultarTabla($consultar);
  $filas=NumeroFilas($resultado);
  if ($filas == 0)
  {
    $query1="INSERT INTO
    dbo.C_NOVEDAD
    (PERIODO_ID,ORGANIZACION_ID,MENU_ID,ESTADO_ID,USUARIO_ID,HORA_NOVEDAD,DESCRIPCION_NOVEDAD,NOMBRE_USUARIO)
    VALUES
    ($var_periodo,$var_organizacion,$var_rubro,0,$var_usuario,'$fecha','$var_descripcion','$var_nombre_usuario')";
    Actualizar($query1);
  }

  include ('../head.php');

  ?>

  <div align="center"><a href="../MenuPrincipal.php" class="btn_menu">Menu Principal</a></div>
  <table width="100%" border="0">
    <tr>
      <?php
      $var_imagen = "../../imagenes/".$_SESSION["var_organizacion"].".jpg";

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
      <td width="50%"><div align="right"><a href="http://www.rfr.org.ec/" target="_blank"><img src="../../imagenes/logo_rfr.jpg" alt="" width="95" height="95" /></a></div></td>
    </tr>
  </table>
  <p class="Mensajes">Miembro: <?php echo mb_strtoupper($_SESSION["var_nombre_organizacion"]); ?></p>
  <p class="Mensajes">Periodo: <?php echo mb_strtoupper($_SESSION["var_nombre_periodo"]); ?></p>
  <div class="content">
    <form action="send2.php" method="post" enctype="multipart/form-data" id="main_form" name="main_form">
      <fieldset>
        <legend>Importar CUC</legend>
        <div class="content_radio">
          <input type="radio" name="tipo_carga" value="consolidado" checked> Consolidado
          <input type="radio" name="tipo_carga" value="por_agencias"> Por agencias
        </div>
        <div id="sucursal_content" style="display:none;">
          <label for="carg_sucursal">Seleccione la Sucursal</label>
          <select class="" name="carg_sucursal"  id="carg_sucursal">
            <option value="-1">--SELECCIONE--</option>
            <?php
            $query_agencia = "SELECT * FROM C_AGENCIAS where ORGANIZACION_ID = $var_organizacion";
            $res = ConsultarTabla($query_agencia);
            $rows_c = NumeroFilas($res);
            for ($j = 0; $j < $rows_c; ++$j){
              $col_nombre = mssql_result($res,$j,"NOMBRE_AGENCIA");
              $col_id = mssql_result($res,$j,"AGENCIA_ID");
              echo "<option value='".$col_id."'>$col_nombre</option>";
            }
            ?>
          </select>
        </div>
        <hr>
        <label>Seleccionar Archivo</label>
        <input type="file" name="file"><br>
        <input type="submit" value="Cargar" name="submitFileUpload" id="submitFileUpload">
      </fieldset>
      <div class="s_error">
        <?php if ($message_error): ?>
          <ul class="list_error">
            <?php foreach ($message_error as $error): ?>
              <li> <?php echo $error ?> </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </div>
      <div id="content_table">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="content_info">
          <tr>
            <td align ="center">NÚMERO</td>
            <td align ="center">CÓDIGO</td>
            <td align ="center">VALOR</td>
            <td align ="center">&nbsp</td>
          </tr>
        </table>
      </div>
      <div class="btn_save">
        <span class="ir-arriba"></span>
        <input id="btnGuardar" type="submit" value="Grabar y Salir">
      </div>
    </form>
  </div>
</body>
<script>
$(".content_radio").change(function(event) {
  var str = "";
  $( "input:checked" ).each(function() {
    str = $( this ).val();
  });
  if (str == "por_agencias") {
    $("#sucursal_content").css('display', 'block');
  }else {
    $("#sucursal_content").css('display', 'none');
  }
});
</script>

<script>
function enableInput( valor ){
  $('#inInput' + valor).attr('readonly', false);
  $('#inInput' + valor).css('color','#222222');
}
</script>
<script>
$('#submitFileUpload').on('click', function(event) {
  event.preventDefault();
  var formData = new FormData(document.getElementById('main_form'));
  $.ajax({
    url: 'datos.php',
    type: 'POST',
    dataType: 'html',
    data: formData,
    cache: false,
    contentType: false,
    processData: false
  })
  .done(function(data) {
    $("#content_table").html("" + data);
  });

});
</script>
<script type="text/javascript">
$(document).ready(function() {
  $("#btnGuardar").on('click', function(event) {
    $('.s_error').html('');
    event.preventDefault();
    var proceed = true;
    if (!$('.r_content').length) {
      proceed = false;
    }
    $("input[required=true]").each(function() {
      if(!$.trim($(this).val())){ //if this field is empty
        $(this).css('border-color','red'); //change border color to red
        proceed = false; //set do not proceed flag
        $('.s_error').css('display', 'block');
        $('.s_error').html('<p>Todos los campos son obligatorios</p>');
      }
      var form_codigo = /^[0-9]+$/;
      if($(this).attr("class")=="codigo" && !form_codigo.test($.trim($(this).val()))){
        $(this).css('border-color','red'); //change border color to red
        proceed = false; //set do not proceed flag
        $('.s_error').css('display', 'block');
        $('.s_error').html('<p>Uno o varios de los campos está incorrecto</p>');
      }
      var form_valor = /^-?(\d{1,})(?:\.(\d{2}))?$/;
      var cont = 0;
      var mens = '';
      if($(this).attr("class")=="valor" && !form_valor.test($.trim($(this).val()))){
        var num_error = $(this).attr("class", "valor").length;
        var name = $(this).attr("name");
        var num_final = name.length - 1;
        var num = name.substring(5,num_final);
        $(this).css('border-color','red'); //change border color to red
        proceed = false; //set do not proceed flag
        $('.s_error').css('display', 'block');
        cont = num;
      }
      if (cont != 0) {
        for (var i = 0; i < cont; i++) {
          mens = '<p>Uno o varios de los campos en la fila número <a href="#num_['+num+']">'+num+'</a> está incorrecto </p>';
        }
        $('.s_error').append('<p>'+mens+'</p>');
        //alert(cont);
      }

    });
    if (proceed) {
      $("form#main_form").submit();
    }
  });
  $("input[required=true]").keyup(function() {
    $(this).css('border-color','');
  });
});
</script>
</html>
