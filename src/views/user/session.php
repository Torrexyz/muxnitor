<?php

require_once(__DOCUMENT_ROOT__.'/modules/dbconn.php');

session_start();
if(!isset($_SESSION['sessref'])) {

  header('Location: '.ROUTER__defaultRoute.'#session-closed');
  exit;

} else {
  $DB_DATA = dbcursor("SELECT * FROM user WHERE `id` = '{$_SESSION['sessref']}'");
  if($DB_DATA->rowCount() != 1) {

    unset($_SESSION['sessref']);
    header('Location: '.ROUTER__defaultRoute.'#session-invalid');
    exit;

  } else $DB_DATA = (object) $DB_DATA->fetch(PDO::FETCH_ASSOC);
}

?>
<?php

$DB_DATA->folder = __DATA_ROOT__."/{$DB_DATA->folder}";

$DB_DATA->profileImage = "{$DB_DATA->folder}/profile-image.png";
$DB_DATA->profileImage = 'data:image/png;base64,'.base64_encode(@file_get_contents($DB_DATA->profileImage));

if(file_exists("{$DB_DATA->folder}/history.json"))
  $DB_DATA->history = json_decode(file_get_contents("{$DB_DATA->folder}/history.json"));

if(file_exists("{$DB_DATA->folder}/schedule.html"))
  $DB_DATA->schedule = file_get_contents("{$DB_DATA->folder}/schedule.html");

?>
