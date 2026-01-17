<?php
session_start();

include __DIR__ . "/../../Classes/OrganizationCntrl.Class.php";

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['addBtn'])) {

    // Sanitize input
    $remarks = filter_var(trim($_POST['remarks']), FILTER_SANITIZE_SPECIAL_CHARS);
    $USERID = $_SESSION['USER_ID'];

    // Controller
    $organization = new OrganizationCntrl();

    // Execute registration
    if(!$organization->leaveOrganization($USERID, $remarks)){
        $_SESSION['OrganizationMessage'] = "ERROR LEAVING ORGANIZATION!";
    }
    else{
        $_SESSION['OrganizationMessageSuccess'] = "LEFT ORGANIZATION SUCCESSFULLY!";
    }

    // Redict after processing
    header("Location: ../../organization.php");
    exit();

} else {
    header("Location: ../organization.php?error=FailedtoLeaveOrganization");
    exit();
}