<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

session_start();
require __DIR__ . "/server_connection.php";

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "Not logged in"]);
    exit;
}

if (!isset($_FILES['profile_image'])) {
    echo json_encode(["success" => false, "message" => "No file uploaded"]);
    exit;
}

$file = $_FILES['profile_image'];

if ($file['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(["success" => false, "message" => "Upload error"]);
    exit;
}

if ($file['size'] > 2 * 1024 * 1024) {
    echo json_encode(["success" => false, "message" => "Max 2MB allowed"]);
    exit;
}

$allowed = [
    'image/jpeg' => 'jpg',
    'image/png'  => 'png',
    'image/webp' => 'webp'
];

$mime = mime_content_type($file['tmp_name']);
if (!isset($allowed[$mime])) {
    echo json_encode(["success" => false, "message" => "Only JPG/PNG/WEBP allowed"]);
    exit;
}

$ext = $allowed[$mime];

$uploadDir = __DIR__ . "/uploads/";
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$userId = (int)$_SESSION['user_id'];
$newName = "user_" . $userId . "_" . time() . "." . $ext;

if (!move_uploaded_file($file['tmp_name'], $uploadDir . $newName)) {
    echo json_encode(["success" => false, "message" => "Save failed"]);
    exit;
}

/* old image delete */
$get = $conn->prepare("SELECT profile_image FROM users WHERE id=?");
$get->bind_param("i", $userId);
$get->execute();
$old = $get->get_result()->fetch_assoc()['profile_image'] ?? '';

if ($old && $old !== 'default.png') {
    $oldPath = $uploadDir . $old;
    if (file_exists($oldPath)) unlink($oldPath);
}

/* update db */
$upd = $conn->prepare("UPDATE users SET profile_image=? WHERE id=?");
$upd->bind_param("si", $newName, $userId);
$upd->execute();

echo json_encode([
    "success" => true,
    "image" => "uploads/" . $newName
]);
exit;