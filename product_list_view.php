<?php
// product.php
include "server_connection.php";

// --- Pagination & search params ---
$perPage = 20;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$search = isset($_GET['q']) ? trim($_GET['q']) : '';
$category = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;
$brand = isset($_GET['brand_id']) ? (int)$_GET['brand_id'] : 0;

// build WHERE
$where = [];
$params = [];
$types = '';

if ($search !== '') {
    $where[] = "(p.product_name LIKE CONCAT('%',?,'%') OR p.short_description LIKE CONCAT('%',?,'%'))";
    $params[] = $search; $params[] = $search;
    $types .= 'ss';
}
if ($category > 0) {
    $where[] = "p.category_id = ?";
    $params[] = $category;
    $types .= 'i';
}
if ($brand > 0) {
    $where[] = "p.brand_id = ?";
    $params[] = $brand;
    $types .= 'i';
}

$whereSQL = count($where) ? 'WHERE ' . implode(' AND ', $where) : '';

// count total
$countSql = "SELECT COUNT(*) AS total FROM products p $whereSQL";
$stmt = $conn->prepare($countSql);
if ($types) $stmt->bind_param($types, ...$params);
$stmt->execute();
$res = $stmt->get_result()->fetch_assoc();
$total = (int)$res['total'];
$stmt->close();

$pages = max(1, ceil($total / $perPage));
$offset = ($page - 1) * $perPage;

// fetch products with category & brand
$sql = "SELECT p.*, c.category_name, b.brand_name, sc.subcategory_name
        FROM products p
        LEFT JOIN categories c ON p.category_id = c.category_id
        LEFT JOIN subcategories sc ON p.subcategory_id = sc.subcategory_id
        LEFT JOIN brands b ON p.brand_id = b.brand_id
        $whereSQL
        ORDER BY p.product_id DESC
        LIMIT ? OFFSET ?";

$stmt = $conn->prepare($sql);
if ($types) {
    // bind dynamic types + ii for limit/offset
    $bindTypes = $types . 'ii';
    $bindParams = array_merge($params, [$perPage, $offset]);
    $stmt->bind_param($bindTypes, ...$bindParams);
} else {
    $stmt->bind_param('ii', $perPage, $offset);
}
$stmt->execute();
$result = $stmt->get_result();

$categories = $conn->query("SELECT category_id, category_name FROM categories ORDER BY category_name");
$brands = $conn->query("SELECT brand_id, brand_name FROM brands ORDER BY brand_name");
?>
<!DOCTYPE html>
<html lang="bn">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Product List</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 min-h-screen text-gray-800">

  <div class="max-w-7xl mx-auto px-4 py-8">

    <div class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-semibold">Product List</h1>
      <a href="add_product.php" class="inline-block bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Add New Product</a>
    </div>

    <!-- Filters -->
    <form method="GET" class="bg-white p-4 rounded-md shadow mb-6 grid grid-cols-1 md:grid-cols-4 gap-3">
      <input type="text" name="q" placeholder="Search product or description..." value="<?php echo htmlspecialchars($search, ENT_QUOTES); ?>"
             class="col-span-1 md:col-span-2 border rounded px-3 py-2" />

      <select name="category_id" class="border rounded px-3 py-2">
        <option value="0">All Categories</option>
        <?php while($c = $categories->fetch_assoc()): ?>
          <option value="<?php echo (int)$c['category_id']; ?>" <?php if($category==(int)$c['category_id']) echo 'selected'; ?>>
            <?php echo htmlspecialchars($c['category_name'], ENT_QUOTES); ?>
          </option>
        <?php endwhile; ?>
      </select>
      <select name="brand_id" class="border rounded px-3 py-2">
        <option value="0">All Brands</option>
        <?php while($b = $brands->fetch_assoc()): ?>
          <option value="<?php echo (int)$b['brand_id']; ?>" <?php if($brand==(int)$b['brand_id']) echo 'selected'; ?>>
            <?php echo htmlspecialchars($b['brand_name'], ENT_QUOTES); ?>
          </option>
        <?php endwhile; ?>
      </select>

      <div class="md:col-span-4 flex gap-2">
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Apply</button>
        <a href="product-list.php" class="px-4 py-2 border rounded">Reset</a>
        <div class="ml-auto text-sm text-gray-600 self-center">Total: <?php echo $total; ?></div>
      </div>
    </form>

    <!-- Table (desktop) + Cards (mobile) -->
    <div class="bg-white rounded-md shadow overflow-hidden">
      <div class="hidden md:block">
        <table class="w-full text-left">
          <thead class="bg-gray-50 text-sm text-gray-600">
            <tr>
              <th class="p-3">#</th>
              <th class="p-3 w-80">Product</th>
              <th class="p-3">Category</th>
              <th class="p-3">Sub Category</th>
              <th class="p-3">Brand</th>
              <th class="p-3 text-right">Price</th>
              <th class="p-3 text-center">Stock</th>
              <th class="p-3 text-center">Status</th>
              <th class="p-3 text-center">Actions</th>
            </tr>
          </thead>
          <tbody class="text-sm">
            <?php while($p = $result->fetch_assoc()): 
                $pid = (int)$p['product_id'];
                $name = htmlspecialchars($p['product_name'], ENT_QUOTES);
                $cat = htmlspecialchars($p['category_name'] ?? '-', ENT_QUOTES);
                $sub_cat = htmlspecialchars($p['subcategory_name'] ?? '-', ENT_QUOTES);
                $brandName = htmlspecialchars($p['brand_name'] ?? '-', ENT_QUOTES);
                $price = number_format((float)$p['price'], 2);
                $dprice = isset($p['discount_price']) && $p['discount_price'] > 0 ? number_format((float)$p['discount_price'],2) : null;
                $stock = (int)$p['stock_qty'];
                $thumb = !empty($p['thumbnail']) ? 'uploads/products/'.htmlspecialchars($p['thumbnail'], ENT_QUOTES) : 'https://via.placeholder.com/80';
                $status = htmlspecialchars($p['status'] ?? 'inactive', ENT_QUOTES);
            ?>
            <tr class="border-t hover:bg-gray-50">
              <td class="p-3 align-top"><?php echo $pid; ?></td>
              <td class="p-3 align-top flex items-start gap-3">
                <img src="<?php echo $thumb; ?>" alt="" class="w-16 h-16 object-cover rounded border" />
                <div>
                  <div class="font-medium"><?php echo $name; ?></div>
                  <div class="text-xs text-gray-500 mt-1"><?php echo htmlspecialchars($p['short_description'] ?? '', ENT_QUOTES); ?></div>
                </div>
              </td>
              <td class="p-3 align-top">
                <div class="text-sm"><?php echo $cat; ?></div>
                <div class="text-xs text-gray-500 mt-1"><?php echo $sub_cat; ?></div>
              </td>
              <td class="p-3 align-top">
                <div class="text-sm"><?php echo $sub_cat; ?></div>
                <div class="text-xs text-gray-500 mt-1"><?php echo $brandName; ?></div>
              </td>
              <td class="p-3 align-top">
                <div class="text-sm"><?php echo $brandName; ?></div>
              </td>
              <td class="p-3 align-top text-right">
                <?php if($dprice): ?>
                  <div class="text-indigo-600 font-semibold">$<?php echo $dprice; ?></div>
                  <div class="text-xs line-through text-gray-400">$<?php echo $price; ?></div>
                <?php else: ?>
                  <div class="font-semibold">$<?php echo $price; ?></div>
                <?php endif; ?>
              </td>
              <td class="p-3 align-top text-center"><?php echo $stock; ?></td>
              <td class="p-3 align-top text-center">
                <?php if(strtolower($status) === 'active'): ?>
                  <span class="text-sm px-2 py-1 bg-green-100 text-green-800 rounded-full">Active</span>
                <?php else: ?>
                  <span class="text-sm px-2 py-1 bg-gray-100 text-gray-700 rounded-full">Inactive</span>
                <?php endif; ?>
              </td>
              <td class="p-3 align-top text-center space-x-2">
                <a href="edit.php?product_id=<?php echo $pid; ?>" class="inline-block px-3 py-1 text-sm bg-yellow-100 text-yellow-800 rounded hover:bg-yellow-200">Edit</a>
                <button data-id="<?php echo $pid; ?>" class="deleteBtn inline-block px-3 py-1 text-sm bg-red-100 text-red-800 rounded hover:bg-red-200">Delete</button>
              </td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>

      <!-- Mobile cards -->
      <div class="md:hidden p-4 space-y-4">
        <?php
        // re-run the query for mobile (or you could reuse results by storing in array)
        $stmt->close();
        $stmt = $conn->prepare("SELECT p.*, c.category_name, b.brand_name FROM products p LEFT JOIN categories c ON p.category_id=c.category_id LEFT JOIN brands b ON p.brand_id=b.brand_id $whereSQL ORDER BY p.product_id DESC LIMIT ? OFFSET ?");
        if ($types) {
            $bindTypes = $types . 'ii';
            $bindParams = array_merge($params, [$perPage, $offset]);
            $stmt->bind_param($bindTypes, ...$bindParams);
        } else {
            $stmt->bind_param('ii', $perPage, $offset);
        }
        $stmt->execute();
        $mobileRes = $stmt->get_result();
        while($p = $mobileRes->fetch_assoc()):
          $pid = (int)$p['product_id'];
          $name = htmlspecialchars($p['product_name'], ENT_QUOTES);
          $price = number_format((float)$p['price'], 2);
          $dprice = isset($p['discount_price']) && $p['discount_price'] > 0 ? number_format((float)$p['discount_price'],2) : null;
          $thumb = !empty($p['thumbnail']) ? 'uploads/products/'.htmlspecialchars($p['thumbnail'], ENT_QUOTES) : 'https://via.placeholder.com/150';
        ?>
        <div class="bg-white rounded shadow p-3 flex gap-3">
          <img src="<?php echo $thumb; ?>" alt="" class="w-24 h-24 object-cover rounded" />
          <div class="flex-1">
            <div class="font-medium"><?php echo $name; ?></div>
            <div class="text-sm text-gray-500 mt-1"><?php echo htmlspecialchars($p['category_name'] ?? '-', ENT_QUOTES); ?></div>
            <div class="mt-2">
              <?php if($dprice): ?>
                <span class="text-indigo-600 font-semibold">$<?php echo $dprice; ?></span>
                <span class="text-xs line-through text-gray-400 ml-2">$<?php echo $price; ?></span>
              <?php else: ?>
                <span class="font-semibold">$<?php echo $price; ?></span>
              <?php endif; ?>
            </div>

            <div class="mt-3 flex gap-2">
              <a href="edit.php?product_id=<?php echo $pid; ?>" class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded text-sm">Edit</a>
              <button data-id="<?php echo $pid; ?>" class="deleteBtn px-3 py-1 bg-red-100 text-red-800 rounded text-sm">Delete</button>
            </div>
          </div>
        </div>
        <?php endwhile; $stmt->close(); ?>
      </div>

    </div>

    <!-- Pagination -->
    <?php if($pages > 1): ?>
    <div class="mt-4 flex items-center justify-between">
      <div class="text-sm text-gray-600">Page <?php echo $page; ?> of <?php echo $pages; ?></div>
      <div class="flex gap-2">
        <?php for($i=1;$i<=$pages;$i++): ?>
          <a href="?<?php
              $qs = $_GET; $qs['page']=$i; echo http_build_query($qs);
            ?>" class="px-3 py-1 rounded <?php echo $i==$page ? 'bg-indigo-600 text-white' : 'bg-white border'; ?>"><?php echo $i; ?></a>
        <?php endfor; ?>
      </div>
    </div>
    <?php endif; ?>

  </div>

<script>

document.addEventListener('click', function(e){
  // event delegation: support dynamically rendered buttons
  const el = e.target;
  // find the closest element with class deleteBtn (button or inside)
  const btn = el.closest ? el.closest('.deleteBtn') : null;
  if (!btn) return;

  const id = btn.dataset.id;
  if (!id) {
    alert('Missing product id on this delete button.');
    return;
  }

  if (!confirm('Are you sure you want to delete product #' + id + '? This action cannot be undone.')) return;

  // disable button to prevent double click
  btn.disabled = true;
  btn.innerText = 'Deleting...';

  fetch('delete.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: 'product_id=' + encodeURIComponent(id)
  })
  .then(async res => {
    // show http status
    console.log('HTTP status:', res.status, res.statusText);
    let text = await res.text();
    console.log('Raw response text:', text);
    // try parse JSON
    try {
      const data = JSON.parse(text);
      return data;
    } catch (err) {
      throw new Error('Invalid JSON response from server. See console raw response.');
    }
  })
  .then(data => {
    console.log('Server JSON:', data);
    if (data.status === 'success') {
      // remove table row if exists
      const row = btn.closest('tr');
      if (row) row.remove();

      // remove mobile card if exists (closest .bg-white card)
      const card = btn.closest('.bg-white');
      if (card) card.remove();

      alert('Product deleted successfully.');
    } else {
      alert('Delete failed: ' + (data.message || 'Unknown error'));
      btn.disabled = false;
      btn.innerText = 'Delete';
    }
  })
  .catch(err => {
    console.error('Delete error:', err);
    alert('Request failed: ' + err.message);
    btn.disabled = false;
    btn.innerText = 'Delete';
  });
});
</script>

</body>
</html>
