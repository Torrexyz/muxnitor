<?php

require(dirname(__DIR__).'/session.php');

$POSTS_CONTAINER = (array) json_decode(@file_get_contents(__POSTS_PATH__)) ?? [];

?>
<?php
if(isset($_POST['insert'])) {

  $PROCS__filenames = [];
  if(isset($_FILES['post-files'])) {
    foreach($_FILES['post-files']['name'] as $index => $name) {
      $PROCS__filenames[$index] = basename($name);
      move_uploaded_file($_FILES['post-files']['tmp_name'][$index], __DOCS_ROOT__."/{$PROCS__filenames[$index]}");
    }
  }

  array_push($POSTS_CONTAINER, (object)array(
    'id'      => strtotime('now'),
    'subject' => $_POST['post-subject'],
    'body'    => $_POST['post-body'],
    'files'   => $PROCS__filenames,
    'date'    => date('d/m/Y h:i A')
  ));
  
  file_put_contents(__POSTS_PATH__, json_encode($POSTS_CONTAINER));

} elseif(isset($_GET['delete'])) {
  
  $POSTS_CONTAINER = array_filter($POSTS_CONTAINER, function($post) {
    if($post->id != $_GET['delete']) {
      return $post;
    } else {
      foreach($post->files as $filename) {
        if(file_exists(__DOCS_ROOT__."/{$filename}"))
          unlink(__DOCS_ROOT__."/{$filename}");
      }
    }
  });

  file_put_contents(__POSTS_PATH__, json_encode($POSTS_CONTAINER));

}
?>
<modal style="flex-direction:row">
  
  <?php $MODAL__deleteButton = true; include(__VIEWS_ROOT__.'/concat/information_board.php') ?>

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
        <input style="display:none" type="file" name="post-files[]" id="file-chooser">
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

    <button type="submit" name="insert" onclick="event.preventDefault(); if(confirm('¿Quieres confirmar el anuncio?')) requestPostModal(this.parentNode, { centerContent: true });">Publicar</button>
  </form>
  
</modal>
