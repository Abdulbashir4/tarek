<?php
include "server_connection.php";

// যদি order_id না আসে → invalid access
if(!isset($_GET['order_id'])){
    echo "Invalid request!";
    exit;
}

$order_id = (int)$_GET['order_id'];

// order details load
$order = $conn->query("SELECT * FROM orders WHERE order_id = $order_id");

if($order->num_rows == 0){
    echo "Order not found!";
    exit;
}

$od = $order->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Order Successful</title>
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-gray-100">

<!-- HEADER -->
<header class="bg-white shadow p-4 flex justify-between items-center sticky top-0 z-50">
    <h1 class="text-2xl font-bold text-indigo-600">ShopPro</h1>
    <nav class="hidden md:block">
      <ul class="flex space-x-6 text-gray-700 font-medium">
        <li><a href="index.php" class="hover:text-indigo-600">Home</a></li>
        <li><a href="shop.php" class="hover:text-indigo-600">Shop</a></li>
        <li><a href="cart.php" class="hover:text-indigo-600">Cart</a></li>
      </ul>
    </nav>
</header>


<!-- SUCCESS BLOCK -->
<div class="max-w-3xl mx-auto p-8 mt-12 bg-white shadow-lg rounded-lg text-center">

    <div class="text-green-600 text-6xl mb-4">✔</div>

    <h2 class="text-3xl font-bold mb-2">Payment Successful!</h2>

    <p class="text-gray-700 text-lg mb-6">
        Thank you <strong><?php echo $od['customer_name']; ?></strong>,  
        your order has been placed successfully.
    </p>

    <!-- Order Summary -->
    <div class="bg-gray-50 p-6 rounded-lg shadow text-left mb-6">
        <h3 class="text-xl font-bold mb-4 text-indigo-600">Order Details</h3>

        <p class="text-gray-700 text-lg mb-2">
            <strong>Order ID:</strong> #<?php echo $od['order_id']; ?>
        </p>

        <p class="text-gray-700 text-lg mb-2">
            <strong>Total Amount:</strong> $<?php echo $od['total_amount']; ?>
        </p>

        <p class="text-gray-700 text-lg">
            <strong>Payment Method:</strong> <?php echo $od['payment_method']; ?>
        </p>
    </div>

    <a href="invoice.php?order_id=<?php echo $order_id; ?>" class="bg-indigo-600 text-white px-6 py-3 rounded text-lg hover:bg-indigo-700">
        Receive invoice
    </a>
</div>

<!-- FOOTER -->
<footer class="bg-gray-800 text-white mt-30 py-6 text-center">
  <p>© 2025 ShopPro — All Rights Reserved.</p>
</footer>


</body>
</html>
