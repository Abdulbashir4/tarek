<?php 
include "server_connection.php";
?>
<header class="bg-white shadow fixed top-0 w-full z-50">

  <!-- TOP HEADER -->
  <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">

    <!-- Logo -->
    <a href="index.php" class="text-2xl font-bold text-indigo-600">ShopPro</a>

    <!-- Desktop Search -->
    <div class="hidden md:flex w-1/2">
      <input type="text" placeholder="Search for products..."
             class="w-full border rounded-l-full py-2 px-4 outline-none focus:ring-2 focus:ring-indigo-500" />
      <button class="bg-indigo-600 text-white px-4 rounded-r-full">Search</button>
    </div>

    <!-- Desktop Icons -->
    <div class="hidden lg:flex items-center space-x-6 text-gray-700 text-2xl">

      <!-- Cart -->
      <a href="cart.php" class="relative">🛒
                <span id="cartCount"
                    class="absolute -top-2 -right-2 bg-red-600 text-white text-xs font-bold w-5 h-5 flex items-center justify-center rounded-full">
                    <?php echo isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'qty')) : 0; ?>
                </span>
            </a>

      <!-- Profile -->
      <a href="profile.php" class="text-gray-700 hover:text-indigo-600">👤</a>
    </div>

    <!-- Mobile Menu Toggle (☰) -->
    <button id="menuBtn" class="md:hidden text-3xl">☰</button>

  </div>

  <!-- MOBILE MENU (hidden by default) -->
  <nav id="mobileMenu" class="hidden bg-indigo-50 shadow md:hidden px-4 pb-4 max-h-[80vh] overflow-y-auto mt-1">
      <ul class="space-y-2">
          <?php
          // Load Categories
          $categories = $conn->query("SELECT * FROM categories");
          while ($cat = $categories->fetch_assoc()) {
              $cat_id = $cat['category_id'];
          ?>
          <li class="border-b pb-2">
              <button class="w-full flex justify-between py-2 font-semibold text-lg toggleCat">
                  <?= $cat['category_name'] ?> <span>▼</span>
              </button>
              <ul class="hidden pl-4 border-l bg-indigo-100 rounded">
                  <?php
                  $sub = $conn->query("SELECT * FROM subcategories WHERE category_id=$cat_id");
                  while ($s = $sub->fetch_assoc()) {
                      $sub_id = $s['subcategory_id'];
                  ?>
                  <li class="py-2">
                      <button class="w-full flex justify-between text-base toggleSub">
                          <?= $s['subcategory_name'] ?> <span>▶</span>
                      </button>
                      <ul class="hidden pl-4 border-l bg-indigo-50 rounded">
                          <?php
                          $brand = $conn->query("SELECT * FROM brands WHERE subcategory_id=$sub_id");
                          while ($b = $brand->fetch_assoc()) {
                          ?>
                          <li class="py-1">
                              <a href="index.php?brand_id=<?= $b['brand_id'] ?>" class="text-sm block">
                                  <?= $b['brand_name'] ?>
                              </a>
                          </li>
                          <?php } ?>
                      </ul>
                  </li>
                  <?php } ?>
              </ul>
          </li>
          <?php } ?>

          <!-- Static Links -->
          <li><a href="admin.php" class="block py-2">Admin</a></li>
          <li><a href="test.php" class="block py-2">Test</a></li>
          <li><a href="shop.php" class="block py-2">Shop</a></li>
      </ul>
  </nav>

</header>

<script>
  // Mobile menu toggle
  document.getElementById("menuBtn").onclick = function () {
      document.getElementById("mobileMenu").classList.toggle("hidden");
  };

  // Mobile category accordion
  document.querySelectorAll(".toggleCat").forEach(btn => {
      btn.onclick = function() {
          this.nextElementSibling.classList.toggle("hidden");
      };
  });

  // Mobile subcategory accordion
  document.querySelectorAll(".toggleSub").forEach(btn => {
      btn.onclick = function() {
          this.nextElementSibling.classList.toggle("hidden");
      };
  });

  // Update cart count dynamically
  document.addEventListener('DOMContentLoaded', () => {
      const headerCount = document.getElementById('cartCount');
      if(headerCount) {
          const n = Number(headerCount.innerText || headerCount.textContent) || 0;
          const bottomBadge = document.getElementById('bottomCartBadge');
          if(bottomBadge) {
              bottomBadge.innerText = n;
              bottomBadge.style.display = n > 0 ? 'inline-flex' : 'none';
          }
      }
  });
</script>
