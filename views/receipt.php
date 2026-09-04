<?php
session_start();
require_once __DIR__ . '/../Models/Delivery.php';

$deliveries = $_SESSION['deliveries'] ?? [];
$id = $_GET['id'] ?? null;

if ($id === null || !isset($deliveries[$id])) {
    echo "<p>Receipt not found.</p>";
    exit;
}

$delivery = $deliveries[$id];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Receipt - Harvest Ledger</title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        @media print {
            button { display: none; }
        }
    </style>
</head>
<body>
    <section id="pnlReceipt">
        <h1>Delivery Receipt</h1>
        <p>Cooperativa Cafetalera El Manantial</p>
        <hr>
        <p><strong>Producer:</strong> <?php echo $delivery->producerName; ?></p>
        <p><strong>Date:</strong> <?php echo $delivery->date; ?></p>
        <p><strong>Weight:</strong> <?php echo $delivery->weightQuintals; ?> quintals</p>
        <p><strong>Quality grade:</strong> <?php echo $delivery->qualityGrade; ?></p>
        <p><strong>Price per quintal:</strong> US$ <?php echo number_format($delivery->pricePerQuintal, 2); ?></p>
        <p><strong>Amount payable:</strong> US$ <?php echo number_format($delivery->amountPayable, 2); ?></p>
    </section>
    <button id="btnPrint" onclick="window.print();">Print receipt</button>
</body>
</html>