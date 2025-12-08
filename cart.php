<?php
session_start();

// কার্ট ডেটা প্রস্তুত
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$hasCartItems = !empty($cart);

// grand total আগে থেকেই বের করে রাখি
$grandTotal = 0;
if ($hasCartItems) {
    foreach ($cart as $item) {
        $grandTotal += $item['qty'] * $item['price'];
    }
}
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
      if (!$hasCartItems) {
        echo '<p class="text-center text-gray-500">Your cart is empty 😔</p>';
      } else {
        foreach ($cart as $item) {
          $itemTotal = $item['qty'] * $item['price'];
          echo '
          <div class="border rounded-lg p-4 bg-white shadow" id="mrow' . $item['id'] . '">
            <div class="flex items-center space-x-3">
              <img src="uploads/products/' . $item['thumbnail'] . '" class="w-16 h-16 rounded object-cover shadow" />
              <div>
                <p class="font-bold text-lg">' . $item['name'] . '</p>
                <p class="text-gray-600">Price: $' . $item['price'] . '</p>

                <div class="mt-2">
                  <p class="text-gray-600 mb-1">Qty:</p>
                  <div class="flex items-center space-x-2">
                    <button 
                      class="qtyBtn px-2 py-1 bg-gray-200 rounded" 
                      data-id="' . $item['id'] . '" 
                      data-action="dec"
                    >-</button>

                    <span 
                      id="mqty' . $item['id'] . '" 
                      class="px-3"
                    >' . $item['qty'] . '</span>

                    <button 
                      class="qtyBtn px-2 py-1 bg-gray-200 rounded" 
                      data-id="' . $item['id'] . '" 
                      data-action="inc"
                    >+</button>
                  </div>
                </div>

                <p class="font-semibold mt-2">
                  Total: $<span id="mtotal' . $item['id'] . '">' . $itemTotal . '</span>
                </p>
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
        if (!$hasCartItems) {
            echo '<tr><td colspan="5" class="p-4 text-center text-gray-500">Your cart is empty 😔</td></tr>';
        } else {
            foreach ($cart as $item) {
                $itemTotal = $item['qty'] * $item['price'];
                echo '
                <tr class="border-b hover:bg-gray-50" id="row'.$item['id'].'">
                    <td class="p-3 flex items-center space-x-3">
                        <img src="uploads/products/'.$item['thumbnail'].'" class="w-16 h-16 rounded object-cover shadow" />
                        <span class="font-semibold">'.$item['name'].'</span>
                    </td>
                    <td class="p-3 text-center">$'.$item['price'].'</td>
                    <td class="p-3 text-center">
                      <div class="inline-flex items-center space-x-2">
                        <button 
                          class="qtyBtn px-2 py-1 bg-gray-200 rounded" 
                          data-id="'.$item['id'].'" 
                          data-action="dec"
                        >-</button>

                        <span id="qty'.$item['id'].'">'.$item['qty'].'</span>

                        <button 
                          class="qtyBtn px-2 py-1 bg-gray-200 rounded" 
                          data-id="'.$item['id'].'" 
                          data-action="inc"
                        >+</button>
                      </div>
                    </td>
                    <td class="p-3 text-center font-semibold">
                      $<span id="total'.$item['id'].'">'.$itemTotal.'</span>
                    </td>
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
        <span id="cartSubtotal">$<?php echo $grandTotal; ?></span>
      </div>
      <button onclick="window.location.href='checkout.php'" class="mt-5 w-full bg-indigo-600 text-white py-3 rounded text-lg hover:bg-indigo-700">
        Proceed to Checkout
      </button>
    </div>
  </div>

  <!-- SCRIPT -->
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      // ======= REMOVE ITEM =======
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
                // Desktop row remove
                let row = document.getElementById("row" + id);
                if (row) row.remove();

                // Mobile row remove
                let mrow = document.getElementById("mrow" + id);
                if (mrow) mrow.remove();

                // Subtotal update
                document.getElementById("cartSubtotal").innerText = "$" + data.subtotal;

                // Header cart count update
                const headerCount = document.getElementById("cartCount");
                if (headerCount) {
                  headerCount.innerText = data.cartCount;
                }

                // Footer cart count update (bottom_navigation_bar.php এ id="footerCartCount" রাখো)
                const footerCount = document.getElementById("footerCartCount");
                if (footerCount) {
                  footerCount.innerText = data.cartCount;
                }

                // Empty cart হলে মেসেজ
                if (data.cartCount == 0) {
                  document.getElementById("cartBody").innerHTML =
                    '<tr><td colspan="5" class="p-4 text-center text-gray-500">Your cart is empty 😔</td></tr>';
                  document.getElementById("mobileCartBody").innerHTML =
                    '<p class="text-center text-gray-500">Your cart is empty 😔</p>';
                }
              }
            });
        });
      });

      // ======= QTY (+ / -) UPDATE =======
      document.querySelectorAll(".qtyBtn").forEach(btn => {
        btn.addEventListener("click", function () {
          let id = this.dataset.id;
          let action = this.dataset.action; // 'inc' বা 'dec'

          fetch("update_qty.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `id=${id}&action=${action}`
          })
            .then(res => res.json())
            .then(data => {
              if (data.status === "success") {

                // Desktop qty + item total আপডেট
                const qtyEl = document.getElementById("qty" + id);
                if (qtyEl) qtyEl.innerText = data.qty;

                const totalEl = document.getElementById("total" + id);
                if (totalEl) totalEl.innerText = data.itemTotal;

                // Mobile qty + item total আপডেট
                const mqtyEl = document.getElementById("mqty" + id);
                if (mqtyEl) mqtyEl.innerText = data.qty;

                const mtotalEl = document.getElementById("mtotal" + id);
                if (mtotalEl) mtotalEl.innerText = data.itemTotal;

                // Subtotal আপডেট
                document.getElementById("cartSubtotal").innerText = "$" + data.subtotal;

                // Header cart count
                const headerCount = document.getElementById("cartCount");
                if (headerCount) headerCount.innerText = data.cartCount;

                // Footer cart count (যদি থাকে)
                const footerCount = document.getElementById("footerCartCount");
                if (footerCount) footerCount.innerText = data.cartCount;
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
