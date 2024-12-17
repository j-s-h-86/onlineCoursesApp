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
            $stmt = $pdo->prepare("SELECT * FROM orders WHERE id = :id");
            $stmt->execute(['id' => $id]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($data);
        } else {
            $stmt = $pdo->query("SELECT * FROM orders");
            $orders = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $orders[] = $row;
            }
            echo json_encode($orders);
        }
        break;

    case 'POST':
        $name = $input['fullName'];
        $email = $input['email'];
        $courseId = $input['courseId'];
        $pdo->query("INSERT INTO orders (fullName, email, courseId) VALUES ('$name', '$email', '$courseId')");
        echo json_encode(["message" => "Order added successfully"]);
        break;

    case 'PUT':
        $id = $_GET['id'];
        $name = $input['name'];
        $email = $input['email'];
        $pdo->query("UPDATE orders SET name='$name',
                     email='$email' WHERE id=$id");
        echo json_encode(["message" => "Order updated successfully"]);
        break;

    case 'DELETE':
        $id = $_GET['id'];
        $pdo->query("DELETE FROM orders WHERE id=$id");
        echo json_encode(["message" => "Order deleted successfully"]);
        break;

    default:
        echo json_encode(["message" => "Invalid request method"]);
        break;
}

?>