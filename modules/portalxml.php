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
          $nodeValue = trim(html_entity_decode($cellNode->nodeValue));
          $rowData[$key] = $nodeValue;
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
  static public function scheduleToHtml(string $innerHTML): array {
    $data = array('html'=>null, 'json'=>null);

    $dom = new DOMDocument();
    @$dom->loadHTML($innerHTML);
    $xpath = new DOMXPath($dom);

    $DOMContext = $xpath->query("(//table)[2]")->item(0);
    $visualMatrix = [];
    $rowIndex = 0;

    # construction of a visual matrix considering row width
    foreach($DOMContext->getElementsByTagName('tr') as $trNode) {
      $colIndex = 0;

      if(!isset($visualMatrix[$rowIndex]))
        $visualMatrix[$rowIndex] = [];

      foreach($trNode->childNodes as $cellNode) {
        if($cellNode->nodeType !== XML_ELEMENT_NODE || $cellNode->tagName !== 'td')
          continue;
        while(isset($visualMatrix[$rowIndex][$colIndex]))
          $colIndex++;
        $rowspan = max(1, (int)$cellNode->getAttribute('rowspan'));
        for($i = 0; $i < $rowspan; $i++)
          $visualMatrix[$rowIndex + $i][$colIndex] = $cellNode;
        $colIndex++;
      }

      $rowIndex++;
    }

    foreach($xpath->query(".//td[contains(@class, 'texto')]", $DOMContext) as $tdNode) {
      foreach($visualMatrix as $rowId) {
        foreach($rowId as $colId => $cellNode) {
          if($cellNode->isSameNode($tdNode)) {
            $nodeValue = explode('/', $tdNode->nodeValue);
            $data['json'][$colId+1][$nodeValue[0]][] = str_replace(' ', '', $nodeValue[1]);
            break 2;
          }
        }
      }
    }
    
    $data['html'].= $dom->saveHTML($xpath->query("(//style)[1]")->item(0));
    $data['html'].= $dom->saveHTML($DOMContext);
    $data['html'].= $dom->saveHTML($xpath->query("(//fieldset)[last()]")->item(0));

    $data['json'] = json_encode($data['json']);
    return $data;
  }

}
?>
