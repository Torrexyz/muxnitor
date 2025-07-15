<?php

require(dirname(__DIR__).'/session.php');

?>
<modal style="height:auto">
  <style><?= file_get_contents(__PUBLIC_ROOT__.'/styles/concat/modals/schedule.css') ?></style>

  <br>
  <br>

  <?= $DB_DATA->schedule ?>

  <div class="schedule">

    <ul>
      <li>Día</li>
      <li>06:00</li>
      <li>07:00</li>
      <li>08:00</li>
      <li>09:00</li>
      <li>10:00</li>
      <li>11:00</li>
      <li>12:00</li>
      <li>01:00</li>
      <li>02:00</li>
      <li>03:00</li>
      <li>04:00</li>
      <li>05:00</li>
      <li>06:00</li>
      <li>07:00</li>
      <li>08:00</li>
      <li>09:00</li>
      <li>10:00</li>
    </ul>

    <select size="18" multiple>
      <option disabled>Lunes</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
    </select>

    <select size="18" multiple>
      <option disabled>Martes</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
    </select>

    <select size="18" multiple>
      <option disabled>Miercoles</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
    </select>

    <select size="18" multiple>
      <option disabled>Jueves</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
    </select>

    <select size="18" multiple>
      <option disabled>Viernes</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
    </select>

    <select size="18" multiple>
      <option disabled>Sabado</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
    </select>

    <select size="18" multiple>
      <option disabled>Domingo</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
      <option value="">...</option>
    </select>

  </div>

  <br>
  <br>

</modal>
