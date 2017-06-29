<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>RFD-ONLINE - Cargar archivo</title>
<link rel="stylesheet" href="css/style.css" type="text/css">
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/scroll_animate.js"></script>
</head>

<body>
    <div class="content">
      <div class="top">
          <h1>Cargar CUC</h1>
      </div>
        <fieldset>
            <legend>Importar CUC</legend>

            <form enctype="multipart/form-data" method="POST" action="">
                <label>Selecciona</label>
                <input type="file" name="file"><br>
                <input type="submit" value="Cargar" name="submitFileUpload">
            </form>
        </fieldset>
        <form action="send2.php" method="post" enctype="multipart/form-data" id="main_form" name="main_form">
          <div class="s_error">
            <?php if ($message_error): ?>
                  <ul class="list_error">
                      <?php foreach ($message_error as $error): ?>
                          <li> <?php echo $error ?> </li>
                      <?php endforeach; ?>
                  </ul>
              <?php endif; ?>
          </div>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td align ="center">N�MERO</td>
                    <td align ="center">CODIGO</td>
                    <td align ="center">VALOR</td>
                    <td align ="center">&nbsp</td>
                </tr>

            <?php
                if (isset($_POST['submitFileUpload'])) {
                  $file_import = 'import/'.$_FILES['file']['name'];
                  if ($_FILES["file"]["type"] == "text/plain" || $_FILES["file"]["type"] == "text/csv") {
                    echo $prueba;
                    if (@move_uploaded_file($_FILES['file']['tmp_name'], $file_import)) {
                      echo 'entró';
                      $fp = fopen($file_import, 'r');//r modo solo de lectura, coloca el puntero al fichero al principio del fichero.
                      $line = fgets($fp);
                      if(strpos($line, ';') !== FALSE && strpos($line, ',') === FALSE && strpos($line, "\t") === FALSE) {
                          $delimiter = ';';
                      } else if(strpos($line, ',') !== FALSE && strpos($line, ';') === FALSE && strpos($line, "\t") === FALSE) {
                          $delimiter = ',';
                      } else if(strpos($line, "\t") !== FALSE && strpos($line, ',') === FALSE && strpos($line, ';') === FALSE) {
                          $delimiter = "\t";
                      }else {
                          die('Problema con el archivo. Los separadores permitidos son "," , ";" o "tabulación".');
                      }
                      $contador = 0;

                      while (($data = fgetcsv($fp, 9999, $delimiter)) !== FALSE) {
                          if ($contador >= 0) {
                              ?>
                              <tr>
                                  <td align="center" class="r_content">
                                      <input readonly="readonly" class="numero" value="<?php echo $contador ?>" type="text" required="true" name="num_[<?php echo $contador ?>]" id="num_[<?php echo $contador ?>]">
                                  </td>
                                  <td align="center" class="r_content">
                                      <input readonly="readonly" value="<?php echo $data[0] ?>" class="codigo" type="text" required="true" name="cod_[<?php echo $contador ?>]">
                                  </td>
                                  <td align="center" class="r_content">
                                      <input readonly="readonly" id="inInput<?php echo $contador ?>" class="valor" value="<?php echo $data[1] ?>" type="text"  required="true" name="val_[<?php echo $contador ?>]">
                                  </td>
                                  <td align="center" class="r_content">
                                      <input class="btn_edit" value="Editar Valor" type="button" name="btn_edit_[<?php echo $contador ?>]" onclick="enableInput(<?php echo $contador ?>)">
                                  </td>
                              </tr>
                          <?php }
                          $aux = $contador;
                          $contador++;
                      }
                      fclose($fp);
                    }
                  }else {
                        echo "<p class='carg_error'>El archivo subido no es correcto!</p>";
                  }
                }
                ?>
            </table>
            <div class="btn_save">
              <span class="ir-arriba"></span>
                <input id="btnGuardar" type="submit" value="Guardar">
            </div>

        </form>
    </div>
    <script>
      function enableInput( valor ){
        $('#inInput' + valor).attr('readonly', false);
        $('#inInput' + valor).css('color','#222222');
      }
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
</body>
</html>
