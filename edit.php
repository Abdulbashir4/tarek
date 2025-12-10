<?php
// edit_product.php - fixed, prepared, thumbnail replace + gallery append
include "server_connection.php";
session_start();

// OPTIONAL: admin auth
// if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) { header('Location: login.php'); exit; }

function esc($v){ return htmlspecialchars($v ?? '', ENT_QUOTES); }

$uploadDir = __DIR__ . '/uploads/products/';
$webUploadDir = 'uploads/products/';

// ensure upload folder
if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

// helper to bind params with dynamic types
function mysqli_bind_params($stmt, $params) {
    // $params: array of values
    $types = '';
    foreach ($params as $v) {
        if (is_int($v)) $types .= 'i';
        elseif (is_float($v)) $types .= 'd';
        else $types .= 's';
    }
    // bind_param requires references
    $bind_names[] = $types;
    for ($i=0; $i<count($params); $i++) {
        $bind_names[] = &$params[$i];
    }
    return call_user_func_array([$stmt, 'bind_param'], $bind_names);
}

// POST -> handle update
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
    if ($product_id <= 0) { $error = "Invalid product id"; }

    // fetch current row
    if (!$error) {
        $s = $conn->prepare("SELECT thumbnail, gallery_images FROM products WHERE product_id = ?");
        $s->bind_param("i", $product_id);
        $s->execute();
        $cur = $s->get_result()->fetch_assoc();
        $s->close();
        if (!$cur) $error = "Product not found";
    }

    // collect inputs
    $product_name = trim($_POST['product_name'] ?? '');
    $category_id = (int)($_POST['category_id'] ?? 0);
    $subcategory_id = (int)($_POST['subcategory_id'] ?? 0);
    $brand_id = (int)($_POST['brand_id'] ?? 0);
    $price = isset($_POST['price']) ? (float)$_POST['price'] : 0.0;
    $discount_raw = $_POST['discount_price'] ?? '';
    $discount_price = ($discount_raw === '' ? 0.00 : (float)$discount_raw);
    $stock_qty = (int)($_POST['stock_qty'] ?? 0);
    $short_description = $_POST['short_description'] ?? '';
    $long_description = $_POST['long_description'] ?? '';
    $status = isset($_POST['status']) ? (int)$_POST['status'] : 1;

    if ($product_name === '') $error = "Product name is required.";

    // prepare old values
    $oldThumb = $cur['thumbnail'] ?? '';
    $oldGallery = $cur['gallery_images'] ? json_decode($cur['gallery_images'], true) : [];

    // ---------- handle thumbnail upload ----------
    $newThumbName = $oldThumb;
    if (empty($error) && !empty($_FILES['product_image']['name'])) {
        $f = $_FILES['product_image'];
        if ($f['error'] !== UPLOAD_ERR_OK) {
            $error = "Thumbnail upload error (code {$f['error']}).";
        } else {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mtype = finfo_file($finfo, $f['tmp_name']);
            finfo_close($finfo);
            $allowed = ['image/jpeg','image/png','image/webp','image/gif'];
            if (!in_array($mtype, $allowed)) {
                $error = "Unsupported thumbnail format. Use JPG/PNG/WEBP/GIF.";
            } else {
                $ext = pathinfo($f['name'], PATHINFO_EXTENSION);
                $newThumbName = uniqid('p_') . '.' . $ext;
                $dest = $uploadDir . $newThumbName;
                if (!move_uploaded_file($f['tmp_name'], $dest)) {
                    $error = "Failed to move thumbnail. Check folder permissions.";
                } else {
                    // remove old file
                    if (!empty($oldThumb) && file_exists($uploadDir . $oldThumb) && $oldThumb !== $newThumbName) {
                        @unlink($uploadDir . $oldThumb);
                    }
                }
            }
        }
    }

    // ---------- perform update with prepared statement ----------
    if (empty($error)) {
        // Build params array in correct order:
        $params = [
            $product_name,
            $category_id,
            $subcategory_id,
            $brand_id,
            $price,
            $discount_price,
            $stock_qty,
            $short_description,
            $long_description,
            $newThumbName,
            $status,
            $product_id
        ];

        $sql = "UPDATE products SET
                    product_name = ?, category_id = ?, subcategory_id = ?, brand_id = ?,
                    price = ?, discount_price = ?, stock_qty = ?, short_description = ?, long_description = ?, thumbnail = ?, status = ?
                WHERE product_id = ?";

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            $error = "Prepare failed: " . $conn->error;
        } else {
            if (!mysqli_bind_params($stmt, $params)) {
                $error = "Bind failed: " . $stmt->error;
            } else {
                if (!$stmt->execute()) {
                    $error = "Execute failed: " . $stmt->error;
                }
            }
            $stmt->close();
        }
    }

    // ---------- gallery upload (append) ----------
    if (empty($error) && !empty($_FILES['product_gallery_image']['name'][0])) {
        $files = $_FILES['product_gallery_image'];
        $existing = is_array($oldGallery) ? $oldGallery : [];
        // limit total images to 8
        for ($i=0; $i<count($files['name']); $i++) {
            if ($files['error'][$i] !== UPLOAD_ERR_OK) continue;
            if (count($existing) >= 8) break;
            $tmp = $files['tmp_name'][$i];
            $orig = $files['name'][$i];
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mtype = finfo_file($finfo, $tmp);
            finfo_close($finfo);
            if (!in_array($mtype, ['image/jpeg','image/png','image/webp','image/gif'])) continue;
            $ext = pathinfo($orig, PATHINFO_EXTENSION);
            $fname = uniqid('g_') . '.' . $ext;
            if (move_uploaded_file($tmp, $uploadDir . $fname)) {
                $existing[] = $fname;
            }
        }
        // update gallery JSON
        $gjson = json_encode(array_values($existing), JSON_UNESCAPED_UNICODE);
        $u = $conn->prepare("UPDATE products SET gallery_images = ? WHERE product_id = ?");
        $u->bind_param("si", $gjson, $product_id);
        $u->execute();
        $u->close();
    }

    if (empty($error)) {
        header("Location: product_list_view.php?updated=1");
        exit;
    }
}

// ---------- GET: show form ----------
$product_id = isset($_GET['product_id']) ? (int)$_GET['product_id'] : 0;
if ($product_id <= 0) { echo "Invalid product id"; exit; }

$stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$product) { echo "Product not found"; exit; }

$cats = $conn->query("SELECT category_id, category_name FROM categories ORDER BY category_name");
$subs = $conn->query("SELECT subcategory_id, subcategory_name FROM subcategories ORDER BY subcategory_name");
$brands = $conn->query("SELECT brand_id, brand_name FROM brands ORDER BY brand_name");

$gallery_list = $product['gallery_images'] ? json_decode($product['gallery_images'], true) : [];
?>
<!DOCTYPE html>
<html lang="bn">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Edit Product</title>
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 p-6">

<div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
  <h2 class="text-xl font-semibold mb-4">Edit Product #<?php echo (int)$product_id; ?></h2>

  <?php if (!empty($error)): ?>
    <div class="mb-4 p-3 bg-red-50 text-red-700 rounded"><?php echo esc($error); ?></div>
  <?php endif; ?>

  <form method="post" enctype="multipart/form-data" class="space-y-4">
    <input type="hidden" name="product_id" value="<?php echo (int)$product_id; ?>">

    <div>
      <label class="block text-sm font-medium">Product Name</label>
      <input name="product_name" value="<?php echo esc($product['product_name']); ?>" class="w-full border px-3 py-2 rounded" required>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label class="block text-sm">Category</label>
        <select name="category_id" class="w-full border px-3 py-2 rounded">
          <option value="0">Select Category</option>
          <?php while($c = $cats->fetch_assoc()): ?>
            <option value="<?php echo (int)$c['category_id']; ?>" <?php if($product['category_id']==$c['category_id']) echo "selected"; ?>>
              <?php echo esc($c['category_name']); ?>
            </option>
          <?php endwhile; ?>
        </select>
      </div>

      <div>
        <label class="block text-sm">Subcategory</label>
        <select name="subcategory_id" class="w-full border px-3 py-2 rounded">
          <option value="0">Select Subcategory</option>
          <?php while($s = $subs->fetch_assoc()): ?>
            <option value="<?php echo (int)$s['subcategory_id']; ?>" <?php if($product['subcategory_id']==$s['subcategory_id']) echo "selected"; ?>>
              <?php echo esc($s['subcategory_name']); ?>
            </option>
          <?php endwhile; ?>
        </select>
      </div>
    </div>

    <div>
      <label class="block text-sm">Brand</label>
      <select name="brand_id" class="w-full border px-3 py-2 rounded">
        <option value="0">Select Brand</option>
        <?php while($b = $brands->fetch_assoc()): ?>
          <option value="<?php echo (int)$b['brand_id']; ?>" <?php if($product['brand_id']==$b['brand_id']) echo "selected"; ?>>
            <?php echo esc($b['brand_name']); ?>
          </option>
        <?php endwhile; ?>
      </select>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <div>
        <label class="block text-sm">Price</label>
        <input type="number" step="0.01" min="0" name="price" value="<?php echo esc($product['price']); ?>" class="w-full border px-3 py-2 rounded">
      </div>
      <div>
        <label class="block text-sm">Discount Price</label>
        <input type="number" step="0.01" min="0" name="discount_price" value="<?php echo esc($product['discount_price']); ?>" class="w-full border px-3 py-2 rounded">
      </div>
      <div>
        <label class="block text-sm">Stock Qty</label>
        <input type="number" min="0" name="stock_qty" value="<?php echo esc($product['stock_qty']); ?>" class="w-full border px-3 py-2 rounded">
      </div>
    </div>

    <div>
      <label class="block text-sm">Short Description</label>
      <textarea name="short_description" class="w-full border px-3 py-2 rounded"><?php echo esc($product['short_description']); ?></textarea>
    </div>

    <div>
      <label class="block text-sm">Long Description</label>
      <textarea name="long_description" rows="6" class="w-full border px-3 py-2 rounded"><?php echo esc($product['long_description']); ?></textarea>
    </div>

    <div>
      <label class="block text-sm font-medium">Current Thumbnail</label>
      <?php if (!empty($product['thumbnail'])): ?>
        <div class="mb-2"><img src="<?php echo $webUploadDir . esc($product['thumbnail']); ?>" class="w-32 h-32 object-cover rounded border"></div>
      <?php endif; ?>
      <input type="file" name="product_image" accept="image/*">
    </div>

    <div>
      <label class="block text-sm">Upload Gallery Images (optional, max total 8)</label>
      <input type="file" name="product_gallery_image[]" accept="image/*" multiple>
      <?php if (!empty($gallery_list) && is_array($gallery_list)): ?>
        <div class="mt-3 grid grid-cols-3 gap-2">
          <?php foreach($gallery_list as $g): ?>
            <div class="border rounded p-1"><img src="<?php echo $webUploadDir . esc($g); ?>" class="w-full h-24 object-cover rounded"></div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>

    <div>
      <label class="block text-sm">Status</label>
      <select name="status" class="w-full border px-3 py-2 rounded">
        <option value="1" <?php if($product['status']==1) echo "selected"; ?>>Active</option>
        <option value="0" <?php if($product['status']==0) echo "selected"; ?>>Inactive</option>
      </select>
    </div>

    <div class="flex gap-2">
      <button class="px-4 py-2 bg-indigo-600 text-white rounded">Update Product</button>
      <a href="product_list_view.php" class="px-4 py-2 border rounded">Back to list</a>
    </div>
  </form>
</div>

</body>
</html>
