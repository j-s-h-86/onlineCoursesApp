<?php
require_once '../../vendor/autoload.php';
require_once '../../config/database.php';

header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

$dbContext = new DBContext();
$pdo = $dbContext->getPdo();

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $stmt = $pdo->prepare("SELECT * FROM teachers WHERE id = :id");
            $stmt->execute(['id' => $id]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($data);
        } else {
            $stmt = $pdo->query("SELECT * FROM teachers");
            $teachers = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $teachers[] = $row;
            }
            echo json_encode($teachers);
        }
        break;



    default:
        echo json_encode(["message" => "Invalid request method"]);
        break;
}
?>