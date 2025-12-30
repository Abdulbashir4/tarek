<?php
include 'server_connection.php';

/* ================= DELETE ================= */
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM companies WHERE company_id=$id");
    header("Location: company_info.php");
    exit;
}

/* ================= EDIT LOAD ================= */
$edit = false;
$data = [];
if (isset($_GET['edit'])) {
    $edit = true;
    $id = (int)$_GET['edit'];
    $res = $conn->query("SELECT * FROM companies WHERE company_id=$id");
    $data = $res->fetch_assoc();
}

/* ================= INSERT / UPDATE ================= */
if (isset($_POST['save'])) {

    // Logo Upload
    $logo = $_POST['old_logo'] ?? '';
    if (!empty($_FILES['logo']['name'])) {
        $logo = time() . '_' . $_FILES['logo']['name'];
        move_uploaded_file($_FILES['logo']['tmp_name'], "uploads/" . $logo);
    }

    if (!empty($_POST['company_id'])) {
        // UPDATE
        $stmt = $conn->prepare("
            UPDATE companies SET
            company_name=?, logo=?, about_us=?,
            mobile_number=?, hotline_number=?, whatsapp_number=?, email=?,
            facebook_page=?, youtube_channel=?,
            office_address=?, google_map_location=?,
            support_hours=?, privacy_policy=?, terms_conditions=?,
            refund_policy=?, shipping_policy=?,
            average_rating=?, total_reviews=?, status=?
            WHERE company_id=?
        ");

        $stmt->bind_param(
            "sssssssssssssssdiiii",
            $_POST['company_name'], $logo, $_POST['about_us'],
            $_POST['mobile_number'], $_POST['hotline_number'], $_POST['whatsapp_number'], $_POST['email'],
            $_POST['facebook_page'], $_POST['youtube_channel'],
            $_POST['office_address'], $_POST['google_map_location'],
            $_POST['support_hours'], $_POST['privacy_policy'], $_POST['terms_conditions'],
            $_POST['refund_policy'], $_POST['shipping_policy'],
            $_POST['average_rating'], $_POST['total_reviews'], $_POST['status'],
            $_POST['company_id']
        );
    } else {
        // INSERT
        $stmt = $conn->prepare("
            INSERT INTO companies (
            company_name, logo, about_us,
            mobile_number, hotline_number, whatsapp_number, email,
            facebook_page, youtube_channel,
            office_address, google_map_location,
            support_hours, privacy_policy, terms_conditions,
            refund_policy, shipping_policy,
            average_rating, total_reviews, status
            ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
        ");

        $stmt->bind_param(
            "sssssssssssssssdiii",
            $_POST['company_name'], $logo, $_POST['about_us'],
            $_POST['mobile_number'], $_POST['hotline_number'], $_POST['whatsapp_number'], $_POST['email'],
            $_POST['facebook_page'], $_POST['youtube_channel'],
            $_POST['office_address'], $_POST['google_map_location'],
            $_POST['support_hours'], $_POST['privacy_policy'], $_POST['terms_conditions'],
            $_POST['refund_policy'], $_POST['shipping_policy'],
            $_POST['average_rating'], $_POST['total_reviews'], $_POST['status']
        );
    }

    $stmt->execute();
    header("Location: company_info.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Company CRUD</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 py-8">

<div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-6">

<!-- ================= FORM ================= -->
<div class="bg-white p-6 rounded shadow">
<h2 class="text-xl font-bold mb-4">
    <?= $edit ? 'Edit Company' : 'Add Company' ?>
</h2>

<form method="POST" enctype="multipart/form-data" class="space-y-3">
<input type="hidden" name="company_id" value="<?= $data['company_id'] ?? '' ?>">
<input type="hidden" name="old_logo" value="<?= $data['logo'] ?? '' ?>">

<input name="company_name" placeholder="Company Name" required
value="<?= $data['company_name'] ?? '' ?>"
class="w-full border px-3 py-2 rounded">

<input type="file" name="logo" class="w-full border px-3 py-2 rounded">

<textarea name="about_us" placeholder="About Us"
class="w-full border px-3 py-2 rounded"><?= $data['about_us'] ?? '' ?></textarea>

<div class="grid grid-cols-2 gap-2">
<input name="mobile_number" placeholder="Mobile" value="<?= $data['mobile_number'] ?? '' ?>" class="border px-2 py-1 rounded">
<input name="hotline_number" placeholder="Hotline" value="<?= $data['hotline_number'] ?? '' ?>" class="border px-2 py-1 rounded">
<input name="whatsapp_number" placeholder="WhatsApp" value="<?= $data['whatsapp_number'] ?? '' ?>" class="border px-2 py-1 rounded">
<input name="email" placeholder="Email" value="<?= $data['email'] ?? '' ?>" class="border px-2 py-1 rounded">
</div>

<div class="grid grid-cols-2 gap-2">
<input name="facebook_page" placeholder="Facebook Page" value="<?= $data['facebook_page'] ?? '' ?>" class="border px-2 py-1 rounded">
<input name="youtube_channel" placeholder="YouTube Channel" value="<?= $data['youtube_channel'] ?? '' ?>" class="border px-2 py-1 rounded">
</div>

<textarea name="office_address" placeholder="Office Address"
class="w-full border px-3 py-2 rounded"><?= $data['office_address'] ?? '' ?></textarea>

<input name="google_map_location" placeholder="Google Map URL"
value="<?= $data['google_map_location'] ?? '' ?>"
class="w-full border px-3 py-2 rounded">

<input name="support_hours" placeholder="Support Hours"
value="<?= $data['support_hours'] ?? '' ?>"
class="w-full border px-3 py-2 rounded">

<textarea name="privacy_policy" placeholder="Privacy Policy" class="w-full border px-3 py-2 rounded"><?= $data['privacy_policy'] ?? '' ?></textarea>
<textarea name="terms_conditions" placeholder="Terms & Conditions" class="w-full border px-3 py-2 rounded"><?= $data['terms_conditions'] ?? '' ?></textarea>
<textarea name="refund_policy" placeholder="Refund Policy" class="w-full border px-3 py-2 rounded"><?= $data['refund_policy'] ?? '' ?></textarea>
<textarea name="shipping_policy" placeholder="Shipping Policy" class="w-full border px-3 py-2 rounded"><?= $data['shipping_policy'] ?? '' ?></textarea>

<div class="grid grid-cols-3 gap-2">
<input type="number" step="0.1" name="average_rating" placeholder="Rating"
value="<?= $data['average_rating'] ?? 0 ?>" class="border px-2 py-1 rounded">

<input type="number" name="total_reviews" placeholder="Total Reviews"
value="<?= $data['total_reviews'] ?? 0 ?>" class="border px-2 py-1 rounded">

<select name="status" class="border px-2 py-1 rounded">
    <option value="1" <?= (($data['status'] ?? 1)==1)?'selected':'' ?>>Active</option>
    <option value="0" <?= (($data['status'] ?? 1)==0)?'selected':'' ?>>Inactive</option>
</select>
</div>

<button name="save"
class="w-full <?= $edit ? 'bg-green-600' : 'bg-blue-600' ?> text-white py-2 rounded">
<?= $edit ? 'Update Company' : 'Save Company' ?>
</button>
</form>
</div>

<!-- ================= LIST ================= -->
<div class="bg-white p-6 rounded shadow">
<h2 class="text-xl font-bold mb-4">Company List</h2>

<table class="w-full border text-sm">
<tr class="bg-gray-200">
<th class="border p-2">Name</th>
<th class="border p-2">Status</th>
<th class="border p-2">Action</th>
</tr>

<?php
$q = $conn->query("SELECT * FROM companies ORDER BY company_id DESC");
while ($row = $q->fetch_assoc()) {
?>
<tr>
<td class="border p-2"><?= $row['company_name'] ?></td>
<td class="border p-2"><?= $row['status'] ? 'Active' : 'Inactive' ?></td>
<td class="border p-2 text-center space-x-2">
<a href="?edit=<?= $row['company_id'] ?>" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</a>
<a href="?delete=<?= $row['company_id'] ?>"
onclick="return confirm('Are you sure?')"
class="bg-red-600 text-white px-2 py-1 rounded">Delete</a>
</td>
</tr>
<?php } ?>
</table>
</div>

</div>
</body>
</html>
