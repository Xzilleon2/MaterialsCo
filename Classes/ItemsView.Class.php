<?php
include_once __DIR__ . '/ItemsCntrl.Class.php';

class ItemsView extends ItemsCntrl{

    // View all Inventory Items
    public function viewInventory($userID){
        return $this->getInventory($userID);
    }

    // View all Reservation Items
    public function viewReservations($userID){
        return $this->getReservations($userID);
    }

    // View all Stocks
    public function viewStocks($userID){
        return $this->getStocks($userID);
    }
    
}