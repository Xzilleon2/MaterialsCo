<?php
include_once __DIR__ . '/Items.Class.php';

class ItemsCntrl extends Items{

    // Attributes
    private $name;
    private $email;
    private $age;
    private $password;
    private $passwordRep;

    // Constructor
    public function __construct($name = "", $email = "", $age = "", $password = "", $passwordRep = "") {
        $this->name = $name;
        $this->email = $email;
        $this->age = $age;
        $this->password = $password;
        $this->passwordRep = $passwordRep;
    }


    
}