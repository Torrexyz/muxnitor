<?php

require_once(__DOCUMENT_ROOT__.'/modules/dbconn.php');

$googleClient = new Google\Client;
$googleClient->setClientId($_ENV['GOOGLE_AUTH__CLIEN_ID']);
$googleClient->setClientSecret($_ENV['GOOGLE_AUTH__CLIEN_SECRET']);
$googleClient->setRedirectUri($_ENV['GOOGLE_AUTH__REDIRECT_URI']);

$DOCUMENT_STATE_ERROR = false;
$LOGIN_ACCOUNT_STATE = false;

?>
<?php
if(isset($_GET['code'])) {

  $google_token = $googleClient->fetchAccessTokenWithAuthCode($_GET['code']);

  if(isset($google_token['access_token']) && $DOCUMENT_STATE_ERROR === false) {

    $googleClient->setAccessToken($google_token['access_token']);
    $googleOAuth = new Google\Service\Oauth2($googleClient);
    $googleUserInfo = $googleOAuth->userinfo->get();
    
    $USER_ID      = explode('@', $googleUserInfo->email)[0];
    $USER__folder = str_replace(['@utp.edu.co', '.'], ['', '_'], $googleUserInfo->email);
    $USER__name   = $googleUserInfo->name;
    $USER__prefix = 'FI';

    if($googleUserInfo->hd === 'utp.edu.co') {
      if(dbcursor("SELECT * FROM user WHERE `id` = '{$USER_ID}'")->rowCount() > 0) {

        $LOGIN_ACCOUNT_STATE = 1;
        session_start();
        $_SESSION['sessref'] = $USER_ID;
        
        # last session updating
        @dbcursor("UPDATE user SET `lastsess` = NOW() WHERE `id` = '{$USER_ID}'");

      } else {
        if(dbcursor("INSERT INTO user(`id`,`folder`,`name`,`prefix`) VALUES (?,?,?,?)", array_values([
          'id'     => $USER_ID,
          'folder' => $USER__folder,
          'name'   => $USER__name,
          'prefix' => $USER__prefix
        ]))) {

          $LOGIN_ACCOUNT_STATE = 2;
          session_start();
          $_SESSION['sessref'] = $USER_ID;

        } else $LOGIN_ACCOUNT_STATE = 3;
      }

      $USER__pathFolder = __DATA_ROOT__."/{$USER__folder}";
      
      # data folder creation
      if(!file_exists($USER__pathFolder))
        mkdir($USER__pathFolder);

      # profile image saving
      if(!file_exists("{$USER__pathFolder}/profile-image.png")) {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $googleUserInfo->picture);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        $googlePictureData = curl_exec($ch);
        curl_close($ch);

        if(curl_getinfo($ch, CURLINFO_HTTP_CODE) == 200 && $googlePictureData)
          file_put_contents("{$USER__pathFolder}/profile-image.png", $googlePictureData);
        
      }
      
    } else $LOGIN_ACCOUNT_STATE = 3;

  } else $DOCUMENT_STATE_ERROR = 2;
} else $DOCUMENT_STATE_ERROR = 1;
?>
<!DOCTYPE html>
<html lang="en-CO">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/styles/concat/notices.css">
    <title>Autentificación de Google</title>
  </head>
  <body>
    <?php
      if($DOCUMENT_STATE_ERROR === false) {
        if($LOGIN_ACCOUNT_STATE === 1) {

          echo <<<HTML
            <h1 style="color:#1abc9c">Sesión iniciada</h1>
            <br>
            <button type="button" onclick="window.location.href = '/user/dashboard'">Redireccionando..</button>
            <script>setTimeout(() => window.location.href = "/user/dashboard", 2*1000);</script>
          HTML;

        } elseif($LOGIN_ACCOUNT_STATE === 2) {

          echo <<<HTML
            <h1 style="color:#1abc9c">Cuenta creada</h1>
            <br>
            <button type="button" onclick="window.location.href = '/user/dashboard'">Redireccionando..</button>
            <script>setTimeout(() => window.location.href = "/user/dashboard", 2*1000);</script>
          HTML;

        } elseif($LOGIN_ACCOUNT_STATE === 3) {

          $invalid_domain_notice = $googleUserInfo->hd !== 'utp.edu.co' ? '<i style="display:block;font-size:12px">(Correo no académico)</i>' : null;

          echo <<<HTML
            <h1 style="color:#ec7063">
              Cuenta no creada
              <br>
              {$invalid_domain_notice}
            </h1>
            <svg xmlns="http://www.w3.org/2000/svg" height="50px" viewBox="0 -960 960 960" width="50px" fill="#ec7063"><path d="M480-280q17 0 28.5-11.5T520-320q0-17-11.5-28.5T480-360q-17 0-28.5 11.5T440-320q0 17 11.5 28.5T480-280Zm-40-160h80v-240h-80v240Zm40 360q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg>
            <br>
          HTML;

          echo '<button type="button" onclick="window.location.href=`'.ROUTER__defaultRoute.'`">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="black"><path d="M280-200v-80h284q63 0 109.5-40T720-420q0-60-46.5-100T564-560H312l104 104-56 56-200-200 200-200 56 56-104 104h252q97 0 166.5 63T800-420q0 94-69.5 157T564-200H280Z"/></svg>
            <span>&nbsp;</span>
            Salir
          </button>';

        }

      } elseif($DOCUMENT_STATE_ERROR === 1) {

        echo <<<HTML
          <h1 style="color:#ec7063">Logueo Fallido</h1>
          <svg xmlns="http://www.w3.org/2000/svg" height="50px" viewBox="0 -960 960 960" width="50px" fill="#ec7063"><path d="M480-280q17 0 28.5-11.5T520-320q0-17-11.5-28.5T480-360q-17 0-28.5 11.5T440-320q0 17 11.5 28.5T480-280Zm-40-160h80v-240h-80v240Zm40 360q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg>
          <br>
        HTML;

        echo '<button type="button" onclick="window.location.href=`'.ROUTER__defaultRoute.'`">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="black"><path d="M280-200v-80h284q63 0 109.5-40T720-420q0-60-46.5-100T564-560H312l104 104-56 56-200-200 200-200 56 56-104 104h252q97 0 166.5 63T800-420q0 94-69.5 157T564-200H280Z"/></svg>
          <span>&nbsp;</span>
          Salir
        </button>';

      } elseif($DOCUMENT_STATE_ERROR === 2) {

        echo <<<HTML
          <h1 style="color:#ec7063">Token Expirado</h1>
          <svg xmlns="http://www.w3.org/2000/svg" height="50px" viewBox="0 -960 960 960" width="50px" fill="#ec7063"><path d="m396-340 84-84 84 84 56-56-84-84 84-84-56-56-84 84-84-84-56 56 84 84-84 84 56 56Zm84 260q-139-35-229.5-159.5T160-516v-244l320-120 320 120v244q0 152-90.5 276.5T480-80Zm0-84q104-33 172-132t68-220v-189l-240-90-240 90v189q0 121 68 220t172 132Zm0-316Z"/></svg>
          <br>
        HTML;

        echo '<button type="button" onclick="window.location.href=`'.ROUTER__defaultRoute.'`">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="black"><path d="M280-200v-80h284q63 0 109.5-40T720-420q0-60-46.5-100T564-560H312l104 104-56 56-200-200 200-200 56 56-104 104h252q97 0 166.5 63T800-420q0 94-69.5 157T564-200H280Z"/></svg>          <span>&nbsp;</span>
          Salir
        </button>';

      }
    ?>
  </body>
</html>
