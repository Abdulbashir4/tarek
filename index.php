<?php
include 'server_connection.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>E-commerce Home Page</title>
  <style>
/* Smooth Dropdown Animation */
/* MAIN NAV STYLE */
.cls01 {
    background: #0c51d1ff;
    padding: 12px 20px;
}
.cls01 ul {
    margin: 0;
    padding: 0;
    list-style: none;
    display: flex;
    gap: 20px;
}
.cls01 ul li {
    position: relative;
}
.cls01 ul li a {
    color: #fff;
    text-decoration: none;
    padding: 8px 5px;
    display: block;
    transition: 0.2s;
    font-size: 15px;
}
.cls01 ul li a:hover {
    color: #ddd;
}

/* FIRST DROPDOWN */
.cls01 ul li ul {
    position: absolute;
    top: 100%;
    left: 0;
    background: #fff;
    min-width: 180px;
    padding: 5px 0;
    border-radius: 5px;
    display: none;
    box-shadow: 0 3px 12px rgba(0,0,0,0.25);
    z-index: 999;
}
.cls01 ul li:hover > ul {
    display: block;
}

/* SUBCATEGORY */
.cls01 ul li ul li:hover {
    background: #f4f4f4;
}
.cls01 ul li ul li a {
    padding: 10px;
    color: #000;
}

/* SECOND LEVEL DROPDOWN */
.cls01 ul li ul li ul {
    position: absolute;
    left: 100%;
    top: 0;
    min-width: 180px;
    padding: 5px 0;
    background: #fff;
    border-radius: 5px;
    display: none;
    box-shadow: 0 3px 12px rgba(0,0,0,0.25);
}

/* SHOW BRAND MENU */
.cls01 ul li ul li:hover > ul {
    display: block;
}

.cls01 ul li ul li ul li:hover {
    background: #ececec;
}
.cls01 ul li ul li ul li a {
    padding: 10px;
    color: #000;
}

</style>

  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100">

  <!-- HEADER -->
  <?php
  include 'header.php';
  include 'menu_bar.php'; ?>

  <!-- MAIN WRAPPER -->
  <div class="max-w-7xl mx-auto mt-6 px-4 flex gap-6">

    <!-- SIDEBAR WITH FILTERS -->
    <aside class="w-[220px] bg-white shadow rounded p-4 h-max sticky top-40 hidden md:block">
      <h2 class="font-bold text-xl mb-4">Categories</h2>
      <ul class="space-y-3 mb-6 text-gray-700">
        <li><a href="#" class="block hover:text-indigo-600">📱 Phones</a></li>
        <li><a href="#" class="block hover:text-indigo-600">⌚ Watches</a></li>
        <li><a href="#" class="block hover:text-indigo-600">🕒 Smart Watch</a></li>
        <li><a href="#" class="block hover:text-indigo-600">📺 LED TV</a></li>
        <li><a href="#" class="block hover:text-indigo-600">🖥 Monitors</a></li>
        <li><a href="#" class="block hover:text-indigo-600">💻 PC Accessories</a></li>
      </ul>

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

      <div class="mb-4">
        <label class="font-semibold text-sm">Condition</label>
        <ul class="space-y-2 text-sm mt-1">
          <li><label><input type="checkbox" class="mr-2"> New</label></li>
          <li><label><input type="checkbox" class="mr-2"> Used</label></li>
          <li><label><input type="checkbox" class="mr-2"> Refurbished</label></li>
        </ul>
      </div>

      <div>
        <label class="font-semibold text-sm">Ratings</label>
        <ul class="space-y-2 text-sm mt-1">
          <li><label><input type="radio" name="rate" class="mr-2"> ⭐⭐⭐⭐⭐</label></li>
          <li><label><input type="radio" name="rate" class="mr-2"> ⭐⭐⭐⭐ & Up</label></li>
          <li><label><input type="radio" name="rate" class="mr-2"> ⭐⭐⭐ & Up</label></li>
        </ul>
      </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1">

      <!-- HERO BANNER -->
      <section class="h-48 mt-35 md:h-64 w-full bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl shadow flex items-center justify-center text-white text-center p-6">
        <div>
          <h1 class="text-3xl md:text-4xl font-bold">Welcome to ShopPro</h1>
          <p class="mt-2 text-lg">Find the best deals on top products!</p>
        </div>
      </section>

      <!-- FEATURED PRODUCTS -->
      <section class="mt-8">
        <h2 class="text-2xl font-bold mb-4">Featured Products</h2>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
         <?php 

      // URL থেকে brand_id নাও (যদি থাকে)
      $brand_id = isset($_GET['brand_id']) ? (int)$_GET['brand_id'] : 0;

      // brand_id থাকলে শুধু সেই ব্র্যান্ডের প্রডাক্ট, না থাকলে সব প্রডাক্ট
      if($brand_id > 0){
          $product = $conn->query("SELECT * FROM products WHERE brand_id = $brand_id");
      } else {
          $product = $conn->query("SELECT * FROM products");
      }

      // যদি কোনো প্রডাক্ট না থাকে
      if($product->num_rows == 0){
          echo '<p class="col-span-2 sm:col-span-3 md:col-span-4 text-gray-500">
                  এই ব্র্যান্ডের জন্য কোনো প্রডাক্ট পাওয়া যায়নি।
                </p>';
      }

while($p = $product->fetch_assoc()){
    echo '
    <a href="product.php?product_id='.$p['product_id'].'" 
       class="block bg-white shadow rounded p-3 hover:shadow-lg transition">
        
        <div class="h-36 bg-gray-200 rounded">
            <img src="uploads/products/'.$p['thumbnail'].'" 
                 class="w-full h-full object-cover rounded"/>
        </div>
        
        <h3 class="mt-3 font-semibold">'. $p['product_name'] .'</h3>

        <button class="bg-indigo-600 text-white w-full py-1 mt-2 rounded">
            Add to Cart
        </button>

    </a>
    ';
}
?>
      </section>

    </main>
  </div>

  <!-- TESTIMONIAL SECTION -->
<section class="mt-12 bg-white shadow rounded-xl p-8">
  <h2 class="text-3xl font-bold text-center mb-6 text-indigo-600">
    What Our Customers Say
  </h2>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <div class="p-6 border rounded-lg shadow hover:shadow-lg transition bg-gray-50">
      <div class="flex items-center space-x-3 mb-3">
        <img src="https://i.pravatar.cc/60?img=12" class="w-12 h-12 rounded-full" />
        <div>
          <h3 class="font-semibold">Rahim Uddin</h3>
          <p class="text-sm text-gray-500">Dhaka, BD</p>
        </div>
      </div>
      <p class="text-gray-700 italic">
        “ShopPro থেকে কেনা আমার প্রথম অভিজ্ঞতা অসাধারণ! Delivery খুব দ্রুত ছিল।”
      </p>
      <div class="text-yellow-400 mt-3">⭐⭐⭐⭐⭐</div>
    </div>

    <div class="p-6 border rounded-lg shadow hover:shadow-lg transition bg-gray-50">
      <div class="flex items-center space-x-3 mb-3">
        <img src="https://i.pravatar.cc/60?img=32" class="w-12 h-12 rounded-full" />
        <div>
          <h3 class="font-semibold">Fatema Akter</h3>
          <p class="text-sm text-gray-500">Chattogram, BD</p>
        </div>
      </div>
      <p class="text-gray-700 italic">
        “প্রোডাক্ট কোয়ালিটি অসাধারণ, এবং সাপোর্ট টিম খুব সাহায্য করেছে!”
      </p>
      <div class="text-yellow-400 mt-3">⭐⭐⭐⭐⭐</div>
    </div>

    <div class="p-6 border rounded-lg shadow hover:shadow-lg transition bg-gray-50">
      <div class="flex items-center space-x-3 mb-3">
        <img src="https://i.pravatar.cc/60?img=47" class="w-12 h-12 rounded-full" />
        <div>
          <h3 class="font-semibold">Jahid Hasan</h3>
          <p class="text-sm text-gray-500">Sylhet, BD</p>
        </div>
      </div>
      <p class="text-gray-700 italic">
        “দাম অনুযায়ী পারফরম্যান্স দারুণ। আবারও এখান থেকে অর্ডার করবো!” 
      </p>
      <div class="text-yellow-400 mt-3">⭐⭐⭐⭐⭐</div>
    </div>

  </div>
</section>

  <!-- FOOTER -->
  <footer class="bg-gray-800 text-white mt-10 py-6 text-center">
    <p>© 2025 ShopPro — All Rights Reserved.</p>
  </footer>

</body>
</html>
