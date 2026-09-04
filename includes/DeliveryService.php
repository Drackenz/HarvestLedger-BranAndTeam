<?php
require_once __DIR__ . '/../Models/Delivery.php';

/**
 * Manages the collection of deliveries stored in the session and persisted to a JSON file.
 */
class DeliveryService
{
    private $filePath;

    public function __construct()
    {
        $this->filePath = __DIR__ . '/../data/deliveries.json';

        if (!isset($_SESSION['deliveries'])) {
            $_SESSION['deliveries'] = $this->loadFromFile();
        }
    }

    public function addDelivery($delivery)
    {
        $_SESSION['deliveries'][] = $delivery;
        $this->saveToFile();
    }

    public function getAllDeliveries()
    {
        return $_SESSION['deliveries'];
    }

    public function deleteDelivery($index)
    {
        if (isset($_SESSION['deliveries'][$index])) {
            array_splice($_SESSION['deliveries'], $index, 1);
            $this->saveToFile();
        }
    }

    public function clearDeliveries()
    {
        $_SESSION['deliveries'] = [];
        $this->saveToFile();
    }

    /**
     * Checks if the same producer already delivered today, to avoid duplicates.
     */
    public function isDuplicate($producerName, $date)
    {
        foreach ($_SESSION['deliveries'] as $delivery) {
            if ($delivery->producerName == $producerName && $delivery->date == $date) {
                return true;
            }
        }
        return false;
    }

    private function saveToFile()
    {
        $data = [];
        foreach ($_SESSION['deliveries'] as $delivery) {
            $data[] = (array) $delivery;
        }

        try {
            file_put_contents($this->filePath, json_encode($data, JSON_PRETTY_PRINT));
        } catch (Exception $e) {
            // If the write fails, the session data is kept in memory and the app keeps working.
        }
    }

    private function loadFromFile()
    {
        if (!file_exists($this->filePath)) {
            file_put_contents($this->filePath, json_encode([]));
            return [];
        }

        try {
            $content = file_get_contents($this->filePath);
            $rawData = json_decode($content, true);
        } catch (Exception $e) {
            return [];
        }

        if ($rawData === null) {
            return [];
        }

        $deliveries = [];
        foreach ($rawData as $item) {
            $deliveries[] = new Delivery($item['producerName'], $item['weightQuintals'], $item['qualityGrade'], $item['pricePerQuintal'], $item['date']);
        }

        return $deliveries;
    }
}