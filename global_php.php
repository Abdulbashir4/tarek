<?php
include 'server_connection.php';
$sql = "SELECT * FROM companies";
$logo = $conn->query($sql);
$company = $logo->fetch_assoc();






?>