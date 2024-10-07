<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: /Roombooking/src/login.php");
    exit();
}

// Include the database configuration file
include '../config.php';

// Get the form data
$room_id = isset($_POST['room_id']) ? intval($_POST['room_id']) : 0;
$checkin_date = isset($_POST['checkin_date']) ? $_POST['checkin_date'] : '';
$checkout_date = isset($_POST['checkout_date']) ? $_POST['checkout_date'] : '';
$adults = isset($_POST['adults']) ? intval($_POST['adults']) : 0;
$children = isset($_POST['children']) ? intval($_POST['children']) : 0;
$payment_method = isset($_POST['payment_method']) ? $_POST['payment_method'] : '';

// Validate the form data
if ($room_id && $checkin_date && $checkout_date && $adults >= 0 && $children >= 0 && $payment_method) {
    // Start a transaction
    $conn->begin_transaction();

    try {
        // Insert the booking into the database
        $sql = "INSERT INTO bookings (room_id, user_id, check_in, check_out, adults, children, status) VALUES (?, ?, ?, ?, ?, ?, 'confirmed')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iissii", $room_id, $_SESSION['user_id'], $checkin_date, $checkout_date, $adults, $children);
        $stmt->execute();

        // Update the room's availability
        $sql_update = "UPDATE rooms SET available = FALSE WHERE id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("i", $room_id);
        $stmt_update->execute();

        // Commit the transaction
        $conn->commit();

        // Redirect to a confirmation page or payment gateway
        header("Location: confirmation.php?booking_id=" . $stmt->insert_id);
        exit();
    } catch (Exception $e) {
        // Rollback the transaction if something goes wrong
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid form data.";
}
?>