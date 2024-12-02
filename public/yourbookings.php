<?php
// Include the database connection file
include __DIR__ . '/../app/core/db_connect.php';

// Start session if it hasn't been started already
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Get the logged-in user's ID from the session
$user_id = $_SESSION['user_id'];

// Prepare SQL query to fetch the user's bookings
$sql = "SELECT b.id AS booking_id, r.room_number, b.check_in, b.check_out, b.status
        FROM bookings b
        JOIN rooms r ON b.room_id = r.id
        WHERE b.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();

// Get the result set from the executed query
$result = $stmt->get_result();
$bookings = $result->fetch_all(MYSQLI_ASSOC);

// Close the statement and database connection
$stmt->close();
$conn->close();

// Set the view file to be included
$view = __DIR__ . '/../app/views/yourbookings.php';

// Include the main layout file which will include the view file
include __DIR__ . '/../app/views/layouts/main.php';
