<?php
include 'server_connection.php'; // must provide $conn (mysqli)

/* ---------- Helpers ---------- */
function redirect($to=null){
    $url = $to ?? $_SERVER['PHP_SELF'];
    header("Location: $url");
    exit;
}

/* ---------- POST actions (add / update) ---------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $act = $_POST['action'] ?? '';

    // Add Category
    if ($act === 'add_category' && ($name = trim($_POST['category_name'] ?? '')) !== '') {

      $imgPath = null;
  
      if (!empty($_FILES['category_image']['name'])) {
          $dir = 'uploads/categories/';
          if (!is_dir($dir)) mkdir($dir, 0777, true);
  
          $fileName = time().'_'.basename($_FILES['category_image']['name']);
          $imgPath = $dir.$fileName;
          move_uploaded_file($_FILES['category_image']['tmp_name'], $imgPath);
      }
  
      $stmt = $conn->prepare(
        "INSERT INTO categories (category_name, category_image) VALUES (?, ?)"
      );
      $stmt->bind_param("ss", $name, $imgPath);
      $stmt->execute();
      $stmt->close();
  
      redirect();
  }
  

    // Update Category
    if ($act === 'update_category'
    && ($id = intval($_POST['category_id'] ?? 0))
    && ($name = trim($_POST['category_name'] ?? '')) !== ''
) {

    $imgSql = "";
    $params = [$name, $id];
    $types = "si";

    if (!empty($_FILES['category_image']['name'])) {
        $dir = 'uploads/categories/';
        if (!is_dir($dir)) mkdir($dir, 0777, true);

        $fileName = time().'_'.basename($_FILES['category_image']['name']);
        $imgPath = $dir.$fileName;
        move_uploaded_file($_FILES['category_image']['tmp_name'], $imgPath);

        $imgSql = ", category_image = ?";
        $params = [$name, $imgPath, $id];
        $types = "ssi";
    }

    $stmt = $conn->prepare(
      "UPDATE categories SET category_name = ? $imgSql WHERE category_id = ?"
    );
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $stmt->close();

    redirect();
}


    // Add Subcategory
    if ($act === 'add_subcategory' && ($cid = intval($_POST['category_id'] ?? 0)) && ($name = trim($_POST['subcategory_name'] ?? '')) !== '') {
        $stmt = $conn->prepare("INSERT INTO subcategories (category_id, subcategory_name) VALUES (?, ?)");
        $stmt->bind_param("is", $cid, $name); $stmt->execute(); $stmt->close();
        redirect();
    }

    // Update Subcategory
    if ($act === 'update_subcategory' && ($id = intval($_POST['subcategory_id'] ?? 0)) && ($cid = intval($_POST['category_id'] ?? 0)) && ($name = trim($_POST['subcategory_name'] ?? '')) !== '') {
        $stmt = $conn->prepare("UPDATE subcategories SET category_id = ?, subcategory_name = ? WHERE subcategory_id = ?");
        $stmt->bind_param("isi", $cid, $name, $id); $stmt->execute(); $stmt->close();
        redirect();
    }

    // Add Brand
    if ($act === 'add_brand' && ($sid = intval($_POST['subcategory_id'] ?? 0)) && ($name = trim($_POST['brand_name'] ?? '')) !== '') {
        $stmt = $conn->prepare("INSERT INTO brands (subcategory_id, brand_name) VALUES (?, ?)");
        $stmt->bind_param("is", $sid, $name); $stmt->execute(); $stmt->close();
        redirect();
    }

    // Update Brand
    if ($act === 'update_brand' && ($id = intval($_POST['brand_id'] ?? 0)) && ($sid = intval($_POST['subcategory_id'] ?? 0)) && ($name = trim($_POST['brand_name'] ?? '')) !== '') {
        $stmt = $conn->prepare("UPDATE brands SET subcategory_id = ?, brand_name = ? WHERE brand_id = ?");
        $stmt->bind_param("isi", $sid, $name, $id); $stmt->execute(); $stmt->close();
        redirect();
    }
}

/* ---------- GET actions (delete) ---------- */
if (isset($_GET['delete_category'])) {
    $id = intval($_GET['delete_category']);
    if ($id) {
        // delete brands under subcategories of this category
        $s = $conn->prepare("DELETE b FROM brands b JOIN subcategories s ON b.subcategory_id = s.subcategory_id WHERE s.category_id = ?");
        $s->bind_param("i", $id); $s->execute(); $s->close();

        $s = $conn->prepare("DELETE FROM subcategories WHERE category_id = ?");
        $s->bind_param("i", $id); $s->execute(); $s->close();

        $s = $conn->prepare("DELETE FROM categories WHERE category_id = ?");
        $s->bind_param("i", $id); $s->execute(); $s->close();
    }
    redirect();
}
if (isset($_GET['delete_subcategory'])) {
    $id = intval($_GET['delete_subcategory']);
    if ($id) {
        $s = $conn->prepare("DELETE FROM brands WHERE subcategory_id = ?");
        $s->bind_param("i", $id); $s->execute(); $s->close();

        $s = $conn->prepare("DELETE FROM subcategories WHERE subcategory_id = ?");
        $s->bind_param("i", $id); $s->execute(); $s->close();
    }
    redirect();
}
if (isset($_GET['delete_brand'])) {
    $id = intval($_GET['delete_brand']);
    if ($id) {
        $s = $conn->prepare("DELETE FROM brands WHERE brand_id = ?");
        $s->bind_param("i", $id); $s->execute(); $s->close();
    }
    redirect();
}

/* ---------- Edit fetch ---------- */
$editCategory = $editSubcategory = $editBrand = null;
if (isset($_GET['edit_category'])) {
    $id = intval($_GET['edit_category']);
    if ($id) $editCategory = $conn->query("SELECT category_id, category_name, category_image FROM categories WHERE category_id = $id")->fetch_assoc();
}
if (isset($_GET['edit_subcategory'])) {
    $id = intval($_GET['edit_subcategory']);
    if ($id) $editSubcategory = $conn->query("SELECT subcategory_id, category_id, subcategory_name FROM subcategories WHERE subcategory_id = $id")->fetch_assoc();
}
if (isset($_GET['edit_brand'])) {
    $id = intval($_GET['edit_brand']);
    if ($id) $editBrand = $conn->query("SELECT brand_id, subcategory_id, brand_name FROM brands WHERE brand_id = $id")->fetch_assoc();
}

/* ---------- Data lists ---------- */
$categories = $conn->query("SELECT * FROM categories ORDER BY category_name");
$subcategories = $conn->query("SELECT s.*, c.category_name FROM subcategories s LEFT JOIN categories c USING(category_id) ORDER BY s.subcategory_name");
$brands = $conn->query("SELECT b.*, s.subcategory_name, c.category_name FROM brands b LEFT JOIN subcategories s ON b.subcategory_id = s.subcategory_id LEFT JOIN categories c ON s.category_id = c.category_id ORDER BY b.brand_id DESC");

/* =========================================================
   REUSABLE CSV IMPORT FUNCTION
========================================================= */
function csvImport($conn, $fileKey, $table, $columns, $updateCols) {

    if (!isset($_FILES[$fileKey]) || !is_uploaded_file($_FILES[$fileKey]['tmp_name'])) {
        return ['status'=>'error', 'message'=>'No file selected'];
    }

    $file = fopen($_FILES[$fileKey]['tmp_name'], 'r');
    fgetcsv($file); // skip header

    $total = $inserted = $skipped = 0;

    while (($data = fgetcsv($file, 1000, ",")) !== false) {
        $total++;

        if (count($data) < count($columns)) {
            $skipped++;
            continue;
        }

        $values = [];
        foreach ($columns as $i => $col) {
            $values[$col] = mysqli_real_escape_string($conn, trim($data[$i] ?? ''));
        }

        // basic validation: last column (name) empty হলে skip
        if ($values[end($columns)] === '') {
            $skipped++;
            continue;
        }

        $colsSql   = implode(',', array_keys($values));
        $valsSql   = "'" . implode("','", array_values($values)) . "'";
        $updateSql = implode(',', array_map(fn($c)=>"$c=VALUES($c)", $updateCols));

        $sql = "INSERT INTO $table ($colsSql)
                VALUES ($valsSql)
                ON DUPLICATE KEY UPDATE $updateSql";

        mysqli_query($conn, $sql);
        $inserted++;
    }

    fclose($file);

    return [
        'status'   => 'success',
        'message'  => ucfirst($table) . ' CSV uploaded successfully!',
        'total'    => $total,
        'inserted' => $inserted,
        'skipped'  => $skipped
    ];
}


/* =========================================================
   REUSABLE CSV EXPORT FUNCTION
========================================================= */
function csvExport($conn, $table, $columns, $filename) {

    header('Content-Type: text/csv; charset=utf-8');
    header("Content-Disposition: attachment; filename=$filename");

    $out = fopen('php://output', 'w');
    fputcsv($out, $columns);

    $cols = implode(',', $columns);
    $res  = mysqli_query($conn, "SELECT $cols FROM $table");

    while ($row = mysqli_fetch_assoc($res)) {
        fputcsv($out, $row);
    }

    fclose($out);
    exit;
}

/* ================= CATEGORY ================= */
if (isset($_POST['ajax']) && $_POST['ajax'] === 'upload_category_csv') {
    echo json_encode(
        csvImport(
            $conn,
            'category_csv',
            'categories',
            ['category_id','category_name','category_image'],
            ['category_name','category_image']
        )
    );
    exit;
}

if (isset($_POST['export_category_csv'])) {
    csvExport(
        $conn,
        'categories',
        ['category_id','category_name','category_image'],
        'categories.csv'
    );
}

/* ================= SUBCATEGORY ================= */
if (isset($_POST['ajax']) && $_POST['ajax'] === 'upload_subcategory_csv') {
    echo json_encode(
        csvImport(
            $conn,
            'subcategory_csv',
            'subcategories',
            ['subcategory_id','category_id','subcategory_name'],
            ['category_id','subcategory_name']
        )
    );
    exit;
}

if (isset($_POST['export_subcategory_csv'])) {
    csvExport(
        $conn,
        'subcategories',
        ['subcategory_id','category_id','subcategory_name'],
        'subcategories.csv'
    );
}

/* ================= BRAND ================= */
if (isset($_POST['ajax']) && $_POST['ajax'] === 'upload_brand_csv') {
    echo json_encode(
        csvImport(
            $conn,
            'brand_csv',
            'brands',
            ['brand_id','subcategory_id','brand_name'],
            ['subcategory_id','brand_name']
        )
    );
    exit;
}

if (isset($_POST['export_brand_csv'])) {
    csvExport(
        $conn,
        'brands',
        ['brand_id','subcategory_id','brand_name'],
        'brands.csv'
    );
}

?>
<!doctype html>
<html lang="bn">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Manage Categories / Subcategories / Brands</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <style>
    /* small custom styles */
    .card{transition:all .12s ease}
    .card:hover{transform:translateY(-4px)}
    .table-ellipsis{max-width:200px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;display:inline-block;vertical-align:middle}
    .scroll-x::-webkit-scrollbar{height:9px}
    .scroll-x::-webkit-scrollbar-thumb{background:rgba(100,116,139,.25);border-radius:8px}
    .chip-buy{background:#ecfdf5;color:#065f46;padding:.15rem .5rem;border-radius:.375rem;font-weight:600;font-size:.72rem}
    .chip-sell{background:#fff1f2;color:#9f1239;padding:.15rem .5rem;border-radius:.375rem;font-weight:600;font-size:.72rem}
  </style>
</head>
<body class="bg-gray-50 text-gray-800">
  <div class="max-w-6xl mx-auto p-6">

    <!-- Header -->
    <header class="mb-6">
      <h1 class="text-2xl font-bold">Manage <span class="text-indigo-600">Categories</span> · Subcategories · Brands</h1>
      <p class="text-sm text-gray-600 mt-1">Add / edit / delete. Tables responsive — horizontal scroll only on small screens when needed.</p>
    </header>

    <!-- Forms: Category / Subcategory / Brand -->
    <div class="grid lg:grid-cols-3 gap-6 mb-6">
      <!-- Category -->
      <div class="card bg-white p-4 rounded shadow">
  <h2 class="font-semibold mb-2">Category</h2>

  <form method="post" enctype="multipart/form-data" class="space-y-2">

    <?php if ($editCategory): ?>
      <input type="hidden" name="action" value="update_category">
      <input type="hidden" name="category_id" value="<?= intval($editCategory['category_id']) ?>">

      <input
        name="category_name"
        value="<?= htmlspecialchars($editCategory['category_name']) ?>"
        required
        class="w-full border rounded px-3 py-2"
      >

      <!-- Image upload -->
      <input type="file" name="category_image" class="w-full border rounded px-3 py-2">

      <!-- Old image preview -->
      <?php if (!empty($editCategory['category_image'])): ?>
        <img src="<?= $editCategory['category_image'] ?>" class="h-16 mt-2 rounded">
      <?php endif; ?>

      <div class="flex gap-2">
        <button class="bg-green-600 text-white px-3 py-2 rounded">Update</button>
        <a href="<?= $_SERVER['PHP_SELF'] ?>" class="border px-3 py-2 rounded">Cancel</a>
      </div>

    <?php else: ?>

      <input type="hidden" name="action" value="add_category">

      <input
        name="category_name"
        placeholder="Category name"
        required
        class="w-full border rounded px-3 py-2"
      >

      <input
        type="file"
        name="category_image"
        required
        class="w-full border rounded px-3 py-2"
      >

      <button class="w-full bg-indigo-600 text-white px-3 py-2 rounded">
        Add Category
      </button>

    <?php endif; ?>

  </form>
</div>


      <!-- Subcategory -->
      <div class="card bg-white p-4 rounded shadow">
        <h2 class="font-semibold mb-2">Subcategory</h2>
        <form method="post" class="space-y-2">
          <?php if ($editSubcategory): ?>
            <input type="hidden" name="action" value="update_subcategory">
            <input type="hidden" name="subcategory_id" value="<?= intval($editSubcategory['subcategory_id']) ?>">
            <select name="category_id" required class="w-full border rounded px-3 py-2">
              <option value="">Select Category</option>
              <?php foreach($categories as $c): ?>
                <option value="<?= intval($c['category_id']) ?>" <?= (intval($c['category_id'])==intval($editSubcategory['category_id']))?'selected':'' ?>><?= htmlspecialchars($c['category_name']) ?></option>
              <?php endforeach; ?>
            </select>
            <input name="subcategory_name" value="<?= htmlspecialchars($editSubcategory['subcategory_name']) ?>" required class="w-full border rounded px-3 py-2">
            <div class="flex gap-2">
              <button class="bg-green-600 text-white px-3 py-2 rounded">Update</button>
              <a href="<?= $_SERVER['PHP_SELF'] ?>" class="border px-3 py-2 rounded">Cancel</a>
            </div>
          <?php else: ?>
            <input type="hidden" name="action" value="add_subcategory">
            <select name="category_id" required class="w-full border rounded px-3 py-2">
              <option value="">Select Category</option>
              <?php foreach($categories as $c): ?><option value="<?= intval($c['category_id']) ?>"><?= htmlspecialchars($c['category_name']) ?></option><?php endforeach; ?>
            </select>
            <input name="subcategory_name" placeholder="Subcategory name" required class="w-full border rounded px-3 py-2">
            <button class="w-full bg-indigo-600 text-white px-3 py-2 rounded">Add Subcategory</button>
          <?php endif; ?>
        </form>
      </div>

      <!-- Brand -->
      <div class="card bg-white p-4 rounded shadow">
        <h2 class="font-semibold mb-2">Brand</h2>
        <form method="post" class="space-y-2">
          <?php if ($editBrand): ?>
            <input type="hidden" name="action" value="update_brand">
            <input type="hidden" name="brand_id" value="<?= intval($editBrand['brand_id']) ?>">
            <select name="subcategory_id" required class="w-full border rounded px-3 py-2">
              <option value="">Select Subcategory</option>
              <?php foreach($subcategories as $s): ?>
                <option value="<?= intval($s['subcategory_id']) ?>" <?= (intval($s['subcategory_id'])==intval($editBrand['subcategory_id']))?'selected':'' ?>><?= htmlspecialchars($s['subcategory_name']).' ('.$s['category_name'].')' ?></option>
              <?php endforeach; ?>
            </select>
            <input name="brand_name" value="<?= htmlspecialchars($editBrand['brand_name']) ?>" required class="w-full border rounded px-3 py-2">
            <div class="flex gap-2">
              <button class="bg-green-600 text-white px-3 py-2 rounded">Update</button>
              <a href="<?= $_SERVER['PHP_SELF'] ?>" class="border px-3 py-2 rounded">Cancel</a>
            </div>
          <?php else: ?>
            <input type="hidden" name="action" value="add_brand">
            <select name="subcategory_id" required class="w-full border rounded px-3 py-2">
              <option value="">Select Subcategory</option>
              <?php foreach($subcategories as $s): ?><option value="<?= intval($s['subcategory_id']) ?>"><?= htmlspecialchars($s['subcategory_name']).' ('.$s['category_name'].')' ?></option><?php endforeach; ?>
            </select>
            <input name="brand_name" placeholder="Brand name" required class="w-full border rounded px-3 py-2">
            <button class="w-full bg-indigo-600 text-white px-3 py-2 rounded">Add Brand</button>
          <?php endif; ?>
        </form>
      </div>
    </div> <!-- forms grid -->

    <!-- TABLE SECTION START -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

    <!-- Category Table -->
    <div class="bg-white p-4 rounded shadow overflow-x-auto">
        <div class="flex justify-between">
          <h3 class="font-semibold mb-3 text-lg">Categories</h3>
          
          <div class="flex gap-6">
            <form method="post">
            <button name="export_category_csv" class="font-semibold mb-2 rounded border border-back px-3 py-1 bg-indigo-50 hover:bg-indigo-300 hover:text-black">Export</button>
          </form>
          <form id="catUpload" enctype="multipart/form-data" class="flex items-center gap-2">
          <input type="file" name="category_csv" required class="border rounded px-2 py-1 w-24 mb-2">
          <button type="submit"class="mb-2 font-semibold rounded border px-3 py-1 bg-indigo-50 hover:bg-indigo-300 hover:text-black">Upload</button>
          </form>

          </div>
        
        </div>
          
          
        

        <?php 
            $cat_res = $conn->query("SELECT * FROM categories ORDER BY category_name");
            $i = 1;
        ?>

        <table class="min-w-full text-sm border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border border-gray-300 px-3 py-2">#</th>
                    <th class="border border-gray-300 px-3 py-2">Category Name</th>
                    <th class="border border-gray-300 px-3 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($c = $cat_res->fetch_assoc()): ?>
                <tr>
                    <td class="border border-gray-300 px-3 py-2"><?= $i++ ?></td>
                    <td class="border border-gray-300 px-3 py-2"><?= htmlspecialchars($c['category_name']) ?></td>
                    <td class="border border-gray-300 px-3 py-2">
                        <a href="?edit_category=<?= $c['category_id'] ?>" class="text-indigo-600 mr-2">Edit</a>
                        <a href="?delete_category=<?= $c['category_id'] ?>" onclick="return confirm('Delete this category?')" class="text-red-600">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Subcategory Table -->
    <div class="bg-white p-4 rounded shadow overflow-x-auto">
          <div class="flex justify-between">
          <h3 class="font-semibold mb-3 text-lg">SubCategories</h3>
          
          <div class="flex gap-6">
            <form method="post">
            <button type="submit"
            name="export_subcategory_csv" class="font-semibold mb-2 rounded border border-back px-3 py-1 bg-indigo-50 hover:bg-indigo-300 hover:text-black">Export</button>
          </form>
          <form id="subUpload" enctype="multipart/form-data" class="flex items-center gap-2">
          <input type="file" name="subcategory_csv" required class="border rounded px-2 py-1 w-24 mb-2">
          <button type="submit"class="mb-2 font-semibold rounded border px-3 py-1 bg-indigo-50 hover:bg-indigo-300 hover:text-black">Upload</button>
          </form>

          </div>
        
        </div>
        <?php 
            $sub_res = $conn->query("SELECT s.*, c.category_name FROM subcategories s LEFT JOIN categories c USING(category_id) ORDER BY s.subcategory_name");
            $j = 1;
        ?>

        <table class="min-w-full text-sm border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border border-gray-300 px-3 py-2">#</th>
                    <th class="border border-gray-300 px-3 py-2">Subcategory</th>
                    <th class="border border-gray-300 px-3 py-2">Category</th>
                    <th class="border border-gray-300 px-3 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($s = $sub_res->fetch_assoc()): ?>
                <tr>
                    <td class="border border-gray-300 px-3 py-2"><?= $j++ ?></td>
                    <td class="border border-gray-300 px-3 py-2"><?= htmlspecialchars($s['subcategory_name']) ?></td>
                    <td class="border border-gray-300 px-3 py-2"><?= htmlspecialchars($s['category_name']) ?></td>
                    <td class="border border-gray-300 px-3 py-2">
                        <a href="?edit_subcategory=<?= $s['subcategory_id'] ?>" class="text-indigo-600 mr-2">Edit</a>
                        <a href="?delete_subcategory=<?= $s['subcategory_id'] ?>" onclick="return confirm('Delete this subcategory?')" class="text-red-600">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</div> <!-- END FIRST ROW -->


<!-- SECOND ROW : BRAND TABLE -->
<div class="bg-white p-4 rounded shadow overflow-x-auto mb-10">
    <div class="flex justify-between">
          <h3 class="font-semibold mb-3 text-lg">Brands</h3>
          <div class="flex gap-6">
            <form method="post">
            <button type="submit"
            name="export_brand_csv" class="font-semibold mb-2 rounded border border-back px-3 py-1 bg-indigo-50 hover:bg-indigo-300 hover:text-black">Export</button>
          </form>
          <form id="brandUpload" enctype="multipart/form-data" class="flex items-center gap-2">
          <input type="file" name="brand_csv" id="brandCsvInput" required class="border rounded px-2 py-1 w-24 mb-2">
          <button type="submit"class="mb-2 font-semibold rounded border px-3 py-1 bg-indigo-50 hover:bg-indigo-300 hover:text-black">Upload</button>
          </form>

          </div>
        
        </div>
    <?php 
        $brand_res = $conn->query("SELECT b.*, s.subcategory_name, c.category_name 
                                   FROM brands b 
                                   LEFT JOIN subcategories s ON b.subcategory_id = s.subcategory_id
                                   LEFT JOIN categories c ON s.category_id = c.category_id
                                   ORDER BY b.brand_id DESC");
        $k = 1;
    ?>

    <table class="min-w-full text-sm border border-gray-300">
        <thead class="bg-gray-100">
            <tr>
                <th class="border border-gray-300 px-3 py-2">#</th>
                <th class="border border-gray-300 px-3 py-2">Brand</th>
                <th class="border border-gray-300 px-3 py-2">Subcategory</th>
                <th class="border border-gray-300 px-3 py-2">Category</th>
                <th class="border border-gray-300 px-3 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($b = $brand_res->fetch_assoc()): ?>
            <tr>
                <td class="border border-gray-300 px-3 py-2"><?= $k++ ?></td>
                <td class="border border-gray-300 px-3 py-2"><?= htmlspecialchars($b['brand_name']) ?></td>
                <td class="border border-gray-300 px-3 py-2"><?= htmlspecialchars($b['subcategory_name']) ?></td>
                <td class="border border-gray-300 px-3 py-2"><?= htmlspecialchars($b['category_name']) ?></td>
                <td class="border border-gray-300 px-3 py-2">
                    <a href="?edit_brand=<?= $b['brand_id'] ?>" class="text-indigo-600 mr-2">Edit</a>
                    <a href="?delete_brand=<?= $b['brand_id'] ?>" onclick="return confirm('Delete this brand?')" class="text-red-600">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<!-- TABLE SECTION END -->





  </div>

  <script>
formData.append('ajax', 'upload_csv');
const subForm = document.getElementById('subcategoryUploadForm');
const subInput = document.getElementById('subcategoryCsvInput');

subForm.addEventListener('submit', function (e) {
    e.preventDefault();

    const data = new FormData(subForm);
    data.append('ajax', 'upload_subcategory_csv');

    fetch('', {
        method: 'POST',
        body: data
    })
    .then(res => res.json())
    .then(res => {
        if (res.status === 'success') {
            alert(
                `${res.message}\n` +
                `Total: ${res.total}, Inserted: ${res.inserted}, Skipped: ${res.skipped}`
            );
            subForm.reset();
        } else {
            alert(res.message);
        }
    })
    .catch(() => alert('Subcategory upload failed'));
});



const brandForm  = document.getElementById('brandUploadForm');
const brandInput = document.getElementById('brandCsvInput');

brandForm.addEventListener('submit', function (e) {
    e.preventDefault();

    const data = new FormData(brandForm);
    data.append('ajax', 'upload_brand_csv');

    fetch('', {
        method: 'POST',
        body: data
    })
    .then(res => res.json())
    .then(res => {
        if (res.status === 'success') {
            alert(
                `${res.message}\n` +
                `Total: ${res.total}, Inserted: ${res.inserted}, Skipped: ${res.skipped}`
            );
            brandForm.reset();
        } else {
            alert(res.message);
        }
    })
    .catch(() => alert('Brand upload failed'));
});
</script>
</body>
</html>
