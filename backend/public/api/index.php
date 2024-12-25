<?php
require_once '../../config/database.php';
require_once '../../models/Course.php';
require_once '../../models/Teacher.php';
require_once '../../models/Order.php';

$dbContext = new DBContext();
$pdo = $dbContext->getPdo();

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

$request_uri = $_SERVER['REQUEST_URI'];
$request_uri = str_replace('/backend/public/api', '', $request_uri);
$uri_parts = explode('/', trim($request_uri, '/'));

$resource = $uri_parts[0] ?? '';
$id = $uri_parts[1] ?? '';

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

switch ($resource) {
    case 'courses':
        $courseModel = new Course($pdo);
        if ($id) {
            $data = $courseModel->getCourseById($id);
            echo json_encode($data);
        } else {
            $courses = $courseModel->getAllCourses();
            echo json_encode($courses);
        }
        break;

    case 'teachers':
        $teacherModel = new Teacher($pdo);
        if ($id) {
            $data = $teacherModel->getTeacherById($id);
            echo json_encode($data);
        } else {
            $teachers = $teacherModel->getAllTeachers();
            echo json_encode($teachers);
        }
        break;

    case 'orders':
        $orderModel = new Order($pdo);
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if ($id) {
                $data = $orderModel->getOrderById($id);
                echo json_encode($data);
            } else {
                $orders = $orderModel->getAllOrders();
                echo json_encode($orders);
            }
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $input = json_decode(file_get_contents('php://input'), true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $result = $orderModel->createOrder($input);
                if ($result) {
                    echo json_encode(["message" => "Order created successfully"]);
                } else {
                    header("HTTP/1.0 500 Internal Server Error");
                    echo json_encode(["message" => "Failed to create order"]);
                }
            } else {
                header("HTTP/1.0 400 Bad Request");
                echo json_encode(["message" => "Invalid JSON input"]);
            }
        }
        break;

    default:
        header("HTTP/1.0 404 Not Found");
        echo json_encode(["message" => "Resource not found"]);
        break;
}
