<?php
header('Content-Type: application/json');

// In-memory storage
session_start();
if (!isset($_SESSION['items'])) {
    $_SESSION['items'] = [];
    $_SESSION['next_id'] = 1;
}

$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Router
if ($method === 'GET' && $path === '/health') {
    http_response_code(200);
    echo json_encode(['status' => 'ok']);
    exit;
}

if ($method === 'GET' && $path === '/items') {
    http_response_code(200);
    echo json_encode(array_values($_SESSION['items']));
    exit;
}

if ($method === 'POST' && $path === '/items') {
    $body = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($body['name']) || empty($body['name'])) {
        http_response_code(400);
        echo json_encode(['error' => 'name is required']);
        exit;
    }
    
    $item = [
        'id' => $_SESSION['next_id'],
        'name' => $body['name']
    ];
    $_SESSION['items'][$_SESSION['next_id']] = $item;
    $_SESSION['next_id']++;
    
    http_response_code(201);
    echo json_encode($item);
    exit;
}

if ($method === 'GET' && preg_match('#^/items/(\d+)$#', $path, $matches)) {
    $id = (int)$matches[1];
    
    if (isset($_SESSION['items'][$id])) {
        http_response_code(200);
        echo json_encode($_SESSION['items'][$id]);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Not Found']);
    }
    exit;
}

http_response_code(404);
echo json_encode(['error' => 'Not Found']);
