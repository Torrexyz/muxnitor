<?php

const ROUTER__defaultRoute = '/login';
const ROUTER__error400Route = null;

define('__DOCUMENT_FILE__', __VIEWS_ROOT__.str_replace('-', '_', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH).'.php'));

?>
<?php
if($_SERVER['REQUEST_URI'] === '/' && ROUTER__defaultRoute) {

  header('Location: '.ROUTER__defaultRoute);

} elseif(file_exists(__DOCUMENT_FILE__)) {
  
  include_once(__DOCUMENT_FILE__);

} elseif(defined('ROUTER__error400Path') ? file_exists(__VIEWS_ROOT__.'/'.ROUTER__error400Route) : false) {
  
  http_response_code(404);
  include_once(__VIEWS_ROOT__.'/'.ROUTER__error400Route);

} else {

  http_response_code(404);
  print(<<<HTML
    <h3 style="margin:0">Página no encontrada</h3>
    <i style="padding-left:10px">Error 404</i>
  HTML);

}

?>
