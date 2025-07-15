<?php

require(dirname(__DIR__).'/session.php');

$POSTULANTS_CONTAINER = dbcursor("SELECT * FROM user")->fetchAll(PDO::FETCH_ASSOC);

?>
<modal style="height:auto">

  <br>
  <br>

  <table class="default">
    <tr>
      <th>Correo</th>
      <th>Nombre</th>
      <th>Último<br>Promedio</th>
      <th>Horario<br>Académico</th>
      <th>Historial<br>Académico</th>
      <th>Asignación de<br>Monitorias</th>
    </tr>
    <?php
      foreach($POSTULANTS_CONTAINER as $postulant) {
        $postulant['folder'] = __DATA_ROOT__."/{$postulant['folder']}";

        if(file_exists("{$postulant['folder']}/history.json"))
            $postulant['history'] = json_decode(file_get_contents("{$postulant['folder']}/history.json"));

        if(file_exists("{$postulant['folder']}/schedule.html"))
          $postulant['schedule'] = file_get_contents("{$postulant['folder']}/schedule.html");

    ?>
      <tr>
        <td>
          <?= $postulant['id'] ?>@utp.edu.co
        </td>

        <td>
          <?= $postulant['name'] ?>
        </td>

        <td>
          <?php if(isset($postulant['history'])) { ?>
            <?= current($postulant['history'])->mean ?>
          <?php } else { ?>
            NO CARGADO
          <?php } ?>
        </td>

        <td>
          <?php if(isset($postulant['schedule'])) { ?>
            <svg style="cursor:pointer" xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="black"><path d="M120-120v-240h80v104l124-124 56 56-124 124h104v80H120Zm480 0v-80h104L580-324l56-56 124 124v-104h80v240H600ZM324-580 200-704v104h-80v-240h240v80H256l124 124-56 56Zm312 0-56-56 124-124H600v-80h240v240h-80v-104L636-580ZM480-400q-33 0-56.5-23.5T400-480q0-33 23.5-56.5T480-560q33 0 56.5 23.5T560-480q0 33-23.5 56.5T480-400Z"/></svg>
          <?php } else { ?>
            NO CARGADO
          <?php } ?>
        </td>

        <td>
          <?php if(isset($postulant['history'])) { ?>
            <svg style="cursor:pointer" xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="black"><path d="M120-120v-240h80v104l124-124 56 56-124 124h104v80H120Zm480 0v-80h104L580-324l56-56 124 124v-104h80v240H600ZM324-580 200-704v104h-80v-240h240v80H256l124 124-56 56Zm312 0-56-56 124-124H600v-80h240v240h-80v-104L636-580ZM480-400q-33 0-56.5-23.5T400-480q0-33 23.5-56.5T480-560q33 0 56.5 23.5T560-480q0 33-23.5 56.5T480-400Z"/></svg>
          <?php } else { ?>
            NO CARGADO
          <?php } ?>
        </td>

        <td>
          <?php if(isset($postulant['history']) && isset($postulant['schedule'])) { ?>
            <svg style="cursor:pointer" xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="black"><path d="M200-80q-33 0-56.5-23.5T120-160v-560q0-33 23.5-56.5T200-800h40v-80h80v80h320v-80h80v80h40q33 0 56.5 23.5T840-720v200h-80v-40H200v400h280v80H200Zm0-560h560v-80H200v80Zm0 0v-80 80ZM560-80v-123l221-220q9-9 20-13t22-4q12 0 23 4.5t20 13.5l37 37q8 9 12.5 20t4.5 22q0 11-4 22.5T903-300L683-80H560Zm300-263-37-37 37 37ZM620-140h38l121-122-18-19-19-18-122 121v38Zm141-141-19-18 37 37-18-19Z"/></svg>
          <?php } else { ?>
            NO DISPONIBLE
          <?php } ?>
        </td>
      </tr>
    <?php } ?>
  </table>

  <br>
  <br>

</modal>
