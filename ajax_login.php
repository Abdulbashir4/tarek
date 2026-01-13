<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
session_start();
require __DIR__ . "/server_connection.php";

$name     = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

$stmt = $conn->prepare(
    "SELECT id, password FROM users WHERE name=?"
);
$stmt->bind_param("s", $name);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $name;

        echo json_encode(["success" => true]);
        exit;
    }
}

echo json_encode([
    "success" => false,
    "message" => "ভুল Username বা Password"
]);
exit;