<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: user_dashbord.php");
} else {
    header("Location: login.php");
}
exit;
?>