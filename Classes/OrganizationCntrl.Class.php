<?php
include_once __DIR__ . '/Organization.Class.php';

class OrganizationCntrl extends Organization {

    private $id;
    private $name;
    private $address;
    private $type;

    public function __construct($id = "", $name = "", $address = "", $type = "") {
        $this->id = $id;
        $this->name = $name;
        $this->address = $address;
        $this->type = $type;
        
    }

    // Add Organization
    public function addOrganization() {

        return $this->insertOrganization(
            $this->id,
            $this->name,
            $this->address,
            $this->type
        );
    }

}
