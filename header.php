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

    <style>
        /* Desktop dropdown hover */
        .dropdown:hover > ul { display: block; }
        .dropdown ul ul { left: 100%; top: 0; }
    </style>
</head>

<body class="bg-gray-100">

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

        <!-- Icons -->
        <div class="flex items-center space-x-6 text-gray-700 text-2xl">

            <!-- Mobile Search button -->
            <button id="mobileSearchBtn" class="md:hidden">🔍</button>

            <button>❤️</button>

            <!-- Cart -->
            <a href="cart.php" class="relative">🛒
                <span id="cartCount"
                    class="absolute -top-2 -right-2 bg-red-600 text-white text-xs font-bold w-5 h-5 flex items-center justify-center rounded-full">
                    <?php echo isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'qty')) : 0; ?>
                </span>
            </a>

            <button>👤</button>

            <!-- Mobile Menu -->
            <button id="menuBtn" class="md:hidden text-3xl">☰</button>
        </div>

    </div>

    <!-- Mobile Search -->
    <div id="mobileSearch" class="hidden px-4 pb-3 md:hidden">
        <input type="text" placeholder="Search..."
            class="w-full border rounded-full py-2 px-4 outline-none focus:ring-2 focus:ring-indigo-500" />
    </div>

    <!-- MOBILE MENU (Your old menu) -->
    <nav id="mobileMenu" class="hidden bg-white shadow md:hidden px-4 pb-4 max-h-[80vh] overflow-y-auto">

        <ul class="space-y-2">

        <?php
        // Load Categories
        $categories = $conn->query("SELECT * FROM categories");
        while ($cat = $categories->fetch_assoc()) {
            $cat_id = $cat['category_id'];
        ?>

        <!-- CATEGORY -->
        <li class="border-b pb-2">
            <button class="w-full flex justify-between py-2 font-semibold text-lg toggleCat">
                <?= $cat['category_name'] ?> <span>▼</span>
            </button>

            <!-- Subcategories -->
            <ul class="hidden pl-4 border-l">
                <?php
                $sub = $conn->query("SELECT * FROM subcategories WHERE category_id=$cat_id");
                while ($s = $sub->fetch_assoc()) {
                    $sub_id = $s['subcategory_id'];
                ?>
                <li class="py-2">
                    <button class="w-full flex justify-between text-base toggleSub">
                        <?= $s['subcategory_name'] ?> <span>▶</span>
                    </button>

                    <!-- Brands -->
                    <ul class="hidden pl-4 border-l">
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

            <!-- Static links -->
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

// Mobile search toggle
document.getElementById("mobileSearchBtn").onclick = function () {
    document.getElementById("mobileSearch").classList.toggle("hidden");
};

// Mobile category accordion
document.querySelectorAll(".toggleCat").forEach(btn=>{
    btn.onclick = function(){
        this.nextElementSibling.classList.toggle("hidden");
    };
});

// Mobile subcategory accordion
document.querySelectorAll(".toggleSub").forEach(btn=>{
    btn.onclick = function(){
        this.nextElementSibling.classList.toggle("hidden");
    };
});
</script>

</body>
</html>
