<!-- Booking form or content goes here -->
<?php

// Fetch room data
$room_id = $_GET['room_id'] ?? null;
$room = null;

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

<body class="bg-gray-100">
    <div class="container mx-auto mt-10">
        <h1 class="text-3xl font-bold mb-4 text-center text-green-600">Book Room: <?php echo htmlspecialchars($room['room_number']); ?></h1>
        <p class="text-lg text-center mb-5 text-gray-700">Room Type: <?php echo htmlspecialchars($room['room_type']); ?></p>

        <form method="POST" action="process_booking.php" class="bg-white p-8 rounded-xl shadow-lg max-w-lg mx-auto border border-gray-200">
            <input type="hidden" name="room_id" value="<?php echo $room_id; ?>">

            <div class="mb-6">
                <label for="checkin_date" class="block text-sm font-medium text-gray-700 mb-2">Check-in Date</label>
                <input type="text" id="checkin_date" name="checkin_date"
                    class="mt-1 block w-full rounded-lg border border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50 placeholder-gray-400 px-4 py-2 transition-all duration-300 ease-in-out"
                    placeholder="Select Date" required>
            </div>

            <div class="mb-6">
                <label for="checkout_date" class="block text-sm font-medium text-gray-700 mb-2">Check-out Date</label>
                <input type="text" id="checkout_date" name="checkout_date"
                    class="mt-1 block w-full rounded-lg border border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50 placeholder-gray-400 px-4 py-2 transition-all duration-300 ease-in-out"
                    placeholder="Select Date" required>
            </div>

            <div class="mb-6">
                <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-2">Payment Method</label>
                <select id="payment_method" name="payment_method"
                    class="mt-1 block w-full rounded-lg border border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50 px-4 py-2 transition-all duration-300 ease-in-out"
                    required>
                    <option value="credit_card">Credit Card</option>
                    <option value="paypal">PayPal</option>
                </select>
            </div>

            <button type="submit"
                class="mt-6 w-full rounded-lg bg-green-600 px-4 py-3 text-white font-semibold hover:bg-green-700 transition duration-300 ease-in-out shadow-md">
                Proceed to Payment
            </button>
        </form>

        <!-- Return to Booking button -->
        <div class="mt-8 text-center">
            <a href="search.php"
                class="inline-block rounded-lg bg-gray-600 px-5 py-2 text-white hover:bg-gray-700 transition duration-300 ease-in-out">
                Return to Booking
            </a>
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
                const checkinDate = selectedDates[0];
                if (checkinDate) {
                    // Update the checkout date picker
                    checkoutFlatpickr.set('minDate', new Date(checkinDate.getTime() + 86400000)); // Add one day to the check-in date
                    checkoutFlatpickr.clear();
                }
            }
        });

        const checkoutFlatpickr = flatpickr("#checkout_date", {
            dateFormat: "Y-m-d",
            minDate: "today",
        });
    </script>
</body>