<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
require __DIR__ . "/server_connection.php";

$name     = trim($_POST['username'] ?? ''); // input নাম username থাকছে
$phone = trim($_POST['phone'] ?? '');
$password = $_POST['password'] ?? '';
$confirm  = $_POST['confirm_password'] ?? '';

if ($name === '' || $phone === '' || $password === '' || $confirm === '') {
    echo json_encode([
        "success" => false,
        "message" => "সব ফিল্ড পূরণ করো"
    ]);
    exit;
}

if ($password !== $confirm) {
    echo json_encode([
        "success" => false,
        "message" => "Password মিলছে না"
    ]);
    exit;
}

/* 🔍 name already exists check */
$check = $conn->prepare("SELECT id FROM users WHERE name=?");
if (!$check) {
    echo json_encode([
        "success" => false,
        "message" => $conn->error
    ]);
    exit;
}

$check->bind_param("s", $name);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    echo json_encode([
        "success" => false,
        "message" => "এই Username আগেই আছে"
    ]);
    exit;
}

/* ✅ Insert user */
$hashed = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO users (name, phone, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $phone, $hashed);



if ($stmt->execute()) {
    echo json_encode([
        "success" => true
    ]);
    exit;
}

echo json_encode([
    "success" => false,
    "message" => "Registration failed"
]);
exit;