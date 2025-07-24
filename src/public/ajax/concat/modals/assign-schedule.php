<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/modules/dbconn.php');

$GET__subjects = $_GET['subjects'] ?? null;
$GET__user = $_GET['user'] ?? null;

dbcursor("UPDATE `catalog` SET `user` = NULL WHERE `user` = '{$GET__user}'");

?>
<?php
if($GET__subjects !== 'NULL') {

  foreach(explode(',', $GET__subjects) as $subjectID)
    dbcursor("UPDATE `catalog` SET `user` = '{$GET__user}' WHERE `id` = {$subjectID}");
  
}
?>
<h1 class="notice">Cambios realizados exitosamente</h1>
