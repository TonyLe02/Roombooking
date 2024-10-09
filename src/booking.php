<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: /Roombooking/src/login.php");
    exit();
}

// Include the database configuration file
include '../config.php';

// Get the room ID from the query parameter
$room_id = isset($_GET['room_id']) ? intval($_GET['room_id']) : 0;

// Fetch room details from the database
$sql = "SELECT r.room_number, rt.name AS room_type FROM rooms r JOIN room_types rt ON r.type_id = rt.id WHERE r.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $room_id);
$stmt->execute();
$result = $stmt->get_result();
$room = $result->fetch_assoc();

// Check if the room exists
if (!$room) {
    echo "Room not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Room</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto mt-10">
        <h1 class="text-3xl font-bold mb-4 text-center text-blue-600">Book Room: <?php echo htmlspecialchars($room['room_number']); ?></h1>
        <p class="text-lg text-center mb-5">Room Type: <?php echo htmlspecialchars($room['room_type']); ?></p>

        <form method="POST" action="process_booking.php" class="bg-white p-8 rounded-lg shadow-md max-w-lg mx-auto">
            <input type="hidden" name="room_id" value="<?php echo $room_id; ?>">

            <div class="mb-6">
                <label for="checkin_date" class="block text-sm font-medium text-gray-700 mb-1">Check-in </label>
                <input type="text" id="checkin_date" name="checkin_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" placeholder="Select Date" required>
            </div>

            <div class="mb-6">
                <label for="checkout_date" class="block text-sm font-medium text-gray-700 mb-1">Check-out </label>
                <input type="text" id="checkout_date" name="checkout_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" placeholder="Select Date" required>
            </div>

            <div class="mb-6">
                <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-1">Payment Method</label>
                <select id="payment_method" name="payment_method" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                    <option value="credit_card">Credit Card</option>
                    <option value="paypal">PayPal</option>
                </select>
            </div>

            <button type="submit" class="mt-4 w-full rounded-md bg-green-600 px-4 py-2 text-white font-semibold hover:bg-green-700 transition duration-300">Proceed to Payment</button>
        </form>

        <div class="mt-6 text-center">
            <a href="search.php" class="inline-block rounded-md bg-gray-600 px-4 py-2 text-white hover:bg-gray-700 transition duration-300">Return to Booking</a>
        </div>
    </div>

    <!-- Include Flatpickr JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        // Initialize Flatpickr for both date fields
        flatpickr("#checkin_date", {
            dateFormat: "Y-m-d",
            minDate: "today",
            onChange: function(selectedDates) {
                // Set the minimum date for check-out to be the day after the selected check-in date
                const checkinDate = selectedDates[0];
                if (checkinDate) {
                    // Update the checkout date picker
                    checkoutFlatpickr.set('minDate', new Date(checkinDate.getTime() + 86400000)); // Add one day to the check-in date
                    checkoutFlatpickr.clear(); // Clear the previous checkout date if it's earlier than the new min date
                }
            }
        });

        const checkoutFlatpickr = flatpickr("#checkout_date", {
            dateFormat: "Y-m-d",
            minDate: "today",
        });
    </script>
</body>

</html>
