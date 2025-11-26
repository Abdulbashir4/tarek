<?php 
include "server_connection.php";
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Product Details</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100">

  <!-- HEADER -->
  <header class="bg-white shadow p-4 flex justify-between items-center sticky top-0 z-50">
    <h1 class="text-2xl font-bold text-indigo-600">ShopPro</h1>
    <nav class="hidden md:block">
      <ul class="flex space-x-6 text-gray-700 font-medium">
        <li><a href="#" class="hover:text-indigo-600">Home</a></li>
        <li><a href="#" class="hover:text-indigo-600">Shop</a></li>
        <li><a href="#" class="hover:text-indigo-600">Admin</a></li>
      </ul>
    </nav>
  </header>

  <!-- PRODUCT DETAILS WRAPPER -->
  <div class="max-w-6xl mx-auto p-6 mt-6 bg-white shadow rounded-lg">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center">

      <!-- LEFT: PRODUCT GALLERY -->
      <div>
        <img src="product_image/shart1.jpg" class="rounded-xl shadow-lg ml-30 mb-10 w-[300px] h-[300px]" />

        <div class="grid grid-cols-4 gap-3">
          <img src="product_image/shart2.jpg" class="rounded-lg shadow cursor-pointer hover:opacity-80" />
          <img src="product_image/shart3.jpg" class="rounded-lg shadow cursor-pointer hover:opacity-80" />
          <img src="product_image/shart4.jpg" class="rounded-lg shadow cursor-pointer hover:opacity-80" />
          <img src="product_image/shart5.jpg" class="rounded-lg shadow cursor-pointer hover:opacity-80" />
        </div>
      </div>

      <!-- RIGHT: PRODUCT DETAILS -->
      <div>
        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">In Stock</span>

        <h2 class="text-4xl font-bold mt-3 mb-2 text-gray-900">Premium Wireless Headphones</h2>

        <div class="flex items-center space-x-2 mb-3">
          <span class="text-yellow-400 text-xl">⭐⭐⭐⭐☆</span>
          <p class="text-gray-600 text-sm">(42 reviews)</p>
        </div>

        <p class="text-3xl font-bold text-indigo-600 mb-4">$299</p>

        <p class="text-gray-700 mb-6 leading-relaxed">
          Experience immersive sound quality with our premium wireless headphones. Designed for comfort,
          durability, and superior audio performance.
        </p>

        <!-- Quantity Selector -->
        <div class="flex items-center space-x-4 mb-6">
          <label class="font-semibold text-gray-700">Quantity:</label>
          <input type="number" value="1" min="1" class="border rounded px-3 py-1 w-20" />
        </div>

        <!-- Buttons -->
        <div class="flex gap-4">
          <button class="bg-indigo-600 text-white px-6 py-3 rounded text-lg w-full md:w-auto hover:bg-indigo-700">Add to Cart</button>
          <button class="border border-indigo-600 text-indigo-600 px-6 py-3 rounded text-lg w-full md:w-auto hover:bg-indigo-50">Buy Now</button>
        </div>

        <!-- Extra Info -->
        <div class="mt-8 text-gray-700 space-y-2">
          <p><strong>Category:</strong> Electronics</p>
          <p><strong>Brand:</strong> AudioPro</p>
          <p><strong>Warranty:</strong> 1 Year</p>
        </div>
      </div>
    </div>

    <!-- DESCRIPTION SECTION -->
    <div class="mt-12">
      <h3 class="text-2xl font-bold mb-4">Product Description</h3>
      <p class="text-gray-700 leading-relaxed">
        This premium wireless headphone delivers crystal-clear sound with deep bass and superior comfort.
        Perfect for music lovers, gamers, and professionals. With long battery life and fast charging,
        enjoy uninterrupted audio for hours.
      </p>
    </div>

    <!-- RELATED PRODUCTS -->
    <div class="mt-12">
      <h3 class="text-2xl font-bold mb-4">Related Products</h3>

      <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
        <div class="bg-white p-3 rounded shadow hover:shadow-lg transition cursor-pointer">
          <div class="h-36 bg-gray-200 rounded mb-2"></div>
          <h4 class="font-semibold">Bluetooth Speaker</h4>
          <p class="text-indigo-600 font-bold">$149</p>
        </div>

        <div class="bg-white p-3 rounded shadow hover:shadow-lg transition cursor-pointer">
          <div class="h-36 bg-gray-200 rounded mb-2"></div>
          <h4 class="font-semibold">Noise Cancelling Earbuds</h4>
          <p class="text-indigo-600 font-bold">$89</p>
        </div>

        <div class="bg-white p-3 rounded shadow hover:shadow-lg transition cursor-pointer">
          <div class="h-36 bg-gray-200 rounded mb-2"></div>
          <h4 class="font-semibold">Studio Microphone</h4>
          <p class="text-indigo-600 font-bold">$199</p>
        </div>
      </div>
    </div>
  </div>
  </div>

  <!-- FOOTER -->
  <footer class="bg-gray-800 text-white mt-10 py-6 text-center">
    <p>© 2025 ShopPro — All Rights Reserved.</p>
  </footer>

</body>
</html>
