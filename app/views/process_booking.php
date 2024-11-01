<?php
session_start();

// Include the database connection
$config = include __DIR__ . '/../config/database.php';

try {
    $conn = new mysqli(
        $config['host'],
        $config['user'],
        $config['password'],
        $config['dbname']
    );

    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Ensure the character set is set correctly
    $conn->set_charset("utf8mb4");
} catch (Exception $e) {
    die("Connection failed: " . $e->getMessage());
}

// Get the form data
$room_id = isset($_POST['room_id']) ? intval($_POST['room_id']) : 0;
$checkin_date = isset($_POST['checkin_date']) ? $_POST['checkin_date'] : '';
$checkout_date = isset($_POST['checkout_date']) ? $_POST['checkout_date'] : '';
$num_adults = isset($_POST['num_adults']) ? intval($_POST['num_adults']) : 0;
$num_children = isset($_POST['num_children']) ? intval($_POST['num_children']) : 0;
$payment_method = isset($_POST['payment_method']) ? $_POST['payment_method'] : '';

// Validate the form data
if ($room_id && $checkin_date && $checkout_date && $num_adults >= 0 && $num_children >= 0 && $payment_method) {
    // Start a transaction
    $conn->begin_transaction();

    try {
        // Insert the booking into the database
        $sql = "INSERT INTO bookings (room_id, user_id, check_in, check_out, adults, children, status) VALUES (?, ?, ?, ?, ?, ?, 'confirmed')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iissii", $room_id, $_SESSION['user_id'], $checkin_date, $checkout_date, $num_adults, $num_children);
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
