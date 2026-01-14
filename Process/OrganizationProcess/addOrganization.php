<?php
session_start();

include __DIR__ . "/../../Classes/OrganizationCntrl.Class.php";

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['addBtn'])) {

    // Sanitize input
    $name = filter_var(trim($_POST['organizationName']), FILTER_SANITIZE_SPECIAL_CHARS);
    $address = filter_var(trim($_POST['organizationAddress']), FILTER_SANITIZE_SPECIAL_CHARS);
    $type = filter_var(trim($_POST['organizationType']), FILTER_SANITIZE_SPECIAL_CHARS);
    $USERID = $_SESSION['USER_ID'];

    // Controller
    $organization = new OrganizationCntrl($USERID, $name, $address, $type);
    // Execute registration
    if(!$organization->addOrganization()){
        $_SESSION['OrganizationMessage'] = "ERROR INSERTING ORGANIZATION!";
    }
    else{
        $_SESSION['OrganizationMessageSuccess'] = "INSERT SUCCESSFUL!";
    }

    // Redict after processing
    header("Location: ../../organization.php");
    exit();

} else {
    header("Location: ../organization.php?error=FailedtoAddOrganization");
    exit();
}