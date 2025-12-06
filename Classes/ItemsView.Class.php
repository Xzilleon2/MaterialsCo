<?php
include_once __DIR__ . '/ItemsCntrl.Class.php';

class ItemsView extends ItemsCntrl{

    // View all Inventory Items
    public function viewInventory(){
        return $this->getInventory();
    }

    // View all Reservation Items
    public function viewReservations(){
        return $this->getReservations();
    }
    
}