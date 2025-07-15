<?php

require_once(__DOCUMENT_ROOT__.'/vendor/autoload.php');
require_once(__DOCUMENT_ROOT__.'/modules/getenv.php');

session_start();

?>
<?php
if(isset($_POST['admin-login'])) {

  $POST__user = $_POST['admin-user'] ?? null;
  $POST__password = $_POST['admin-password'] ?? null;

  $NOTICE__adminLogin = false;

  if($POST__user === $_ENV['ADMIN_USER'] && $POST__password === $_ENV['ADMIN_PASSWORD']) {

    $_SESSION['sessref'] = $POST__user; 
    header('Location: /admin/dashboard');
    exit;

  } else $NOTICE__adminLogin = true;

} elseif(!isset($_SESSION['sessref'])) {
  
  $googleClient = new Google\Client;
  $googleClient->setClientId($_ENV['GOOGLE_AUTH__CLIEN_ID']);
  $googleClient->setClientSecret($_ENV['GOOGLE_AUTH__CLIEN_SECRET']);
  $googleClient->setRedirectUri($_ENV['GOOGLE_AUTH__REDIRECT_URI']);

  $googleClient->addScope('email');
  $googleClient->addScope('profile');

  $googleAuthUrl = $googleClient->createAuthUrl();

} else header('Location: '.(($_SESSION['sessref'] === $_ENV['ADMIN_USER']) ? '/admin' : '/user').'/dashboard');
?>
<!DOCTYPE html>
<html lang="en-CO">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="/styles/main.css">
    <link rel="stylesheet" href="/styles/login.css">
    <script src="/scripts/login.js"></script>

    <link rel="shortcut icon" href="/resources/favicon.png" type="image/x-icon">
    <title>Muxnitor</title>
  </head>
  <body>
    <div class="container">

      <header>
        <img src="/resources/favicon.png">
        <h1>Sistema de gestión para<br>monitores académicos</h1>
      </header>

      <form action="" method="post">
        <div class="type-selection">
          <b>TIPO DE INGRESO</b>
          <button type="button" class="default" onclick="showFormLogin(this)">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="black"><path d="M400-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM80-160v-112q0-33 17-62t47-44q51-26 115-44t141-18h14q6 0 12 2-8 18-13.5 37.5T404-360h-4q-71 0-127.5 18T180-306q-9 5-14.5 14t-5.5 20v32h252q6 21 16 41.5t22 38.5H80Zm560 40-12-60q-12-5-22.5-10.5T584-204l-58 18-40-68 46-40q-2-14-2-26t2-26l-46-40 40-68 58 18q11-8 21.5-13.5T628-460l12-60h80l12 60q12 5 22.5 11t21.5 15l58-20 40 70-46 40q2 12 2 25t-2 25l46 40-40 68-58-18q-11 8-21.5 13.5T732-180l-12 60h-80Zm40-120q33 0 56.5-23.5T760-320q0-33-23.5-56.5T680-400q-33 0-56.5 23.5T600-320q0 33 23.5 56.5T680-240ZM400-560q33 0 56.5-23.5T480-640q0-33-23.5-56.5T400-720q-33 0-56.5 23.5T320-640q0 33 23.5 56.5T400-560Zm0-80Zm12 400Z"/></svg>
            <span>&nbsp;</span>
            Administrador
          </button>
          <button type="button" class="default" onclick="showGoogleLogin(this)">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="black"><path d="M480-120 200-272v-240L40-600l440-240 440 240v320h-80v-276l-80 44v240L480-120Zm0-332 274-148-274-148-274 148 274 148Zm0 241 200-108v-151L480-360 280-470v151l200 108Zm0-241Zm0 90Zm0 0Z"/></svg>
            <span>&nbsp;</span>
            Estudiante
          </button>
        </div>
      </form>

      <img src="/resources/icon-utp.webp">

    </div>

    <script>
      const googleAuthUrl = '<?= $googleAuthUrl ?? null ?>';
      <?php if($NOTICE__adminLogin ?? false) print('alert("Acceso administrativo incorrecto, intente nuevamente")') ?>
    </script>

    <?php include(__VIEWS_ROOT__.'/concat/footer.php') ?>
  </body>
</html>
