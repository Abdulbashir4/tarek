<?php
session_start();
header('Content-Type: application/json');

if (!isset($_POST['id'], $_POST['action'])) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
    exit;
}

$id = $_POST['id'];
$action = $_POST['action'];

if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
    echo json_encode(['status' => 'error', 'message' => 'Cart empty']);
    exit;
}

$foundKey = null;

// ধরে নিচ্ছি $_SESSION['cart'] এ প্রতিটা item এর ভিতরে 'id' আছে
foreach ($_SESSION['cart'] as $key => $item) {
    if ($item['id'] == $id) {
        $foundKey = $key;
        break;
    }
}

if ($foundKey === null) {
    echo json_encode(['status' => 'error', 'message' => 'Item not found']);
    exit;
}

// quantity increment/decrement
if ($action === 'inc') {
    $_SESSION['cart'][$foundKey]['qty']++;
} elseif ($action === 'dec') {
    // minimum 1 রাখলাম
    if ($_SESSION['cart'][$foundKey]['qty'] > 1) {
        $_SESSION['cart'][$foundKey]['qty']--;
    }
}

$qty = $_SESSION['cart'][$foundKey]['qty'];

// হিসাব কষা
$subtotal = 0;
$cartCount = 0;
$itemTotal = 0;

foreach ($_SESSION['cart'] as $item) {
    $lineTotal = $item['qty'] * $item['price'];
    $subtotal += $lineTotal;
    $cartCount += $item['qty'];

    if ($item['id'] == $id) {
        $itemTotal = $lineTotal;
    }
}

echo json_encode([
    'status'     => 'success',
    'qty'        => $qty,
    'itemTotal'  => $itemTotal,
    'subtotal'   => $subtotal,
    'cartCount'  => $cartCount,
]);
