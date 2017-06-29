<?php
/**
 * Created by PhpStorm.
 * User: dparedes
 * Date: 05/06/2017
 * Time: 13:54
 */

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script>
        function showHint(str) {
            if (str.length == 0){
                document.getElementById("txtHint").innerHTML = "";
                return;
            }else {
             var xmlhttp = new XMLHttpRequest();
             xmlhttp.onreadystatechange = function () {
                 if (this.readyState == 4 && this.status == 200){
                     document.getElementById("txtHint").innerHTML = this.responseText;
                 }
             };
             xmlhttp.open("GET", "gethint.php?q=" + str, true);
             xmlhttp.send();
            }
        }
    </script>
</head>
<body>
<p><b>Start typing a name in the input field below:</b></p>
<form>
    first name : <input type="text" onkeyup="showHint(this.value)">
</form>
<p>Sugegestions : <span id=""txtHint></span></p>
</body>
</html>
