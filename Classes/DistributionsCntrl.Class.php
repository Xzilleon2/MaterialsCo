<?php
include_once __DIR__ . '/Distributions.Class.php';

class DistributionsCntrl extends Distributions {

    // Attributes
    private $materialId;
    private $userId;
    private $quantity;
    private $location;
    private $remarks;
    private $reservationId;

    // Constructor
    public function __construct($materialId = 0, $userId = 0, $quantity = 0, $location = "", $remarks = "", $reservationId = null) {
        $this->materialId = $materialId;
        $this->userId = $userId;
        $this->quantity = $quantity;
        $this->location = $location;
        $this->remarks = $remarks;
        $this->reservationId = $reservationId;
    }

    // Add Distributions
}