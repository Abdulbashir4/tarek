<?php
include 'server_connection.php';

if (isset($_FILES['csv_file']['tmp_name'])) {

    $file = fopen($_FILES['csv_file']['tmp_name'], 'r');

    // Skip header row
    fgetcsv($file);

    while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {

        $category_id    = mysqli_real_escape_string($conn, $data[0]);
        $category_name  = mysqli_real_escape_string($conn, $data[1]);
        $category_image = mysqli_real_escape_string($conn, $data[2]);

        $query = "INSERT INTO categories (category_id, category_name, category_image)
                  VALUES ('$category_id', '$category_name', '$category_image')
                  ON DUPLICATE KEY UPDATE
                  category_name='$category_name',
                  category_image='$category_image'";

        mysqli_query($conn, $query);
    }

    fclose($file);
    echo "CSV Successfully Uploaded!";
} else {
    echo "No file selected!";
}
?>