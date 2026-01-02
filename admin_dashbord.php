<?php
include 'server_connection.php';

// ============================
// Fetch Completed Orders + Total Sale
// ============================

$completedOrders = [];
$totalSale = 0;

$sql = "SELECT * FROM orders WHERE order_status = 'Completed'";
$result = $conn->query($sql);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $completedOrders[] = $row;
        $totalSale += (float)$row['total_amount']; // total sale sum
    }
}

$total_completed = count($completedOrders);

// ============================
// Order Counters
// ============================

// Total orders
$total_orders = $conn->query("SELECT COUNT(*) AS total FROM orders")->fetch_assoc()['total'];

// Pending
$pending_orders = $conn->query("SELECT COUNT(*) AS total FROM orders WHERE order_status = 'Pending'")->fetch_assoc()['total'];

// Processing
$processing_orders = $conn->query("SELECT COUNT(*) AS total FROM orders WHERE order_status = 'Processing'")->fetch_assoc()['total'];

// Shipped
$shipped_orders = $conn->query("SELECT COUNT(*) AS total FROM orders WHERE order_status = 'Shipped'")->fetch_assoc()['total'];

// Cancelled
$cancelled_orders = $conn->query("SELECT COUNT(*) AS total FROM orders WHERE order_status = 'Cancelled'") ->fetch_assoc()['total'];
?>

<!doctype html>
<html lang="bn">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Admin Dashboard — ShopPro</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <style>
    :root{ --sidebar-w:18rem; }
    /* subtle scrollbar for panel */
    .scrollbar-thin::-webkit-scrollbar { height:8px; width:8px; }
    .scrollbar-thin::-webkit-scrollbar-thumb { background:rgba(0,0,0,0.12); border-radius:8px; }
    /* small helper for KPI delta color */
    .delta-up { color: #16a34a; }
    .delta-down { color: #dc2626; }
  </style>
</head>
<body class="bg-gray-100 text-gray-800 font-sans">

<!-- Page wrapper -->
<div class="min-h-screen flex">
  

  

  <!-- Main content -->
  <div class="flex-1 min-h-screen">   

    <!-- PAGE BODY -->
    <main class="max-w-7xl mx-auto px-4 py-6 grid grid-cols-1 lg:grid-cols-12 gap-6">

      <!-- Left: KPIs + Chart -->
      <section class="lg:col-span-8 space-y-6">

        <!-- KPI Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
          <div class="bg-white p-4 rounded shadow flex items-center justify-between">
            <div>
              <div class="text-xs text-gray-500">Total Sales  = <?= $total_completed ?></div>
              <div class="text-2xl font-bold">৳<?= number_format($totalSale, 2) ?></div>
              <div class="text-xs text-gray-500 mt-1"><span class="delta-up">+8.4%</span> vs last week</div>
            </div>
          </div>

          <div class="bg-white p-4 rounded shadow flex items-center justify-between">
            <div>
              <div class="text-xs text-gray-500">Total Orders</div>
              <div class="text-2xl font-bold"><?= $total_orders ?></div>
              <div class="text-xs text-gray-500 mt-1"><span class="delta-down">-2.1%</span> vs last week</div>
            </div>
          </div>
          <div class="bg-white p-4 rounded shadow flex items-center justify-between">
            <div>
              <div class="text-xs text-gray-500">Order Pending</div>
              <div class="text-2xl font-bold"><?= $pending_orders ?> </div>
              <div class="text-xs text-gray-500 mt-1"><span class="delta-up">+8.4%</span> vs last week</div>
            </div>
          </div>

          <div class="bg-white p-4 rounded shadow flex items-center justify-between">
            <div>
              <div class="text-xs text-gray-500">Cancel Orders</div>
              <div class="text-2xl font-bold"><?= $cancelled_orders ?></div>
              <div class="text-xs text-gray-500 mt-1"><span class="delta-down">-2.1%</span> vs last week</div>
            </div>
          </div>
          <div class="bg-white p-4 rounded shadow flex items-center justify-between">
            <div>
              <div class="text-xs text-gray-500">Order Processing</div>
              <div class="text-2xl font-bold"><?= $processing_orders ?></div>
              <div class="text-xs text-gray-500 mt-1"><span class="delta-up">+8.4%</span> vs last week</div>
            </div>
          </div>

          <div class="bg-white p-4 rounded shadow flex items-center justify-between">
            <div>
              <div class="text-xs text-gray-500">Orders Shipped</div>
              <div class="text-2xl font-bold"><?= $shipped_orders ?>
</div>
              <div class="text-xs text-gray-500 mt-1"><span class="delta-down">-2.1%</span> vs last week</div>
            </div>
            <div class="bg-amber-50 p-3 rounded">
              <svg class="w-8 h-8 text-amber-600" viewBox="0 0 24 24" fill="none"><path d="M3 7h18" stroke="currentColor" stroke-width="2"/></svg>
            </div>
          </div>

          <div class="bg-white p-4 rounded shadow flex items-center justify-between">
            <div>
              <div class="text-xs text-gray-500">Customers</div>
              <div class="text-2xl font-bold">8,214</div>
              <div class="text-xs text-gray-500 mt-1"><span class="delta-up">+3.2%</span></div>
            </div>
            <div class="bg-green-50 p-3 rounded">
              <svg class="w-8 h-8 text-green-600" viewBox="0 0 24 24" fill="none"><path d="M12 2v20" stroke="currentColor" stroke-width="2"/></svg>
            </div>
          </div>

          <div class="bg-white p-4 rounded shadow flex items-center justify-between">
            <div>
              <div class="text-xs text-gray-500">Revenue</div>
              <div class="text-2xl font-bold">$56,430</div>
              <div class="text-xs text-gray-500 mt-1"><span class="delta-up">+12.6%</span></div>
            </div>
            <div class="bg-pink-50 p-3 rounded">
              <svg class="w-8 h-8 text-pink-600" viewBox="0 0 24 24" fill="none"><path d="M3 12h18" stroke="currentColor" stroke-width="2"/></svg>
            </div>
          </div>
        </div>

        <!-- Revenue Chart + small stats -->
        <div class="bg-white rounded shadow p-4">
          <div class="flex items-center justify-between mb-3">
            <h3 class="text-lg font-semibold">Revenue (Last 30 days)</h3>
            <div class="text-sm text-gray-500">Updated 2h ago</div>
          </div>

          <!-- simple sparkline area (placeholder) -->
          <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="md:col-span-3">
              <div class="w-full h-44 bg-gradient-to-b from-indigo-50 to-white rounded p-3">
                <!-- tiny svg area chart -->
                <svg viewBox="0 0 400 120" class="w-full h-full">
                  <defs>
                    <linearGradient id="g" x1="0" x2="0" y1="0" y2="1">
                      <stop offset="0%" stop-color="#6366F1" stop-opacity="0.18"></stop>
                      <stop offset="100%" stop-color="#A78BFA" stop-opacity="0"></stop>
                    </linearGradient>
                  </defs>
                  <path d="M0 80 L50 60 L100 40 L150 50 L200 30 L250 20 L300 35 L350 25 L400 20 L400 120 L0 120 Z" fill="url(#g)"></path>
                  <path d="M0 80 L50 60 L100 40 L150 50 L200 30 L250 20 L300 35 L350 25 L400 20" fill="none" stroke="#6366F1" stroke-width="3" stroke-linejoin="round" stroke-linecap="round"></path>
                </svg>
              </div>
            </div>

            <div class="md:col-span-1 flex flex-col gap-2">
              <div class="bg-gray-50 p-3 rounded">
                <div class="text-xs text-gray-500">Avg Order Value</div>
                <div class="font-semibold">$42.70</div>
              </div>
              <div class="bg-gray-50 p-3 rounded">
                <div class="text-xs text-gray-500">Conversion Rate</div>
                <div class="font-semibold">3.2%</div>
              </div>
              <div class="bg-gray-50 p-3 rounded">
                <div class="text-xs text-gray-500">Refund Rate</div>
                <div class="font-semibold text-red-600">0.6%</div>
              </div>
            </div>
          </div>
        </div>

        <!-- Recent Orders table -->
        <div class="bg-white rounded shadow p-4">
          <div class="flex items-center justify-between mb-3">
            <h3 class="text-lg font-semibold">Recent Orders</h3>
            <div class="flex items-center gap-2">
              <input id="ordersFilter" class="border rounded px-3 py-1 text-sm" placeholder="Filter by customer or id...">
              <button id="refreshOrders" class="px-3 py-1 bg-indigo-600 text-white rounded text-sm">Refresh</button>
            </div>
          </div>

          <div class="overflow-x-auto">
            <table class="w-full text-sm">
              <thead class="text-left text-gray-500 bg-gray-50">
                <tr>
                  <th class="p-3">Order</th>
                  <th class="p-3">Customer</th>
                  <th class="p-3">Total</th>
                  <th class="p-3">Status</th>
                  <th class="p-3">Date</th>
                  <th class="p-3">Action</th>
                </tr>
              </thead>
              <tbody id="ordersTable">
                <!-- rows populated by JS -->
              </tbody>
            </table>
          </div>
        </div>

      </section>

      <!-- Right: Products / Activity -->
      <aside class="lg:col-span-4 space-y-6">

        <!-- Quick Actions -->
        <div class="bg-white rounded shadow p-4">
          <h3 class="font-semibold mb-3">Quick Actions</h3>
          <div class="grid grid-cols-2 gap-2">
            <a class="p-3 bg-indigo-600 text-white rounded" href="add_product.php">Add Product</a>
            <button class="p-3 bg-amber-500 text-white rounded">Add Discount</button>
            <button class="p-3 bg-green-600 text-white rounded">Export CSV</button>
            <button class="p-3 bg-gray-200 rounded">Settings</button>
          </div>
        </div>

        <!-- Products list -->
        <div class="bg-white rounded shadow p-4">
          <h3 class="font-semibold mb-3">Top Products</h3>
          <div class="space-y-3" id="productList">
            <!-- product cards by JS -->
          </div>
        </div>

        <!-- Activity / Messages -->
        <div class="bg-white rounded shadow p-4">
          <h3 class="font-semibold mb-3">Activity</h3>
          <ul class="text-sm text-gray-600 space-y-2">
            <li>🟢 New user signed up — <span class="text-gray-500">10m ago</span></li>
            <li>📦 Order #2712 shipped — <span class="text-gray-500">30m ago</span></li>
            <li>⚠️ Payment failed — <span class="text-gray-500">2h ago</span></li>
          </ul>
        </div>

      </aside>

    </main>

    <!-- FOOTER -->
    <footer class="bg-white border-t mt-6">
      <div class="max-w-7xl mx-auto px-4 py-4 text-sm text-gray-500 text-center">
        © 2025 ShopPro • Admin Dashboard
      </div>
    </footer>

  </div>
</div>

<!-- SCRIPTS: demo data & interactivity -->

</body>
</html>
