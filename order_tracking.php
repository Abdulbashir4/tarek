<?php 
include "server_connection.php"; 
?>

<!DOCTYPE html>
<html lang="bn">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Order Tracking</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-gray-50 min-h-screen">

  <div class="max-w-7xl mx-auto px-4 py-8">

    <!-- Page header -->
    <header class="mb-6">
      <h1 class="text-2xl sm:text-3xl font-bold text-indigo-600 text-center">Track Your Order</h1>
      <p class="text-sm text-gray-600 text-center mt-2">অর্ডার আইডি দিয়ে অবস্থা দেখুন — দ্রুত এবং নিরাপদ।</p>
    </header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

      <!-- Left: Form -->
      <div class="lg:col-span-1">
        <form method="GET" class="bg-white rounded-xl shadow p-5">
          <label class="block font-semibold mb-2 text-gray-700">Enter Your Order ID</label>
          <div class="flex gap-3">
            <input 
              type="text" 
              name="order_id" 
              placeholder="Order ID Example: 5" 
              class="lg:flex-1 border rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" 
              required 
              value="<?php echo isset($_GET['order_id']) ? htmlspecialchars($_GET['order_id'], ENT_QUOTES, 'UTF-8') : ''; ?>"
            />
            <button class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-700">
              Track
            </button>
          </div>
        </form>

        <!-- Quick tips / contact -->
        <div class="mt-4 bg-white rounded-xl shadow p-4 text-sm text-gray-700">
          <p class="font-semibold mb-2">Tip</p>
          <p class="text-gray-600">আপনার অর্ডার আইডি খুঁজে না পান? অর্ডার কনফরমেশন ইমেইল চেক করুন বা <a href="contact.php" class="text-indigo-600 underline">Contact Support</a>.</p>
        </div>
      </div>

      <!-- Right: Tracking Result -->
      <div class="lg:col-span-2">
        <?php
        if(isset($_GET['order_id']) && $_GET['order_id'] !== ''){

            // sanitize order id (integer)
            $oid = (int) $_GET['order_id'];

            // prepared statement (if mysqli prepared available)
            $stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = ?");
            $stmt->bind_param("i", $oid);
            $stmt->execute();
            $result = $stmt->get_result();

            if(!$result || $result->num_rows == 0){
                echo "<div class='bg-red-50 border border-red-200 text-red-700 p-5 rounded-lg shadow'> 
                        <p class='font-semibold'>❌ No Order Found!</p>
                        <p class='text-sm mt-1'>অনুগ্রহ করে সঠিক Order ID প্রদান করুন।</p>
                      </div>";
            } else {

                $data = $result->fetch_assoc();
                $status = $data['order_status'] ?? 'Pending';
                $created = $data['created_at'] ?? date('Y-m-d H:i:s');
                $orderId = (int)$data['order_id'];
                $total = number_format((float)($data['total_amount'] ?? 0), 2);

                // Delivery Date = created_at + 3 days (you can change)
                $delivery_date = date('Y-m-d H:i:s', strtotime($created . ' +3 days'));

                // helper for active class
                function stepClass($currentStatus, $step){
                    $list = ["Pending","Processing","Shipped","Completed"];
                    $cur = array_search($currentStatus, $list);
                    $idx = array_search($step, $list);
                    if ($cur === false) $cur = 0;
                    if ($idx === false) $idx = 0;
                    return ($cur >= $idx) ? "bg-indigo-600" : "bg-gray-300";
                }
        ?>

        <!-- Result Card -->
        <div class="bg-white rounded-2xl shadow p-6">

          <!-- Summary row -->
          <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
              <p class="text-sm text-gray-500">Order ID</p>
              <p class="font-semibold text-gray-800">#<?php echo $orderId; ?></p>
            </div>

            <div>
              <p class="text-sm text-gray-500">Placed on</p>
              <p class="font-medium text-gray-800"><?php echo htmlspecialchars(date('F j, Y, g:i A', strtotime($created)), ENT_QUOTES, 'UTF-8'); ?></p>
            </div>

            <div>
              <p class="text-sm text-gray-500">Total</p>
              <p class="font-medium text-gray-800">$<?php echo $total; ?></p>
            </div>

            <div>
              <p class="text-sm text-gray-500">Status</p>
              <p class="font-medium text-indigo-600"><?php echo htmlspecialchars($status, ENT_QUOTES, 'UTF-8'); ?></p>
            </div>
          </div>

          <!-- Countdown (if applicable) -->
          <?php if(in_array($status, ['Processing','Shipped'])): ?>
            <div class="mt-6 bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
              <h3 class="text-sm font-semibold text-yellow-700">Estimated Delivery Countdown</h3>
              <p class="text-sm text-gray-700 mt-1">Your package will be delivered in:</p>
              <p id="countdown" class="text-2xl font-bold text-yellow-600 mt-2">--</p>
            </div>

            <script>
              // pass ISO string for consistent parsing
              const deliveryDate = new Date("<?php echo date('c', strtotime($delivery_date)); ?>").getTime();

              function updateCountdown() {
                const now = new Date().getTime();
                const distance = deliveryDate - now;

                if (distance <= 0) {
                  document.getElementById('countdown').innerText = "Delivered";
                  clearInterval(window.countdownTimer);
                  return;
                }

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                document.getElementById('countdown').innerText = 
                  (days ? days + "d " : "") + hours + "h " + minutes + "m " + seconds + "s";
              }

              updateCountdown();
              window.countdownTimer = setInterval(updateCountdown, 1000);
            </script>
          <?php endif; ?>

          <!-- Steps timeline -->
          <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="col-span-1">
              <div class="space-y-6 relative pl-6 before:content-[''] before:absolute before:left-3 before:top-6 before:bottom-6 before:w-0.5 before:bg-gray-200">
                <!-- Step: Pending -->
                <div class="flex items-start gap-4">
                  <div class="w-8 h-8 rounded-full <?php echo stepClass($status,'Pending'); ?> flex items-center justify-center text-white">
                    <span class="text-sm font-semibold">1</span>
                  </div>
                  <div>
                    <h4 class="font-semibold">Order Placed</h4>
                    <p class="text-sm text-gray-600">Your order was placed successfully.</p>
                    <p class="text-xs text-gray-400 mt-1">Date: <?php echo htmlspecialchars($created, ENT_QUOTES, 'UTF-8'); ?></p>
                  </div>
                </div>

                <!-- Step: Processing -->
                <div class="flex items-start gap-4">
                  <div class="w-8 h-8 rounded-full <?php echo stepClass($status,'Processing'); ?> flex items-center justify-center text-white">
                    <span class="text-sm font-semibold">2</span>
                  </div>
                  <div>
                    <h4 class="font-semibold">Processing</h4>
                    <p class="text-sm text-gray-600">We are preparing your order for shipment.</p>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-span-1">
              <div class="space-y-6 relative pl-6 before:content-[''] before:absolute before:left-3 before:top-6 before:bottom-6 before:w-0.5 before:bg-gray-200">
                <!-- Step: Shipped -->
                <div class="flex items-start gap-4">
                  <div class="w-8 h-8 rounded-full <?php echo stepClass($status,'Shipped'); ?> flex items-center justify-center text-white">
                    <span class="text-sm font-semibold">3</span>
                  </div>
                  <div>
                    <h4 class="font-semibold">Shipped</h4>
                    <p class="text-sm text-gray-600">Your package is on the way.</p>
                  </div>
                </div>

                <!-- Step: Completed -->
                <div class="flex items-start gap-4">
                  <div class="w-8 h-8 rounded-full <?php echo stepClass($status,'Completed'); ?> flex items-center justify-center text-white">
                    <span class="text-sm font-semibold">4</span>
                  </div>
                  <div>
                    <h4 class="font-semibold">Delivered</h4>
                    <p class="text-sm text-gray-600">Package delivered successfully.</p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Optional order items preview -->
          <?php
          // Uncomment to show items if you have order_items table
          /*
          $itemsStmt = $conn->prepare("SELECT product_name, quantity, line_total FROM order_items WHERE order_id = ?");
          $itemsStmt->bind_param("i", $orderId);
          $itemsStmt->execute();
          $itemsRes = $itemsStmt->get_result();
          if($itemsRes && $itemsRes->num_rows){
              echo '<div class="mt-6 border-t pt-4">';
              while($it = $itemsRes->fetch_assoc()){
                  echo '<div class="flex justify-between text-sm text-gray-700"><div>'.$it['product_name'].' × '.$it['quantity'].'</div><div>$'.number_format($it['line_total'],2).'</div></div>';
              }
              echo '</div>';
          }
          */
          ?>

        </div> <!-- end result card -->

        <?php 
            } // end else found
            $stmt->close();
        } // end if isset
        ?>
      </div>

    </div> <!-- grid -->

    <!-- Footer buttons -->
    <div class="mt-8 flex flex-col sm:flex-row gap-3 justify-center">
      <a href="shop.php" class="inline-block bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 text-center">Continue Shopping</a>
      <a href="index.php" class="inline-block border border-indigo-600 text-indigo-600 px-6 py-2 rounded-lg hover:bg-indigo-50 text-center">Go Home</a>
    </div>

  </div> <!-- container -->

</body>
</html>
