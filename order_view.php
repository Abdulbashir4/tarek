<?php
include "server_connection.php";

if(!isset($_GET['order_id'])){
    echo "Invalid order!";
    exit;
}

$order_id = (int)$_GET['order_id'];

// ❗ POST এলে status update করব
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $order_status   = $_POST['order_status'];
    $payment_status = $_POST['payment_status'];

    $stmt = $conn->prepare("UPDATE orders SET order_status = ?, payment_status = ? WHERE order_id = ?");
    $stmt->bind_param("ssi", $order_status, $payment_status, $order_id);
    $stmt->execute();
    $stmt->close();

    $msg = "Order updated successfully!";
}

// Order info
$orderRes = $conn->query("SELECT * FROM orders WHERE order_id = $order_id");
if($orderRes->num_rows == 0){
    echo "Order not found!";
    exit;
}
$od = $orderRes->fetch_assoc();

// Order items
$itemsRes = $conn->query("SELECT * FROM order_items WHERE order_id = $order_id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>View Order #<?php echo $od['order_id']; ?></title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100">

<header class="bg-white shadow p-4 flex justify-between items-center sticky top-0 z-50">
  <h1 class="text-2xl font-bold text-indigo-600">ShopPro Admin</h1>
  <nav class="hidden md:block">
    <ul class="flex space-x-6 text-gray-700 font-medium">
      <li><a href="admin_orders.php" class="hover:text-indigo-600">← Back to Orders</a></li>
    </ul>
  </nav>
</header>

<div class="max-w-5xl mx-auto mt-8 bg-white shadow rounded-lg p-6">
  <h2 class="text-3xl font-bold mb-4 text-indigo-600">Order #<?php echo $od['order_id']; ?></h2>

  <?php if(isset($msg)){ ?>
    <div class="mb-4 bg-green-100 text-green-700 px-4 py-2 rounded">
      <?php echo $msg; ?>
    </div>
  <?php } ?>

  <!-- Customer & Order Info -->
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    
    <div>
      <h3 class="text-xl font-semibold mb-3">Customer Info</h3>
      <p><strong>Name:</strong> <?php echo $od['customer_name']; ?></p>
      <p><strong>Email:</strong> <?php echo $od['email']; ?></p>
      <p><strong>Phone:</strong> <?php echo $od['phone']; ?></p>
      <p><strong>Address:</strong> <?php echo $od['address']; ?></p>
      <p><strong>City:</strong> <?php echo $od['city']; ?></p>
      <p><strong>Postal Code:</strong> <?php echo $od['postal_code']; ?></p>
      <p><strong>Country:</strong> <?php echo $od['country']; ?></p>
    </div>

    <div>
      <h3 class="text-xl font-semibold mb-3">Order Info</h3>
      <p><strong>Total Amount:</strong> $<?php echo $od['total_amount']; ?></p>
      <p><strong>Payment Method:</strong> <?php echo $od['payment_method']; ?></p>
      <p><strong>Order Status:</strong> <?php echo $od['order_status']; ?></p>
      <p><strong>Payment Status:</strong> <?php echo $od['payment_status']; ?></p>
      <p><strong>Date:</strong> <?php echo $od['created_at']; ?></p>
    </div>

  </div>

  <!-- Items Table -->
  <h3 class="text-xl font-semibold mb-3">Order Items</h3>

  <table class="w-full text-left border rounded-lg overflow-hidden shadow mb-8">
    <thead class="bg-gray-200 text-gray-700">
      <tr>
        <th class="p-3">Product</th>
        <th class="p-3 text-center">Price</th>
        <th class="p-3 text-center">Qty</th>
        <th class="p-3 text-center">Total</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $items_total = 0;
      while($it = $itemsRes->fetch_assoc()){
          $items_total += $it['total'];
          echo '
          <tr class="border-b hover:bg-gray-50">
            <td class="p-3">'.$it['product_name'].'</td>
            <td class="p-3 text-center">$'.$it['price'].'</td>
            <td class="p-3 text-center">'.$it['qty'].'</td>
            <td class="p-3 text-center">$'.$it['total'].'</td>
          </tr>
          ';
      }
      ?>
      <tr>
        <td colspan="3" class="p-3 text-right font-bold">Items Total:</td>
        <td class="p-3 text-center font-bold">$<?php echo $items_total; ?></td>
      </tr>
    </tbody>
  </table>

  <!-- Status Update Form -->
  <h3 class="text-xl font-semibold mb-3">Update Status</h3>

  <form method="POST" class="bg-gray-50 p-4 rounded-lg shadow max-w-md">
    <div class="mb-4">
      <label class="block font-semibold mb-1">Order Status</label>
      <select name="order_status" class="w-full border px-3 py-2 rounded">
        <?php
        $statuses = ['Pending','Processing','Shipped','Completed','Cancelled'];
        foreach($statuses as $st){
            $sel = ($od['order_status'] == $st) ? 'selected' : '';
            echo '<option '.$sel.'>'.$st.'</option>';
        }
        ?>
      </select>
    </div>

    <div class="mb-4">
      <label class="block font-semibold mb-1">Payment Status</label>
      <select name="payment_status" class="w-full border px-3 py-2 rounded">
        <?php
        $pstats = ['Unpaid','Paid','Refunded'];
        foreach($pstats as $pst){
            $sel = ($od['payment_status'] == $pst) ? 'selected' : '';
            echo '<option '.$sel.'>'.$pst.'</option>';
        }
        ?>
      </select>
    </div>

    <button type="submit" 
            class="bg-indigo-600 text-white px-5 py-2 rounded hover:bg-indigo-700">
      Save Changes
    </button>
  </form>

</div>

<footer class="bg-gray-800 text-white mt-10 py-6 text-center">
  <p>© 2025 ShopPro — Admin Panel.</p>
</footer>

</body>
</html>
