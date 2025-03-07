<?php
header("Access-Control-Allow-Origin: *"); // allow CORS-policy on frontend
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once "student.php";

$email = $_POST['email'] ?? '';

if ($email) {
    $user = Student::getStudentFromEmail($email);
    if ($user) {
        http_response_code(200);
        echo json_encode(["message" => "Welcome back, " . $user->getEmail() . "!"]);
    } else {
        http_response_code(404);
        echo json_encode(["message" => "Email not found. Please register."]);
    }
} else {
    http_response_code(400);
    echo json_encode(["message" => "Email is required."]);
}
