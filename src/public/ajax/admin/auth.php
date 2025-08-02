<?php

require("{$_SERVER['DOCUMENT_ROOT']}/autoload.php");

session_start();

if(isset($_SESSION['sessref']) ? ($_SESSION['sessref'] !== $_ENV['ADMIN_USER'] || $_SESSION['sesstype'] !== 'ADMIN') : true) {
  unset($_SESSION['sessref']);
  http_response_code(401);
  exit;
}

?>
