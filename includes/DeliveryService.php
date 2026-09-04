<?php
require_once __DIR__ . '/../Models/Delivery.php';

/**
 * Manages the collection of deliveries stored in the session.
 */
class DeliveryService
{
    public function __construct()
    {
        if (!isset($_SESSION['deliveries'])) {
            $_SESSION['deliveries'] = [];
        }
    }

    public function addDelivery($delivery)
    {
        $_SESSION['deliveries'][] = $delivery;
    }

    public function getAllDeliveries()
    {
        return $_SESSION['deliveries'];
    }

    public function clearDeliveries()
    {
        $_SESSION['deliveries'] = [];
    }
}