<?php
session_start();
include "server_connection.php";

// যদি কার্ট একদম খালি হয় → Checkout এ আসতে দেবে না
if(!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0){
    echo "<h2 style='text-align:center; margin-top:50px;'>Your cart is empty!</h2>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Checkout</title>
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

  <!-- CHECKOUT WRAPPER -->
  <div class="max-w-5xl mx-auto p-6 mt-6 bg-white shadow rounded-lg">
    <h2 class="text-3xl font-bold mb-6 text-indigo-600">Checkout</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

      <!-- BILLING DETAILS -->
      <div>
        <h3 class="text-xl font-semibold mb-4">Billing Details</h3>

        <form action="place_order.php" method="POST">

        <div class="space-y-4">
          <input name="name" type="text" placeholder="Full Name" required class="w-full border px-3 py-2 rounded" />
          <input name="email" type="email" placeholder="Email Address" required class="w-full border px-3 py-2 rounded" />
          <input name="phone" type="text" placeholder="Phone Number" required class="w-full border px-3 py-2 rounded" />
          <input name="address" type="text" placeholder="Address" required class="w-full border px-3 py-2 rounded" />

          <div class="grid grid-cols-2 gap-4">
            <input name="city" type="text" placeholder="City" required class="border px-3 py-2 rounded" />
            <input name="zip" type="text" placeholder="Postal Code" required class="border px-3 py-2 rounded" />
          </div>

          <select name="country" required class="w-full border px-3 py-2 rounded">
            <option value="">Select Country</option>
            <option>Bangladesh</option>
            <option>India</option>
            <option>USA</option>
          </select>
        </div>

      </div>

      <!-- ORDER SUMMARY -->
      <div>
        <h3 class="text-xl font-semibold mb-4">Order Summary</h3>

        <div class="bg-gray-50 p-4 rounded-lg shadow">
          <?php
          $total = 0;

          foreach($_SESSION['cart'] as $item){
              $lineTotal = $item['price'] * $item['qty'];
              $total += $lineTotal;

              echo '
              <div class="flex justify-between mb-3">
                <span>'.$item['name'].' (x'.$item['qty'].')</span>
                <span>$'.$lineTotal.'</span>
              </div>
              ';
          }
          ?>

          <hr class="my-4" />

          <div class="flex justify-between text-lg font-bold">
            <span>Total:</span>
            <span>$<?php echo $total; ?></span>
          </div>

          <input type="hidden" name="total_amount" value="<?php echo $total; ?>">
        </div>

        <!-- PAYMENT METHODS -->
        <div class="mt-8">
          <h3 class="text-xl font-semibold mb-4">Payment Method</h3>

          <div class="space-y-3 bg-gray-50 p-4 rounded-lg shadow">
            <label class="flex items-center space-x-3">
              <input type="radio" name="payment_method" value="COD" checked class="w-5 h-5" />
              <span>💵 Cash on Delivery</span>
            </label>

            <label class="flex items-center space-x-3">
              <input type="radio" name="payment_method" value="Card" class="w-5 h-5" />
              <span>💳 Credit / Debit Card</span>
            </label>

            <label class="flex items-center space-x-3">
              <input type="radio" name="payment_method" value="Bkash" class="w-5 h-5" />
              <span>📱 bKash</span>
            </label>

            <label class="flex items-center space-x-3">
              <input type="radio" name="payment_method" value="Nagad" class="w-5 h-5" />
              <span>📱 Nagad</span>
            </label>
          </div>
        </div>

        <button type="submit" class="mt-6 w-full bg-indigo-600 text-white py-3 rounded text-lg hover:bg-indigo-700">
          Place Order
        </button>

        </form>
      </div>
    </div>
  </div>

  <!-- FOOTER -->
  <footer class="bg-gray-800 text-white mt-10 py-6 text-center">
    <p>© 2025 ShopPro — All Rights Reserved.</p>
  </footer>

</body>
</html>
