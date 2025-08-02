<?php
function getWebsiteHTML($url) {
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_USERAGENT => 'PHP cURL Request',
        CURLOPT_TIMEOUT => 10,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0
    ]);

    $html = curl_exec($ch);
    
    if ($html === false) {
        throw new Exception("cURL error: " . curl_error($ch));
    }

    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($httpCode !== 200) {
        throw new Exception("HTTP request failed with code $httpCode");
    }

    curl_close($ch);
    return $html;
}

// Uso
try {
    $html = getWebsiteHTML("https://app4.utp.edu.co/pe/index.php");
    
    $dom = new DOMDocument();
    @$dom->loadHTML($html);
    $xpath = new DOMXPath($dom);

    $formulario = $xpath->query('//form[@name="frm_Inicio"]')->item(0);
    
    $hiddenInputs = $xpath->query('.//input[@type="hidden"]', $formulario);

    $user_form_name = null;
    $user_form_value = null;

    foreach ($hiddenInputs as $input) {
        $user_form_name = $input->getAttribute('name');
        $user_form_value = $input->getAttribute('value');
    }

    

// URL a la que se enviará la petición POST
$url = "https://app4.utp.edu.co/pe/validacion.php";

// Datos POST a enviar (formato array asociativo)
$postData = [
    $user_form_name => $user_form_value,
    'txtUrio' => '1004778853',  // Cambia 'valor1' por el valor real
    'txtPsswd'   => 'valor2',  // Cambia 'valor2' por el valor real
    'cocat'   => '0'   // Cambia 'valor3' por el valor real
];

// Inicializar cURL
$ch = curl_init();

// Configurar opciones de cURL
curl_setopt_array($ch, [
    CURLOPT_URL            => $url,
    CURLOPT_POST           => true,                // Método POST
    CURLOPT_POSTFIELDS     => http_build_query($postData), // Datos POST codificados
    CURLOPT_RETURNTRANSFER => true,               // Devuelve el resultado como string
    CURLOPT_HEADER         => true,               // Incluir cabeceras en la respuesta
    CURLOPT_FOLLOWLOCATION => true,               // Seguir redirecciones
    #CURLOPT_COOKIEJAR      => 'cookies.txt',      // Guardar cookies en un archivo (opcional)
    #CURLOPT_COOKIEFILE     => 'cookies.txt',       // Leer cookies desde un archivo (opcional)
    CURLOPT_USERAGENT      => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
    CURLOPT_SSL_VERIFYHOST => 0,
    CURLOPT_SSL_VERIFYPEER => 0
]);

// Ejecutar la petición y guardar la respuesta
$response = curl_exec($ch);

// Verificar errores
if (curl_errno($ch)) {
    die("Error en cURL: " . curl_error($ch));
}

// Obtener información de la petición (como el código HTTP)
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// Cerrar la sesión cURL
curl_close($ch);

// Separar cabeceras y cuerpo (HTML) de la respuesta
$headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
$headers = substr($response, 0, $headerSize);
$html = substr($response, $headerSize);

// Mostrar resultados
echo "=== CABECERAS ===\n";
echo $headers . "\n\n";

echo "=== HTML ===\n";
echo $html . "\n\n";

echo "=== CÓDIGO HTTP ===\n";
echo $httpCode . "\n";

// Si se guardaron cookies, puedes leerlas
if (file_exists('cookies.txt')) {
    echo "=== COOKIES GUARDADAS ===\n";
    echo file_get_contents('cookies.txt') . "\n";
}




} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>