<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Payment Successful</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">

  <div class="bg-white shadow-lg rounded-2xl p-10 max-w-lg text-center">

    <!-- Success Icon -->
    <div class="flex justify-center mb-6">
      <div class="w-20 h-20 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-5xl">
        ✔
      </div>
    </div>

    <!-- Success Message -->
    <h1 class="text-3xl font-bold text-green-600 mb-3">Payment Successful!</h1>
    <p class="text-gray-600 mb-6 text-lg">
      Thank you for your purchase. Your payment has been received successfully.
    </p>

    <!-- Order Summary Box -->
    <div class="bg-gray-50 p-5 rounded-lg shadow mb-6 text-left space-y-2">
      <p class="text-gray-700"><strong>Order ID:</strong> #SP-2025-00123</p>
      <p class="text-gray-700"><strong>Payment Method:</strong> bKash</p>
      <p class="text-gray-700"><strong>Amount Paid:</strong> $448</p>
      <p class="text-gray-700"><strong>Status:</strong> <span class="text-green-600 font-semibold">Paid</span></p>
    </div>

    <!-- Buttons -->
    <div class="flex flex-col md:flex-row gap-4 justify-center">
      <a href="order_tracking.php" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 w-full md:w-auto text-center">Continue Shopping</a>
      <a href="index.php" class="border border-indigo-600 text-indigo-600 px-6 py-3 rounded-lg hover:bg-indigo-50 w-full md:w-auto text-center">Go Home</a>
    </div>

  </div>

</body>
</html>