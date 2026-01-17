<?php
include_once __DIR__ . '/Organization.Class.php';

class OrganizationView extends Organization{

    // View all Organizations
    public function viewOrganizations(){
        return $this->getOrganizations();
    }

    //View all Members
    public function viewMembers(){
        return $this->getMembers();
    }
    
}