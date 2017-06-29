<?php
$var_includ='';
$inicio = '';
function head($page){
  $inicio = $page;
  $var_includ = include('header.php');
  return $var_includ;
}
function menu(){
  $var_includ = include('menu.php');
  return $var_includ;
}
function foot(){
  $var_includ = include('footer.php');
  return $var_includ;
}
function datosCliente(){
  $var_includ = include('perfil_cliente.php');
  return $var_includ;
}
function btnEnviar(){
  $var_includ = include('btn_enviar.php');
  return $var_includ;
}
function nameEnc(){
  $var_includ = include('n_enc.php');
  return $var_includ;
}
function pregEnc(){
  $var_includ = include('p_enc.php');
  return $var_includ;
}
function urlString($string){
  $to_min = mb_strtolower(trim($string));
	return strtr($to_min,'ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ','AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn');
}
function enviarEnc(){
  $var_includ = include('guardar.php');
  return $var_includ;
}

function obtenerNavegadorWeb(){
  $agente = $_SERVER['HTTP_USER_AGENT'];
  $navegador = 'Unknown';
  if(preg_match('/MSIE/i',$agente) && !preg_match('/Opera/i',$agente)){
    $navegador = 'Internet Explorer';
    $navegador_corto = "MSIE";
  }
  elseif(preg_match('/Firefox/i',$agente))
  {
    $navegador = 'Mozilla Firefox';
    $navegador_corto = "Firefox";
  }
  elseif(preg_match('/Chrome/i',$agente))
  {
    $navegador = 'Google Chrome';
    $navegador_corto = "Chrome";
  }
  elseif(preg_match('/Safari/i',$agente))
  {
    $navegador = 'Apple Safari';
    $navegador_corto = "Safari";
  }
  elseif(preg_match('/Opera/i',$agente))
  {
    $navegador = 'Opera';
    $navegador_corto = "Opera";
  }
  elseif(preg_match('/Netscape/i',$agente))
  {
    $navegador = 'Netscape';
    $navegador_corto = "Netscape";
  }
  return $navegador_corto;
}

function cambiaEncodeString($cadena){
  $ew = obtenerNavegadorWeb();
  $cadenaCambiada = '';
  $nombre_navegador = $ew;
  if ($nombre_navegador == 'Firefox') {
    $cadenaCambiada = mb_convert_encoding($cadena, "UTF-8", "ISO-8859-1");
  }elseif ($nombre_navegador == 'Chrome') {
    $cadenaCambiada = $cadena;
  }
  return $cadenaCambiada;
}
function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}
function cerrarSesion(){
  $_SESSION = array();
  if ( ini_get( "session.use_cookies" ) ) {
      $params = session_get_cookie_params();
      setcookie( session_name(), '', time() - 42000,
          $params["path"], $params["domain"],
          $params["secure"], $params["httponly"]
      );
  }
  session_destroy();
  http_redirect('');
}
?>
