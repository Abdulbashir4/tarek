<?php include "server_connection.php"; ?>

<!DOCTYPE html>
<html lang="bn">
<head>
<meta charset="UTF-8">
<title>Product Add</title>
<style>

body{
    font-family: Arial, sans-serif;
    background: #f2f4f7;
    margin: 0;
    padding: 0;
}

.container{
    width: 800px;
    margin: 40px auto;
    background: #fff;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.15);
}

h2{
    text-align: center;
    margin-bottom: 25px;
    color: #444;
}

.form-group{
    margin-bottom: 15px;
}

label{
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
    color: #444;
}

input[type="text"],
input[type="number"],
input[type="file"],
textarea,
select{
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    outline: none;
    font-size: 15px;
    box-sizing: border-box;
}

textarea{
    min-height: 80px;
}

button{
    width: 100%;
    padding: 12px;
    background: #1e73be;
    border: none;
    color: #fff;
    font-size: 17px;
    border-radius: 6px;
    cursor: pointer;
    transition: 0.3s;
}

button:hover{
    background: #155a90;
}

.row{
    display: flex;
    gap: 20px;
}

.row .form-group{
    flex: 1;
}

</style>
</head>
<body>

<div class="container">

<h2>প্রডাক্ট যোগ করুন</h2>

<form action="product-insert.php" method="POST" enctype="multipart/form-data">

    <div class="form-group">
        <label>প্রডাক্ট নাম *</label>
        <input type="text" name="product_name" required>
    </div>

    <div class="row">
        <div class="form-group">
            <label>ক্যাটাগরি *</label>
            <select name="category_id" required>
                <option value="">নির্বাচন করুন</option>
                <?php

                $cats = $conn->query("SELECT * FROM categories");
                while($c = $cats->fetch_assoc()){
                    echo "<option value='{$c['category_id']}'>{$c['category_name']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label>সাবক্যাটাগরি *</label>
            <select name="subcategory_id" required>
                <option value="">নির্বাচন করুন</option>
                <?php
                $subs = $conn->query("SELECT * FROM subcategories");
                while($s = $subs->fetch_assoc()){
                    echo "<option value='{$s['subcategory_id']}'>{$s['subcategory_name']}</option>";
                }
                ?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label>ব্র্যান্ড *</label>
        <select name="brand_id" required>
            <option value="">নির্বাচন করুন</option>
            <?php
            $brands = $conn->query("SELECT * FROM brands");
            while($b = $brands->fetch_assoc()){
                echo "<option value='{$b['brand_id']}'>{$b['brand_name']}</option>";
            }
            ?>
        </select>
    </div>

    <div class="row">
        <div class="form-group">
            <label>মূল দাম *</label>
            <input type="number" name="price" required>
        </div>

        <div class="form-group">
            <label>ডিসকাউন্ট দাম</label>
            <input type="number" name="discount_price">
        </div>
    </div>

    <div class="form-group">
        <label>স্টকে আছে কত পিস *</label>
        <input type="number" name="stock_qty" required>
    </div>

    <div class="form-group">
        <label>সংক্ষিপ্ত বিবরণ</label>
        <textarea name="short_description"></textarea>
    </div>

    <div class="form-group">
        <label>সম্পূর্ণ বিবরণ</label>
        <textarea name="long_description" style="height:150px;"></textarea>
    </div>

    <div class="form-group">
        <label>প্রডাক্ট ইমেজ *</label>
        <input type="file" name="product_image" required>
    </div>

    <button type="submit">সাবমিট করুন</button>

</form>

</div>

</body>
</html>
