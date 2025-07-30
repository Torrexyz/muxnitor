<?php

require(dirname(__DIR__).'/session.php');

$POSTS_CONTAINER = (array)json_decode(@file_get_contents(__POSTS_PATH__)) ?? [];

?>
<modal>
  <?php if(count($POSTS_CONTAINER) > 0) { ?>

    <?php include(__VIEWS_ROOT__.'/concat/information_board.php') ?>

  <?php } else { ?>

    <h1>No hay anuncios disponibles</h1>
    
  <?php } ?>
</modal>
