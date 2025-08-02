<?php

require(dirname(__DIR__).'/session.php');

$LABOR_CONTAINER = dbcursor("SELECT * FROM `catalog` WHERE `user` = '{$DB_DATA->id}'")->fetchAll(PDO::FETCH_ASSOC);

?>
<modal style="height:auto">

  <br>
  <br>

  <table class="default">
    <tr>
      <th style="width:70px">Código</th>
      <th style="width:200px" column-ref="subject">Materia</th>
      <th style="width:70px" column-ref="group">Grupo</th>
      <th column-ref="schedule">Horario<br>Asignado</th>
      <th style="width:300px" column-ref="professor">Información<br>Docente</th>
    </tr>
    <?php
      foreach($LABOR_CONTAINER as $catalog) {
        if(!is_null($catalog['schedule'])) {

          $catalog_schedule_weekday = explode('@', $catalog['schedule'])[0];
          $catalog_schedule_time = explode('-', explode('@', $catalog['schedule'])[1]);

        } else {
          $catalog_schedule_weekday = null;
          $catalog_schedule_time = null;
        }
    ?>
      <tr>
        <td tabindex="0"><?= $catalog['code'] ?></td>

        <td tabindex="0"><?= $catalog['subject'] ?></td>

        <td tabindex="0"><?= $catalog['group'] ?? 'SIN DEFINIR' ?></td>

        <td tabindex="0">
          <?php if(isset($catalog['schedule'])) { ?>
            <?= array('Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado')[intval($catalog_schedule_weekday)-1] ?>
            <br>de <?= $catalog_schedule_time[0] ?> a <?= $catalog_schedule_time[1] ?>
          <?php } else print('SIN DEFINIR'); ?>
        </td>

        <td tabindex="0"><?= $catalog['professor'] ?? 'SIN DEFINIR' ?></td>
      </tr>
    <?php } ?>
  </table>

  <br>
  <br>

</modal>
