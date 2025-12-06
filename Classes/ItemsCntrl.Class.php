<?php
include_once __DIR__ . '/Items.Class.php';

class ItemsCntrl extends Items{

    // Attributes
    private $name;
    private $quantity;
    private $price;
    private $size;
    private $model;

    // Constructor
    public function __construct($name = "", $quantity = "", $price = "", $size = "", $model = "") {
        $this->name = $name;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->size = $size;
        $this->model = $model;
    }

    public function addItem(){

        // Error Handlings
        if($this->checkEmptyFields($this->name, $this->quantity, $this->price, $this->size, $this->model)){
            $_SESSION['LogmessageReg'] = "Empty Input Fields!";
            header("Location: ../Inventory.php?error=EmptyInputs");
            exit();
        }

        // Insert to DB
        $this->insertItem($this->name, $this->quantity, $this->price, $this->size, $this->model);
    }

    private function checkEmptyFields($name, $quantity, $price, $size, $model){
        return empty($name) || empty($quantity) || empty($price) || empty($size) || empty($model);
    }

    
}