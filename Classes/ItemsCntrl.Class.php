<?php
include_once __DIR__ . '/Items.Class.php';

class ItemsCntrl extends Items {

    private $name;
    private $quantity;
    private $price;
    private $size;
    private $model;
    private $id;

    public function __construct($id = "", $name = "", $quantity = "", $price = "", $size = "", $model = "") {
        $this->id = $id;
        $this->name = $name;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->size = $size;
        $this->model = $model;
        
    }

    // Add Item
    public function addItem() {

        if ($this->checkEmptyFields($this->name, $this->quantity, $this->price, $this->size, $this->model)) {
            return false;
        }

        return $this->insertItem(
            $this->id,
            $this->name,
            $this->quantity,
            $this->price,
            $this->size,
            $this->model,
        );
    }

    // Add Reservation
    public function addReservation($materialID, $userID, $quantity, $requestor, $claimDate, $remarks) {

        if ($this->checkEmptyFields($materialID, $quantity, $requestor, $claimDate, $remarks)) {
            return false;
        }

        // Implementation for adding reservation
        return $this->insertReservation(
            $materialID,
            $userID,
            $quantity,
            $requestor,
            $claimDate,
            $remarks
        );
    }

    // Update Item
    public function updateItem() {

        if ($this->checkEmptyFields($this->name, $this->quantity, $this->price, $this->size, $this->model)) {
            return false;
        }

        return $this->updateItemDB(
            $this->name,
            $this->quantity,
            $this->price,
            $this->size,
            $this->model,
            $this->id
        );
    }

    // Update Reservation
    public function updateReservation($reservationID, $quantity, $requestor, $purpose, $claimingDate) {

        return $this->updateReservationDB(
            $reservationID,
            $quantity,
            $requestor,
            $purpose,
            $claimingDate
        );
    }

    // Delete Item
    public function deleteItem() {

        return $this->deleteItemDB(
            $this->id
        );

    }

    // Delete Reservation
    public function deleteReservation($ID) {

        return $this->deleteReservationDB(
            $ID
        );

    }

    private function checkEmptyFields($name, $quantity, $price, $size, $model) {
        return empty($name) || empty($quantity) || empty($price) || empty($size) || empty($model);
    }
}
