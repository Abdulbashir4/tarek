<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Order Tracking</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6 flex justify-center items-start">

  <div class="bg-white shadow-xl rounded-2xl p-8 w-full max-w-3xl mt-10">

    <!-- Header -->
    <h1 class="text-3xl font-bold text-indigo-600 mb-6 text-center">Track Your Order</h1>

    <!-- Tracking Input -->
    <div class="bg-gray-50 p-5 rounded-xl shadow mb-8">
      <label class="block font-semibold mb-2 text-gray-700">Enter Your Order ID</label>
      <div class="flex gap-3">
        <input type="text" placeholder="Example: SP-2025-00123" class="flex-1 border px-4 py-2 rounded-lg" />
        <button class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">Track</button>
      </div>
    </div>

    <!-- Tracking Status Box -->
    <div class="mt-10">
      <h2 class="text-2xl font-bold mb-4">Order Status</h2>

      <!-- DELIVERY COUNTDOWN -->
<div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded mb-6">
<h3 class="text-lg font-semibold text-yellow-700">Estimated Delivery Countdown</h3>
<p class="text-gray-700 mt-1">Your package will be delivered in:</p>
<p id="countdown" class="text-3xl font-bold text-yellow-600 mt-2"></p>
</div>

      <div class="relative border-l-4 border-indigo-600 pl-6 space-y-10">

        <!-- Step 1 -->
        <div class="flex items-start gap-4">
          <div class="w-6 h-6 bg-indigo-600 rounded-full"></div>
          <div>
            <h3 class="text-lg font-semibold">Order Placed</h3>
            <p class="text-gray-600 text-sm">Your order has been successfully placed.</p>
            <p class="text-gray-500 text-xs mt-1">Date: Jan 14, 2025</p>
          </div>
        </div>

        <!-- Step 2 -->
        <div class="flex items-start gap-4">
          <div class="w-6 h-6 bg-indigo-600 rounded-full"></div>
          <div>
            <h3 class="text-lg font-semibold">Processing</h3>
            <p class="text-gray-600 text-sm">Your order is being prepared.</p>
            <p class="text-gray-500 text-xs mt-1">Estimated: Jan 16, 2025</p>
          </div>
        </div>

        <!-- Step 3 -->
        <div class="flex items-start gap-4">
          <div class="w-6 h-6 bg-gray-300 rounded-full"></div>
          <div>
            <h3 class="text-lg font-semibold">Shipped</h3>
            <p class="text-gray-600 text-sm">Your package is on the way.</p>
          </div>
        </div>

        <!-- Step 4 -->
        <div class="flex items-start gap-4">
          <div class="w-6 h-6 bg-gray-300 rounded-full"></div>
          <div>
            <h3 class="text-lg font-semibold">Delivered</h3>
            <p class="text-gray-600 text-sm">Package will be delivered soon.</p>
          </div>
        </div>

      </div>
    </div>

    <!-- Buttons -->
    <div class="mt-10 text-center flex flex-col md:flex-row gap-4 justify-center">
      <a href="shop.php" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 w-full md:w-auto">Continue Shopping</a>
      <a href="index.php" class="border border-indigo-600 text-indigo-600 px-6 py-3 rounded-lg hover:bg-indigo-50 w-full md:w-auto">Go Home</a>
    </div>

  </div>
<script>
// Delivery countdown (3 days from now)
const deliveryDate = new Date();
deliveryDate.setDate(deliveryDate.getDate() + 3);


function updateCountdown() {
const now = new Date().getTime();
const distance = deliveryDate - now;


if (distance <= 0) {
document.getElementById('countdown').innerHTML = "Delivered";
return;
}


const days = Math.floor(distance / (1000 * 60 * 60 * 24));
const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
const seconds = Math.floor((distance % (1000 * 60)) / 1000);


document.getElementById('countdown').innerHTML =
`${days}d ${hours}h ${minutes}m ${seconds}s`;
}


setInterval(updateCountdown, 1000);
</script>
</body>
</html>
