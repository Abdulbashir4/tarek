<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Shopping Cart</title>
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

  <!-- CART WRAPPER -->
  <div class="max-w-5xl mx-auto p-6 mt-6 bg-white shadow rounded-lg">
    <h2 class="text-3xl font-bold mb-6 text-indigo-600">Your Cart</h2>

    <!-- CART ITEM -->
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
  <tbody>
    <tr class="border-b hover:bg-gray-50">
      <td class="p-3 flex items-center space-x-3">
        <img src="https://picsum.photos/120" class="w-16 h-16 rounded object-cover shadow" />
        <span class="font-semibold">Premium Wireless Headphones</span>
      </td>
      <td class="p-3 text-center">$299</td>
      <td class="p-3 text-center"><input type="number" value="1" min="1" class="border rounded px-3 py-1 w-20 text-center" /></td>
      <td class="p-3 text-center font-semibold">$299</td>
      <td class="p-3 text-center"><button class="text-red-600 font-semibold">Remove</button></td>
    </tr>

    <tr class="border-b hover:bg-gray-50">
      <td class="p-3 flex items-center space-x-3">
        <img src="https://picsum.photos/121" class="w-16 h-16 rounded object-cover shadow" />
        <span class="font-semibold">Bluetooth Speaker</span>
      </td>
      <td class="p-3 text-center">$149</td>
      <td class="p-3 text-center"><input type="number" value="1" min="1" class="border rounded px-3 py-1 w-20 text-center" /></td>
      <td class="p-3 text-center font-semibold">$149</td>
      <td class="p-3 text-center"><button class="text-red-600 font-semibold">Remove</button></td>
    </tr>
  </tbody>
</table>

<!-- CART TOTAL -->
    <div class="mt-8 bg-gray-50 p-6 rounded-lg shadow">
      <h3 class="text-2xl font-bold mb-4">Cart Total</h3>
      <div class="flex justify-between text-lg font-semibold">
        <span>Subtotal:</span>
        <span>$448</span>
      </div>

      <button onclick="window.location.href='checkout.php'" class="mt-6 w-full bg-indigo-600 text-white py-3 rounded text-lg hover:bg-indigo-700">Proceed to Checkout</button>
    </div>

  </div>

  <!-- FOOTER -->
  <footer class="bg-gray-800 text-white mt-10 py-6 text-center">
    <p>© 2025 ShopPro — All Rights Reserved.</p>
  </footer>

</body>
</html>
