<?php
include "server_connection.php";

// যদি order_id না আসে → invalid access
if (!isset($_GET['order_id'])) {
    echo "Invalid request!";
    exit;
}

$order_id = (int) $_GET['order_id'];

// order details load
$order = $conn->query("SELECT * FROM orders WHERE order_id = $order_id");

if ($order->num_rows == 0) {
    echo "Order not found!";
    exit;
}

$od = $order->fetch_assoc();
$customerName = htmlspecialchars($od['customer_name'] ?? 'Customer', ENT_QUOTES, 'UTF-8');
$orderId = (int) $od['order_id'];
$totalAmount = number_format((float) ($od['total_amount'] ?? 0), 2);
$paymentMethod = htmlspecialchars($od['payment_method'] ?? 'N/A', ENT_QUOTES, 'UTF-8');
$orderDate = !empty($od['created_at']) ? date('F j, Y, g:i A', strtotime($od['created_at'])) : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Order Successful — #<?php echo $orderId; ?></title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-50 text-gray-800 min-h-screen flex flex-col">

  <!-- HEADER -->
  <?php include 'header.php'; ?>

  <!-- MAIN -->
  <main class="flex-1 flex justify-center py-12 px-4 sm:px-6 lg:px-8 mt-20">
    <div class="w-full max-w-4xl md:mt-20">

      <!-- CARD -->
      <div class="bg-white shadow-md rounded-2xl overflow-hidden">
        <div class="p-6 md:p-10 grid grid-cols-1 md:grid-cols-3 gap-6 items-center">

          <!-- Left: Icon + Success -->
          <div class="flex items-center md:items-start gap-4 md:col-span-1">
            <div class="flex-shrink-0">
              <!-- nice SVG check -->
              <div class="h-20 w-20 rounded-full bg-green-50 flex items-center justify-center">
                <svg class="h-10 w-10 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 13l4 4L19 7" />
                </svg>
              </div>
            </div>

            <div>
              <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Payment Successful!</h1>
              <p class="mt-1 text-sm text-gray-600">
                Thank you <span class="font-semibold text-gray-800"><?php echo $customerName; ?></span>.
              </p>
              <?php if ($orderDate): ?>
                <p class="mt-1 text-xs text-gray-500">Placed on <?php echo htmlspecialchars($orderDate, ENT_QUOTES, 'UTF-8'); ?></p>
              <?php endif; ?>
            </div>
          </div>

          <!-- Middle: Order summary (spans 2 cols on md) -->
          <div class="md:col-span-2">
            <div class="bg-gray-50 rounded-lg p-4 md:p-6">
              <h2 class="text-lg font-semibold text-indigo-600 mb-4">Order Summary</h2>

              <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm text-gray-700">
                <div class="space-y-2">
                  <p><span class="font-medium">Order ID:</span> <span class="text-gray-800">#<?php echo $orderId; ?></span></p>
                  <p><span class="font-medium">Payment Method:</span> <span class="text-gray-800"><?php echo $paymentMethod; ?></span></p>
                </div>

                <div class="space-y-2">
                  <p><span class="font-medium">Total Amount:</span> <span class="text-gray-800">$<?php echo $totalAmount; ?></span></p>
                  <?php if (!empty($od['shipping_address'])): ?>
                    <p class="truncate"><span class="font-medium">Shipping:</span> <span class="text-gray-800"><?php echo htmlspecialchars($od['shipping_address'], ENT_QUOTES, 'UTF-8'); ?></span></p>
                  <?php endif; ?>
                </div>
              </div>

              <!-- Optional: ordered items preview (if you have order_items table) -->
              <?php
              // যদি order_items টেবিল থেকে আইটেমগুলো দেখাতে চাও, নিচের কোড আনকমেন্ট করে ব্যবহার করতে পারো
              /*
              $itemsRes = $conn->query(\"SELECT * FROM order_items WHERE order_id = $orderId\");
              if($itemsRes && $itemsRes->num_rows){
                  echo '<div class=\"mt-4 border-t pt-4 text-sm text-gray-700\">';
                  while($it = $itemsRes->fetch_assoc()){
                      $iname = htmlspecialchars($it['product_name'], ENT_QUOTES, 'UTF-8');
                      $iqty = (int)$it['quantity'];
                      $iline = number_format((float)$it['line_total'], 2);
                      echo \"<div class='flex justify-between'><div>$iname × $iqty</div><div>\$$iline</div></div>\";
                  }
                  echo '</div>';
              }
              */
              ?>
            </div>

            <!-- ACTIONS -->
            <div class="mt-4 flex flex-col sm:flex-row sm:items-center sm:justify-end gap-3">
              <a href="invoice.php?order_id=<?php echo $orderId; ?>" class="inline-flex items-center justify-center px-5 py-2 rounded-md bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700 transition">
                Download Invoice
              </a>

              <a href="order_tracking.php?order_id=<?php echo $orderId; ?>" class="inline-flex items-center justify-center px-5 py-2 rounded-md border border-gray-200 text-sm font-medium hover:bg-gray-50 transition">
                Track Order
              </a>

              <a href="shop.php" class="inline-flex items-center justify-center px-5 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                Continue Shopping
              </a>
            </div>

          </div>
        </div>
      </div>

      <!-- HELPFUL NOTE -->
      <div class="mt-6 text-center text-sm text-gray-600">
        <p>If you have any questions, please <a href="contact.php" class="text-indigo-600 underline">contact our support</a>. Keep your order ID for reference.</p>
      </div>
    </div>
  </main>

  <!-- FOOTER -->
  <footer class="bg-gray-900 text-gray-300 py-6">
    <div class="max-w-7xl mx-auto px-4 text-center">
      <p>© 2025 ShopPro — All Rights Reserved.</p>
    </div>
  </footer>

</body>
</html>
