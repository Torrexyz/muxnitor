<?php

$GET__filename = $_GET['filename'] ?? null;

if(!is_null($GET__filename)) {

  $FILENAME__extension = pathinfo($GET__filename, PATHINFO_EXTENSION);
  $FILENAME__path = __DOCS_ROOT__."/{$GET__filename}";

  if(file_exists($FILENAME__path)) {

    if(in_array($FILENAME__extension, ['png', 'jpg', 'jpeg', 'gif'])) {

      header('Content-Type: '.$FILENAME__extension);
      header('Content-Length: '.filesize($FILENAME__path));
      @readfile($FILENAME__path);
      exit;

    } elseif($FILENAME__extension === 'pdf') {

      header('Content-Type: application/pdf');
      header('Content-Disposition: inline; filename="'.$GET__filename.'"');
      header('Content-Length: ' .filesize($FILENAME__path));
      @readfile($FILENAME__path);

    } else {

      header('Content-Type: application/octet-stream');
      header('Content-Disposition: attachment; filename="'.basename($FILENAME__path).'"');
      header('Content-Length: '.filesize($FILENAME__path));
      @readfile($FILENAME__path);
      exit;

    }

  } else print('<mark>Archivo no detectado</mark>');
} else print('<mark>Archivo no detectado</mark>');

?>
