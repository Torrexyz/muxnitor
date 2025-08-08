<?php

require(dirname(__DIR__).'/auth.php');

?>
<?php
if($_POST['action'] === 'update') {

  if(dbcursor("UPDATE `catalog` SET `{$_POST['column']}` = ".(strlen($_POST['text']) > 0 ? "'{$_POST['text']}'" : 'NULL')." WHERE `id` = '{$_POST['id']}'")->rowCount() != 1)
    http_response_code(500);

} elseif($_POST['action'] === 'delete') {

  if(dbcursor("DELETE FROM `catalog` WHERE `id` = '{$_POST['id']}'")->rowCount() != 1)
    http_response_code(500);

} else http_response_code(400);
?>
