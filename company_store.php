<?php
include 'server_connection.php';

$logoName = null;
if (!empty($_FILES['logo']['name'])) {
    $logoName = time() . $_FILES['logo']['name'];
    move_uploaded_file($_FILES['logo']['tmp_name'], "uploads/" . $logoName);
}

$sql = "INSERT INTO companies (
    company_name, logo, about_us, mobile_number, hotline_number,
    whatsapp_number, email, facebook_page, youtube_channel,
    office_address, google_map_location, support_hours,
    privacy_policy, terms_conditions, refund_policy, shipping_policy,
    average_rating, total_reviews
) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "ssssssssssssssssdi",
    $_POST['company_name'],
    $logoName,
    $_POST['about_us'],
    $_POST['mobile_number'],
    $_POST['hotline_number'],
    $_POST['whatsapp_number'],
    $_POST['email'],
    $_POST['facebook_page'],
    $_POST['youtube_channel'],
    $_POST['office_address'],
    $_POST['google_map_location'],
    $_POST['support_hours'],
    $_POST['privacy_policy'],
    $_POST['terms_conditions'],
    $_POST['refund_policy'],
    $_POST['shipping_policy'],
    $_POST['average_rating'],
    $_POST['total_reviews']
);

$stmt->execute();

header("Location: company_info.php?success=1");
