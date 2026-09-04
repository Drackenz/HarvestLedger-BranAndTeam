<?php
/**
 * Validates the raw form input for a new delivery.
 * Returns a list of English error messages. Empty if everything is valid.
 */
function validateDeliveryInput($producerName, $weight, $qualityGrade, $pricePerQuintal)
{
    $errors = [];

    if (trim($producerName) == "") {
        $errors[] = "Please enter a producer name.";
    }

    if (!is_numeric($weight) || $weight <= 0) {
        $errors[] = "Weight must be a positive number.";
    }

    if ($qualityGrade != "A" && $qualityGrade != "B" && $qualityGrade != "C") {
        $errors[] = "Select a valid quality grade.";
    }

    if (!is_numeric($pricePerQuintal) || $pricePerQuintal <= 0) {
        $errors[] = "Price per quintal must be a positive number.";
    }
    
    if (strlen($producerName) > 100) {
    $errors[] = "Producer name must be under 100 characters.";
}

    return $errors;
}