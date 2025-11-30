<?php
session_start();
include "server_connection.php";

// যদি কার্ট খালি হয় — order হবে না
if(!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0){
    echo "Cart is empty!";
    exit;
}

// Billing data
$name    = $_POST['name'];
$email   = $_POST['email'];
$phone   = $_POST['phone'];
$address = $_POST['address'];
$city    = $_POST['city'];
$zip     = $_POST['zip'];
$country = $_POST['country'];

$payment_method = $_POST['payment_method'];
$total_amount   = $_POST['total_amount'];


// STEP 1: Insert into orders
$stmt = $conn->prepare("
    INSERT INTO orders 
    (customer_name, email, phone, address, city, postal_code, country, payment_method, total_amount) 
    VALUES (?,?,?,?,?,?,?,?,?)
");

$stmt->bind_param("ssssssssd", 
    $name, $email, $phone, $address, $city, $zip, $country, $payment_method, $total_amount
);

$stmt->execute();

// নতুন order_id
$order_id = $stmt->insert_id;

$stmt->close();


// STEP 2: Insert all order items
foreach($_SESSION['cart'] as $item){

    $product_id = $item['id'];
    $product_name = $item['name'];
    $price = $item['price'];
    $qty = $item['qty'];
    $lineTotal = $price * $qty;

    $stmt2 = $conn->prepare("
        INSERT INTO order_items (order_id, product_id, product_name, price, qty, total)
        VALUES (?,?,?,?,?,?)
    ");

    $stmt2->bind_param("iisddi", 
        $order_id, $product_id, $product_name, $price, $qty, $lineTotal
    );

    $stmt2->execute();
    $stmt2->close();
}


// STEP 3: CART CLEAR
unset($_SESSION['cart']);


// STEP 4: Redirect to success page
header("Location: payment_successful.php?order_id=".$order_id);
exit;

?>
