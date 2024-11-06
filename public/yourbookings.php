<?php
// Database connection
include __DIR__ . '/../app/core/db_connect.php';

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
$user_id = $_SESSION['user_id'];

// Fetch user's bookings
$sql = "SELECT b.id AS booking_id, r.room_number, b.check_in, b.check_out, b.status
        FROM bookings b
        JOIN rooms r ON b.room_id = r.id
        WHERE b.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$bookings = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$conn->close();

// Set the view file to be included
$view = __DIR__ . '/../app/views/yourbookings.php';

// Include the main layout file
include __DIR__ . '/../app/views/layouts/main.php';
