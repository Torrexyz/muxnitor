<?php

require(dirname(__DIR__).'/session.php');

?>
<modal>
  <style><?= file_get_contents(__PUBLIC_ROOT__.'/styles/concat/modals/information.css') ?></style>

  <div class="board">
    <div>
      <span>Beatriz Gonzales</span>
      <h3>Informe monitorias</h3>
      <pre>
Buenas tardes, estimados estudiantes

Por medio de la presente se envía carta de compromiso e informe mensual el cual debe ser firmado por el docente y enviado a mi correo el día 9 de septiembre para realizar los trámites correspondientes
Todos tienen fecha de inicio el 12 de agosto.

Es de aclarar que la carta de compromiso solo se firma una vez.

Se envía formato guia para reporte de monitorias
      </pre>
      <ul>
        <li onclick="window.open('', '_blank')">
          <svg xmlns="http://www.w3.org/2000/svg" height="22px" viewBox="0 -960 960 960" width="30px" fill="black"><path d="M320-440h320v-80H320v80Zm0 120h320v-80H320v80Zm0 120h200v-80H320v80ZM240-80q-33 0-56.5-23.5T160-160v-640q0-33 23.5-56.5T240-880h320l240 240v480q0 33-23.5 56.5T720-80H240Zm280-520v-200H240v640h480v-440H520ZM240-800v200-200 640-640Z"/></svg>
          Documento sin título.docx
        </li>
      </ul>
      <i>11/07/2025 07:00 A.M</i>
    </div>
  </div>
</modal>
