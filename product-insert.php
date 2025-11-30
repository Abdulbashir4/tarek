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

    
// MULTIPLE GALLERY IMAGE UPLOAD
    // --------------------------------
    $gallery_images = [];  // Array where all gallery images will be stored

    if(isset($_FILES['product_gallery_image']['name'])){
        
        $total_files = count($_FILES['product_gallery_image']['name']);
        
        for($i = 0; $i < $total_files; $i++){

            $g_name = $_FILES['product_gallery_image']['name'][$i];
            $g_tmp  = $_FILES['product_gallery_image']['tmp_name'][$i];

            if($g_name != ""){
                $g_new_name = time() . "_" . rand(1000,9999) . "_" . $g_name;
                move_uploaded_file($g_tmp, $folder . $g_new_name);

                // Add to array
                $gallery_images[] = $g_new_name;
            }
        }
    }

    // Convert gallery array → JSON
    $gallery_json = json_encode($gallery_images);





    // ----------------------------------------
    // Insert Query
    // ----------------------------------------
    $sql = "INSERT INTO products 
    (product_name, category_id, subcategory_id, brand_id, price, discount_price, stock_qty, short_description, long_description, thumbnail, gallery_images)
    VALUES
    ('$product_name', '$category_id', '$subcategory_id', '$brand_id', '$price', '$discount_price', '$stock_qty', '$short_description', '$long_description', '$new_image_name', '$gallery_json')";


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
