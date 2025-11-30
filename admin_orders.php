<?php
include "server_connection.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>All Orders - Admin</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100">

<div class="max-w-6xl mx-auto mt-8 bg-white shadow rounded-lg p-6">
  <h2 class="text-3xl font-bold mb-6 text-indigo-600">All Orders</h2>

  <table class="w-full text-left border rounded-lg overflow-hidden shadow">
    <thead class="bg-gray-200 text-gray-700">
      <tr>
        <th class="p-3">Order ID</th>
        <th class="p-3">Customer</th>
        <th class="p-3">Total</th>
        <th class="p-3">Order Status</th>
        <th class="p-3">Payment</th>
        <th class="p-3">Date</th>
        <th class="p-3 text-center">Action</th>
      </tr>
    </thead>
    <tbody>
    <?php
    $res = $conn->query("SELECT * FROM orders ORDER BY created_at DESC");
    if($res->num_rows == 0){
        echo '
        <tr>
          <td colspan="7" class="p-4 text-center text-gray-500">No orders found.</td>
        </tr>
        ';
    } else {
        while($row = $res->fetch_assoc()){
            echo '
            <tr class="border-b hover:bg-gray-50">
              <td class="p-3">#'.$row['order_id'].'</td>
              <td class="p-3">'.$row['customer_name'].'</td>
              <td class="p-3">$'.$row['total_amount'].'</td>
              <td class="p-3">'.$row['order_status'].'</td>
              <td class="p-3">'.$row['payment_status'].'</td>
              <td class="p-3">'.$row['created_at'].'</td>
              <td class="p-3 text-center">
                <a href="order_view.php?order_id='.$row['order_id'].'" 
                   class="text-indigo-600 font-semibold">View</a>
              </td>
            </tr>
            ';
        }
    }
    ?>
    </tbody>
  </table>
</div>

</body>
</html>
