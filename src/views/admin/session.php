<?php

session_start();

if($_SESSION['sessref'] !== $_ENV['ADMIN_USER']) {
  header('Location: '.ROUTER__defaultRoute.'#session-closed');
  exit;
}

?>
