<?php

define('PRODUCTION_MODE', $_SERVER['HTTP_HOST'] !== 'localhost');

error_reporting(E_ALL);

ini_set('log_errors', 'On');
ini_set('error_log', "{$_SERVER['DOCUMENT_ROOT']}/error.log");
ini_set('display_errors', !PRODUCTION_MODE ? 'On' : 'Off');
ini_set('display_startup_errors', !PRODUCTION_MODE ? 'On' : 'Off');

ini_set('session.name', 'MUXSESSID');
ini_set('date.timezone', 'America/Bogota');

session_set_cookie_params([
  'path'     => '/',
  'secure'   => PRODUCTION_MODE,
  'httponly' => true,
  'samesite' => 'Lax'
]);

?>
<?php

define('__DOCUMENT_ROOT__', $_SERVER['DOCUMENT_ROOT']);
define('__DATA_ROOT__', __DOCUMENT_ROOT__.'/data');

const ROUTER__defaultRoute = '/login';
require_once(__DOCUMENT_ROOT__.'/modules/router.php');

?>
