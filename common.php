<!DOCTYPE html>
<html lang="bn">
<head>
<meta charset="UTF-8">
<title>Admin Panel - Common Page</title>

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
    .sidebar a{
        display: block;
        padding: 10px 18px;
        color: #e5e7eb;
        text-decoration: none;
        font-size: 15px;
        border-bottom: 1px solid #111827;
    }
    .sidebar a:hover{
        background: #374151;
        color: #fff;
    }

    /* Content area */
    .content{
        flex: 1;
        padding: 15px;
        background: #e5e7eb;
    }

    .content iframe{
        width: 100%;
        height: 100%;
        border: none;
        background: #ffffff;
        box-shadow: 0 0 10px rgba(0,0,0,0.15);
        border-radius: 6px;
    }
</style>

</head>
<body>

<div class="header">
    Admin Dashboard
</div>

<div class="wrapper">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <a href="test1.php" target="content_frame">📊 Dashboard</a>
        <a href="add_product.php" target="content_frame">➕ Add Product</a>
        <a href="product-list.php" target="content_frame">📦 Product List</a>
        <a href="category-add.php" target="content_frame">🗃 Add Category</a>
        <a href="brand-add.php" target="content_frame">🏷 Add Brand</a>
        <a href="orders.php" target="content_frame">🧾 Orders</a>
    </div>

    <!-- BODY / CONTENT -->
    <div class="content">
        <!-- এখানে অন্য পেজগুলো লোড হবে -->
        <iframe name="content_frame" src="test1.php"></iframe>
    </div>

</div>

</body>
</html>
