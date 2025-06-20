<?php

define('__DOCUMENT_ROOT__', $_SERVER['DOCUMENT_ROOT']);
define('__DATA_ROOT__', __DOCUMENT_ROOT__.'/data');

const ROUTER__defaultRoute = '/login';

require_once(__DOCUMENT_ROOT__.'/modules/router.php');

?>
