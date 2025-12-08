
<?php
session_start();
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
  ?>

  <!-- MAIN WRAPPER -->
  <div class="max-w-7xl mx-auto mt-6 px-4 flex gap-6">

    <!-- SIDEBAR WITH FILTERS -->
    <aside class="w-[220px] bg-white shadow rounded p-4 h-max sticky top-40 hidden md:block">

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
      <section class="h-48 lg:mt-35 mt-12 md:h-64 w-full bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl shadow flex items-center justify-center text-white text-center p-6">
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

          // প্রডাক্ট লুপ
          while($p = $product->fetch_assoc()){
              echo '
              <div class="bg-white shadow rounded p-3 hover:shadow-lg transition">

                  <a href="product.php?product_id='.$p['product_id'].'">
                      <div class="h-36 bg-gray-200 rounded">
                          <img src="uploads/products/'.$p['thumbnail'].'" 
                               class="w-full h-full object-cover rounded"/>
                      </div>
                  </a>

                  <h3 class="mt-3 font-semibold">'.$p['product_name'].'</h3>

                  <button 
                      class="addToCart bg-indigo-600 text-white w-full py-1 mt-2 rounded block text-center"
                      data-id="'.$p['product_id'].'"
                      data-name="'.htmlspecialchars($p['product_name']).'"
                      data-price="'.$p['price'].'"
                  >
                      Add to Cart
                  </button>

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
    <p>© 2025 ShopPro — All Rights Reserved.</p>
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
