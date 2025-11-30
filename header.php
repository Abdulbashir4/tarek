<?php 
session_start();
include "server_connection.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body>
    <header class="bg-white shadow fixed top-0 w-full z-50">
        <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
      <a href="#" class="text-2xl font-bold text-indigo-600">ShopPro</a>
      <div class="hidden md:flex w-1/2">
        <input type="text" placeholder="Search for products..." class="w-full border rounded-l-full py-2 px-4 outline-none focus:ring-2 focus:ring-indigo-500" />
        <button class="bg-indigo-600 text-white px-4 rounded-r-full">Search</button>
      </div>
      <div class="flex items-center space-x-6 text-gray-700 text-xl">
        <button>❤️</button>
        <a href="cart.php" class="relative">🛒

    <!-- CART COUNT BADGE -->
    <span class="absolute -top-2 -right-2 bg-red-600 text-white text-xs font-bold w-5 h-5 flex items-center justify-center rounded-full">
        <?php echo isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'qty')) : 0; ?>
    </span>
</a>
        <button>👤</button>
      </div>
    </div>
    </header>
    
</body>
</html>