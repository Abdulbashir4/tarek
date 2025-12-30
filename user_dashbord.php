<!DOCTYPE html>
<html lang="bn">
<head>
  <meta charset="UTF-8">
  <title>User Dashboard</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100">

<div class="flex min-h-screen">

  <!-- Sidebar -->
  <aside class="w-64 bg-white shadow-lg">
    <div class="p-6 border-b">
      <img src="https://i.pravatar.cc/100" class="w-16 h-16 rounded-full mx-auto">
      <h2 class="text-center font-semibold mt-2">Hasan Ahmed</h2>
      <p class="text-center text-sm text-gray-500">hasan@example.com</p>
    </div>

    <nav class="p-4 space-y-2">
      <a href="#" class="block bg-blue-600 text-white px-4 py-2 rounded">ড্যাশবোর্ড</a>
      <a href="#" class="block px-4 py-2 hover:bg-gray-100 rounded">আমার অর্ডার</a>
      <a href="#" class="block px-4 py-2 hover:bg-gray-100 rounded">ইচ্ছের তালিকা</a>
      <a href="#" class="block px-4 py-2 hover:bg-gray-100 rounded">কার্ট</a>
      <a href="#" class="block px-4 py-2 hover:bg-gray-100 rounded">ঠিকানা</a>
      <a href="#" class="block px-4 py-2 hover:bg-gray-100 rounded">প্রোফাইল</a>
      <a href="#" class="block px-4 py-2 text-red-500 hover:bg-red-50 rounded">লগআউট</a>
    </nav>
  </aside>

  <!-- Main Content -->
  <main class="flex-1 p-6">

    <!-- Header -->
    <h1 class="text-2xl font-bold mb-6">আমার ড্যাশবোর্ড</h1>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
      <div class="bg-white p-4 rounded shadow">
        <p class="text-gray-500">চলমান অর্ডার</p>
        <h2 class="text-3xl font-bold">02</h2>
      </div>
      <div class="bg-white p-4 rounded shadow">
        <p class="text-gray-500">ডেলিভারি হচ্ছে</p>
        <h2 class="text-3xl font-bold">01</h2>
      </div>
      <div class="bg-white p-4 rounded shadow">
        <p class="text-gray-500">সম্পন্ন অর্ডার</p>
        <h2 class="text-3xl font-bold">10</h2>
      </div>
      <div class="bg-white p-4 rounded shadow">
        <p class="text-gray-500">রিটার্ন অনুরোধ</p>
        <h2 class="text-3xl font-bold">01</h2>
      </div>
    </div>

    <!-- Orders & Notifications -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

      <!-- Orders Table -->
      <div class="lg:col-span-2 bg-white p-4 rounded shadow">
        <h2 class="font-semibold mb-4">সাম্প্রতিক অর্ডার</h2>

        <table class="w-full text-sm">
          <thead class="bg-gray-100">
            <tr>
              <th class="p-2 text-left">অর্ডার</th>
              <th class="p-2">তারিখ</th>
              <th class="p-2">স্ট্যাটাস</th>
              <th class="p-2">মোট</th>
            </tr>
          </thead>
          <tbody>
            <tr class="border-t">
              <td class="p-2">#10245</td>
              <td class="p-2">২২ জানুয়ারি ২০২৪</td>
              <td class="p-2 text-green-600">ডেলিভারি</td>
              <td class="p-2">৳ 1500</td>
            </tr>
            <tr class="border-t">
              <td class="p-2">#10198</td>
              <td class="p-2">৬ জানুয়ারি ২০২৪</td>
              <td class="p-2 text-yellow-500">প্রসেসিং</td>
              <td class="p-2">৳ 2800</td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Notifications -->
      <div class="bg-white p-4 rounded shadow">
        <h2 class="font-semibold mb-4">বার্তা</h2>
        <ul class="space-y-3 text-sm">
          <li class="bg-gray-100 p-3 rounded">আপনার অর্ডার #10245 পাঠানো হয়েছে</li>
          <li class="bg-gray-100 p-3 rounded">২০% ডিসকাউন্ট কুপন পেয়েছেন</li>
        </ul>
      </div>
    </div>

    <!-- Wishlist -->
    <div class="mt-6">
      <h2 class="font-semibold mb-4">ইচ্ছের তালিকা</h2>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-white p-4 rounded shadow flex items-center gap-4">
          <img src="https://images.unsplash.com/photo-1585386959984-a415522b831c" class="w-24 h-24 rounded">
          <div>
            <h3 class="font-semibold">Wireless Headphones</h3>
            <p class="text-gray-500">৳ 2,200</p>
            <button class="mt-2 bg-blue-600 text-white px-4 py-1 rounded text-sm">
              কার্টে যোগ করুন
            </button>
          </div>
        </div>

        <div class="bg-white p-4 rounded shadow flex items-center gap-4">
          <img src="https://images.unsplash.com/photo-1516574187841-cb9cc2ca948b" class="w-24 h-24 rounded">
          <div>
            <h3 class="font-semibold">Smart Watch</h3>
            <p class="text-gray-500">৳ 3,500</p>
            <button class="mt-2 bg-blue-600 text-white px-4 py-1 rounded text-sm">
              কার্টে যোগ করুন
            </button>
          </div>
        </div>
      </div>
    </div>

  </main>
</div>

</body>
</html>
