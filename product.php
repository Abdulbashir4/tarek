<?php 
include "server_connection.php";

// URL থেকে product_id নাও
if(!isset($_GET['product_id'])){
    echo "Invalid product!";
    exit;
}

$product_id = (int)$_GET['product_id'];

// product details load
$query = $conn->query("
    SELECT 
        pro.*,
        bra.brand_name,
        cat.category_name
    FROM products pro
    LEFT JOIN brands bra ON pro.brand_id = bra.brand_id
    LEFT JOIN categories cat ON pro.category_id = cat.category_id
    WHERE pro.product_id = $product_id");

if($query->num_rows == 0){
    echo "Product not found!";
    exit;
}

$p = $query->fetch_assoc();




?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo $p['product_name']; ?> - Product Details</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-gray-100">

  <!-- HEADER -->
  <header >
      <?php include 'header.php'; ?>
  </header>

  <!-- PRODUCT DETAILS WRAPPER -->
  <div class="max-w-6xl mx-auto p-6 mt-14 lg:mt-30 bg-white shadow rounded-lg">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center">

      <!-- LEFT: PRODUCT GALLERY -->
      <div>

        <!-- main image -->
        <img id="mainImage" 
     src="uploads/products/<?php echo $p['thumbnail']; ?>" 
     class="rounded-xl shadow-lg mx-auto mb-10 w-[300px] h-[300px] object-cover" />

        <!-- extra images (optional) -->
        <div class="relative">

  <!-- LEFT ARROW -->
  <button 
    onclick="scrollGalleryLeft()" 
    class="absolute left-0 top-1/2 -translate-y-1/2 bg-indigo-400 shadow p-2 rounded-full hover:bg-indigo-500 z-10">
      <
  </button>

  <!-- Scrollable gallery container -->
  <div id="galleryWrapper" 
       class="flex gap-3 overflow-x-auto scroll-smooth no-scrollbar w-full px-10">

    <?php
    $gallery = [];

    if (!empty($p['gallery_images'])) {
        $gallery = json_decode($p['gallery_images'], true);
    }

    if (!empty($gallery)) {
        foreach ($gallery as $gimg) {
            echo '
            <img 
              onclick="changeMainImage(\'uploads/products/'.$gimg.'\')" 
              src="uploads/products/'.$gimg.'" 
              class="rounded-lg shadow cursor-pointer hover:opacity-80 w-20 h-20 object-cover"
            />';
        }
    } else {
        echo "<p class='text-gray-500'>No gallery images</p>";
    }
    ?>
  </div>

  <!-- RIGHT ARROW -->
  <button 
    onclick="scrollGalleryRight()" 
    class="absolute right-0 top-1/2 -translate-y-1/2 bg-indigo-400 shadow p-2 rounded-full hover:bg-indigo-500">
      >
  </button>

</div>


      </div>

      <!-- RIGHT: PRODUCT DETAILS -->
      <div>

        <!-- Stock Status -->
        <?php if($p['stock_qty'] > 0){ ?>
            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">In Stock</span>
        <?php } else { ?>
            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-semibold">Out of Stock</span>
        <?php } ?>

        <h2 class="text-4xl font-bold mt-3 mb-2 text-gray-900">
          <?php echo $p['product_name']; ?>
        </h2>

        <p class="text-3xl font-bold text-indigo-600 mb-4">
          ৳<?php echo $p['price']; ?>
        </p>

        <p class="text-gray-700 mb-6 leading-relaxed">
          <?php echo $p['short_description']; ?>
        </p>

        <!-- Quantity Selector -->
        <div class="flex items-center space-x-4 mb-6">
          <label class="font-semibold text-gray-700">Quantity:</label>
          <input 
    type="number" 
    id="qtyInput" 
    value="1" 
    min="1" 
    class="border rounded px-3 py-1 w-20" 
/>

        </div>

        <!-- Buttons -->
        <div class="flex gap-4">
          <button 
    id="addSingleCart"
    data-id="<?php echo $p['product_id']; ?>"
    class="bg-indigo-600 text-white px-6 py-3 rounded text-lg w-full md:w-auto hover:bg-indigo-700">
    Add to Cart
</button>


          <button id="buyNowBtn"
            data-id="<?= $p['product_id']; ?>"
             class="border border-indigo-600 text-indigo-600 px-6 py-3 rounded text-lg w-full md:w-auto hover:bg-indigo-50">
            Buy Now
          </button>
        </div>

        <div class="mt-8 text-gray-700 space-y-2">
          <p><strong>Brand:</strong> <?php echo $p['brand_name']; ?></p>
          <p><strong>Category:</strong> <?php echo $p['category_name']; ?></p>
          <p><strong>Stock:</strong> <?php echo $p['stock_qty']; ?></p>
        </div>

      </div>
    </div>

    <!-- DESCRIPTION SECTION -->
    <div class="mt-12">
      <h3 class="text-2xl font-bold mb-4">Product Description</h3>
      <p class="text-gray-700 leading-relaxed">
        <?php echo $p['long_description']; ?>
      </p>
    </div>

  </div>

  <!-- FOOTER -->
  <footer class="bg-gray-800 text-white mt-10 py-6 text-center">
    <p>© 2025 ShopPro — All Rights Reserved.</p>
  </footer>
<script>
  /* =========================
   IMAGE GALLERY FUNCTIONS
========================= */
function changeMainImage(imagePath) {
  const mainImage = document.getElementById("mainImage");
  if (mainImage) {
    mainImage.src = imagePath;
  }
}

function scrollGalleryRight() {
  const box = document.getElementById("galleryWrapper");
  if (box) {
    box.scrollLeft += 150;
  }
}

function scrollGalleryLeft() {
  const box = document.getElementById("galleryWrapper");
  if (box) {
    box.scrollLeft -= 150;
  }
}

/* =========================
   CART & BUY NOW FUNCTIONS
========================= */
document.addEventListener("DOMContentLoaded", function () {

  const qtyInput   = document.getElementById("qtyInput");
  const addBtn     = document.getElementById("addSingleCart");
  const buyNowBtn  = document.getElementById("buyNowBtn");

  // Safety check
  if (!qtyInput || !addBtn || !buyNowBtn) {
    console.error("Cart buttons or quantity input not found!");
    return;
  }

  /**
   * Add product to cart
   * @param {number} productId
   * @param {number} qty
   * @param {boolean} redirect
   */
  function addToCart(productId, qty, redirect = false) {

    qty = parseInt(qty);

    if (isNaN(qty) || qty < 1) {
      alert("Please enter a valid quantity!");
      return;
    }

    fetch("add_to_cart.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded"
      },
      body: `id=${encodeURIComponent(productId)}&qty=${encodeURIComponent(qty)}`
    })
    .then(response => response.json())
    .then(data => {

      if (data.status === "success") {

        // Update cart count in header
        const cartCount = document.getElementById("cartCount");
        if (cartCount) {
          cartCount.innerText = data.cartCount;
        }

        // Buy Now → redirect to cart page
        if (redirect === true) {
          window.location.href = "cart.php";
        }

      } else {
        alert(data.message || "Failed to add product to cart!");
      }

    })
    .catch(error => {
      console.error("Add to cart error:", error);
      alert("Something went wrong. Please try again.");
    });
  }

  /* Add to Cart Button */
  addBtn.addEventListener("click", function () {
    addToCart(this.dataset.id, qtyInput.value, false);
  });

  /* Buy Now Button */
  buyNowBtn.addEventListener("click", function () {
    addToCart(this.dataset.id, qtyInput.value, true);
  });

});
</script>
</body>
</html>
