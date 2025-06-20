<?php

include(__DOCUMENT_ROOT__.'/modules/dbconn.php');

session_start();

if(!isset($_SESSION['sessref'])) {
  header('Location: '.ROUTER__defaultRoute.'#session-closed');
  exit;
}

$DB_DATA = (object) dbcursor("SELECT * FROM monitor WHERE `email` = '{$_SESSION['sessref']}'")->fetch(PDO::FETCH_ASSOC);

?>
