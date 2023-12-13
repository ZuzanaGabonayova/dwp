<?php

require_once __DIR__ . '../../../vendor/tecnickcom/tcpdf/tcpdf.php';
require_once __DIR__ . '../../config/db.php';
require_once __DIR__ . '../../orders/ReadOrders.php'; // Adjust the path to ReadOrders.php

$order_id = $_GET['order_id'] ?? null; 

if (!$order_id) {
    die("Order ID is required.");
}

$readOrders = new ReadOrders($conn);
$result = $readOrders->readOrders(); // Modify this method or create a new one to fetch a single order by ID

// Initialize TCPDF object
$pdf = new TCPDF();

// Add a page and some content
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 10);

// Iterate through your order data and add it to the PDF
while ($row = $result->fetch_assoc()) {
    if ($row['id'] == $order_id) {
        $pdf->Cell(0, 10, "Order ID: " . $row['id'], 0, 1);
        // Add more order details
        $pdf->Cell(0, 10, "Product: " . $row['product_name'] . " - Quantity: " . $row['quantity'], 0, 1);
        $pdf->Cell(0, 10, "Customer Name: " . $row['customer_name'], 0, 1);
        $pdf->Cell(0, 10, "Customer Email: " . $row['customer_email'], 0, 1);
        $pdf->Cell(0, 10, "Customer Phone: " . $row['customer_phone'], 0, 1);
        $pdf->Cell(0, 10, "Customer Shipping Address: " . $row['shipping_address'], 0, 1);
        $pdf->Cell(0, 10, "City: " . $row['city'], 0, 1);
        $pdf->Cell(0, 10, "Amount Total: " . $row['amount_total'], 0, 1);
        $pdf->Cell(0, 10, "Currency: " . $row['currency'], 0, 1);
        $pdf->Cell(0, 10, "Created At: " . $row['created_at'], 0, 1);
        // ...
    }
}

// Close and output PDF document
$pdf->Output('order_' . $order_id . '.pdf', 'I');

?>