<?php

require("{$_SERVER['DOCUMENT_ROOT']}/autoload.php");

session_start();
if(!isset($_SESSION['sessref'])) {
  http_response_code(401);
  exit;
}

$GET__id = $_GET['id'] ?? null;
$GET__get = $_GET['get'] ?? null;

$DB_DATA = dbcursor("SELECT * FROM user WHERE `id` = '{$GET__id}'");

?>
<?php
if($DB_DATA->rowCount() == 1) {

  $DB_DATA = (object) $DB_DATA->fetch(PDO::FETCH_ASSOC);
  $DB_DATA->folder = __DATA_ROOT__."/{$DB_DATA->folder}";

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
            <style>'.file_get_contents(__PUBLIC_ROOT__->styles.'/admin/assign-schedule.css').'</style>
            <script>'.file_get_contents(__PUBLIC_ROOT__->scripts.'/admin/assign-schedule.js').'</script>
            <div>
              <i>Oferta Académica</i>
              <select size="8" multiple>
                <option onclick="setSubjectSchedule(this)">Limpiar</option>
      ';

      $user_approved_subjects = [];
      if(file_exists("{$DB_DATA->folder}/history.json")) {
        foreach(json_decode(file_get_contents("{$DB_DATA->folder}/history.json")) as $semester) {
          foreach($semester->details as $subject) {
            if($subject->Estado === 'Aprobado')
              $user_approved_subjects[] = substr($subject->Código, 0, 5);
          }
        }
      }
      
      foreach(dbcursor("SELECT * FROM `catalog` WHERE `schedule` IS NOT NULL")->fetchAll(PDO::FETCH_OBJ) as $subject) {

        $subject->weekday = intval(explode('@', $subject->schedule)[0]);
        $subject->time = explode('@', $subject->schedule)[1];
        $subject->approved = $subject->user !== $GET__id ? in_array($subject->code, $user_approved_subjects) : true;

        $RENDER_HTML.= "
          <option onclick='setSubjectSchedule(this)' oncontextmenu='
            event.preventDefault();
            this.disabled=false;
            this.selected=false;
            this.oncontextmenu=null
          ' value='{$subject->schedule}' data-subject-code='{$subject->code}' data-subject-id='{$subject->id}' ".(!$subject->approved ? 'disabled' : null).">
            {$subject->code} - {$subject->subject}
            |
            ".array('Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo')[$subject->weekday-1]."
            de
            ".str_replace('-', ' a ', $subject->time)."
          </option>
          ".($subject->user === $GET__id ? 
            '<script>
              document.querySelector(`option[data-subject-id="'.$subject->id.'"]`).selected = true;
              document.currentScript.remove();
              setTimeout(() => document.querySelector(`option[data-subject-id="'.$subject->id.'"]`).click(), 0);
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
        <script>
          var CURRENT_SCHEDULE_DATA = JSON.parse(`'.(file_get_contents("{$DB_DATA->folder}/schedule.json") ?? null).'`);
          document.currentScript.remove();
        </script>
      ';

    } else exit('<h2>Datos no encontrados</h2>');

  } else exit('component nof found');
}
?>
<h2>
  <?php if(isset($DB_DATA->name)) {
    echo <<<HTML
      {$DB_DATA->name}
      <span>0 horas</span>
    HTML;
  } else print('INDEFINID@') ?>
</h2>
<br>
<br>
<?= $RENDER_HTML ?>
