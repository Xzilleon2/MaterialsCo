<?php
session_start();

include __DIR__ . "/../../Classes/ItemsCntrl.Class.php";

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['updateBtn'])) {

    // Sanitize input
    $reservationID = filter_var(trim($_POST['reservationId']), FILTER_SANITIZE_NUMBER_INT);;
    $quantity = filter_var(trim($_POST['quantity']), FILTER_SANITIZE_NUMBER_INT);
    $requestor = filter_var(trim($_POST['requestor']), FILTER_SANITIZE_SPECIAL_CHARS);
    $purpose = filter_var(trim($_POST['remarks']), FILTER_SANITIZE_SPECIAL_CHARS);
    $claimingDate = $_POST['claimingDate'];

    // Controller
    $items = new ItemsCntrl();

    // Execute registration
    if(!$items->updateReservation($reservationID, $quantity, $requestor, $purpose, $claimingDate)){
        $_SESSION['ReservationMessage'] = "ERROR UPDATING RESERVATION!";
    }
    else{
         $_SESSION['ReservationMessageSuccess'] = "UPDATE SUCCESSFUL!";
    }

   header("Location: ../../Reservation.php");
    exit();

} else {
    header("Location: ../Reservation.php?error=FailedtoAddItem");
    exit();
}