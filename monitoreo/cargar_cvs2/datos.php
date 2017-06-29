<?php
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
  echo "<table width='100%' border='0' cellspacing='0' cellpadding='0' class='content_info'>";
  echo "<tr>";
  echo "<td align ='center'>N&Uacute;MERO</td>";
  echo "<td align ='center'>C&Oacute;DIGO</td>";
  echo "<td align ='center'>VALOR</td>";
  echo "<td align ='center'>&nbsp</td>";
  echo "</tr>";
  $file_import = 'import/'.$_FILES['file']['name'];

  if ($_FILES["file"]["type"] == "text/plain" || $_FILES["file"]["type"] == "text/csv") {
    //echo $_FILES['file']['tmp_name'];
      //if (@move_uploaded_file($_FILES['file']['tmp_name'], $file_import)) {
    if (@move_uploaded_file($_FILES['file']['tmp_name'], $file_import)) {
      $fp = fopen($file_import, 'r');//r modo solo de lectura, coloca el puntero al fichero al principio del fichero.
      $line = fgets($fp);
      if(strpos($line, ';') !== FALSE && strpos($line, ',') === FALSE && strpos($line, "\t") === FALSE) {
        $delimiter = ';';
      } else if(strpos($line, ',') !== FALSE && strpos($line, ';') === FALSE && strpos($line, "\t") === FALSE) {
        $delimiter = ',';
      } else if(strpos($line, "\t") !== FALSE && strpos($line, ',') === FALSE && strpos($line, ';') === FALSE) {
        $delimiter = "\t";
      }else {
        echo $delimiter;
        die('Problema con el archivo. Los separadores permitidos son "," , ";" o "tabulación".');
      }
      $contador = 0;

      while (($data = fgetcsv($fp, 9999, $delimiter)) !== FALSE) {
        if ($contador >= 0) {
          echo "<tr>";
          echo "<td align='center' class='r_content'>";
          echo "<input readonly='readonly' class='numero' value='".$contador."' type='text' required='true' name='num_[".$contador."]' id='num_[".$contador."]'>";
          echo "</td>";
          echo "<td align='center' class='r_content'>";
          echo "<input readonly='readonly' value=".$data[0]." class='codigo' type='text' required='true' name='cod_[".$contador."]'>";
          echo "</td>";
          echo "<td align='center' class='r_content'>";
          echo "<input readonly='readonly' id='inInput".$contador."' class='valor' value='".$data[1]."' type='text'  required='true' name='val_[".$contador."]'>";
          echo "</td>";
          echo "<td align='center' class='r_content'>";
          echo "<input class='btn_edit' value='Editar Valor' type='button' name='btn_edit_[".$contador."]' onclick='enableInput(".$contador.")'>";
          echo "</td>";
          echo "</tr>";



        }
        $aux = $contador;
        $contador++;
      }
      fclose($fp);
      unlink($file_import);
      echo "<input value='$aux' type='hidden' name='num_rows'>";
    }
  }else {
    echo "<p class='carg_error'>El archivo subido no es correcto!</p>";
  }
}
echo "</table>";
?>
