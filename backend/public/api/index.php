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

$id = isset($_GET['id']) ? (int) $_GET['id'] : null;

$request_uri = $_SERVER['REQUEST_URI'];
$request_uri = str_replace('/backend/public/api', '', $request_uri);
$uri_parts = explode('/', trim($request_uri, '/'));

$resource = $uri_parts[0] ?? '';
$id = $uri_parts[1] ?? '';

switch ($resource) {
    case 'courses':
        $courseModel = new Course($pdo);
        header("Content-Type: application/json");

        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                if ($id) {
                    $data = $courseModel->getCourseById($id);
                    if ($data) {
                        echo json_encode($data);
                    } else {
                        http_response_code(404);
                        echo json_encode(["message" => "Course not found"]);
                    }
                } else {
                    $courses = $courseModel->getAllCourses();
                    echo json_encode($courses);
                }
                break;

            case 'POST':
                $input = json_decode(file_get_contents('php://input'), true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $result = $courseModel->addCourse($input);
                    if ($result) {
                        http_response_code(201);
                        echo json_encode(["message" => "Course added successfully"]);
                    } else {
                        http_response_code(500);
                        echo json_encode(["message" => "Failed to add course"]);
                    }
                } else {
                    http_response_code(400);
                    echo json_encode(["message" => "Invalid JSON input"]);
                }
                break;

            case 'PUT':
                if (!$id) {
                    http_response_code(400);
                    echo json_encode(["message" => "Missing course ID"]);
                    break;
                }

                $input = json_decode(file_get_contents('php://input'), true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $result = $courseModel->updateCourse($id, $input);
                    if ($result) {
                        echo json_encode(["message" => "Course updated successfully"]);
                    } else {
                        http_response_code(404);
                        echo json_encode(["message" => "Course not found"]);
                    }
                } else {
                    http_response_code(400);
                    echo json_encode(["message" => "Invalid JSON input"]);
                }
                break;

            case 'DELETE':
                if (!$id) {
                    http_response_code(400);
                    echo json_encode(["message" => "Missing course ID"]);
                    break;
                }

                $result = $courseModel->deleteCourse($id);
                if ($result) {
                    echo json_encode(["message" => "Course deleted successfully"]);
                } else {
                    http_response_code(404);
                    echo json_encode(["message" => "Course not found"]);
                }
                break;

            default:
                http_response_code(405);
                echo json_encode(["message" => "Method not allowed"]);
                break;
        }
        break;

    case 'teachers':
        $teacherModel = new Teacher($pdo);
        header("Content-Type: application/json");

        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                if ($id) {
                    $data = $teacherModel->getTeacherById($id);
                    if ($data) {
                        echo json_encode($data);
                    } else {
                        http_response_code(404);
                        echo json_encode(["message" => "Teacher not found"]);
                    }
                } else {
                    $teacher = $teacherModel->getAllTeachers();
                    echo json_encode($teacher);
                }
                break;

            case 'POST':
                $input = json_decode(file_get_contents('php://input'), true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $result = $teacherModel->addTeacher($input);
                    if ($result) {
                        http_response_code(201);
                        echo json_encode(["message" => "Teacher added successfully"]);
                    } else {
                        http_response_code(500);
                        echo json_encode(["message" => "Failed to add teacher"]);
                    }
                } else {
                    http_response_code(400);
                    echo json_encode(["message" => "Invalid JSON input"]);
                }
                break;

            case 'PUT':
                if (!$id) {
                    http_response_code(400);
                    echo json_encode(["message" => "Missing teacher ID"]);
                    break;
                }

                $input = json_decode(file_get_contents('php://input'), true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $result = $teacherModel->updateTeacher($id, $input);
                    if ($result) {
                        echo json_encode(["message" => "Teacher updated successfully"]);
                    } else {
                        http_response_code(404);
                        echo json_encode(["message" => "Teacher not found"]);
                    }
                } else {
                    http_response_code(400);
                    echo json_encode(["message" => "Invalid JSON input"]);
                }
                break;

            case 'DELETE':
                if (!$id) {
                    http_response_code(400);
                    echo json_encode(["message" => "Missing teacher ID"]);
                    break;
                }

                $result = $teacherModel->deleteTeacher($id);
                if ($result) {
                    echo json_encode(["message" => "Teacher deleted successfully"]);
                } else {
                    http_response_code(404);
                    echo json_encode(["message" => "Teacher not found"]);
                }
                break;

            default:
                http_response_code(405);
                echo json_encode(["message" => "Method not allowed"]);
                break;
        }
        break;

    case 'orders':
        $orderModel = new Order($pdo);
        header("Content-Type: application/json");

        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                if ($id) {
                    $data = $orderModel->getOrderById($id);
                    if ($data) {
                        echo json_encode($data);
                    } else {
                        http_response_code(404);
                        echo json_encode(["message" => "Order not found"]);
                    }
                } else {
                    $order = $orderModel->getAllOrders();
                    echo json_encode($order);
                }
                break;

            case 'POST':
                $input = json_decode(file_get_contents('php://input'), true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $result = $orderModel->createOrder($input);
                    if ($result) {
                        http_response_code(201);
                        echo json_encode(["message" => "Order added successfully"]);
                    } else {
                        http_response_code(500);
                        echo json_encode(["message" => "Failed to add Order"]);
                    }
                } else {
                    http_response_code(400);
                    echo json_encode(["message" => "Invalid JSON input"]);
                }
                break;

            case 'PUT':
                if (!$id) {
                    http_response_code(400);
                    echo json_encode(["message" => "Missing order ID"]);
                    break;
                }

                $input = json_decode(file_get_contents('php://input'), true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $result = $orderModel->updateOrder($id, $input);
                    if ($result) {
                        echo json_encode(["message" => "Order updated successfully"]);
                    } else {
                        http_response_code(404);
                        echo json_encode(["message" => "Order not found"]);
                    }
                } else {
                    http_response_code(400);
                    echo json_encode(["message" => "Invalid JSON input"]);
                }
                break;

            case 'DELETE':
                if (!$id) {
                    http_response_code(400);
                    echo json_encode(["message" => "Missing order ID"]);
                    break;
                }

                $result = $orderModel->deleteOrder($id);
                if ($result) {
                    echo json_encode(["message" => "Order removed successfully"]);
                } else {
                    http_response_code(404);
                    echo json_encode(["message" => "Order not found"]);
                }
                break;

            default:
                http_response_code(405);
                echo json_encode(["message" => "Method not allowed"]);
                break;
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
