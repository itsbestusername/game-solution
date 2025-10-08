<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    // Логируем для отладки
    error_log("Upload attempt: " . $_FILES['file']['name']);
    
    $url = 'https://api.watersolver.zeonbot.com/solve-file';
    
    // Создаем CURLFile для правильной передачи файла
    $file = new CURLFile($_FILES['file']['tmp_name'], $_FILES['file']['type'], $_FILES['file']['name']);
    
    $postData = [
        'file' => $file
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Игнорируем проверку SSL
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // Игнорируем проверку хоста
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    
    // Логируем детали для отладки
    error_log("CURL Response Code: " . $httpCode);
    error_log("CURL Error: " . $error);
    error_log("Response preview: " . substr($response, 0, 200));
    
    if ($error) {
        http_response_code(500);
        echo json_encode(['error' => 'CURL Error: ' . $error, 'url' => $url]);
    } else if ($httpCode >= 400) {
        http_response_code($httpCode);
        echo json_encode(['error' => 'API Error: HTTP ' . $httpCode, 'response' => substr($response, 0, 500)]);
    } else {
        http_response_code($httpCode);
        echo $response;
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'No file uploaded or wrong method']);
}
?>