<?php
include "server_connection.php";

$order_id = (int)$_GET['order_id'];

$orderRes = $conn->query("SELECT * FROM orders WHERE order_id = $order_id");
$od = $orderRes->fetch_assoc();

$itemsRes = $conn->query("SELECT * FROM order_items WHERE order_id = $order_id");

// QR Code URL
$qr_link = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=OrderID_$order_id";
?>

<style>
body { font-family: 'Arial'; color:#333; }

.invoice-box {
    max-width: 800px;
    margin: auto;
    padding: 20px 40px;
    border: 1px solid #ddd;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.logo {
    font-size: 28px;
    font-weight: bold;
    color: #4F46E5;
}

.info-box {
    width: 45%;
    padding: 10px;
    border: 1px solid #ddd;
    margin-top: 15px;
}

.table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 25px;
}

.table th {
    background: #f3f4f6;
    padding: 10px;
    border: 1px solid #ddd;
}

.table td {
    padding: 10px;
    border: 1px solid #ddd;
}

.table tr:nth-child(even){
    background: #f9f9f9;
}

.total-row td {
    font-size: 18px;
    font-weight: bold;
    background: #eef2ff;
}

.footer {
    text-align: center;
    margin-top: 35px;
    font-size: 14px;
    color: #555;
    padding-top: 10px;
    border-top: 1px solid #ddd;
}
</style>

<div class="invoice-box">

    <!-- Header -->
    <div class="header">
        <div class="logo">ShopPro Invoice</div>

        <div>
            <img src="<?php echo $qr_link; ?>" width="100">
        </div>
    </div>

    <hr style="margin-top:20px; margin-bottom:20px;">

    <!-- Invoice Info -->
    <p><strong>Invoice #:</strong> <?php echo $order_id; ?></p>
    <p><strong>Date:</strong> <?php echo $od['created_at']; ?></p>

    <!-- Billing + Shop Info -->
    <div style="display:flex; justify-content:space-between; margin-top:20px;">

        <!-- Customer -->
        <div class="info-box">
            <h3 style="margin-bottom:10px;">Billing Details</h3>
            <p><strong><?php echo $od['customer_name']; ?></strong></p>
            <p>Email: <?php echo $od['email']; ?></p>
            <p>Phone: <?php echo $od['phone']; ?></p>
            <p>Address: <?php echo $od['address']; ?></p>
            <p><?php echo $od['city']; ?> - <?php echo $od['postal_code']; ?></p>
            <p><?php echo $od['country']; ?></p>
        </div>

        <!-- Shop Info -->
        <div class="info-box">
            <h3 style="margin-bottom:10px;">ShopPro</h3>
            <p>ShopPro E-commerce</p>
            <p>Dhaka, Bangladesh</p>
            <p>Email: support@shoppro.com</p>
            <p>Phone: +880 1234-567890</p>
            <p>Website: shoppro.com</p>
        </div>

    </div>

    <!-- Status Box -->
    <div style="margin-top:25px;">
        <p><strong>Payment Method:</strong> <?php echo $od['payment_method']; ?></p>
        <p><strong>Payment Status:</strong> <?php echo $od['payment_status']; ?></p>
        <p><strong>Order Status:</strong> <?php echo $od['order_status']; ?></p>
    </div>

    <!-- Items Table -->
    <table class="table">
        <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Qty</th>
            <th>Total</th>
        </tr>

        <?php
        $grandTotal = 0;
        while($it = $itemsRes->fetch_assoc()){
            $grandTotal += $it['total'];

            echo "
            <tr>
                <td>{$it['product_name']}</td>
                <td>\${$it['price']}</td>
                <td>{$it['qty']}</td>
                <td>\${$it['total']}</td>
            </tr>
            ";
        }
        ?>

        <tr class="total-row">
            <td colspan="3" align="right">Grand Total:</td>
            <td>$<?php echo $grandTotal; ?></td>
        </tr>
    </table>

    <!-- Footer -->
    <div class="footer">
        Thank you for shopping with ShopPro!  
        <br>For support, contact: support@shoppro.com
    </div>

</div>
