<?php

require_once("{$_SERVER['DOCUMENT_ROOT']}/modules/dbconn.php");

$GET__id = $_GET['id'] ?? null;
$GET__get = $_GET['get'] ?? null;

$DB_DATA = dbcursor("SELECT * FROM user WHERE `id` = '{$GET__id}'");

?>
<?php
if($DB_DATA->rowCount() == 1) {

  $DB_DATA = (object) $DB_DATA->fetch(PDO::FETCH_ASSOC);
  $DB_DATA->folder = "{$_SERVER['DOCUMENT_ROOT']}/data/{$DB_DATA->folder}";

  if($GET__get === 'schedule') {

    if(file_exists("{$DB_DATA->folder}/schedule.html")) {
      $RENDER_HTML = file_get_contents("{$DB_DATA->folder}/schedule.html");
    } else exit('<h2>Datos no encontrados</h2>');

  } elseif($GET__get === 'history') {

    $RENDER_HTML = <<<HTML
      <table class="stylize">
        <tr>
          <th>Código</th>
          <th>Asignatura Aprobada</th>
          <th>Nota</th>
        </tr>
    HTML;

    if(file_exists("{$DB_DATA->folder}/history.json")) {
      foreach(json_decode(file_get_contents("{$DB_DATA->folder}/history.json")) as $semester) {
        foreach($semester->details as $subject) {
          if($subject->Estado === 'Aprobado') {
            $RENDER_HTML.= "<tr>
              <td>{$subject->Código}</td>
              <td style='text-align:left'>{$subject->Asignatura}</td>
              <td>{$subject->Nota}</td>
            </tr>";
          }
        }
      }
    } else exit('<h2>Datos no encontrados</h2>');

    $RENDER_HTML.= '</table>';

  } elseif($GET__get === 'assign') {

    if(file_exists("{$DB_DATA->folder}/schedule.html") && file_get_contents("{$DB_DATA->folder}/history.json")) {

      $AUX_RENDER_HTML = null;
      for($i = 1; $i < 8; $i++) {
        $AUX_RENDER_HTML.= '<div class="weekday">';
        foreach(['06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22'] as $time)
          $AUX_RENDER_HTML.= "<div class='time' id='{$i}@{$time}'></div>";
        $AUX_RENDER_HTML.= '</div>';
      }

      $RENDER_HTML = '
        <div class="assign">
          <div>
            '.file_get_contents("{$DB_DATA->folder}/schedule.html").'
            <div class="assign-schedule">
              '.$AUX_RENDER_HTML.'
            </div>
          </div>
          <div>
            <style>'.file_get_contents("{$_SERVER['DOCUMENT_ROOT']}/src/public/styles/concat/modals/assign-schedule.css").'</style>
            <script>'.file_get_contents("{$_SERVER['DOCUMENT_ROOT']}/src/public/scripts/concat/modals/assign-schedule.js").'</script>
            <div>
              <select size="8" multiple>
                <option onclick="setSubjectSchedule(this)">Limpiar</option>
      ';

      foreach(dbcursor("SELECT * FROM `catalog` WHERE `schedule` IS NOT NULL")->fetchAll(PDO::FETCH_OBJ) as $subject) {
        $RENDER_HTML.= "
          <option onclick='setSubjectSchedule(this)' value='{$subject->schedule}' data-subject-code='{$subject->code}' data-subject-id='{$subject->id}'>
            {$subject->code} - {$subject->subject}
            |
            ".array('Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado')[intval(explode('@', $subject->schedule)[0])-1]."
            de
            ".str_replace('-', ' a ', explode('@', $subject->schedule)[1])."
          </option>
          ".($subject->user === $GET__id ? 
            '<script>
              document.querySelector(`option[data-subject-id="'.$subject->id.'"]`).selected = true;
              document.querySelector(`option[data-subject-id="'.$subject->id.'"]`).click();
              document.currentScript.remove();
            </script>' : null
          )."
        ";
      }

      $RENDER_HTML.= '
              </select>
              <button type="button" onclick="updateUserSchedule(this.previousElementSibling, `'.$GET__id.'`)">Actualizar</button>
            </div>
            <br>
            <div class="details">
              <b>MONITORIAS</b>
              <br>
            </div>
          </div>
        </div>
      ';

    } else exit('<h2>Datos no encontrados</h2>');

  } else exit('component nof found');
}
?>
<h2><?= $DB_DATA->name ?? 'INDEFINID@' ?></h2>
<br>
<br>
<?= $RENDER_HTML ?>
