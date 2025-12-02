<?php
session_start();
include "server_connection.php";

// LOGIN PROTECTION
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
$user_email = $_SESSION['user_email'];

// Load user's orders (match email from orders table)
$orders = $conn->query("SELECT * FROM orders WHERE email='$user_email' ORDER BY order_id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-gray-100 min-h-screen">

    <!-- TOP NAVBAR -->
    <header class="bg-white shadow p-4 flex justify-between items-center sticky top-0">
        <h1 class="text-2xl font-bold text-indigo-600">User Dashboard</h1>

        <div class="flex items-center gap-4">
            <span class="text-gray-700 font-medium">👤 <?php echo $user_name; ?></span>

            <a href="logout.php" 
               class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
               Logout
            </a>
        </div>
    </header>

    <!-- DASHBOARD WRAPPER -->
    <div class="max-w-6xl mx-auto p-6 mt-6">

        <!-- USER INFO CARD -->
        <div class="bg-white p-6 rounded-lg shadow mb-8">
            <h2 class="text-xl font-bold mb-4 text-indigo-600">Your Profile</h2>
            
            <p class="text-gray-700"><strong>Name:</strong> <?php echo $user_name; ?></p>
            <p class="text-gray-700"><strong>Email:</strong> <?php echo $user_email; ?></p>

            <div class="mt-4">
                <a href="edit_profile.php" 
                   class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                   Edit Profile
                </a>
            </div>
        </div>

        <!-- ORDER HISTORY -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-bold mb-4 text-indigo-600">Your Orders</h2>

            <?php if($orders->num_rows == 0): ?>
                <p class="text-gray-500">No orders found!</p>
            <?php else: ?>

            <div class="overflow-x-auto">
                <table class="min-w-full border text-left">
                    <thead>
                        <tr class="bg-gray-100 border-b">
                            <th class="py-3 px-4">Order ID</th>
                            <th class="py-3 px-4">Amount</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4">Date</th>
                            <th class="py-3 px-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php while($o = $orders->fetch_assoc()): ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4 font-semibold">#<?php echo $o['order_id']; ?></td>

                            <td class="py-3 px-4"><?php echo $o['total_amount']; ?> TK</td>

                            <td class="py-3 px-4">
                                <span class="px-3 py-1 rounded-full text-sm
                                    <?php 
                                        if($o['order_status']=='Completed') echo 'bg-green-100 text-green-700';
                                        elseif($o['order_status']=='Processing') echo 'bg-yellow-100 text-yellow-700';
                                        elseif($o['order_status']=='Shipped') echo 'bg-blue-100 text-blue-700';
                                        else echo 'bg-gray-100 text-gray-700';
                                    ?>">
                                    <?php echo $o['order_status']; ?>
                                </span>
                            </td>

                            <td class="py-3 px-4 text-gray-600">
                                <?php echo $o['created_at']; ?>
                            </td>

                            <td class="py-3 px-4">
                                <a href="track-order.php?order_id=<?php echo $o['order_id']; ?>"
                                   class="text-indigo-600 hover:underline">
                                   Track Order
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>

                    </tbody>
                </table>
            </div>

            <?php endif; ?>

        </div>

    </div>

</body>
</html>
