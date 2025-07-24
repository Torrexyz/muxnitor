<?php

require(dirname(__DIR__).'/session.php');

?>
<?php
if(isset($_POST['insert'])) {

  $POSTS_CONTAINER = (array) json_decode(file_get_contents(__DATA_ROOT__.'/posts.json')) ?? [];

  array_push($POSTS_CONTAINER, array(
    'subject' => $_POST['post-subject'],
    'body' => $_POST['post-body'],
    'date' => date('d/m/Y h:i A')
  ));
  
  file_put_contents(__DATA_ROOT__.'/posts.json', json_encode($POSTS_CONTAINER));

}
?>
<modal style="flex-direction:row">
  <style><?= file_get_contents(__PUBLIC_ROOT__.'/styles/concat/modals/information.css') ?></style>
  
  <div class="board">

    <?php foreach(array_reverse((array) json_decode(file_get_contents(__DATA_ROOT__.'/posts.json')) ?? []) as $post) { ?>
      <div>
        <span>Beatriz Gonzales</span>
        <h3><?= $post->subject ?></h3>
        <pre><?= $post->body ?></pre>
        <i><?= $post->date ?></i>
      </div>
    <?php } ?>

    <div>
      <span>Beatriz Gonzales</span>
      <h3>Informe monitorias</h3>
      <pre>
Buenas tardes, estimados estudiantes

Por medio de la presente se envía carta de compromiso e informe mensual el cual debe ser firmado por el docente y enviado a mi correo el día 9 de septiembre para realizar los trámites correspondientes
Todos tienen fecha de inicio el 12 de agosto.

Es de aclarar que la carta de compromiso solo se firma una vez.

Se envía formato guia para reporte de monitorias
      </pre>
      <ul>
        <li onclick="window.open('', '_blank')">
          <svg xmlns="http://www.w3.org/2000/svg" height="22px" viewBox="0 -960 960 960" width="30px" fill="black"><path d="M320-440h320v-80H320v80Zm0 120h320v-80H320v80Zm0 120h200v-80H320v80ZM240-80q-33 0-56.5-23.5T160-160v-640q0-33 23.5-56.5T240-880h320l240 240v480q0 33-23.5 56.5T720-80H240Zm280-520v-200H240v640h480v-440H520ZM240-800v200-200 640-640Z"/></svg>
          Documento sin título.docx
        </li>
      </ul>
      <i>11/07/2025 07:00 A.M</i>
    </div>

  </div>

  <form class="entry" action="/admin/modals/information">
    <div>
      <p>Asunto</p>
      <input type="text" name="post-subject" placeholder="...">
    </div>

    <div>
      <p>Cuerpo</p>
      <textarea style="width:100%" rows="9" type="text" name="post-body" placeholder="..."></textarea>
    </div>

    <div>
      <p>Recursos</p>
      <label style="border:2px inset #BDBDBD;border-radius:5px" for="file-chooser">
        <input style="display:none" type="file" name="post-files[]" id="file-chooser" multiple>
        <svg xmlns="http://www.w3.org/2000/svg" height="15px" viewBox="0 -960 960 960" width="15px" fill="black"><path d="M720-330q0 104-73 177T470-80q-104 0-177-73t-73-177v-370q0-75 52.5-127.5T400-880q75 0 127.5 52.5T580-700v350q0 46-32 78t-78 32q-46 0-78-32t-32-78v-370h80v370q0 13 8.5 21.5T470-320q13 0 21.5-8.5T500-350v-350q-1-42-29.5-71T400-800q-42 0-71 29t-29 71v370q-1 71 49 120.5T470-160q70 0 119-49.5T640-330v-390h80v390Z"/></svg>
        Agregar archivos
      </label>
      <ul id="post-resources"></ul>
    </div>

    <div>
      <p>Funciones</p>
      <label for="mailer" title="Proximamente" style="opacity:.5">
        <input type="checkbox" name="post-mailer" id="mailer" disabled>
        Enviar correos
      </label>
    </div>

    <button type="submit" name="insert" onclick="requestPostModal(this.parentNode, { centerContent: true })">Publicar</button>
  </form>

  <script reload><?= file_get_contents(__PUBLIC_ROOT__.'/scripts/concat/modals/information.js') ?></script>
</modal>
