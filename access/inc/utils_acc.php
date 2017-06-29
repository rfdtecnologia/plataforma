<?php
function http_redirect_enc( $url ){
  echo $url;
  header( 'Location: ' . URL_RELATIVA_ENC . $url );
  exit;
}
?>
