<?php
require_once '../../vendor/autoload.php';
require_once '../../config/database.php';

header('Access-Control-Allow-Origin: http://localhost:5173');
header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit();
}

$dbContext = new DBContext();

try {
    $dbContext->getUserDatabase()->getAuth()->logOut();
    echo json_encode(['success' => true, 'message' => 'User logged out successfully']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Could not log out']);
}

exit;
