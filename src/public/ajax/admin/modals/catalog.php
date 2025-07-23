<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/modules/dbconn.php');

ini_set('session.name', 'MUXSESSID');
session_start();

if(($_SESSION['sessref'] ?? null) === $_ENV['ADMIN_USER']) {
  
  if($_POST['action'] === 'update') {

    if(dbcursor("UPDATE `catalog` SET `{$_POST['column']}` = '{$_POST['text']}' WHERE `id` = '{$_POST['id']}'")->rowCount() == 0)
      http_response_code(500);

  } elseif($_POST['action'] === 'delete') {

    if(dbcursor("DELETE FROM `catalog` WHERE `id` = '{$_POST['id']}'")->rowCount() == 0)
      http_response_code(500);

  } else http_response_code(400);

} else { http_response_code(403); }

?>
