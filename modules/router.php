<?php

define('__PUBLIC_ROOT__', __DOCUMENT_ROOT__.'/src/public');
define('__VIEWS_ROOT__', __DOCUMENT_ROOT__.'/src/views');

$REQUEST__route = rtrim(str_replace($_SERVER['QUERY_STRING'], '', $_SERVER['REQUEST_URI']), '?');
$REQUEST__filename = __VIEWS_ROOT__.str_replace('-', '_', "{$REQUEST__route}.php");

?>
<?php
if($REQUEST__route === '/' && defined('ROUTER__defaultRoute')) {

  header('Location: '.ROUTER__defaultRoute);

} elseif(file_exists($REQUEST__filename)) {
  
  include_once($REQUEST__filename);

} elseif(defined('ROUTER__error400Path') ? file_exists(__VIEWS_ROOT__.'/'.ROUTER__error400Path) : false) {
  
  http_response_code(404);
  include_once(__VIEWS_ROOT__.'/'.ROUTER__error400Path);

} else {

  http_response_code(404);
  print(<<<HTML
    <h3 style="margin:0">Página no encontrada</h3>
    <i style="padding-left:10px">Error 404</i>
  HTML);

}

?>
