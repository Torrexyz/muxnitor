<?php

const _REQUEST_MODAL_ = true;
require('session.php');

$GET__device = $_GET['device'] ?? null;
$GET__steps = $_GET['steps'] ?? null;

?>
<modal>
  <style><?= file_get_contents(__PUBLIC_ROOT__.'/styles/monitor/cookie-guide.css'); ?></style>
  <?php if(!isset($GET__steps) && !is_null($GET__device)) { ?>
    <p>
      <i>¿QUÉ ES Y POR QUÉ ES NECESARIO SACAR MANUALMENTE LA COOKIE DE SESIÓN?</i>
      <br><br>
      La cookie de sesión es un identificador temporal que se genera al iniciar sesión en el portal estudiantil y
      dura solo unos minutos. Esta cookie se usara en lugar de las credenciales de inicio de su portal academico
      para acceder a los datos requeridos (horario e historial académico), y asi mantener su confianza y privacidad 😉
      <br><br>
      Usted extraerá manualmente la cookie desde su navegador de confianza en su <?= match($GET__device) { 'phone' => 'telefono', 'pc' => 'computador' } ?>,
      una vez haya iniciado la sesión en su portal academico, con los siguientes sencillos pasos 🤓
    </p>
    <br><br>
    <button type="button" class="default next-button" onclick="requestModal('/monitor/cookie-guide?device=<?= $GET__device ?>&steps')">
      <svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 -960 960 960" width="30px" fill="#45b39d"><path d="m438-338 226-226-57-57-169 169-84-84-57 57 141 141Zm42 258q-139-35-229.5-159.5T160-516v-244l320-120 320 120v244q0 152-90.5 276.5T480-80Zm0-84q104-33 172-132t68-220v-189l-240-90-240 90v189q0 121 68 220t172 132Zm0-316Z"/></svg>
      <span>&nbsp;</span>
      De one!
    </button>
  <?php } elseif($GET__device === 'phone') { ?>

    <div class="guide-box">
      pasos telefono
    </div>

  <?php } elseif($GET__device === 'pc') { ?>

    <div class="guide-box">
      pasos computador
    </div>

  <?php } else print("Alguien está tocando cosas que no debe? 🧐") ?>
</modal>
