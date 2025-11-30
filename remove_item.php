<?php
session_start();
header("Content-Type: application/json");

$id = $_POST['id'];

$response = [
    "status" => "error",
    "message" => "Item not found",
    "cartCount" => 0,
    "subtotal" => 0
];

if(isset($_SESSION['cart'][$id])){
    unset($_SESSION['cart'][$id]);

    // আপডেটেড কার্ট কাউন্টার
    $count = 0;
    $subtotal = 0;

    foreach($_SESSION['cart'] as $item){
        $count += $item['qty'];
        $subtotal += ($item['qty'] * $item['price']);
    }

    // রেসপন্স আপডেট
    $response = [
        "status" => "success",
        "message" => "Item removed",
        "cartCount" => $count,
        "subtotal" => $subtotal
    ];
}

echo json_encode($response);
exit;
?>
