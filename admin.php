<?php
include 'server_connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100">

  <!-- ADMIN HEADER -->
  <header class="bg-white shadow p-4 flex justify-between items-center">
    <h1 class="text-2xl font-bold text-indigo-600">ShopPro Admin</h1>
    <button class="bg-indigo-600 text-white px-4 py-1 rounded">Logout</button>
  </header>

  <div class="flex p-4 gap-4">

    <!-- SIDEBAR -->
    <aside class="w-60 bg-white shadow rounded p-4 h-max">
      <h2 class="font-bold text-lg mb-4">Admin Menu</h2>
      <ul class="space-y-3 text-gray-700">
        <li><a href="#" class="block hover:text-indigo-600">📦 Manage Products</a></li>
        <li><a href="#" class="block hover:text-indigo-600">📁 Categories</a></li>
        <li><a href="#" class="block hover:text-indigo-600">🎛 Homepage Controls</a></li>
        <li><a href="#" class="block hover:text-indigo-600">💰 Orders</a></li>
        <li><a href="#" class="block hover:text-indigo-600">👤 Users</a></li>
        <li><a href="#" class="block hover:text-indigo-600">⚙ Settings</a></li>
        <li><a href="index.php" class="block hover:text-indigo-600">⚙ Shop Page</a></li>
      </ul>
    </aside>

    <!-- MAIN ADMIN AREA -->
    <main class="flex-1 bg-white shadow rounded p-6">
      <h2 class="text-xl font-bold mb-4">Homepage Control Panel</h2>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="p-4 border rounded">
          <h3 class="font-semibold mb-2">Hero Banner Visibility</h3>
          <label class="flex items-center space-x-2">
            <input id="toggle-hero" type="checkbox" checked />
            <span>Show Hero Banner</span>
          </label>
        </div>

        <div class="p-4 border rounded">
          <h3 class="font-semibold mb-2">Featured Products Section</h3>
          <label class="flex items-center space-x-2">
            <input id="toggle-featured" type="checkbox" checked />
            <span>Show Featured Products</span>
          </label>
        </div>

        <div class="p-4 border rounded">
          <h3 class="font-semibold mb-2">Sidebar Categories</h3>
          <label class="flex items-center space-x-2">
            <input id="toggle-sidebar-categories" type="checkbox" checked />
            <span>Show Categories</span>
          </label>
        </div>

        <div class="p-4 border rounded">
          <h3 class="font-semibold mb-2">Product Filter Panel</h3>
          <label class="flex items-center space-x-2">
            <input id="toggle-sidebar-filters" type="checkbox" checked />
            <span>Enable Filters</span>
          </label>
        </div>
      </div>

      <div class="mt-10">
        <h2 class="text-xl font-bold mb-4">Add New Product</h2>
        <form class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <input type="text" placeholder="Product Name" class="border p-2 rounded" />
          <input type="number" placeholder="Price" class="border p-2 rounded" />
          <input type="text" placeholder="Image URL" class="border p-2 rounded md:col-span-2" />
          <textarea placeholder="Product Description" class="border p-2 rounded md:col-span-2"></textarea>
          <button class="bg-indigo-600 text-white px-6 py-2 rounded md:col-span-2">Add Product</button>
        </form>
      </div>

      <div class="mt-10">
        <h2 class="mb-4 text-xl font-bold">Add Category</h2>
          <form method="POST">
              <input type="text" name="category_name" placeholder="Category Name" required class="border p-2">
              <button type="submit" name="add_category" class="bg-indigo-600 text-white px-3 py-2 rounded">Add Catagory</button>
          </form>

          <?php
          if(isset($_POST['add_category'])){
              $name = $_POST['category_name'];
              $insert = "INSERT INTO categories (category_name) VALUES ('$name')";
              $conn->query($insert);
              echo "Category added successfully!";
          }
          ?>
      </div>

      <div class="mt-10">

          <h2 class="mb-4 text-xl font-bold">Add Subcategory</h2>

          <form method="POST">

              <select name="category_id" required class="border p-2">
                  <option value="">Select Category</option>

                  <?php
                  $cats = $conn->query("SELECT * FROM categories");
                  while($c = $cats->fetch_assoc()){
                      echo '<option value="'.$c['category_id'].'">'.$c['category_name'].'</option>';
                  }
                  ?>
              </select>

              <input type="text" name="subcategory_name" placeholder="Subcategory Name" required class="border p-2">

              <button type="submit" name="add_subcategory" class="bg-indigo-600 text-white px-3 py-2 rounded">Add</button>
          </form>

            <?php
            if(isset($_POST['add_subcategory'])){
                $cid = $_POST['category_id'];
                $name = $_POST['subcategory_name'];
                $insert = "INSERT INTO subcategories (category_id, subcategory_name) VALUES ($cid, '$name')";
                $conn->query($insert);
                echo "Subcategory added!";
            }
            ?>
      </div>
      <div class="mt-10">
                <h2>Add Brands</h2>

                <form method="POST">

                    <select name="subcategory_id" required class="border p-2">
                        <option value="">Select Subcategory</option>

                        <?php
                        $subs = $conn->query("SELECT * FROM subcategories");
                        while($s = $subs->fetch_assoc()){
                            echo '<option value="'.$s['subcategory_id'].'">'.$s['subcategory_name'].'</option>';
                        }
                        ?>
                    </select>

                    <input type="text" name="brand_name" placeholder="Brand Name" required class="border p-2">

                    <button type="submit" name="add_brand" class="bg-indigo-600 text-white px-3 py-1">Add</button>
                </form>

              <?php
              if(isset($_POST['add_brand'])){
                  $sid = $_POST['subcategory_id'];
                  $name = $_POST['brand_name'];
                  $insert = "INSERT INTO brands (subcategory_id, brand_name) VALUES ($sid, '$name')";
                  $conn->query($insert);
                  echo "Brand added!";
              }
              ?>

      </div>

    </main>
  </div>

  <!-- SETTINGS SCRIPT -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const heroToggle = document.getElementById('toggle-hero');
      const featuredToggle = document.getElementById('toggle-featured');
      const sidebarCatToggle = document.getElementById('toggle-sidebar-categories');
      const sidebarFilterToggle = document.getElementById('toggle-sidebar-filters');

      function loadSettings() {
        const settings = JSON.parse(localStorage.getItem('shoppro_home_settings') || '{}');

        heroToggle.checked = settings.showHero !== false;
        featuredToggle.checked = settings.showFeatured !== false;
        sidebarCatToggle.checked = settings.showSidebarCategories !== false;
        sidebarFilterToggle.checked = settings.showFilters !== false;
      }

      function saveSettings() {
        const settings = {
          showHero: heroToggle.checked,
          showFeatured: featuredToggle.checked,
          showSidebarCategories: sidebarCatToggle.checked,
          showFilters: sidebarFilterToggle.checked
        };
        localStorage.setItem('shoppro_home_settings', JSON.stringify(settings));
      }

      [heroToggle, featuredToggle, sidebarCatToggle, sidebarFilterToggle].forEach(input => {
        input.addEventListener('change', saveSettings);
      });

      loadSettings();
    });
  </script>

</body>
</html>
