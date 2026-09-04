<?php
/**
 * Represents one coffee delivery registered at the receiving station.
 */
class Delivery
{
    public string $producerName;
    public float $weightQuintals;
    public string $qualityGrade;
    public float $pricePerQuintal;
    public float $amountPayable;
    public string $date;

    public function __construct($producerName, $weightQuintals, $qualityGrade, $pricePerQuintal, $date)
    {
        $this->producerName = $producerName;
        $this->weightQuintals = $weightQuintals;
        $this->qualityGrade = $qualityGrade;
        $this->pricePerQuintal = $pricePerQuintal;
        $this->date = $date;
        $this->amountPayable = $this->calculateAmount();
    }

    /**
     * Calculates the amount payable, adjusted by quality grade.
     * @return float The final amount to pay the producer.
     */
    private function calculateAmount()
    {
        $gradeMultiplier = 1.0;

        if ($this->qualityGrade == "A") {
            $gradeMultiplier = 1.0;
        } elseif ($this->qualityGrade == "B") {
            $gradeMultiplier = 0.9;
        } elseif ($this->qualityGrade == "C") {
            $gradeMultiplier = 0.8;
        }

        return $this->weightQuintals * $this->pricePerQuintal * $gradeMultiplier;
    }
}