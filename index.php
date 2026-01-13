<?php
session_start();
include 'global_php.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>E-commerce Home Page</title>
  <style>
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
    include 'menu_bar.php';
    // ধরে নিচ্ছি $conn কানেকশন header বা অন্য কোথাও থেকে এসেছে
  ?>

  <!-- MAIN WRAPPER -->
  <div class="max-w-7xl mx-auto mt-6 flex gap-6">

    <!-- SIDEBAR WITH FILTERS -->
    <aside class="w-[240px] bg-white shadow rounded p-4 h-max sticky top-45 hidden md:block">
      <div>
        <h2 class="font-bold text-xl mb-4">Categories</h2>

      <?php
        $categories = $conn->query("SELECT * FROM categories");
        echo '<ul class="space-y-2 text-gray-700">';

        while ($cat = $categories->fetch_assoc()) {
            echo '<li>
                    <a href="index.php?category_id='.$cat['category_id'].'"
                       class="block hover:text-indigo-600">
                       📂 '.$cat['category_name'].'
                    </a>
                  </li>';
        }
        echo '</ul>';
      ?>
      </div>

      <!-- FILTERS -->
      <div class="mb-6 bg-white p-4 rounded shadow mt-3">
        <h2 class="font-bold text-xl mb-3">Filter Products</h2>

        <label class="font-semibold text-sm">Price Range</label>

        <input type="range"
               min="0"
               max="20000"
               value="<?php echo isset($_GET['price']) ? (int)$_GET['price'] : 500; ?>"
               class="w-full mt-2"
               oninput="document.getElementById('priceText').textContent=this.value"
               onchange="redirectWithParam('price', this.value)" />

        <p class="text-sm text-gray-600 mt-2">
            Up to $<span id="priceText"><?php echo isset($_GET['price']) ? (int)$_GET['price'] : 500; ?></span>
        </p>
      </div>
      
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1">

      <!-- HERO BANNER -->
      <section class="relative h-48 lg:mt-40 mt-12 md:h-64 w-full rounded-xl overflow-hidden shadow">

    <!-- 🎥 Background Video -->
    <video 
        class="absolute inset-0 w-full h-full object-cover"
        autoplay 
        muted 
        loop 
        playsinline
    >
        <source src="image/video.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <!-- 🔲 Gradient Overlay (text readable করার জন্য) -->
    <div class="absolute inset-0 bg-gradient-to-r from-indigo-500/70 to-purple-600/70"></div>

    <!-- 📝 Content -->
    <div class="relative z-9 flex flex-col items-center justify-center h-full text-white text-center p-6">
        <h1 class="text-3xl md:text-4xl font-bold"><?php echo $company['company_name']; ?></h1>
        <p class="mt-2 text-lg">Find the best deals on top products!</p>
        <p id="category"></p>
    </div>

</section>

      
      <!-- CATEGORY GRID -->

    <section  class="mt-10">
      <h2 class="text-2xl font-bold text-center mb-6">Shop by Category</h2>

      <?php
      // 🔴 IMPORTANT FIX: এখানে নতুন করে query
      $cate = $conn->query("SELECT * FROM categories");
      ?>

      <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">

        <?php while ($c = $cate->fetch_assoc()) { ?>
          <a href="index.php?category_id=<?php echo (int)$c['category_id']; ?>" class="block">

            <div class="group bg-white rounded shadow overflow-hidden">

              <div class="h-28 bg-gray-100 overflow-hidden">
                <img
                  src="<?php echo !empty($c['category_image']) ? $c['category_image'] : 'images/no-image.png'; ?>"
                  alt="<?php echo htmlspecialchars($c['category_name']); ?>"
                  class="w-full h-full object-cover group-hover:scale-110 transition duration-300"
                >
              </div>

              <div class="p-3 text-center">
                <h3 class="text-sm font-semibold">
                  <?php echo htmlspecialchars($c['category_name']); ?>
                </h3>
              </div>

            </div>
          </a>
        <?php } ?>

      </div>
    </section>


      <!-- FEATURED PRODUCTS -->
      <section class="mt-8">
        <h2 class="text-2xl font-bold mb-4">Featured Products</h2>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
        <?php 
          // -------- FILTER CONDITIONS BUILD --------
          $conditions = [];

          if (isset($_GET['brand_id']) && $_GET['brand_id'] > 0) {
              $conditions[] = "brand_id = " . (int)$_GET['brand_id'];
          }

          if (isset($_GET['category_id']) && $_GET['category_id'] > 0) {
              $conditions[] = "category_id = " . (int)$_GET['category_id'];
          }

          if (isset($_GET['subcategory_id']) && $_GET['subcategory_id'] > 0) {
              $conditions[] = "subcategory_id = " . (int)$_GET['subcategory_id'];
          }

          if (isset($_GET['price']) && $_GET['price'] > 0) {
              $conditions[] = "price <= " . (int)$_GET['price'];
          }

          // -------- FINAL QUERY --------
          if (!empty($conditions)) {
              $where = "WHERE " . implode(" AND ", $conditions);
              $sql = "SELECT * FROM products $where";
          } else {
              $sql = "SELECT * FROM products";
          }
          
          $product = $conn->query($sql);

          // যদি কোনো প্রডাক্ট না থাকে
          if($product->num_rows == 0){
              echo '<p class="col-span-2 sm:col-span-3 md:col-span-4 text-gray-500">
                      কোনো প্রডাক্ট পাওয়া যায়নি।
                    </p>';
          }

          // প্রডাক্ট লুপ – এখানে Tailwind standard product card
          while($p = $product->fetch_assoc()) {

     $name = htmlspecialchars($p['product_name'], ENT_QUOTES, 'UTF-8');
    $price = $p['price'];
    $dis_price = $p['discount_price'];
    $oldPrice = $price + $dis_price;
    $discount_price =number_format( ($dis_price/$oldPrice)*100,1);
     // 15% বেশি ধরে পুরনো দাম
    $priceForm = number_format($price, 2);
    $oldPriceForm = number_format($oldPrice, 2);

echo '
<div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden group">

    <!-- IMAGE -->
    <a href="product.php?product_id='.$p['product_id'].'">
        <div class="relative h-40 sm:h-48 bg-gray-100 overflow-hidden">
            <img 
                src="uploads/products/'.$p['thumbnail'].'"
                class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                alt="'.$name.'"
            />

            <!-- DISCOUNT BADGE -->
            <span class="absolute top-3 left-3 bg-red-600 text-white text-xs px-2 py-1 rounded-md shadow">
                '.$discount_price.'% OFF
            </span>
        </div>
    </a>

    <!-- CONTENT -->
    <div class="p-4">

        <!-- PRODUCT NAME -->
        <h3 class="text-base font-semibold text-gray-800 leading-snug line-clamp-2 min-h-[48px]">
            '.$name.'
        </h3>

        <!-- RATING -->
        <div class="flex items-center mt-2 text-yellow-400 text-sm">
            ★★★★☆
            <span class="text-gray-500 ml-2 text-xs">4.1</span>
        </div>

        <!-- PRICE -->
        <div class="mt-3">
            <span class="text-lg font-bold text-indigo-600">$'.$priceForm.'</span>
            <span class="text-gray-400 line-through ml-2">$'.$oldPriceForm.'</span>
        </div>

        <!-- BUTTONS -->
        <div class="mt-4 flex gap-2">

            <!-- VIEW DETAILS -->
            <a href="product.php?product_id='.$p['product_id'].'"
                class="flex-1 border border-indigo-600 text-indigo-600 text-center py-2 rounded-lg font-medium hover:bg-indigo-50 transition">
                View Details
            </a>

            <!-- ADD TO CART -->
            <button 
                class="addToCart flex-1 bg-indigo-600 hover:bg-indigo-700 text-white py-2 rounded-lg font-medium transition"
                data-id="'.$p['product_id'].'"
                data-name="'.$name.'"
                data-price="'.$price.'"
            >
                Add to Cart
            </button>

        </div>

    </div>

</div>
';
}
        ?>
        </div> <!-- end grid -->
      </section>

    </main>
  </div>

  <!-- TESTIMONIAL SECTION -->
  <section class="mt-12 bg-white shadow rounded-xl p-8 max-w-7xl mx-auto">
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

  <?php include "bottom_navigation_bar.php" ?>

  <!-- FOOTER -->
  <footer class="bg-gray-800 text-white mt-10 py-6 text-center md:h-20 h-5">
    <p>© 2025 <?php echo $company['company_name']; ?> — All Rights Reserved. Developed By ENG. ABDUL BASIR</p>
  </footer>

<script>
document.addEventListener("DOMContentLoaded", () => {

    // সব Add to Cart বাটন সিলেক্ট
    document.querySelectorAll(".addToCart").forEach(button => {
        button.addEventListener("click", function(){

            let id = this.dataset.id;
            let name = this.dataset.name;
            let price = this.dataset.price;

            fetch("add_to_cart.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: `id=${id}&name=${encodeURIComponent(name)}&price=${price}`
            })
            .then(res => res.json())
            .then(data => {

                if (data.status === "success") {
                    // Header cart count update
                    const headerCount = document.getElementById("cartCount");
                    if (headerCount) {
                        headerCount.innerText = data.cartCount;
                    }

                    // Footer / bottom nav cart count update
                    const footerCount = document.getElementById("footerCartCount");
                    if (footerCount) {
                        footerCount.innerText = data.cartCount;
                    }
                }

            });

        });
    });

});


// URL এ যেকোনো filter param সেট করার জন্য common function
function redirectWithParam(key, value){
    let url = new URL(window.location.href);

    if(value === "" || value === null){
        url.searchParams.delete(key);
    } else {
        url.searchParams.set(key, value);
    }

    window.location = url.toString();
}
</script>

</body>
</html>
