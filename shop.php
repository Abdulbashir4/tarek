<?php
session_start();
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

<header>
  <?php include 'header.php'; ?>
</header>

<div class="max-w-7xl mx-auto p-4 mt-20 flex gap-6">

  <!-- LEFT SIDEBAR -->
  <div class="flex flex-col">

    <!-- CATEGORY -->
    <aside class="w-64 bg-white shadow rounded p-4 h-max hidden md:block">
      <h2 class="font-bold text-xl mb-4">Categories</h2>

      <?php
        $categories = $conn->query("SELECT * FROM categories");
        echo '<ul class="space-y-2 text-gray-700">';

        while ($cat = $categories->fetch_assoc()) {
            echo '<li>
                    <a href="shop.php?category_id='.$cat['category_id'].'"
                       class="block hover:text-indigo-600">
                       📂 '.$cat['category_name'].'
                    </a>
                  </li>';
        }
        echo '</ul>';
      ?>
    </aside>

    <!-- SUBCATEGORY -->
    <aside class="w-64 mt-2 bg-white shadow rounded p-4 h-max hidden md:block">
      <h2 class="font-bold text-xl mb-4">Sub Category</h2>

      <?php
        if (!empty($_GET['category_id'])) {
            $cid = (int)$_GET['category_id'];
            $subcategories = $conn->query("SELECT * FROM subcategories WHERE category_id=$cid");
        } else {
            $subcategories = $conn->query("SELECT * FROM subcategories");
        }

        echo '<select class="w-full border rounded px-2 py-1 mt-1"
                onchange="redirectWithParam(\'subcategory_id\', this.value)">';

        echo '<option value="">Select subcategory</option>';

        while ($sub = $subcategories->fetch_assoc()) {
            echo '<option value="'.$sub['subcategory_id'].'">'.$sub['subcategory_name'].'</option>';
        }

        echo '</select>';
      ?>
    </aside>

    <!-- BRAND FILTER -->
    <aside class="w-64 mt-2 bg-white shadow rounded p-4 h-max hidden md:block">
      <h2 class="font-bold text-xl mb-4">Brand</h2>

      <?php
        if (!empty($_GET['subcategory_id'])) {
            $sid = (int)$_GET['subcategory_id'];
            $brands = $conn->query("
                SELECT DISTINCT brands.brand_id, brands.brand_name
                FROM brands
                INNER JOIN products ON products.brand_id = brands.brand_id
                WHERE products.subcategory_id = $sid
            ");
        } else {
            $brands = $conn->query("SELECT * FROM brands");
        }

        echo '<select class="w-full border rounded px-2 py-1 mt-1"
                onchange="redirectWithParam(\'brand_id\', this.value)">';

        echo '<option value="">Select brand</option>';

        while ($brand = $brands->fetch_assoc()) {
            echo '<option value="'.$brand['brand_id'].'">'.$brand['brand_name'].'</option>';
        }

        echo '</select>';
      ?>
    </aside>

    <!-- PRICE FILTER -->
    <div class="mb-6 bg-white p-4 rounded shadow mt-3">
        <h2 class="font-bold text-xl mb-3">Filter Products</h2>

        <label class="font-semibold text-sm">Price Range</label>

        <input type="range"
               min="0"
               max="2000"
               value="<?php echo $_GET['price'] ?? 500; ?>"
               class="w-full mt-2"
               oninput="document.getElementById('priceText').textContent=this.value"
               onchange="redirectWithParam('price', this.value)" />

        <p class="text-sm text-gray-600 mt-2">
            Up to $<span id="priceText"><?php echo $_GET['price'] ?? 500; ?></span>
        </p>
    </div>

  </div>

  <!-- MAIN CONTENT -->
  <main class="flex-1">
    <h2 class="text-3xl font-bold mb-6 text-indigo-600">All Products</h2>

    <section class="mt-8">
      <h2 class="text-2xl font-bold mb-4">Featured Products</h2>

      <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">

        <?php

        // BUILD FILTER CONDITIONS
        $conditions = [];

        if (!empty($_GET['brand_id'])) {
            $conditions[] = "brand_id = " . (int)$_GET['brand_id'];
        }
        if (!empty($_GET['category_id'])) {
            $conditions[] = "category_id = " . (int)$_GET['category_id'];
        }
        if (!empty($_GET['subcategory_id'])) {
            $conditions[] = "subcategory_id = " . (int)$_GET['subcategory_id'];
        }
        if (!empty($_GET['price'])) {
            $conditions[] = "price <= " . (int)$_GET['price'];
        }

        if ($conditions) {
            $sql = "SELECT * FROM products WHERE " . implode(" AND ", $conditions);
        } else {
            $sql = "SELECT * FROM products";
        }
        
        $product = $conn->query($sql);

        if($product->num_rows == 0){
            echo '<p class="col-span-2 sm:col-span-3 md:col-span-4 text-gray-500">
                    কোনো প্রডাক্ট পাওয়া যায়নি।
                 </p>';
        }

        // PRODUCT LOOP (নতুন কার্ড ডিজাইন)
        while($p = $product->fetch_assoc()){

            $name = htmlspecialchars($p['product_name'], ENT_QUOTES, 'UTF-8');

            // database ধরে নিচ্ছি: price = মূল দাম, discount_price = ডিসকাউন্টের পর দাম (না থাকলে 0)
            $originalPrice   = (float)$p['price'];
            $discountPriceDB = isset($p['discount_price']) ? (float)$p['discount_price'] : 0;

            // যদি discount_price সেট থাকে এবং মূল দামের চেয়ে কম হয়, তাহলে ওটাকেই current price ধরি
            if ($discountPriceDB > 0 && $discountPriceDB < $originalPrice) {
                $currentPrice = $discountPriceDB;
            } else {
                $currentPrice = $originalPrice;
            }

            // ডিসকাউন্ট পার্সেন্ট
            $discountPercent = 0;
            if ($currentPrice < $originalPrice && $originalPrice > 0) {
                $discountPercent = round((($originalPrice - $currentPrice) / $originalPrice) * 100);
            }

            $currentPriceFormatted = number_format($currentPrice, 2);
            $originalPriceFormatted = number_format($originalPrice, 2);

            // ব্যাজ HTML
            $badgeHtml = '';
            if ($discountPercent > 0) {
                $badgeHtml = '
                <span class="absolute top-3 left-3 bg-red-600 text-white text-xs px-2 py-1 rounded-md shadow">
                    '.$discountPercent.'% OFF
                </span>';
            }

            // প্রাইস HTML
            $priceHtml = '
                <span class="text-lg font-bold text-indigo-600">$'.$currentPriceFormatted.'</span>';
            if ($discountPercent > 0) {
                $priceHtml .= '
                <span class="text-sm text-gray-400 line-through ml-2">$'.$originalPriceFormatted.'</span>';
            }

            echo '
            <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col group">

                <!-- IMAGE -->
                <a href="product.php?product_id='.$p['product_id'].'">
                    <div class="relative h-40 sm:h-48 bg-gray-100 overflow-hidden">
                        <img 
                            src="uploads/products/'.$p['thumbnail'].'"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                            alt="'.$name.'"
                        />
                        '.$badgeHtml.'
                    </div>
                </a>

                <!-- CONTENT -->
                <div class="p-4 flex flex-col flex-1">

                    <!-- NAME -->
                    <h3 class="text-sm sm:text-base font-semibold text-gray-800 leading-snug line-clamp-2 min-h-[40px]">
                        '.$name.'
                    </h3>

                    <!-- RATING (ডামি) -->
                    <div class="flex items-center mt-2 text-yellow-400 text-xs sm:text-sm">
                        ★★★★☆
                        <span class="text-gray-500 ml-2 text-[11px]">4.2</span>
                    </div>

                    <!-- PRICE -->
                    <div class="mt-3">
                        '.$priceHtml.'
                    </div>

                    <!-- BUTTONS -->
                    <div class="mt-4 flex gap-2">

                        <a href="product.php?product_id='.$p['product_id'].'"
                            class="flex-1 border border-indigo-600 text-indigo-600 text-center py-2 rounded-lg text-xs sm:text-sm font-medium hover:bg-indigo-50 transition">
                            View Details
                        </a>

                        <button 
                            class="addToCart flex-1 bg-indigo-600 hover:bg-indigo-700 text-white py-2 rounded-lg text-xs sm:text-sm font-medium transition"
                            data-id="'.$p['product_id'].'"
                            data-name="'.$name.'"
                            data-price="'.$currentPrice.'"
                        >
                            Add to Cart
                        </button>

                    </div>

                </div>

            </div>
            ';
        }

        ?>

      </div>
    </section>

  </main>
</div>

<footer class="bg-gray-800 text-white mt-10 py-6 text-center">
  <p>© 2025 ShopPro — All Rights Reserved.</p>
</footer>


<!-- JAVASCRIPT -->
<script>
document.addEventListener("DOMContentLoaded", () => {

    // AJAX Add To Cart
    document.querySelectorAll(".addToCart").forEach(button => {
        button.addEventListener("click", function(){

            let id = this.dataset.id;
            let name = this.dataset.name;
            let price = this.dataset.price;

            fetch("add_to_cart.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `id=${id}&name=${encodeURIComponent(name)}&price=${price}`
            })
            .then(res => res.json())
            .then(data => {
                if(data.status === "success" && document.getElementById("cartCount")){
                    document.getElementById("cartCount").innerText = data.cartCount;
                }
            });

        });
    });
});

// UNIVERSAL FILTER REDIRECT
function redirectWithParam(key, value){
    let url = new URL(window.location.href);

    if(value === ""){
        url.searchParams.delete(key);
    } else {
        url.searchParams.set(key, value);
    }

    window.location = url.toString();
}
</script>

</body>
</html>
