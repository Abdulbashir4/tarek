<?php
include "server_connection.php";

// DomPDF autoload (Composer ছাড়া)
require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;

// কোনো order ID না এলে stop
if(!isset($_GET['order_id'])){
    die("Invalid request");
}

$order_id = (int)$_GET['order_id'];

// --- Load Invoice HTML ---
ob_start();
include "invoice.php"; // আমরা নতুন ফাইল ব্যবহার করবো
$html = ob_get_clean();

// --- DOMPDF Generate ---
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// ---- DOWNLOAD PDF ----
$dompdf->stream("Invoice_$order_id.pdf", ["Attachment" => true]);
exit;
