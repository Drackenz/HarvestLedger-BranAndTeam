<?php
session_start();
require_once __DIR__ . '/Models/Delivery.php';
require_once __DIR__ . '/includes/DeliveryService.php';
require_once __DIR__ . '/includes/validation.php';

$deliveryService = new DeliveryService();
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addDelivery'])) {
    $producerName = $_POST['producerName'];
    $weight = $_POST['weightQuintals'];
    $qualityGrade = $_POST['qualityGrade'];
    $pricePerQuintal = $_POST['pricePerQuintal'];

    $errors = validateDeliveryInput($producerName, $weight, $qualityGrade, $pricePerQuintal);

    if (count($errors) == 0) {
        $newDelivery = new Delivery($producerName, (float)$weight, $qualityGrade, (float)$pricePerQuintal, date("d/m/Y"));
        $deliveryService->addDelivery($newDelivery);
    }
}

if (isset($_POST['clearSession'])) {
    $deliveryService->clearDeliveries();
}

$deliveries = $deliveryService->getAllDeliveries();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Harvest Ledger</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h1>Harvest Ledger</h1>
    <p>Coffee delivery &amp; payment register - Cooperativa Cafetalera El Manantial</p>

    <?php include __DIR__ . '/views/delivery_form.php'; ?>
    <?php include __DIR__ . '/views/deliveries_table.php'; ?>
</body>
</html>