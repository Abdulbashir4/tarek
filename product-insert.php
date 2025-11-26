<?php
include "server_connection.php";

if($_SERVER['REQUEST_METHOD'] == "POST"){

    // Get form data
    $product_name       = $_POST['product_name'];
    $category_id        = $_POST['category_id'];
    $subcategory_id     = $_POST['subcategory_id'];
    $brand_id           = $_POST['brand_id'];
    $price              = $_POST['price'];
    $discount_price     = $_POST['discount_price'];
    $stock_qty          = $_POST['stock_qty'];
    $short_description  = $_POST['short_description'];
    $long_description   = $_POST['long_description'];


    // -----------------------------
    // IMAGE UPLOAD PROCESS
    // -----------------------------
    $image_name = $_FILES['product_image']['name'];
    $tmp = $_FILES['product_image']['tmp_name'];
    $folder = "uploads/products/";

    // If folder not exists → create it
    if(!is_dir($folder)){
        mkdir($folder, 0777, true);
    }

    // Create unique file name
    $new_image_name = time() . "_" . $image_name;

    // Move file to folder
    move_uploaded_file($tmp, $folder . $new_image_name);


    // ----------------------------------------
    // Insert Query
    // ----------------------------------------
    $sql = "INSERT INTO products 
    (product_name, category_id, subcategory_id, brand_id, price, discount_price, stock_qty, short_description, long_description, thumbnail)
    VALUES
    ('$product_name', '$category_id', '$subcategory_id', '$brand_id', '$price', '$discount_price', '$stock_qty', '$short_description', '$long_description', '$new_image_name')";


    if($conn->query($sql)){
        echo "<script>
                alert('Product Added Successfully!');
                window.location='product-add.php';
              </script>";
    }else{
        echo "<script>
                alert('Something went wrong: ".$conn->error."');
                history.back();
              </script>";
    }
}
?>
