<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>E-commerce Home Page</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100">

  <!-- HEADER -->
  <header class="bg-white shadow sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
      <a href="#" class="text-2xl font-bold text-indigo-600">ShopPro</a>
      <div class="hidden md:flex w-1/2">
        <input type="text" placeholder="Search for products..." class="w-full border rounded-l-full py-2 px-4 outline-none focus:ring-2 focus:ring-indigo-500" />
        <button class="bg-indigo-600 text-white px-4 rounded-r-full">Search</button>
      </div>
      <div class="flex items-center space-x-6 text-gray-700 text-xl">
        <button>❤️</button>
        <button>🛒</button>
        <button>👤</button>
      </div>
    </div>
    <!-- HEADER MENU BAR -->
  <nav class="bg-indigo-600 text-white">
    <div class="max-w-7xl mx-auto px-4 py-2 overflow-x-auto">
      <ul class="flex space-x-6 text-sm md:text-base font-medium whitespace-nowrap">
        <li><a href="#" class="hover:text-gray-200">Home</a></li>
        <li><a href="admin.php" class="hover:text-gray-200">Admin</a></li>
        <li><a href="test.php" class="hover:text-gray-200">Test</a></li>
        <li><a href="#" class="hover:text-gray-200">Shop</a></li>
        <li><a href="#" class="hover:text-gray-200">Deals</a></li>
        <li><a href="#" class="hover:text-gray-200">New Arrivals</a></li>
        <li><a href="#" class="hover:text-gray-200">Top Selling</a></li>
        <li><a href="#" class="hover:text-gray-200">Contact</a></li>
      </ul>
    </div>
  </nav>

</header>

  <!-- MAIN WRAPPER -->
  <div class="max-w-7xl mx-auto mt-6 px-4 flex gap-6">

    <!-- SIDEBAR WITH FILTERS -->
    <aside class="w-[220px] bg-white shadow rounded p-4 h-max sticky top-20 hidden md:block">
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
      <section class="h-48 md:h-64 w-full bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl shadow flex items-center justify-center text-white text-center p-6">
        <div>
          <h1 class="text-3xl md:text-4xl font-bold">Welcome to ShopPro</h1>
          <p class="mt-2 text-lg">Find the best deals on top products!</p>
        </div>
      </section>

      <!-- FEATURED PRODUCTS -->
      <section class="mt-8">
        <h2 class="text-2xl font-bold mb-4">Featured Products</h2>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
          <div class="bg-white shadow rounded p-3 hover:shadow-lg transition">
            <div class="h-36 bg-gray-200 rounded"></div>
            <h3 class="mt-3 font-semibold">Smart Phone X</h3>
            <p class="text-indigo-600 font-bold">$499</p>
            <button class="bg-indigo-600 text-white w-full py-1 mt-2 rounded">Add to Cart</button>
          </div>

          <div class="bg-white shadow rounded p-3 hover:shadow-lg transition">
            <div class="h-36 bg-gray-200 rounded"></div>
            <h3 class="mt-3 font-semibold">LED TV 45"</h3>
            <p class="text-indigo-600 font-bold">$699</p>
            <button class="bg-indigo-600 text-white w-full py-1 mt-2 rounded">Add to Cart</button>
          </div>

          <div class="bg-white shadow rounded p-3 hover:shadow-lg transition">
            <div class="h-36 bg-gray-200 rounded"></div>
            <h3 class="mt-3 font-semibold">Gaming Monitor</h3>
            <p class="text-indigo-600 font-bold">$299</p>
            <button class="bg-indigo-600 text-white w-full py-1 mt-2 rounded">Add to Cart</button>
          </div>

          <div class="bg-white shadow rounded p-3 hover:shadow-lg transition">
            <div class="h-36 bg-gray-200 rounded"></div>
            <h3 class="mt-3 font-semibold">Wireless Earbuds</h3>
            <p class="text-indigo-600 font-bold">$99</p>
            <button class="bg-indigo-600 text-white w-full py-1 mt-2 rounded">Add to Cart</button>
          </div>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
          <div class="bg-white shadow rounded p-3 hover:shadow-lg transition">
            <div class="h-36 bg-gray-200 rounded"></div>
            <h3 class="mt-3 font-semibold">Smart Phone X</h3>
            <p class="text-indigo-600 font-bold">$499</p>
            <button class="bg-indigo-600 text-white w-full py-1 mt-2 rounded">Add to Cart</button>
          </div>

          <div class="bg-white shadow rounded p-3 hover:shadow-lg transition">
            <div class="h-36 bg-gray-200 rounded"></div>
            <h3 class="mt-3 font-semibold">LED TV 45"</h3>
            <p class="text-indigo-600 font-bold">$699</p>
            <button class="bg-indigo-600 text-white w-full py-1 mt-2 rounded">Add to Cart</button>
          </div>

          <div class="bg-white shadow rounded p-3 hover:shadow-lg transition">
            <div class="h-36 bg-gray-200 rounded"></div>
            <h3 class="mt-3 font-semibold">Gaming Monitor</h3>
            <p class="text-indigo-600 font-bold">$299</p>
            <button class="bg-indigo-600 text-white w-full py-1 mt-2 rounded">Add to Cart</button>
          </div>

          <div class="bg-white shadow rounded p-3 hover:shadow-lg transition">
            <div class="h-36 bg-gray-200 rounded"></div>
            <h3 class="mt-3 font-semibold">Wireless Earbuds</h3>
            <p class="text-indigo-600 font-bold">$99</p>
            <button class="bg-indigo-600 text-white w-full py-1 mt-2 rounded">Add to Cart</button>
          </div>
        </div>
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
