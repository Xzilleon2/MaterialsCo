<?php
session_start();

include __DIR__ . "/../../Classes/OrganizationCntrl.Class.php";

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['updateBtn'])) {

    // Sanitize input
    $status = filter_var(trim($_POST['is_active']), FILTER_SANITIZE_SPECIAL_CHARS);
    $memberID = filter_var(trim($_POST['memberId']), FILTER_SANITIZE_NUMBER_INT);

    // Controller
    $organization = new OrganizationCntrl();

    // Execute registration
    if(!$organization->updateMemberStatus($memberID, $status)){
        $_SESSION['OrganizationMessage'] = "ERROR UPDATING STATUS!";
    }
    else{
        $_SESSION['OrganizationMessageSuccess'] = "STATUS UPDATED SUCCESSFULLY!";
    }

    // Redict after processing
    header("Location: ../../organization.php");
    exit();

} else {
    header("Location: ../organization.php?error=FailedtoUpdateStatus");
    exit();
}