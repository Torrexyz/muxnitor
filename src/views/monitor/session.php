<?php

include(__DOCUMENT_ROOT__.'/modules/dbconn.php');

session_start();

if(!isset($_SESSION['sessref'])) {
  if(!defined('_REQUEST_MODAL_')) {
    header('Location: '.ROUTER__defaultRoute.'#session-closed');
  } else http_response_code(403);
  exit;
}

?>
<?php

$DB_DATA = (object) dbcursor("SELECT * FROM monitor WHERE `email` = '{$_SESSION['sessref']}'")->fetch(PDO::FETCH_ASSOC);

$DB_DATA->folder = __DATA_ROOT__."/{$DB_DATA->folder}";

$DB_DATA->profileImage = "{$DB_DATA->folder}/profile-image.png";
$DB_DATA->profileImage = 'data:image/png;base64,'.base64_encode(file_get_contents($DB_DATA->profileImage));

?>
