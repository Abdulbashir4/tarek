<?php
include 'server_connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body>
    <div class="mt-10">

      <div class="mt-10">
        <h2 class="mb-4 text-xl font-bold">Add Category</h2>
          <form method="POST">
              <input type="text" name="category_name" placeholder="Category Name" required class="border p-2">
              <button type="submit" name="add_category" class="bg-indigo-600 text-white px-3 py-2 rounded">Add Catagory</button>
          </form>

          <?php
          if(isset($_POST['add_category'])){
              $name = $_POST['category_name'];
              $insert = "INSERT INTO categories (category_name) VALUES ('$name')";
              $conn->query($insert);
              echo "Category added successfully!";
          }
          ?>
      </div>

      <div class="mt-10">

          <h2 class="mb-4 text-xl font-bold">Add Subcategory</h2>

          <form method="POST">

              <select name="category_id" required class="border p-2">
                  <option value="">Select Category</option>

                  <?php
                  $cats = $conn->query("SELECT * FROM categories");
                  while($c = $cats->fetch_assoc()){
                      echo '<option value="'.$c['category_id'].'">'.$c['category_name'].'</option>';
                  }
                  ?>
              </select>

              <input type="text" name="subcategory_name" placeholder="Subcategory Name" required class="border p-2">

              <button type="submit" name="add_subcategory" class="bg-indigo-600 text-white px-3 py-2 rounded">Add</button>
          </form>

            <?php
            if(isset($_POST['add_subcategory'])){
                $cid = $_POST['category_id'];
                $name = $_POST['subcategory_name'];
                $insert = "INSERT INTO subcategories (category_id, subcategory_name) VALUES ($cid, '$name')";
                $conn->query($insert);
                echo "Subcategory added!";
            }
            ?>
      </div>
      <div class="mt-10">
                <h2>Add Brands</h2>

                <form method="POST">

                    <select name="subcategory_id" required class="border p-2">
                        <option value="">Select Subcategory</option>

                        <?php
                        $subs = $conn->query("SELECT * FROM subcategories");
                        while($s = $subs->fetch_assoc()){
                            echo '<option value="'.$s['subcategory_id'].'">'.$s['subcategory_name'].'</option>';
                        }
                        ?>
                    </select>

                    <input type="text" name="brand_name" placeholder="Brand Name" required class="border p-2">

                    <button type="submit" name="add_brand" class="bg-indigo-600 text-white px-3 py-1">Add</button>
                </form>

              <?php
              if(isset($_POST['add_brand'])){
                  $sid = $_POST['subcategory_id'];
                  $name = $_POST['brand_name'];
                  $insert = "INSERT INTO brands (subcategory_id, brand_name) VALUES ($sid, '$name')";
                  $conn->query($insert);
                  echo "Brand added!";
              }
              ?>

      </div>
</body>
</html>