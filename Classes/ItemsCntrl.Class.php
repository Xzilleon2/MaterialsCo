<?php
include_once __DIR__ . '/Items.Class.php';

class ItemsCntrl extends Items {

    private $name;
    private $quantity;
    private $price;
    private $size;
    private $model;
    private $id;

    public function __construct($name = "", $quantity = "", $price = "", $size = "", $model = "", $id = "") {
        $this->name = $name;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->size = $size;
        $this->model = $model;
        $this->id = $id;
    }

    // Add Item
    public function addItem() {

        if ($this->checkEmptyFields($this->name, $this->quantity, $this->price, $this->size, $this->model)) {
            return false;
        }

        return $this->insertItem(
            $this->name,
            $this->quantity,
            $this->price,
            $this->size,
            $this->model
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

    // Delete Item
    public function deleteItem() {

        return $this->deleteItemDB(
            $this->id
        );
        
    }

    private function checkEmptyFields($name, $quantity, $price, $size, $model) {
        return empty($name) || empty($quantity) || empty($price) || empty($size) || empty($model);
    }
}
