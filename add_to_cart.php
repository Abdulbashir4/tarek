<?php
session_start();
include 'server_connection.php';

$id = $_POST['id'];
$qty = isset($_POST['qty']) ? (int)$_POST['qty'] : 1;

// DB থেকে product নাও
$q = $conn->query("SELECT * FROM products WHERE product_id = $id");
$p = $q->fetch_assoc();

$name = $p['product_name'];
$price = $p['price'];
$thumbnail = $p['thumbnail'];

if(!isset($_SESSION['cart'])){
    $_SESSION['cart'] = [];
}

if(isset($_SESSION['cart'][$id])){
    $_SESSION['cart'][$id]['qty'] += $qty;
} else {
    $_SESSION['cart'][$id] = [
        "id" => $id,
        "name" => $name,
        "price" => $price,
        "thumbnail" => $thumbnail,
        "qty" => $qty
    ];
}

$cartCount = array_sum(array_column($_SESSION['cart'], 'qty'));

echo json_encode([
    "status" => "success",
    "cartCount" => $cartCount
]);

exit;
?>
