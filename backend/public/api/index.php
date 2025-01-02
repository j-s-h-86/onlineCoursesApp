<?php

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit(0);
}

require_once '../../config/database.php';
require_once '../../models/Course.php';
require_once '../../models/Teacher.php';
require_once '../../models/Order.php';

$dbContext = new DBContext();
$pdo = $dbContext->getPdo();

$request_uri = $_SERVER['REQUEST_URI'];
$request_uri = str_replace('/backend/public/api', '', $request_uri);
$uri_parts = explode('/', trim($request_uri, '/'));

$resource = $uri_parts[0] ?? '';
$id = $uri_parts[1] ?? '';



switch ($resource) {
    case 'courses':
        $courseModel = new Course($pdo);
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if ($id) {
                $data = $courseModel->getCourseById($id);
                echo json_encode($data);
            } else {
                $courses = $courseModel->getAllCourses();
                echo json_encode($courses);
            }
        } else {
            header("HTTP/1.0 405 Method Not Allowed");
            echo json_encode(["message" => "Method not allowed"]);
        }
        break;

    case 'teachers':
        $teacherModel = new Teacher($pdo);
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if ($id) {
                $data = $teacherModel->getTeacherById($id);
                echo json_encode($data);
            } else {
                $teachers = $teacherModel->getAllTeachers();
                echo json_encode($teachers);
            }
        } else {
            header("HTTP/1.0 405 Method Not Allowed");
            echo json_encode(["message" => "Method not allowed"]);
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
        } else {
            header("HTTP/1.0 405 Method Not Allowed");
            echo json_encode(["message" => "Method not allowed"]);
        }
        break;

    case 'create-checkout-session':
        require 'create-checkout-session.php';
        break;

    case 'login':
        require 'login.php';
        break;

    case 'logout':
        require 'logout.php';
        break;

    default:
        header("HTTP/1.0 404 Not Found");
        echo json_encode(["message" => "Resource not found"]);
        break;
}
