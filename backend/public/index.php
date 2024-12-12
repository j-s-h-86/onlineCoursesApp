<?php
$request_uri = $_SERVER['REQUEST_URI'];

var_dump($request_uri);
switch ($request_uri) {
    case '/api/courses':
        include 'api/courses.php';
        break;
    case '/api/teachers':
        include 'api/teachers.php';
        break;
    default:
        header("HTTP/1.0 404 Not Found");
        echo json_encode(["message" => "Resource not found"]);
        break;
}
?>