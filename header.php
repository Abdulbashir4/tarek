<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "/server_connection.php";

$img = "default.png";

if (isset($_SESSION['user_id'])) {
    $uid = (int)$_SESSION['user_id'];

    $q = $conn->prepare("SELECT profile_image FROM users WHERE id=?");
    $q->bind_param("i", $uid);
    $q->execute();

    $r = $q->get_result()->fetch_assoc();
    if (!empty($r['profile_image'])) {
        $img = $r['profile_image'];
    }
}
include "global_php.php";

?>
<header class="bg-white shadow fixed top-0 w-full z-50 h-16">

  <!-- TOP HEADER -->
  <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center ">

    <!-- Logo -->
    <a href="index.php" class="text-2xl font-bold text-indigo-600 "><?php echo $company['company_name']; ?></a>

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
      <!-- ✅ Dropdown Wrapper -->
    <div class="relative">

        <!-- ✅ group wrapper -->
        <div class="group inline-block">

            <!-- ✅ Profile Image (Hover Trigger) -->
             <a href="user_redirect.php" class="block">
            <img id="headerProfileImg"
                 src="uploads/<?= htmlspecialchars($img) ?>"
                 class="w-10 h-10 rounded-full border object-cover cursor-pointer"
                 alt="profile">
                 </a>
            <!-- ✅ Dropdown Menu -->
            <div
                class="absolute right-0 mt-2 w-44 bg-white shadow-lg rounded-md border z-50
                       opacity-0 invisible group-hover:opacity-100 group-hover:visible
                       transition-all duration-200 z-[1000]">

                <?php if (isset($_SESSION['user_id'])): ?>
                    <!-- ✅ Logged in: Logout -->
                    <a href="logout.php"
                       class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 rounded-md">
                        Logout
                    </a>
                <?php else: ?>
                    <!-- ❌ Not logged in: Login + Register -->
                    <a href="login.php"
                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                        Login
                    </a>

                    <a href="register.php"
                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                        Register
                    </a>
                <?php endif; ?>

            </div>

        </div>
    </div>
    </div>

    <!-- Mobile Menu Toggle (☰) -->
    <button id="menuBtn" class="md:hidden text-3xl">☰</button>

  </div>

  <!-- MOBILE MENU (hidden by default) -->
  <nav id="mobileMenu" class="hidden bg-indigo-50 shadow md:hidden px-4 pb-4 max-h-[80vh] overflow-y-auto mt-1">
      <ul class="">
      <li><a href="index.php" class="block py-2 ">Home</a></li>
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
          <li><a href="contact.php" class="block py-2">Contact Us</a></li>
          
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
