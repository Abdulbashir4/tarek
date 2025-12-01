<!DOCTYPE html>
<html lang="bn">
<head>
<meta charset="UTF-8">
<title>Admin Panel - Common Page</title>
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

<style>
    body{
        margin: 0;
        font-family: Arial, sans-serif;
        background: #f4f4f4;
    }

    /* Header */
    .header{
        background: #111827;
        color: #fff;
        padding: 12px 20px;
        font-size: 18px;
        font-weight: bold;
    }

    /* Layout */
    .wrapper{
        display: flex;
        height: calc(100vh - 48px); /* header বাদে পুরো height */
    }

    /* Sidebar */
    .sidebar{
        width: 220px;
        background: #1f2937;
        color: #fff;
        padding-top: 15px;
    }
   

    /* Content area */
    .content{
        flex: 1;
        background: #e5e7eb;
    }

    .content iframe{
        width: 100%;
        height: 100%;
        border: none;
        background: #ffffff;
    }
</style>

</head>
<body>

<div class="header">
    Admin Dashboard
</div>

<div class="wrapper">

    <!-- SIDEBAR -->
    <div class="sidebar p-4">
        <a class="border-1 block px-4 py-2 rounded mb-2 hover:bg-gray-500 hover:text-white" href="test1.php" target="content_frame">📊 Dashboard</a>
        <a class="border-1 block px-4 py-2 rounded mb-2 hover:bg-gray-500 hover:text-white" href="add_product.php" target="content_frame">➕ Add Product</a>
        <a class="border-1 block px-4 py-2 rounded mb-2 hover:bg-gray-500 hover:text-white" href="product-list.php" target="content_frame">📦 Product List</a>
        <a class="border-1 block px-4 py-2 rounded mb-2 hover:bg-gray-500 hover:text-white" href="admin_orders.php" target="content_frame">📦 Order List</a>
        <a class="border-1 block px-4 py-2 rounded mb-2 hover:bg-gray-500 hover:text-white" href="add_catagory_sub&brand.php" target="content_frame">🗃 Add Category</a>
        <a class="border-1 block px-4 py-2 rounded mb-2 hover:bg-gray-500 hover:text-white" href="brand-add.php" target="content_frame">🏷 Add Brand</a>
        <a class="border-1 block px-4 py-2 rounded mb-2 hover:bg-gray-500 hover:text-white" href="order_tracking.php" target="content_frame">🧾 Orders tracking</a>
    </div>

    <!-- BODY / CONTENT -->
    <div class="content">
        <!-- এখানে অন্য পেজগুলো লোড হবে -->
        <iframe name="content_frame" src="test1.php"></iframe>
    </div>

</div>

</body>
</html>
