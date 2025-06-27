<?php

function xmlhistoryToJson(string $innerHTML): array {
  $data = [];

  $dom = new DOMDocument();
  @$dom->loadHTML($innerHTML);
  $xpath = new DOMXPath($dom);

  foreach($xpath->query("//*[contains(@class, 'tblNotas')]") as $DOMContext) {
            
    $user_history_means = $xpath->query(".//*[contains(@class, 'promedio')]", $DOMContext);
    $user_history_credits = $xpath->query("./tr[3]/td[2]", $DOMContext);
    $user_history_status = $xpath->query(".//td[contains(@colspan, '2')]", $DOMContext);
    $user_history_details = $xpath->query(".//table[contains(@class, 'tblDetalle')]", $DOMContext);
            
    for($i = 0; $i < $user_history_means->length; $i++) {
      $data[] = array(
        'mean'    => trim(explode(':', $user_history_means[$i]->nodeValue)[1]),
        'credits' => explode(' ', explode(',', $user_history_credits[0]->nodeValue)[2])[3],
        'status'  => $user_history_status[$i]->nodeValue,
        'details' => $user_history_details[$i]
      );
    }

  }

  foreach($data as $mainIndex => $semester) {

    $headers = [];
    $tableContent = [];

    $headerNodes = $xpath->query("./tr[1]/th", $semester['details']);
    $rowsNodes = $xpath->query("./tr[position() > 1]", $semester['details']);

    # header extract
    foreach($headerNodes as $headerNode)
      $headers[] = trim(html_entity_decode($headerNode->nodeValue));

    # cells extract
    foreach($rowsNodes as $rowNode) {
      $rowData = [];
      $cellNodes = $xpath->query("./td", $rowNode);
              
      foreach($cellNodes as $rowIndex => $cellNode) {
        $key = $headers[$rowIndex] ?? $rowIndex;
        $value = trim(html_entity_decode($cellNode->nodeValue));
        $rowData[$key] = $value;
      }
              
      if(!empty($rowData))
        $tableContent[] = $rowData;
    }

    $data[$mainIndex]["details"] = $tableContent;

  }

  return $data;
}

function xmlScheduleToJson(string $innerHTML) {}

?>
<?php

require_once(__DOCUMENT_ROOT__.'/modules/dbconn.php');

session_start();

$SESSION__sessref = $_SESSION['sessref'] ?? null;
$GET__data = $_GET['data'] ?? null;

?>
<?php
if(!is_null($GET__data)) {
  if(preg_match('/PHPSESSID=([^;\s]+)/', $GET__data, $matches)) {
    if(!empty($matches[0])) {

      $user_cookie_value = $matches[1];

      if(!is_null($SESSION__sessref)) {

        $user_sess_check = dbcursor("SELECT * FROM user WHERE `id` = '{$SESSION__sessref}'");
        $USER_DATA = $user_sess_check->fetch(PDO::FETCH_ASSOC);

        if($user_sess_check->rowCount() > 0) {

          $ch_history = curl_init();
          curl_setopt($ch_history, CURLOPT_URL, 'https://app4.utp.edu.co/MatAcad/verificacion/oracle.php');
          curl_setopt($ch_history, CURLOPT_POST, true);
          curl_setopt($ch_history, CURLOPT_POSTFIELDS, 'cmbprogramas=FI');
          curl_setopt($ch_history, CURLOPT_HTTPHEADER, ["Cookie: PHPSESSID={$user_cookie_value}"]);
          curl_setopt($ch_history, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch_history, CURLOPT_SSL_VERIFYPEER, false);

          $history_response = curl_exec($ch_history);
          if(!curl_errno($ch_history)) {
            
            file_put_contents(__DATA_ROOT__."/{$USER_DATA['folder']}/history.json", json_encode(xmlhistoryToJson($history_response), JSON_PRETTY_PRINT));
            $DOCUMENT_STATE = true;

          } else $DOCUMENT_STATE = false;

          curl_close($ch_history);
          $DOCUMENT_STATE = true;

        }
      }

    } else { $DOCUMENT_STATE = false; }
  } else { $DOCUMENT_STATE = false; }
} else { $DOCUMENT_STATE = false; }
?>
<!DOCTYPE html>
<html lang="es-CO">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/styles/notices.css">
    <link rel="shortcut icon" href="/resources/favicon.png" type="image/x-icon">
    <title>Importación de Cookies</title>
  </head>
  <body>

    <?php if(is_null($SESSION__sessref)) { ?>
    
      <h1 style="color:#ec7063">No se ha detectada<br>su sesión en Muxnitor</h1>

    <?php } elseif($DOCUMENT_STATE) { ?>

      <h1 style="color:#52be80">Datos cargados exitosamente</h1>
      <br>
      <button>Redireccionando..</button>
      <script>setTimeout(() => window.location.href = "/user/dashboard", 2*1000);</script>

    <?php } else { ?>

      <h1 style="color:#ec7063">No se han podido cargar los datos</h1>

    <?php } ?>

  </body>
</html>
