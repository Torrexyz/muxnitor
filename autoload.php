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
define('__VIEWS_ROOT__', __DOCUMENT_ROOT__.'/src/views');

define('__DATA_ROOT__', __DOCUMENT_ROOT__.'/content/data');
define('__DOCS_ROOT__', __DOCUMENT_ROOT__.'/content/docs');
define('__POSTS_PATH__', __DOCUMENT_ROOT__.'/content/posts.json');

define('__PUBLIC_ROOT__', (object)array(
  'ajax'    => __DOCUMENT_ROOT__.'/src/public/ajax',
  'rsrc'    => __DOCUMENT_ROOT__.'/src/public/resources',
  'scripts' => __DOCUMENT_ROOT__.'/src/public/scripts',
  'styles'  => __DOCUMENT_ROOT__.'/src/public/styles'
));

?>
<?php require_once(__DOCUMENT_ROOT__.'/modules/dbconn.php'); ?>
