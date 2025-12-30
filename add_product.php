<?php include "server_connection.php"; ?>

<!DOCTYPE html>
<html lang="bn">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Product Add</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 min-h-screen">

  <div class="max-w-4xl mx-auto px-4 py-10">
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
      <div class="px-6 py-6 border-b">
        <h2 class="text-2xl font-semibold text-gray-800 text-center">প্রডাক্ট যোগ করুন</h2>
      </div>

      <form action="product-insert.php" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">

        <!-- Name -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">প্রডাক্ট নাম <span class="text-red-500">*</span></label>
          <input type="text" name="product_name" required
                 class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
        </div>

        <!-- Category / Subcategory -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">ক্যাটাগরি <span class="text-red-500">*</span></label>
            <select name="category_id" required
                    class="w-full border border-gray-300 rounded-md px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
              <option value="">নির্বাচন করুন</option>
              <?php
                $cats = $conn->query("SELECT * FROM categories");
                while($c = $cats->fetch_assoc()){
                    echo "<option value='".(int)$c['category_id']."'>".htmlspecialchars($c['category_name'], ENT_QUOTES, 'UTF-8')."</option>";
                }
              ?>
            </select>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">সাবক্যাটাগরি <span class="text-red-500">*</span></label>
            <select name="subcategory_id" 
                    class="w-full border border-gray-300 rounded-md px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
              <option value="">নির্বাচন করুন</option>
              <?php
                $subs = $conn->query("SELECT * FROM subcategories");
                while($s = $subs->fetch_assoc()){
                    echo "<option value='".(int)$s['subcategory_id']."'>".htmlspecialchars($s['subcategory_name'], ENT_QUOTES, 'UTF-8')."</option>";
                }
              ?>
            </select>
          </div>
        </div>

        <!-- Brand -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">ব্র্যান্ড <span class="text-red-500">*</span></label>
          <select name="brand_id" 
                  class="w-full border border-gray-300 rounded-md px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <option value="">নির্বাচন করুন</option>
            <?php
              $brands = $conn->query("SELECT * FROM brands");
              while($b = $brands->fetch_assoc()){
                  echo "<option value='".(int)$b['brand_id']."'>".htmlspecialchars($b['brand_name'], ENT_QUOTES, 'UTF-8')."</option>";
              }
            ?>
          </select>
        </div>

        <!-- Price and Discount -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">মূল দাম <span class="text-red-500">*</span></label>
            <input type="number" name="price" required step="0.01" min="0"
                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">ডিসকাউন্ট দাম</label>
            <input type="number" name="discount_price" step="0.01" min="0"
                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
          </div>
        </div>

        <!-- Stock -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">স্টকে আছে কত পিস <span class="text-red-500">*</span></label>
          <input type="number" name="stock_qty" required min="0"
                 class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
        </div>

        <!-- Short & Long Description -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">সংক্ষিপ্ত বিবরণ</label>
            <textarea name="short_description"
                      class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">সম্পূর্ণ বিবরণ</label>
            <textarea name="long_description" rows="6"
                      class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
          </div>
        </div>

        <!-- Images -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-start">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">প্রডাক্ট ইমেজ <span class="text-red-500">*</span></label>
            <input type="file" name="product_image" accept="image/*" required
                   class="w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold
                          file:bg-indigo-600 file:text-white hover:file:bg-indigo-700" />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Gallery Image (Multiple)</label>
            <input type="file" name="product_gallery_image[]" accept="image/*" multiple
                   class="w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold
                          file:bg-gray-200 file:text-gray-700 hover:file:bg-gray-300" />
            <p class="text-xs text-gray-500 mt-2">অনেকগুলো ছবি আপলোড করতে হলে Ctrl/Shift চেপে নির্বাচন করুন।</p>
          </div>
        </div>

        <!-- Submit -->
        <div>
          <button type="submit"
                  class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-md px-4 py-3">
            সাবমিট করুন
          </button>
        </div>

      </form>
    </div>
  </div>

</body>
</html>
