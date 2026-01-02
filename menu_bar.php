<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body >
    <header class="bg-white shadow sticky top-0 z-50">
    
    <!-- HEADER MENU BAR -->
  <nav class="cls01 mt-10 fixed w-full z-50 hidden md:block">
    
    <div class="flex flex-nowrap overflow-x-auto">
        <ul class="shrink-0 ">
        <?php
        
        // 1️⃣ Load Categories
        $categories = $conn->query("SELECT * FROM categories");

        while ($cat = $categories->fetch_assoc()) {
            $cat_id = $cat['category_id'];

            echo '
            <li class="group border border-gray-400 rounded px-2 py-1 mb-3 hover:bg-indigo-500">
                <a class="text-gray-700 group-hover:text-black transition" href="index.php?category_id='.$cat['category_id'].'">'.$cat['category_name'].' ▼</a>';

            // 2️⃣ Load Subcategories
            $sub_query = $conn->query("SELECT * FROM subcategories WHERE category_id=$cat_id");

            echo '<ul>';

            while ($sub = $sub_query->fetch_assoc()) {

                $sub_id = $sub['subcategory_id'];

                echo '
                <li class="group-sub">
                    <a  href="index.php?subcategory_id='.$sub['subcategory_id'].'" class="cls02">'.$sub['subcategory_name'].' ►</a>';
                // 3️⃣ Load Brands
                $brand_query = $conn->query("SELECT * FROM brands WHERE subcategory_id=$sub_id");

                echo '<ul>';

                while ($brand = $brand_query->fetch_assoc()) {
                    echo '
                    <li>
                        <a href="index.php?brand_id='.$brand['brand_id'].'">
                            '.$brand['brand_name'].'
                        </a>
                    </li>';
                }


                echo '</ul></li>';
            }

            echo '</ul></li>';
        }
        ?>

            <!-- Static Items -->
            <li><a href="admin.php">Admin</a></li>
            <li><a href="shop.php">Shop</a></li>
            <li><a href="contact.php">Contact Us</a></li>
        </ul>
    </div>
</nav>



</header>
</body>
</html>