<?php
class PortalXML {

  /**
   * Converts HTML history text into useful JSON data format
   * @param string $innerHTML Raw html response
   */
  static public function historyToJson(string $innerHTML): array {
    $data = [];

    $dom = new DOMDocument();
    @$dom->loadHTML($innerHTML);
    $xpath = new DOMXPath($dom);

    # semester primary extraction
    foreach($xpath->query("//*[contains(@class, 'tblNotas')]")[1] ?? [] as $DOMContext) {
              
      $history_means   = $xpath->query(".//*[contains(@class, 'promedio')]", $DOMContext);
      $history_status  = $xpath->query(".//td[contains(@colspan, '2')]", $DOMContext);
      $history_details = $xpath->query(".//table[contains(@class, 'tblDetalle')]", $DOMContext);
              
      for($i = 0; $i < $history_means->length; $i++) {
        $data[] = array(
          'mean'    => trim(explode(':', $history_means[$i]->nodeValue)[1]),
          'status'  => $history_status[$i]->nodeValue,
          'details' => $history_details[$i]
        );
      }

    }

    # semester details extraction
    foreach($data as $mainIndex => $semesterContent) {

      $headers = [];
      $tableContent = [];

      $headerNodes = $xpath->query("./tr[1]/th", $semesterContent['details']);
      $rowsNodes = $xpath->query("./tr[position() > 1]", $semesterContent['details']);

      # header extraction
      foreach($headerNodes as $headerNode)
        $headers[] = trim(html_entity_decode($headerNode->nodeValue));

      # cells extraction
      foreach($rowsNodes as $rowNode) {
        $rowData = [];
        $cellNodes = $xpath->query('./td', $rowNode);
                
        foreach($cellNodes as $rowIndex => $cellNode) {
          $key = $headers[$rowIndex] ?? $rowIndex;
          $value = trim(html_entity_decode($cellNode->nodeValue));
          $rowData[$key] = $value;
        }
                
        if(!empty($rowData))
          $tableContent[] = $rowData;
      }

      $data[$mainIndex]['details'] = $tableContent;

    }

    return $data;
  }

  /*<><><><><><><><><><>*/

  /**
   * Reduces HTML content to a simple required format
   * @param string $innerHTML Raw html response
   */
  static public function scheduleToHtml(string $innerHTML): string {
    $data = '';

    $dom = new DOMDocument();
    @$dom->loadHTML($innerHTML);
    $xpath = new DOMXPath($dom);

    $data.= $dom->saveHTML($xpath->query("(//style)[1]")->item(0));
    $data.= $dom->saveHTML($xpath->query("(//table)[2]")->item(0));
    $data.= $dom->saveHTML($xpath->query("(//fieldset)[last()]")->item(0));

    return $data;
  }

}
?>
