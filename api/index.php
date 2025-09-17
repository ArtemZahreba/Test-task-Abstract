<?php
// Підключаємо конфіг
$config = require __DIR__ . '/../config.php';

// Перевірка токена
$headers = getallheaders();
if (!isset($headers['Authorization']) || $headers['Authorization'] !== 'Bearer ' . $config['api_token']) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

// Встановлюємо заголовки
header('Content-Type: application/json');

// Шлях до файлу з даними
$dataFile = $config['data_file'];
if (!file_exists($dataFile)) {
    file_put_contents($dataFile, json_encode([]));
}
$data = json_decode(file_get_contents($dataFile), true);

// Метод і маршрут
$method = $_SERVER['REQUEST_METHOD'];
$path   = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// ---- GET /api/info ----
if ($method === 'GET' && $path === '/api/info') {
    echo json_encode($data);
    exit;
}

// ---- POST /api/info ----
if ($method === 'POST' && $path === '/api/info') {
    $input = json_decode(file_get_contents('php://input'), true);

    if (!isset($input['name']) || !isset($input['email'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid input']);
        exit;
    }

    $new = [
        'id' => count($data) + 1,
        'name' => htmlspecialchars($input['name']),
        'email' => htmlspecialchars($input['email'])
    ];

    $data[] = $new;
    file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT));

    echo json_encode($new);
    exit;
}

// ---- Якщо маршрут не знайдений ----
http_response_code(404);
echo json_encode(['error' => 'Not Found']);
