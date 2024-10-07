<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: /Roombooking/src/login.php");
    exit();
}

// Include the database configuration file
include '../config.php';

// Get the booking ID from the query parameter
$booking_id = isset($_GET['booking_id']) ? intval($_GET['booking_id']) : 0;

// Fetch booking details from the database
$sql = "SELECT b.id, b.check_in, b.check_out, b.adults, b.children, b.status, r.room_number, rt.name AS room_type
        FROM bookings b
        JOIN rooms r ON b.room_id = r.id
        JOIN room_types rt ON r.type_id = rt.id
        WHERE b.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();

// Check if the booking exists
if (!$booking) {
    echo "Booking not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto mt-10">
        <h1 class="text-2xl font-bold mb-5">Booking Confirmation</h1>
        <p class="mb-5">Thank you for your booking! Here are your booking details:</p>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <p><strong>Room Number:</strong> <?php echo htmlspecialchars($booking['room_number']); ?></p>
            <p><strong>Room Type:</strong> <?php echo htmlspecialchars($booking['room_type']); ?></p>
            <p><strong>Check-in Date:</strong> <?php echo htmlspecialchars($booking['check_in']); ?></p>
            <p><strong>Check-out Date:</strong> <?php echo htmlspecialchars($booking['check_out']); ?></p>
            <p><strong>Adults:</strong> <?php echo htmlspecialchars($booking['adults']); ?></p>
            <p><strong>Children:</strong> <?php echo htmlspecialchars($booking['children']); ?></p>
            <p><strong>Status:</strong> <?php echo htmlspecialchars($booking['status']); ?></p>
        </div>
    </div>
</body>
</html>