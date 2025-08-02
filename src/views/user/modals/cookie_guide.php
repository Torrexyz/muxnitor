<?php

require(dirname(__DIR__).'/session.php');

$GET__steps = $_GET['steps'] ?? null;

?>
<modal>
  <?php if(!isset($GET__steps)) { ?>

    <p>
      <i>¿QUÉ ES Y POR QUÉ ES NECESARIO GESTIONAR MANUALMENTE LA COOKIE DE SESIÓN?</i>
      <br>
      <br>
      <br>
      La cookie de sesión es un identificador temporal que se genera al iniciar sesión en el portal estudiantil y
      dura solo unos minutos. Esta cookie se usara en lugar de las credenciales de inicio de su portal academico
      para acceder a los datos requeridos (horario e historial académico), y asi mantener su privacidad 😉
      <br>
      <br>
      <mark>CARGA DE DATOS DISPONIBLE SOLO DESDE PC</mark>
    </p>
    
    <br><br>

    <button type="button" class="default next-button" onclick="requestModal('/user/modals/cookie-guide?steps', { centerContent: true })">
      <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="30px" fill="#45b39d"><path d="m381-240 424-424-57-56-368 367-169-170-57 57 227 226Zm0 113L42-466l169-170 170 170 366-367 172 168-538 538Z"/></svg>  
      <span>&nbsp;</span>
      Entendido
    </button>

  <?php } else { ?>

    <section class="swiper">
			<div class="swiper-wrapper">

        <div class="swiper-slide">
          <img src="/resources/user/cookie-step0.gif">
          <p>0. Resumen</p>
        </div>

        <div class="swiper-slide">
          <img src="/resources/user/cookie-step1.jpg">
          <p>1. <u onclick="window.open('https://app4.utp.edu.co/pe/index.php', '_blank')">Inicia sesión</u> en el portal académico</p>
        </div>

        <div class="swiper-slide">
          <img src="/resources/user/cookie-step2.jpg">
          <p>2. Una vez logueado, borra la url del buscador y escribe el siguiente texto 👉 <span>javascript:</span></p>
        </div>

        <div class="swiper-slide">
          <img src="/resources/user/cookie-step3.jpg">
          <p>3. Posteriormente, seguido de <span>javascript:</span> pega el siguiente texto que copiaras de aquí 👉 <u onclick="setClipboard('window.open(`http://<?= $_SERVER['HTTP_HOST'] ?>/user/data-import?data=${document.cookie}`, `_self`)');alert('Texto copiado 👍')">Copiar ✍️</u></p>
        </div>

        <div class="swiper-slide">
          <img src="/resources/user/cookie-step4.jpg">
          <p>4. IMPORTANTE: Debes seleccionar la opción de búsqueda con el icono del mundo 👍🌐 y no la lupa 🚫🔍</p>
        </div>

        <div class="swiper-slide">
          <img src="/resources/user/cookie-step5.jpg" style="width:100%">
          <p>5. Finalmente... si todo salió bien, los datos se abran cargado correctamente ✅ y solo deberás esperar ⏳ el resultado de su postulación 😁</p>
        </div>

      </div>
      
      <div class="swiper-button-next"></div>
      <div class="swiper-button-prev"></div>
      <div class="swiper-pagination"></div>
    </section>

  <?php } ?>
</modal>
