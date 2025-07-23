<?php

require('session.php');

?>
<!DOCTYPE html>
<html lang="es-CO">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="/styles/main.css">
    <link rel="stylesheet" href="/styles/concat/main.css">
    <script src="/scripts/concat/utils.js"></script>

    <link rel="shortcut icon" href="/resources/favicon.png" type="image/x-icon">
    <title>Portal del Administrativo</title>
  </head>
  <body>
    <div class="container">
      
      <header>
        <img src="https://a0.anyrgb.com/pngimg/1526/18/icon-ico-files-admin-system-administrator-ico-icon-download-user-profile-password-megaphone-login-thumbnail.png">
        <div>
          <h3>Administrador</h3>
          <p>Beatriz Gonzales</p>
          <b>@utp.edu.co</b>
          <br>
          <i onclick="window.open('https://ingenierias.utp.edu.co/ingenieria-electronica/')">Ingenieria Electrónica</i>
        </div>
        <h1>Portal Administrativo<br>de Monitorias</h1>
        <img id="icon-utp" onclick="window.open('https://www.utp.edu.co/')" src="/resources/icon-utp.png">
      </header>

      <nav>
        <button type="button" onclick="requestModal('/logout', { unerrorState: true, success: () => window.location.href='<?= ROUTER__defaultRoute ?>' })">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="black"><path d="M200-120q-33 0-56.5-23.5T120-200v-160h80v160h560v-560H200v160h-80v-160q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm220-160-56-58 102-102H120v-80h346L364-622l56-58 200 200-200 200Z"/></svg>
          <span>&nbsp;</span>
          <u>Cerrar Sesión</u>
        </button>

        <button type="button" onclick="requestModal('/admin/modals/information', { centerContent: true })">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="black"><path d="m260-80-40-40v-160H80v-80l60-106v-94H80v-80h360v80h-60v94l60 106v80H300v160l-40 40Zm-88-280h176l-48-84v-116h-80v116l-48 84Zm88 0Zm460-280q-50 0-85-35t-35-85q0-50 35-85t85-35q50 0 85 35t35 85q0 50-35 85t-85 35Zm-196-80H80q0-33 23.5-56.5T160-800h364q-2 10-3 19.5t-1 20.5q0 11 1 20.5t3 19.5Zm276 560H480v-80h320v-337q24-11 44-27t36-36v400q0 33-23.5 56.5T800-160Z"/></svg>
          <span>&nbsp;</span>
          Tablero de Anuncios
        </button>

        <button type="button" onclick="requestModal('/admin/modals/postulants', { centerContent: true })">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="black"><path d="M40-160v-112q0-34 17.5-62.5T104-378q62-31 126-46.5T360-440q66 0 130 15.5T616-378q29 15 46.5 43.5T680-272v112H40Zm720 0v-120q0-44-24.5-84.5T666-434q51 6 96 20.5t84 35.5q36 20 55 44.5t19 53.5v120H760ZM360-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47Zm400-160q0 66-47 113t-113 47q-11 0-28-2.5t-28-5.5q27-32 41.5-71t14.5-81q0-42-14.5-81T544-792q14-5 28-6.5t28-1.5q66 0 113 47t47 113ZM120-240h480v-32q0-11-5.5-20T580-306q-54-27-109-40.5T360-360q-56 0-111 13.5T140-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T440-640q0-33-23.5-56.5T360-720q-33 0-56.5 23.5T280-640q0 33 23.5 56.5T360-560Zm0 320Zm0-400Z"/></svg>
          <span>&nbsp;</span>
          Postulantes
        </button>

        <button type="button" onclick="requestModal('/admin/modals/monitors', { centerContent: true })">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="black"><path d="M480-440q-58 0-99-41t-41-99q0-58 41-99t99-41q58 0 99 41t41 99q0 58-41 99t-99 41Zm0-80q25 0 42.5-17.5T540-580q0-25-17.5-42.5T480-640q-25 0-42.5 17.5T420-580q0 25 17.5 42.5T480-520Zm0 460L120-280v-400l360-220 360 220v400L480-60Zm0-93 147-91q-34-18-71.5-27t-75.5-9q-38 0-75.5 9T333-244l147 91ZM256-291q50-34 107-51.5T480-360q60 0 117 17.5T704-291l56-33v-311L480-806 200-635v311l56 33Zm224-189Z"/></svg>
          <span>&nbsp;</span>
          Monitores
        </button>

        <button type="button" onclick="requestModal('/admin/modals/catalog', { centerContent: true })">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="black"><path d="M240-80q-33 0-56.5-23.5T160-160v-640q0-33 23.5-56.5T240-880h480q33 0 56.5 23.5T800-800v640q0 33-23.5 56.5T720-80H240Zm0-80h480v-640h-80v280l-100-60-100 60v-280H240v640Zm0 0v-640 640Zm200-360 100-60 100 60-100-60-100 60Z"/></svg>
          <span>&nbsp;</span>
          Oferta Académica
        </button>
      </nav>

      <main id="modal-viewer" center-content>
        <h1 style="color:#1abc9c">Sistema de Gestión de Monitorias</h1>
        <br>
        <p>
          <i>(Para más información o reportes, consultar al soporte de la plataforma)</i>
        </p>
      </main>

      <?php include(__VIEWS_ROOT__.'/concat/footer.php') ?>

      <curtain style="display:none">
        <svg xmlns="http://www.w3.org/2000/svg" height="35px" viewBox="0 -960 960 960" width="35px" fill="black"><path d="M480-480Zm-400 0q0-88 34-163t93-130q59-55 136-83.5T508-879q17 2 27 14.5t7 29.5q-3 17-16.5 27t-30.5 9q-69-3-129.5 19.5T259-713q-46 44-72.5 103.5T160-480q0 134 93 227t227 93q69 0 128.5-26.5T712-259q46-48 68-109t19-127q-1-17 9-30.5t27-16.5q17-3 29.5 7t14.5 27q6 87-22.5 164T774-208q-57 62-133 95T480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480Zm640-120q-50 0-85-35t-35-85q0-50 35-85t85-35q50 0 85 35t35 85q0 50-35 85t-85 35Z"/></svg>
        <span>&nbsp;&nbsp;</span>
        <h2>Cargando</h2>
      </curtain>

    </div>
  </body>
</html>
