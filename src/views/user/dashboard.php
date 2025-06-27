<?php

require('session.php');

?>
<!DOCTYPE html>
<html lang="es-CO">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/styles/main.css">
    <link rel="stylesheet" href="/styles/user/dashboard.css">
    <link rel="stylesheet" href="/styles/swiper-bundle.min.css">
    <script src="/scripts/utils.js"></script>
    <script src="/scripts/swiper-bundle.min.js"></script>
    <link rel="shortcut icon" href="/resources/favicon.png" type="image/x-icon">
    <title>Bienvenid@ <?= $DB_DATA->name ?></title>
  </head>
  <body>
    <div class="container">
      
      <header>
        <img src="<?= htmlspecialchars($DB_DATA->profileImage) ?>">
        <div>
          <h3>Postulante</h3>
          <p><?= $DB_DATA->name ?></p>
          <b>@utp.edu.co</b>
          <br>
          <i onclick="window.open('https://ingenierias.utp.edu.co/ingenieria-electronica/')">Ingenieria Electrónica</i>
        </div>
        <h1>Portal de Monitores<br>Académicos</h1>
        <img id="icon-utp" onclick="window.open('https://www.utp.edu.co/')" src="/resources/icon-utp.png">
      </header>

      <nav>
        <button type="button" onclick="requestModal('/logout', { forceCancel: true, success: () => window.location.href='<?= ROUTER__defaultRoute ?>' })">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="black"><path d="M200-120q-33 0-56.5-23.5T120-200v-160h80v160h560v-560H200v160h-80v-160q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm220-160-56-58 102-102H120v-80h346L364-622l56-58 200 200-200 200Z"/></svg>
          <span>&nbsp;</span>
          <u>Cerrar Sesión</u>
        </button>
        <button type="button">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="black"><path d="m260-80-40-40v-160H80v-80l60-106v-94H80v-80h360v80h-60v94l60 106v80H300v160l-40 40Zm-88-280h176l-48-84v-116h-80v116l-48 84Zm88 0Zm460-280q-50 0-85-35t-35-85q0-50 35-85t85-35q50 0 85 35t35 85q0 50-35 85t-85 35Zm-196-80H80q0-33 23.5-56.5T160-800h364q-2 10-3 19.5t-1 20.5q0 11 1 20.5t3 19.5Zm276 560H480v-80h320v-337q24-11 44-27t36-36v400q0 33-23.5 56.5T800-160Z"/></svg>
          <span>&nbsp;</span>
          Anuncios
        </button>
      </nav>

      <main id="modal-viewer" center-content>
        
        <?php if(!isset($DB_DATA->history)) { ?>
          <h1>Carga de criterios académicos</h1>
          <br>
          <p>
            Los datos de selección para el monitor, estan dados respecto al promedio academico del semestre anterior,
            las asignaturas aprobadas y la disponibilidad de horario del postulante.
            <br><br>
            Por consiguiente se le solicita acceso para la obtención de los datos requeridos.
          </p>
          <br><br>
          <button type="button" class="default" onclick="requestModal('/user/cookie-guide')">
            Realizar
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="black"><path d="M441-82q-76-8-141.5-41.5t-114.5-87Q136-264 108-333T80-480q0-157 104.5-270T441-878v81q-119 15-200 104.5T160-480q0 123 81 212.5T441-163v81Zm0-198v-247L337-423l-56-57 200-200 200 200-57 56-103-103v247h-80Zm80 198v-81q44-5 83.5-22t72.5-43l57 58q-45 36-99 59T521-82Zm155-650q-33-26-72-43t-83-22v-81q60 6 114 29t99 59l-58 58Zm114 505-57-57q26-33 43-72.5t22-83.5h81q-6 60-29.5 114T790-227Zm8-293q-5-44-22-83.5T733-676l57-57q36 45 59.5 99T879-520h-81Z"/></svg>
          </button>
        <?php } else { ?>

          <h1 style="color:#1abc9c">Postulación exitosa</h1>
          <br>
          <p>
            ¡Todo listo!, ahora solo debes esperar a que seas asignado a alguna monitoria,
            <br>
            recuerda que este proceso es respecto a los criterios de prioridad y evaluación de monitores.
            <br><br>
            <i>(Para más información consulta la dirección del programa académico)</i>
          </p>

        <?php } ?>

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
