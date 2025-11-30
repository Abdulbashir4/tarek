<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Your Cart</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-gray-100">

<!-- HEADER -->
<?php include 'header.php'; ?>

<!-- CART WRAPPER -->
<div class="max-w-5xl mx-auto p-6 mt-6 bg-white shadow rounded-lg">
  <h2 class="text-3xl font-bold mb-6 text-indigo-600">Your Cart</h2>

  <!-- CART TABLE -->
  <table class="w-full text-left border rounded-lg overflow-hidden shadow">
    <thead class="bg-gray-200 text-gray-700">
      <tr>
        <th class="p-3">Product</th>
        <th class="p-3 text-center">Price</th>
        <th class="p-3 text-center">Quantity</th>
        <th class="p-3 text-center">Total</th>
        <th class="p-3 text-center">Action</th>
      </tr>
    </thead>

    <tbody id="cartBody">

        <?php
        if(!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0){
            echo '
              <tr>
                <td colspan="5" class="p-4 text-center text-gray-500">
                  Your cart is empty 😔
                </td>
              </tr>
            ';
        } else {

            $grandTotal = 0;

            foreach($_SESSION['cart'] as $item){

                $itemTotal = $item["qty"] * $item["price"];
                $grandTotal += $itemTotal;

                echo '
                <tr class="border-b hover:bg-gray-50" id="row'.$item['id'].'">

                    <td class="p-3 flex items-center space-x-3">
                        <img src="uploads/products/'.$item['thumbnail'].'" 
                             class="w-16 h-16 rounded object-cover shadow" />
                        <span class="font-semibold">'.$item['name'].'</span>
                    </td>

                    <td class="p-3 text-center">$'.$item['price'].'</td>

                    <td class="p-3 text-center">'.$item['qty'].'</td>

                    <td class="p-3 text-center font-semibold">$'.$itemTotal.'</td>

                    <td class="p-3 text-center">
                        <button 
                            class="removeItem text-red-600 font-semibold"
                            data-id="'.$item['id'].'"
                        >
                            Remove
                        </button>
                    </td>

                </tr>
                ';
            }
        }
        ?>

    </tbody>
  </table>

  <!-- CART TOTAL -->
  <div class="mt-8 bg-gray-50 p-6 rounded-lg shadow">
    <h3 class="text-2xl font-bold mb-4">Cart Total</h3>

    <div class="flex justify-between text-lg font-semibold">
      <span>Subtotal:</span>
      <span id="cartSubtotal">$<?php echo isset($grandTotal) ? $grandTotal : 0; ?></span>
    </div>

    <button onclick="window.location.href='checkout.php'" 
            class="mt-6 w-full bg-indigo-600 text-white py-3 rounded text-lg hover:bg-indigo-700">
      Proceed to Checkout
    </button>
  </div>

</div>


<!-- AJAX SCRIPT -->
<script>
document.addEventListener("DOMContentLoaded", () => {

    document.querySelectorAll(".removeItem").forEach(btn => {

        btn.addEventListener("click", function(){

            let id = this.dataset.id;
            let row = document.getElementById("row" + id);

            fetch("remove_item.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `id=${id}`
            })
            .then(res => res.json())
            .then(data => {

                if(data.status === "success"){

                    // Remove Table Row
                    row.remove();

                    // Update subtotal
                    document.getElementById("cartSubtotal").innerText = "$" + data.subtotal;

                    // Update header cart counter
                    if(document.getElementById("cartCount")){
                        document.getElementById("cartCount").innerText = data.cartCount;
                    }

                    // If cart empty
                    if(data.cartCount == 0){
                        document.getElementById("cartBody").innerHTML =
                            '<tr><td colspan="5" class="p-4 text-center text-gray-500">Your cart is empty 😔</td></tr>';
                    }
                }
            });
        });
    });

});
</script>

<!-- FOOTER -->
<footer class="bg-gray-800 text-white mt-10 py-6 text-center">
  <p>© 2025 ShopPro — All Rights Reserved.</p>
</footer>

</body>
</html>
