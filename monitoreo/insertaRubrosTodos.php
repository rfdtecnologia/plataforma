<? session_start(); ?>


<html>
<head>
<title>RFD -- INSERTAR RUBROS</title>
<meta name="generator" content="text/html">

<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/HojasEstilos.css" rel="stylesheet" type="text/css">
<link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="jquery.js"></script>

 <script type="text/javascript">
   function cargarModelos(str){
	if (str==""){
	 document.getElementById("txtHint").innerHTML="";
	 return;
	}
        // código para IE7+, Firefox, Chrome, Opera, Safari
	if (window.XMLHttpRequest){
	 xmlhttp=new XMLHttpRequest();
        //código para IE6, IE5
	}else{
	 xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
	  if (xmlhttp.readyState==4 && xmlhttp.status==200){
		document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
		}
	}
	 xmlhttp.open('GET','proc.php?marca='+str,true);
	 xmlhttp.send();
   }
 </script>

</head>
<body>
<table width="100%" border="0">
      <tr>
        <?php
        $var_imagen = "../imagenes/".$_SESSION["var_organizacion"].".jpg";
        $var_titulo = "PARAMETROS";
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

 <br/>
 <br/>

<form action="proc.php" method="POST">
<center>
  <select id="marcas" name="marcas" onchange="cargarModelos(this.value)">
	<option id="0">Seleccione una organizacion...</option>
	<?php
	  include("../librerias/conexion.php");
      $conn = connect();
	  $consulta = mssql_query("SELECT * FROM dbo.C_ORGANIZACION ORDER BY NOMBRE_ORGANIZACION ASC");
	  while($fila=mssql_fetch_array($consulta))
	  {
          echo "<option value='".$fila["ORGANIZACION_ID"]."'>".$fila["NOMBRE_ORGANIZACION"]."</option>";
	  }
	  ?>
  </select>

 <p id="txtHint"></p>
 </center>
</form>
<form action="pasaSP.php" method = "POST">
<center>
 <p><input type="submit" name="enviar" value="Cargar Rubros"></p>
 </center>
 </form>
</body>
</html>
