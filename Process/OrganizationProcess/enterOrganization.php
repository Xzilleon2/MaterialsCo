<?php
session_start();

include __DIR__ . "/../../Classes/OrganizationCntrl.Class.php";

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['updateBtn'])) {

    // Sanitize input
    $remarks = filter_var(trim($_POST['remarks']), FILTER_SANITIZE_SPECIAL_CHARS);
    $organizationID = filter_var(trim($_POST['organizationId']), FILTER_SANITIZE_NUMBER_INT);
    $USERID = $_SESSION['USER_ID'];

    // Controller
    $organization = new OrganizationCntrl();

    // Execute registration
    if(!$organization->enterOrganization($USERID, $organizationID, $remarks)){
        $_SESSION['OrganizationMessage'] = "ERROR JOINING ORGANIZATION!";
    }
    else{
        $_SESSION['OrganizationMessageSuccess'] = "APPLICATION SUBMITTED SUCCESSFULLY!";
    }

    // Redict after processing
    header("Location: ../../organization.php");
    exit();

} else {
    header("Location: ../organization.php?error=FailedtoSubmitApplication");
    exit();
}