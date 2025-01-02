<?php
require_once '../../vendor/autoload.php';
require_once '../../config/database.php';

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit();
}

$dbContext = new DBContext();
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputData = json_decode(file_get_contents('php://input'), true);

    if (empty($inputData['email']) || empty($inputData['password'])) {
        echo json_encode(['success' => false, 'message' => 'Email and password are required']);
        http_response_code(400);
        exit;
    }

    $email = $inputData['email'];
    $password = $inputData['password'];

    try {
        $dbContext->getUserDatabase()->getAuth()->login($email, $password);
        echo json_encode(['success' => true, 'message' => 'User logged in successfully']);
        http_response_code(200);
    } catch (Exception $e) {
        error_log($e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Could not login']);
        http_response_code(401);
    }
}
?>