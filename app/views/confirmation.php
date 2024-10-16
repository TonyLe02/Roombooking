<?php

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

// Calculate the stay duration
$check_in = new DateTime($booking['check_in']);
$check_out = new DateTime($booking['check_out']);
?>

<!-- Confirmation form or content goes here -->

<body class="bg-green-50">
    <div class="container mx-auto mt-10">
        <h1 class="text-3xl font-bold mb-5 text-center text-green-700">Booking Confirmation</h1>
        <p class="mb-5 text-center text-gray-600">Thank you for your booking! Here are your booking details:</p>

        <?php
        $currentMonth = new DateTime();
        $formattedMonth = $currentMonth->format('F Y'); // Format as "Month Year" (e.g., "October 2023")
        ?>

        <!-- Calendar View -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <h2 class="text-xl font-semibold mb-4 text-gray-800 text-center"> <?php echo $formattedMonth; ?></h2>
            <div class="grid grid-cols-7 gap-1">
                <?php
                $startDate = new DateTime($booking['check_in']);
                $endDate = new DateTime($booking['check_out']);

                // Get the first day of the month
                $firstDayOfMonth = new DateTime($currentMonth->format('Y-m-01'));
                $lastDayOfMonth = new DateTime($currentMonth->format('Y-m-t'));

                // Display headers for days of the week
                $weekDays = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
                foreach ($weekDays as $day) {
                    echo '<div class="text-center font-semibold text-gray-600">' . $day . '</div>';
                }

                // Display empty days before the first day of the month
                for ($i = 0; $i < $firstDayOfMonth->format('w'); $i++) {
                    echo '<div class="p-4"></div>'; // Empty div for the days before the first of the month
                }

                // Display each day of the month
                for ($day = 1; $day <= $lastDayOfMonth->format('d'); $day++) {
                    $currentDay = new DateTime($currentMonth->format('Y-m-') . str_pad($day, 2, '0', STR_PAD_LEFT));

                    // Base class for each day
                    $class = 'p-4 text-center border border-gray-300';

                    // Highlight check-in date
                    if ($currentDay == $startDate) {
                        $class .= ' bg-green-200'; // Highlight the check-in date
                    }
                    // Highlight stay days
                    if ($currentDay > $startDate && $currentDay < $endDate) {
                        $class .= ' border-dashed border-green-400'; // Dashed border for days in between
                    }
                    // Highlight check-out date
                    if ($currentDay == $endDate) {
                        $class .= ' bg-red-200'; // Highlight the checkout day
                    }
                    // Highlight today's date
                    if ($currentDay->format('Y-m-d') == date('Y-m-d')) {
                        $class .= ' border-green-600'; // Border for today's date
                    }

                    echo '<div class="' . $class . '">' . $day . '</div>';
                }
                ?>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="mb-4 border-b pb-2">
                <h2 class="text-xl font-semibold text-gray-800">Booking Details</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex items-center">
                    <p><strong>Room Number:</strong> <?php echo htmlspecialchars($booking['room_number']); ?></p>
                </div>
                <div class="flex items-center">
                    <p><strong>Room Type:</strong> <?php echo htmlspecialchars($booking['room_type']); ?></p>
                </div>
                <div class="flex items-center">
                    <p><strong>Check-in Date:</strong> <?php echo htmlspecialchars($booking['check_in']); ?></p>
                </div>
                <div class="flex items-center">
                    <p><strong>Check-out Date:</strong> <?php echo htmlspecialchars($booking['check_out']); ?></p>
                </div>
                <div class="flex items-center">
                    <p><strong>Adults:</strong> <?php echo htmlspecialchars($booking['adults']); ?></p>
                </div>
                <div class="flex items-center">
                    <p><strong>Children:</strong> <?php echo htmlspecialchars($booking['children']); ?></p>
                </div>
                <div class="flex items-center">
                    <p><strong>Status:</strong> <?php echo htmlspecialchars($booking['status']); ?></p>
                </div>
            </div>
        </div>

        <!-- Return Button -->
        <div class="mt-6 text-center">
            <a href="/Roombooking/public/search.php" class="inline-block rounded-md bg-green-600 px-4 py-2 text-white hover:bg-green-700 transition duration-300">Return to Booking</a>
        </div>
    </div>
</body>