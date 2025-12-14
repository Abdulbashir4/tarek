<?php
// completed_orders.php
// Shows all Completed orders using your existing server_connection.php

include __DIR__ . "/server_connection.php"; // uses $conn (mysqli)

// Fetch completed orders
$completedOrders = [];

$sql = "SELECT order_id, customer_name, email, phone, address, city, postal_code, country, payment_method, total_amount, created_at, order_status, payment_status 
        FROM `orders`
        WHERE order_status = 'Completed'
        ORDER BY created_at DESC";

$result = $conn->query($sql);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $completedOrders[] = $row;
    }
}

$completedCount = count($completedOrders);

// CSV Export
if (isset($_GET['export']) && $_GET['export'] == 'csv') {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=completed_orders.csv');
    $out = fopen('php://output', 'w');
    if ($completedCount > 0) {
        fputcsv($out, array_keys($completedOrders[0]));
        foreach ($completedOrders as $row) {
            fputcsv($out, $row);
        }
    }
    fclose($out);
    exit;
}

function e($s) {
    return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Completed Orders</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="bg-gray-100 p-6">

<div class="max-w-6xl mx-auto">

    <h1 class="text-3xl font-bold mb-4">Completed Orders</h1>
    <p class="text-gray-600 mb-6">ই-কমার্স ড্যাশবোর্ড — এখানে Completed হওয়া সমস্ত অর্ডার দেখতে পাবেন</p>

    <div class="flex items-center gap-4 mb-6">
        <div class="bg-white shadow px-6 py-4 rounded-xl">
            <div class="text-gray-500 text-sm">Total Completed Orders</div>
            <div class="text-3xl font-bold text-green-600"><?= $completedCount ?></div>
        </div>

        <a href="?export=csv" class="px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700">
            Export CSV
        </a>
    </div>

    <div class="bg-white shadow rounded-lg overflow-x-auto">
        <?php if ($completedCount == 0): ?>
            <div class="p-6 text-center text-gray-600">No completed orders found.</div>
        <?php else: ?>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Created At</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Payment</th>
                </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-100">
                <?php foreach ($completedOrders as $o): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3"><?= e($o['order_id']) ?></td>
                        <td class="px-6 py-3"><?= e($o['customer_name']) ?></td>
                        <td class="px-6 py-3 text-gray-600"><?= e($o['email']) ?></td>
                        <td class="px-6 py-3 font-semibold"><?= number_format($o['total_amount'], 2) ?></td>
                        <td class="px-6 py-3 text-gray-500"><?= e($o['created_at']) ?></td>
                        <td class="px-6 py-3">
                            <?php
                            $ps = strtolower($o['payment_status']);
                            $badge = $ps == 'paid'
                                ? "bg-green-100 text-green-800"
                                : ($ps == 'refunded'
                                    ? "bg-red-100 text-red-800"
                                    : "bg-yellow-100 text-yellow-800");
                            ?>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold <?= $badge ?>">
                                <?= e($o['payment_status']) ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>

            </table>
        <?php endif; ?>
    </div>

</div>

</body>
</html>
