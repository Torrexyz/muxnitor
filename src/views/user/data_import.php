<?php

require_once(__DOCUMENT_ROOT__.'/modules/dbconn.php');
require_once(__DOCUMENT_ROOT__.'/modules/portalxml.php');

session_start();
$SESSION__sessref = $_SESSION['sessref'] ?? null;

$GET__data = $_GET['data'] ?? null;
$DOCUMENT_STATE = false;

?>
<?php

function history_request(string $cookie) {
  $result = [];

  $ch_history = curl_init();
  curl_setopt($ch_history, CURLOPT_URL, 'https://app4.utp.edu.co/MatAcad/verificacion/oracle.php');
  curl_setopt($ch_history, CURLOPT_POST, true);
  curl_setopt($ch_history, CURLOPT_POSTFIELDS, 'cmbprogramas=FI');
  curl_setopt($ch_history, CURLOPT_HTTPHEADER, ["Cookie: PHPSESSID={$cookie}"]);
  curl_setopt($ch_history, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch_history, CURLOPT_SSL_VERIFYPEER, false);

  $history_response = curl_exec($ch_history);
  if(!curl_errno($ch_history))
    $result = PortalXML::historyToJson($history_response);

  curl_close($ch_history);
  return $result;
}

function schedule_request(string $cookie) {
  $result = null;

  $ch_schedule = curl_init();
  curl_setopt($ch_schedule, CURLOPT_URL, 'https://app4.utp.edu.co/MatAcad/verificacion/horario.php');
  curl_setopt($ch_schedule, CURLOPT_POST, true);
  curl_setopt($ch_schedule, CURLOPT_HTTPHEADER, ["Cookie: PHPSESSID={$cookie}"]);
  curl_setopt($ch_schedule, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch_schedule, CURLOPT_SSL_VERIFYPEER, false);

  $schedule_response = curl_exec($ch_schedule);
  if(!curl_errno($ch_schedule))
    $result = PortalXML::scheduleToHtml($schedule_response);

  curl_close($ch_schedule);
  return $result;
}

?>
<?php
if(!is_null($GET__data)) {
  if(preg_match('/PHPSESSID=([^;\s]+)/', $GET__data, $matches)) {
    if(!empty($matches[0])) {

      $user_cookie_value = $matches[1];

      # check if session exists
      if(!is_null($SESSION__sessref)) {

        $user_sess_check = dbcursor("SELECT * FROM user WHERE `id` = '{$SESSION__sessref}'");
        $USER_DATA = $user_sess_check->fetch(PDO::FETCH_ASSOC);

        # check if user exists
        if($user_sess_check->rowCount() > 0) {

          # request user portal history
          $user_history_data = history_request($user_cookie_value);
          
          if(count($user_history_data) > 0) {
            
            # json history file saving
            @file_put_contents(__DATA_ROOT__."/{$USER_DATA['folder']}/history.json", json_encode($user_history_data, JSON_PRETTY_PRINT));

            # request user portal schedule
            $user_schedule_data = schedule_request($user_cookie_value);

            # html schedule file saving
            @file_put_contents(__DATA_ROOT__."/{$USER_DATA['folder']}/schedule.html", $user_schedule_data);
            
            # requests ok state
            $DOCUMENT_STATE = true;

          }

        }
      }

    }
  }
}
?>
<!DOCTYPE html>
<html lang="es-CO">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/styles/concat/notices.css">
    <link rel="shortcut icon" href="/resources/favicon.png" type="image/x-icon">
    <title>Importación de Cookies</title>
  </head>
  <body>
    <?php if(is_null($SESSION__sessref)) { ?>
    
      <h1 style="color:#ec7063">No se ha detectada<br>su sesión en Muxnitor</h1>

    <?php } elseif($DOCUMENT_STATE) { ?>

      <h1 style="color:#52be80">Datos cargados exitosamente</h1>
      <br>
      <button type="onclick" onclick="window.location.href = '/user/dashboard'">Redireccionando..</button>
      <script>setTimeout(() => window.location.href = "/user/dashboard", 2*1000);</script>

    <?php } else { ?>

      <h1 style="color:#ec7063">No se han podido cargar los datos</h1>

    <?php } ?>
  </body>
</html>
