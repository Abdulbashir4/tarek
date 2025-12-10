<?php
// delete_product.php - robust JSON-only responder
// Overwrites any previous version. Place this file as delete_product.php

// Turn on errors to log only (not to browser). For local debug you can enable display_errors,
// but to keep JSON safe we capture and log errors instead.
ini_set('display_errors', 0);
error_reporting(E_ALL);

// start output buffering to prevent accidental echo/whitespace
ob_start();

header('Content-Type: application/json; charset=utf-8');

include "server_connection.php";
session_start();

// debug log file (make sure webserver can write to logs/ folder or change path)
$logFile = __DIR__ . '/logs/delete.log';
if (!is_dir(__DIR__ . '/logs')) @mkdir(__DIR__ . '/logs', 0755, true);

// helper to log
function dbg($msg) {
    global $logFile;
    @file_put_contents($logFile, "[".date('Y-m-d H:i:s')."] ".$msg.PHP_EOL, FILE_APPEND);
}

// ensure no prior output leaks
ob_clean();

try {
    // Basic request checks
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(['status'=>'error','message'=>'Invalid request method']);
        exit;
    }

    if (empty($_POST['product_id'])) {
        echo json_encode(['status'=>'error','message'=>'Missing product_id']);
        exit;
    }

    $product_id = (int)$_POST['product_id'];
    if ($product_id <= 0) {
        echo json_encode(['status'=>'error','message'=>'Invalid product_id']);
        exit;
    }

    $uploadDir = __DIR__ . '/uploads/products/';
    if (!is_dir($uploadDir)) @mkdir($uploadDir, 0755, true);

    // fetch product (thumbnail + gallery JSON)
    $stmt = $conn->prepare("SELECT thumbnail, gallery_images FROM products WHERE product_id = ?");
    if (!$stmt) {
        dbg("Prepare failed (select): " . $conn->error);
        echo json_encode(['status'=>'error','message'=>'Server prepare error']);
        exit;
    }
    $stmt->bind_param("i", $product_id);
    if (!$stmt->execute()) {
        dbg("Execute failed (select): " . $stmt->error);
        echo json_encode(['status'=>'error','message'=>'Server execute error']);
        exit;
    }
    $res = $stmt->get_result();
    if (!$res || $res->num_rows === 0) {
        echo json_encode(['status'=>'error','message'=>'Product not found']);
        exit;
    }
    $row = $res->fetch_assoc();
    $stmt->close();

    $thumb = $row['thumbnail'] ?? '';
    $gallery_json = $row['gallery_images'] ?? null;

    // delete DB row
    $del = $conn->prepare("DELETE FROM products WHERE product_id = ?");
    if (!$del) {
        dbg("Prepare failed (delete): " . $conn->error);
        echo json_encode(['status'=>'error','message'=>'Server prepare error (delete)']);
        exit;
    }
    $del->bind_param("i", $product_id);
    if (!$del->execute()) {
        dbg("Execute failed (delete): " . $del->error);
        echo json_encode(['status'=>'error','message'=>'Delete failed']);
        exit;
    }
    $del->close();

    // delete files
    $deletedFiles = [];

    if (!empty($thumb)) {
        $path = $uploadDir . $thumb;
        if (file_exists($path)) {
            if (@unlink($path)) {
                $deletedFiles[] = $thumb;
            } else {
                $deletedFiles[] = "FAILED_TO_DELETE: {$thumb}";
                dbg("Failed to unlink thumbnail: $path");
            }
        } else {
            dbg("Thumbnail file not found: $path");
        }
    }

    if (!empty($gallery_json)) {
        $imgs = json_decode($gallery_json, true);
        if (is_array($imgs)) {
            foreach ($imgs as $g) {
                if (empty($g)) continue;
                $gpath = $uploadDir . $g;
                if (file_exists($gpath)) {
                    if (@unlink($gpath)) {
                        $deletedFiles[] = $g;
                    } else {
                        $deletedFiles[] = "FAILED_TO_DELETE: {$g}";
                        dbg("Failed to unlink gallery: $gpath");
                    }
                } else {
                    dbg("Gallery file not found: $gpath");
                }
            }
        } else {
            dbg("gallery_images not json array for product {$product_id}");
        }
    }

    // final JSON success
    echo json_encode([
        'status' => 'success',
        'product_id' => $product_id,
        'files_deleted' => $deletedFiles
    ]);
    exit;

} catch (Throwable $t) {
    // catch everything and return JSON error (log full trace)
    dbg("Exception: " . $t->getMessage() . " in " . $t->getFile() . ":" . $t->getLine());
    echo json_encode(['status'=>'error','message'=>'Server exception occurred']);
    exit;
}
