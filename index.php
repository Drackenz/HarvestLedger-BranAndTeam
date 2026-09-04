<?php
require_once __DIR__ . '/Models/Delivery.php';
require_once __DIR__ . '/includes/DeliveryService.php';
require_once __DIR__ . '/includes/validation.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$deliveryService = new DeliveryService();
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addDelivery'])) {
    $producerName = trim($_POST['producerName']);
    $weight = $_POST['weightQuintals'];
    $qualityGrade = $_POST['qualityGrade'];
    $pricePerQuintal = $_POST['pricePerQuintal'];
    $today = date("d/m/Y");

    $errors = validateDeliveryInput($producerName, $weight, $qualityGrade, $pricePerQuintal);

    if (count($errors) == 0 && $deliveryService->isDuplicate($producerName, $today)) {
        $errors[] = "This producer already has a delivery registered today.";
    }

    if (count($errors) == 0) {
        $newDelivery = new Delivery($producerName, (float)$weight, $qualityGrade, (float)$pricePerQuintal, $today);
        $deliveryService->addDelivery($newDelivery);
    }
}

if (isset($_POST['clearSession'])) {
    $deliveryService->clearDeliveries();
}

if (isset($_GET['deleteId'])) {
    $deliveryService->deleteDelivery((int)$_GET['deleteId']);
    header("Location: index.php");
    exit;
}

$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
$allDeliveries = $deliveryService->getAllDeliveries();

if ($searchTerm != '') {
    $deliveries = array_filter($allDeliveries, function ($delivery) use ($searchTerm) {
        return stripos($delivery->producerName, $searchTerm) !== false;
    });
} else {
    $deliveries = $allDeliveries;
}
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