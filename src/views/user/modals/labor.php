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
      <th column-ref="schedule">Horario<br>Designado</th>
      <th style="width:200px" column-ref="professor">Información<br>Docente</th>
      <th>Bitácora</th>
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

        <td>
          <svg style="cursor:pointer" onclick="alert('Función en desarrollo..')" xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="black"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-640v560h560v-560h-80v280l-100-60-100 60v-280H200Zm0 560v-560 560Z"/></svg>
        </td>
      </tr>
    <?php } ?>
  </table>

  <br>
  <br>

</modal>
