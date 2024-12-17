<?php
require_once '../../config/database.php';
require_once '../../models/Course.php';
require_once '../../models/Teacher.php';

$dbContext = new DBContext();
$pdo = $dbContext->getPdo();

$request_uri = $_SERVER['REQUEST_URI'];
$request_uri = str_replace('/backend/public/api', '', $request_uri);
$uri_parts = explode('/', trim($request_uri, '/'));

$resource = $uri_parts[0] ?? '';
$id = $uri_parts[1] ?? '';

header("Content-Type: application/json");

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

    default:
        header("HTTP/1.0 404 Not Found");
        echo json_encode(["message" => "Resource not found"]);
        break;
}
