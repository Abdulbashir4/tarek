<?php
include "server_connection.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Shop - All Products</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100">

  <!-- HEADER -->
  <header >
      <?php include 'header.php'; ?>
  </header>

  <div class="max-w-7xl mx-auto p-4 mt-20 flex gap-6">
    <div class="flex flex-col">
    <!-- CATEGORY SIDEBAR -->
    <aside class="w-64 bg-white shadow rounded p-4 h-max hidden md:block">
      <h2 class="font-bold text-xl mb-4">Categories</h2>
      <ul class="space-y-2 text-gray-700">
        <li><a href="#" class="block hover:text-indigo-600">📱 Smartphones</a></li>
        <li><a href="#" class="block hover:text-indigo-600">⌚ Watches</a></li>
        <li><a href="#" class="block hover:text-indigo-600">🖥 Monitors</a></li>
        <li><a href="#" class="block hover:text-indigo-600">💻 Laptops</a></li>
        <li><a href="#" class="block hover:text-indigo-600">🎧 Accessories</a></li>
        <li><a href="#" class="block hover:text-indigo-600">📺 TV</a></li>
      </ul>
    </aside>
    <!-- FILTERS -->
      <h2 class="font-bold text-xl mb-3">Filter Products</h2>

      <div class="mb-4">
        <label class="font-semibold text-sm">Price Range</label>
        <input type="range" min="0" max="2000" value="500" class="w-full mt-2" />
        <p class="text-xs text-gray-600">Up to $500</p>
      </div>

      <div class="mb-4">
        <label class="font-semibold text-sm">Brand</label>
        <select class="w-full border rounded px-2 py-1 mt-1">
          <option>Select brand</option>
          <option>Samsung</option>
          <option>Apple</option>
          <option>Xiaomi</option>
          <option>Oppo</option>
        </select>
      </div>
      </div>

    <!-- ALL PRODUCTS AREA -->
    <main class="flex-1">
      <h2 class="text-3xl font-bold mb-6 text-indigo-600">All Products</h2>

      <!-- CATEGORY GROUPS -->
      <section class="mb-10">
        <h3 class="text-2xl font-semibold mb-4">Cloths</h3>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6" onclick="window.location.href='product.php'">
          <div class="bg-white p-3 rounded shadow hover:shadow-lg transition">
            <div class="h-40 bg-gray-200 rounded mb-2">
                <img src="product_image/shart1.jpg" alt="" class="h-[160px] w-[200px] hover:shadow ">
            </div>
            <h4 class="font-semibold">Shart</h4>
            <p class="text-indigo-600 font-bold">$899</p>
          </div>

          <div class="bg-white p-3 rounded shadow hover:shadow-lg transition">
            <div class="h-40 bg-gray-200 rounded mb-2"></div>
            <h4 class="font-semibold">Samsung Galaxy S23</h4>
            <p class="text-indigo-600 font-bold">$799</p>
          </div>

          <div class="bg-white p-3 rounded shadow hover:shadow-lg transition">
            <div class="h-40 bg-gray-200 rounded mb-2"></div>
            <h4 class="font-semibold">Xiaomi Mi 12</h4>
            <p class="text-indigo-600 font-bold">$499</p>
          </div>
        </div>
      </section>
      <section class="mb-10">
        <h3 class="text-2xl font-semibold mb-4">📱 Smartphones</h3>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6" onclick="window.location.href='product.php'">
          <div class="bg-white p-3 rounded shadow hover:shadow-lg transition">
            <div class="h-40 bg-gray-200 rounded mb-2"></div>
            <h4 class="font-semibold">iPhone 14</h4>
            <p class="text-indigo-600 font-bold">$899</p>
          </div>

          <div class="bg-white p-3 rounded shadow hover:shadow-lg transition">
            <div class="h-40 bg-gray-200 rounded mb-2"></div>
            <h4 class="font-semibold">Samsung Galaxy S23</h4>
            <p class="text-indigo-600 font-bold">$799</p>
          </div>

          <div class="bg-white p-3 rounded shadow hover:shadow-lg transition">
            <div class="h-40 bg-gray-200 rounded mb-2"></div>
            <h4 class="font-semibold">Xiaomi Mi 12</h4>
            <p class="text-indigo-600 font-bold">$499</p>
          </div>
        </div>
      </section>

      <section class="mb-10">
        <h3 class="text-2xl font-semibold mb-4">⌚ Watches</h3>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
          <div class="bg-white p-3 rounded shadow hover:shadow-lg transition">
            <div class="h-40 bg-gray-200 rounded mb-2"></div>
            <h4 class="font-semibold">Apple Watch 8</h4>
            <p class="text-indigo-600 font-bold">$399</p>
          </div>

          <div class="bg-white p-3 rounded shadow hover:shadow-lg transition">
            <div class="h-40 bg-gray-200 rounded mb-2"></div>
            <h4 class="font-semibold">Mi Watch Lite</h4>
            <p class="text-indigo-600 font-bold">$59</p>
          </div>
        </div>
      </section>

      <section class="mb-10">
        <h3 class="text-2xl font-semibold mb-4">🖥 Monitors</h3>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
          <div class="bg-white p-3 rounded shadow hover:shadow-lg transition">
            <div class="h-40 bg-gray-200 rounded mb-2"></div>
            <h4 class="font-semibold">LG UltraWide</h4>
            <p class="text-indigo-600 font-bold">$299</p>
          </div>

          <div class="bg-white p-3 rounded shadow hover:shadow-lg transition">
            <div class="h-40 bg-gray-200 rounded mb-2"></div>
            <h4 class="font-semibold">Dell 24" Monitor</h4>
            <p class="text-indigo-600 font-bold">$199</p>
          </div>
        </div>
      </section>

    </main>
  </div>

  <!-- FOOTER -->
  <footer class="bg-gray-800 text-white mt-10 py-6 text-center">
    <p>© 2025 ShopPro — All Rights Reserved.</p>
  </footer>

</body>
</html>
