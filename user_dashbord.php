<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require __DIR__ . "/server_connection.php";

$uid = (int)$_SESSION['user_id'];

$q = $conn->prepare("SELECT name, phone, profile_image FROM users WHERE id=?");
$q->bind_param("i", $uid); // ✅ FIXED
$q->execute();
$user = $q->get_result()->fetch_assoc();

$profile = $user['profile_image'] ?? 'default.png';
?>

<!DOCTYPE html>
<html lang="bn">
<head>
  <meta charset="UTF-8">
  <title>User Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="flex min-h-screen">

  <!-- Sidebar -->
  <aside class="w-64 bg-white shadow-lg">
    <div class="p-6 border-b">
      <img id="profilePreview"
         src="uploads/<?= htmlspecialchars($profile) ?>"
         class="w-20 h-20 rounded-full border object-cover mx-auto">
         <input type="file" id="profile_image" class="hidden" accept="image/*">

        <button onclick="profile_image.click()"
                class="mt-2 px-4 py-2 bg-blue-500 text-white rounded">
            Upload Profile Image
        </button>
      <h2 class="text-center font-semibold mt-2"><?php echo $_SESSION['name']; ?></h2>
      <p class="text-center text-sm text-gray-500"><?= htmlspecialchars($user['phone'] ?? '') ?></p>
      <p id="uploadMsg" class="mt-2 text-sm"></p>
    </div>

    <nav class="p-4 space-y-2">
      <a href="#" class="block bg-blue-600 text-white px-4 py-2 rounded">ড্যাশবোর্ড</a>
      <a href="#" class="block px-4 py-2 hover:bg-gray-100 rounded">আমার অর্ডার</a>
      <a href="#" class="block px-4 py-2 hover:bg-gray-100 rounded">ইচ্ছের তালিকা</a>
      <a href="#" class="block px-4 py-2 hover:bg-gray-100 rounded">কার্ট</a>
      <a href="#" class="block px-4 py-2 hover:bg-gray-100 rounded">ঠিকানা</a>
      <a href="index.php" class="block px-4 py-2 hover:bg-gray-100 rounded">Visit Shop</a>
      <a href="logout.php" class="block px-4 py-2 text-red-500 hover:bg-red-50 rounded">লগআউট</a>
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
<script>
profile_image.addEventListener("change", () => {
    const file = profile_image.files[0];
    if (!file) return;

    const fd = new FormData();
    fd.append("profile_image", file);

    uploadMsg.innerText = "Uploading...";

    fetch("ajax_upload_profile.php", {
        method: "POST",
        body: fd
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            profilePreview.src = data.image + "?t=" + Date.now();
            // ✅ header image update (no reload)
        const headerImg = document.getElementById("headerProfileImg");
        if (headerImg) {
            headerImg.src = data.image + "?t=" + Date.now();
        }
            uploadMsg.innerText = "Image updated";
        } else {
            uploadMsg.innerText = data.message;
        }
    })
    .catch(() => uploadMsg.innerText = "Server error");
});
</script>
</body>
</html>
