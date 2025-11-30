<?php
include "server_connection.php";

$order_id = (int)$_GET['order_id'];

$orderRes = $conn->query("SELECT * FROM orders WHERE order_id = $order_id");
$od = $orderRes->fetch_assoc();

$itemsRes = $conn->query("SELECT * FROM order_items WHERE order_id = $order_id");
?>

<div style="font-family: Arial;">

<h2 style="text-align:center; color:#4F46E5;">ShopPro Invoice</h2>
<hr>

<p><strong>Invoice ID:</strong> #<?php echo $od['order_id']; ?></p>
<p><strong>Date:</strong> <?php echo $od['created_at']; ?></p>

<h3>Billing Details</h3>
<p><strong>Name:</strong> <?php echo $od['customer_name']; ?></p>
<p><strong>Email:</strong> <?php echo $od['email']; ?></p>
<p><strong>Phone:</strong> <?php echo $od['phone']; ?></p>
<p><strong>Address:</strong> <?php echo $od['address']; ?>, <?php echo $od['city']; ?> - <?php echo $od['postal_code']; ?></p>
<p><strong>Country:</strong> <?php echo $od['country']; ?></p>

<h3>Order Items</h3>

<table width="100%" border="1" cellspacing="0" cellpadding="8">
    <tr style="background:#f3f3f3;">
        <th>Product</th>
        <th>Price</th>
        <th>Qty</th>
        <th>Total</th>
    </tr>

<?php
$total = 0;
while($it = $itemsRes->fetch_assoc()){
    $total += $it['total'];
    echo "
    <tr>
        <td>{$it['product_name']}</td>
        <td>\${$it['price']}</td>
        <td>{$it['qty']}</td>
        <td>\${$it['total']}</td>
    </tr>";
}
?>

<tr>
    <td colspan="3" align="right"><strong>Grand Total:</strong></td>
    <td><strong>$<?php echo $total; ?></strong></td>
</tr>

</table>

</div>
