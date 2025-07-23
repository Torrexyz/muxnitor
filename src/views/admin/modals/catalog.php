<?php

require(dirname(__DIR__).'/session.php');

$CATALOG_CONTAINER = dbcursor("SELECT * FROM catalog ORDER BY `id` DESC")->fetchAll(PDO::FETCH_ASSOC);

?>
<?php
if(!is_null($_POST['insert'] ?? null)) {
  
  $NOTICE__insert = null;

  $POST__code    = strtoupper($_POST['code'] ?? '');
  $POST__subject = $_POST['subject'] ?? null;
  $POST__group   = $_POST['group'] ?? null;

  if(strlen($POST__code) == 5) {
    if(strlen($POST__subject) <= 50) {
      if(strlen($POST__group) == 3) {
        
        if(dbcursor("INSERT INTO catalog(`code`,`subject`,`group`) VALUES (?,?,?)", array_values([
          'code'    => $POST__code,
          'subject' => $POST__subject,
          'group'   => $POST__group
        ]), true)) {
          header('Location: /admin/modals/catalog');
        } else { $NOTICE__insert = '<u>AVISO</u><br><br>Ah ocurrido un error al guardar el registro'; }

      } else { $NOTICE__insert = '<u>AVISO</u><br><br>El GRUPO de la asignatura debe<br>ser igual a 3 caracteres'; }
    } else { $NOTICE__insert = '<u>AVISO</u><br><br>El NOMBRE de la asignatura no debe<br>ser menor a 50 caracteres'; }
  } else { $NOTICE__insert = '<u>AVISO</u><br><br>El CÓDIGO de la asignatura debe<br>ser igual a 5 caracteres'; }

}
?>
<modal style="height:auto">

  <br>
  <br>

  <?php if(is_null($_GET['insert'] ?? null)) { ?>

    <button type="button" class="redirect" style="background:#58d68d" onclick="requestModal('/admin/modals/catalog?insert', { centerContent: true })">
      <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="white"><path d="M680-40v-120H560v-80h120v-120h80v120h120v80H760v120h-80ZM200-200v-560 560Zm0 80q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v353q-18-11-38-18t-42-11v-324H200v560h280q0 21 3 41t10 39H200Zm120-160q17 0 28.5-11.5T360-320q0-17-11.5-28.5T320-360q-17 0-28.5 11.5T280-320q0 17 11.5 28.5T320-280Zm0-160q17 0 28.5-11.5T360-480q0-17-11.5-28.5T320-520q-17 0-28.5 11.5T280-480q0 17 11.5 28.5T320-440Zm0-160q17 0 28.5-11.5T360-640q0-17-11.5-28.5T320-680q-17 0-28.5 11.5T280-640q0 17 11.5 28.5T320-600Zm120 160h240v-80H440v80Zm0-160h240v-80H440v80Zm0 320h54q8-23 20-43t28-37H440v80Z"/></svg>  
      <span>&nbsp;</span>
      Agregar
    </button>

    <br>
    <br>

    <table class="default">
      <tr>
        <th style="width:70px">Código</th>
        <th style="width:200px" column-ref="subject">Materia</th>
        <th column-ref="group">Grupo</th>
        <th column-ref="schedule">Horario</th>
        <th style="width:200px" column-ref="professor">Profesor</th>
        <th>Monitor</th>
      </tr>
      <?php
        foreach($CATALOG_CONTAINER as $catalog) {
          if(!is_null($catalog['schedule'])) {

            $catalog_schedule_weekday = explode('@', $catalog['schedule'])[0];
            $catalog_schedule_time = explode('-', explode('@', $catalog['schedule'])[1]);

          } else {
            $catalog_schedule_weekday = null;
            $catalog_schedule_time = null;
          }
      ?>
        <tr>
          <td oncontextmenu="changeCellValue(this, 'contextmenu-text')" tabindex="0" rowid-value="<?= $catalog['id'] ?>" cell-value="<?= $catalog['code'] ?>"><?= $catalog['code'] ?></td>

          <td ondblclick="changeCellValue(this)" tabindex="0"><?= $catalog['subject'] ?></td>

          <td ondblclick="changeCellValue(this)" tabindex="0"><?= $catalog['group'] ?? 'SIN DEFINIR' ?></td>

          <td ondblclick="changeCellValue(this, 'schedule')" tabindex="0" weekday-value="<?= $catalog_schedule_weekday ?>" starttime-value="<?= $catalog_schedule_time[0] ?>" endtime-value="<?= $catalog_schedule_time[1] ?>">
            <?php if(isset($catalog['schedule'])) { ?>
              <?= array('Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado')[intval($catalog_schedule_weekday)-1] ?>
              <br>de <?= $catalog_schedule_time[0] ?> a <?= $catalog_schedule_time[1] ?>
            <?php } else print('SIN DEFINIR'); ?>
          </td>

          <td ondblclick="changeCellValue(this)" tabindex="0"><?= $catalog['professor'] ?? 'SIN DEFINIR' ?></td>

          <td><?= null ?? 'SIN DEFINIR' ?></td>
        </tr>
      <?php } ?>
    </table>

  <?php } else { ?>

    <button type="button" class="redirect" style="background:#5499c7" onclick="requestModal('/admin/modals/catalog', { centerContent: true })">
      <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="white"><path d="M320-80q-33 0-56.5-23.5T240-160v-480q0-33 23.5-56.5T320-720h480q33 0 56.5 23.5T880-640v480q0 33-23.5 56.5T800-80H320Zm0-80h200v-120H320v120Zm280 0h200v-120H600v120ZM80-240v-560q0-33 23.5-56.5T160-880h560v80H160v560H80Zm240-120h200v-120H320v120Zm280 0h200v-120H600v120ZM320-560h480v-80H320v80Z"/></svg>  
      <span>&nbsp;</span>
      Ver registros
    </button>
    
    <br>
    <br>

    <form class="insert" action="/admin/modals/catalog?insert">
      <h2>Nueva oferta</h2>

      <p>Código</p>
      <input type="text" placeholder="FI414" value="<?= $POST__code ?? null ?>" name="code" maxlength="5">

      <p>Asignatura</p>
      <input type="text" placeholder="Analisis De Sistemas De Corriente Continua" value="<?= $POST__subject ?? null ?>" name="subject" maxlength="50">

      <p>Grupo</p>
      <input type="text" placeholder="101" name="group" value="<?= $POST__group ?? null ?>" maxlength="3">

      <button type="submit" name="insert" onclick="requestPostModal(this.parentNode, { centerContent: true })">Guardar</button>

      <i><?= $NOTICE__insert ?? 'Los demás datos como el horario y el docente<br>se podrán modificar posterior al<br>añadir el registro' ?></i>
    </form>

  <?php } ?>

  <br>
  <br>

</modal>
