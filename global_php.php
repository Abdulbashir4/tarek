<?php
include 'server_connection.php';
$com = "SELECT * FROM companies";
$compa = $conn->query($com);
$company = $compa->fetch_assoc();

$cat = "SELECT * FROM categories";
$cate =$conn->query($cat);




?>