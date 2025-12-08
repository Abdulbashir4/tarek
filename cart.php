<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Your Cart</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-gray-100">
  <?php include 'header.php'; ?>

  <div class="max-w-5xl mx-auto p-4 sm:p-6 mt-20 bg-white shadow rounded-lg">
    <h2 class="text-2xl sm:text-3xl font-bold mb-6 text-indigo-600">Your Cart</h2>

    <!-- MOBILE CARD VIEW -->
    <div class="block sm:hidden space-y-4" id="mobileCartBody">
      <?php
      if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
        echo '<p class="text-center text-gray-500">Your cart is empty 😔</p>';
      } else {
        foreach ($_SESSION['cart'] as $item) {
          $itemTotal = $item['qty'] * $item['price'];
          echo '
          <div class="border rounded-lg p-4 bg-white shadow" id="mrow' . $item['id'] . '">
            <div class="flex items-center space-x-3">
              <img src="uploads/products/' . $item['thumbnail'] . '" class="w-16 h-16 rounded object-cover shadow" />
              <div>
                <p class="font-bold text-lg">' . $item['name'] . '</p>
                <p class="text-gray-600">Price: $' . $item['price'] . '</p>
                <p class="text-gray-600">Qty: ' . $item['qty'] . '</p>
                <p class="font-semibold mt-1">Total: $' . $itemTotal . '</p>
              </div>
            </div>
            <button class="removeItem mt-3 text-red-600 font-semibold" data-id="' . $item['id'] . '">Remove</button>
          </div>';
        }
      }
      ?>
    </div>

    <!-- DESKTOP TABLE VIEW -->
    <div class="hidden sm:block overflow-x-auto">
      <table class="w-full text-left border rounded-lg overflow-hidden shadow">
        <thead class="bg-gray-200 text-gray-700">
          <tr>
            <th class="p-3">Product</th>
            <th class="p-3 text-center">Price</th>
            <th class="p-3 text-center">Qty</th>
            <th class="p-3 text-center">Total</th>
            <th class="p-3 text-center">Action</th>
          </tr>
        </thead>
        <tbody id="cartBody">
<?php
if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
    echo '<tr><td colspan="5" class="p-4 text-center text-gray-500">Your cart is empty 😔</td></tr>';
} else {
    $grandTotal = 0;
    foreach ($_SESSION['cart'] as $item) {
        $itemTotal = $item['qty'] * $item['price'];
        $grandTotal += $itemTotal;
        echo '
        <tr class="border-b hover:bg-gray-50" id="row'.$item['id'].'">
            <td class="p-3 flex items-center space-x-3">
                <img src="uploads/products/'.$item['thumbnail'].'" class="w-16 h-16 rounded object-cover shadow" />
                <span class="font-semibold">'.$item['name'].'</span>
            </td>
            <td class="p-3 text-center">$'.$item['price'].'</td>
            <td class="p-3 text-center">'.$item['qty'].'</td>
            <td class="p-3 text-center font-semibold">$'.$itemTotal.'</td>
            <td class="p-3 text-center">
                <button class="removeItem text-red-600 font-semibold" data-id="'.$item['id'].'">Remove</button>
            </td>
        </tr>';
    }
}
?>
</tbody>
      </table>
    </div>

    <!-- TOTAL SECTION (Shared) -->
    <div class="mt-8 bg-gray-50 p-6 rounded-lg shadow">
      <h3 class="text-xl sm:text-2xl font-bold mb-4">Cart Total</h3>
      <div class="flex justify-between text-lg font-semibold">
        <span>Subtotal:</span>
        <span id="cartSubtotal">$<?php echo isset($grandTotal) ? $grandTotal : 0; ?></span>
      </div>
      <button onclick="window.location.href='checkout.php'" class="mt-5 w-full bg-indigo-600 text-white py-3 rounded text-lg hover:bg-indigo-700">
        Proceed to Checkout
      </button>
    </div>
  </div>

  <!-- REMOVE SCRIPT -->
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      document.querySelectorAll(".removeItem").forEach(btn => {
        btn.addEventListener("click", function () {
          let id = this.dataset.id;

          fetch("remove_item.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `id=${id}`
          })
            .then(res => res.json())
            .then(data => {
              if (data.status === "success") {
                let row = document.getElementById("row" + id);
                if (row) row.remove();

                let mrow = document.getElementById("mrow" + id);
                if (mrow) mrow.remove();

                document.getElementById("cartSubtotal").innerText = "$" + data.subtotal;

                if (document.getElementById("cartCount")) {
                  document.getElementById("cartCount").innerText = data.cartCount;
                }

                if (data.cartCount == 0) {
                  document.getElementById("cartBody").innerHTML = '<tr><td colspan="5" class="p-4 text-center text-gray-500">Your cart is empty 😔</td></tr>';
                  document.getElementById("mobileCartBody").innerHTML = '<p class="text-center text-gray-500">Your cart is empty 😔</p>';
                }
              }
            });
        });
      });
    });
  </script>

  <footer class="bg-gray-800 text-white mt-10 py-6 text-center text-sm">
    <p>© 2025 ShopPro — All Rights Reserved.</p>
  </footer>
</body>
</html>
