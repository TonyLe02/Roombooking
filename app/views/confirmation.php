<?php
// Get the booking ID from the query parameter
$booking_id = isset($_GET['booking_id']) ? intval($_GET['booking_id']) : 0;

// Fetch booking details from the database
$sql = "SELECT b.id, b.check_in, b.check_out, b.adults, b.children, b.status, r.room_number, rt.name AS room_type, rt.max_adults, rt.max_children
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

// Fetch the room type image URL from the database or configuration
$roomTypeImage = '';
switch ($booking['room_type']) {
    case 'Single Room':
        $roomTypeImage = '/Roombooking/public/images/Single.webp';
        break;
    case 'Double Room':
        $roomTypeImage = '/Roombooking/public/images/Double.webp';
        break;
    case 'Junior Suite':
        $roomTypeImage = '/Roombooking/public/images/Suite.webp';
        break;
    default:
        $roomTypeImage = '/Roombooking/public/images/Single.webp';
        break;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $userEmail = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    if ($userEmail) {
        // Send confirmation email
        require __DIR__ . '/../../send_email.php';
        sendConfirmationEmail($userEmail, $booking);
        $toastMessage = "Confirmation email sent to " . htmlspecialchars($userEmail) . ".";
    }
}

// Display toast message if set
if (isset($toastMessage)) {
    include __DIR__ . '/../../app/views/components/toast_success.php';
}
?>

<!-- Confirmation form -->
<body class="bg-green-50">
    <div class="container mx-auto mt-10">
        <h1 class="text-3xl font-bold mb-5 text-center text-green-700">Booking Confirmation</h1>
        <p class="mb-6 text-center text-gray-600">Thank you for your booking! Here are your booking details:</p>

        <?php
        $currentMonth = new DateTime();
        $formattedMonth = $currentMonth->format('F Y');
        ?>

        <!-- Calendar View -->
        <div class="bg-white p-6 rounded-lg shadow-lg mb-8 border border-gray-200">
            <h2 class="text-xl font-semibold mb-4 text-gray-800 text-center"><?php echo $formattedMonth; ?></h2>
            <div class="grid grid-cols-7 gap-2">
                <?php
                $startDate = new DateTime($booking['check_in']);
                $endDate = new DateTime($booking['check_out']);

                // Get the first day of the month
                $firstDayOfMonth = new DateTime($currentMonth->format('Y-m-01'));
                $lastDayOfMonth = new DateTime($currentMonth->format('Y-m-t'));

                // Display headers for days of the week
                $weekDays = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
                foreach ($weekDays as $day) {
                    echo '<div class="text-center font-medium text-gray-700">' . $day . '</div>';
                }

                // Display empty days before the first day of the month
                for ($i = 0; $i < $firstDayOfMonth->format('w'); $i++) {
                    echo '<div class="p-4"></div>'; // Empty div for the days before the first of the month
                }

                // Display each day of the month
                for ($day = 1; $day <= $lastDayOfMonth->format('d'); $day++) {
                    $currentDay = new DateTime($currentMonth->format('Y-m-') . str_pad($day, 2, '0', STR_PAD_LEFT));

                    // Base class for each day
                    $class = 'p-2 text-center border rounded-md text-gray-600 transition-all duration-300 ease-in-out';

                    // Highlight check-in date
                    if ($currentDay == $startDate) {
                        $class .= ' bg-green-200 font-semibold'; // Highlight the check-in date
                    }
                    // Highlight stay days
                    if ($currentDay > $startDate && $currentDay < $endDate) {
                        $class .= ' border-dashed border-gray-600 bg-gray-200'; // Dashed border for days in between
                    }
                    // Highlight check-out date
                    if ($currentDay == $endDate) {
                        $class .= ' bg-red-200 border-red-600 font-bold text-red-600'; // Highlight the checkout day
                    }
                    // Highlight today's date
                    if ($currentDay->format('Y-m-d') == date('Y-m-d')) {
                        $class .= ' border-green-600 font-bold text-green-600'; // Border for today's date
                    }

                    echo '<div class="' . $class . '">' . $day . '</div>';
                }
                ?>
            </div>
        </div>

        <!-- Booking Details -->
        <div class="bg-white p-6 rounded-lg shadow-lg border border-gray-200">
            <div class="mb-5 border-b pb-3">
                <h2 class="text-xl font-semibold text-gray-800">Booking Details</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-700">
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
                    <p><strong>Number of Adults:</strong> <?php echo htmlspecialchars($booking['adults']); ?></p>
                </div>
                <div class="flex items-center">
                    <p><strong>Number of Children:</strong> <?php echo htmlspecialchars($booking['children']); ?></p>
                </div>
            </div>
        </div>

        <!-- Dynamic Room Image -->
        <div class="flex justify-center mb-6">
            <img src="<?php echo $roomTypeImage; ?>" alt="Room Image" class="rounded-lg shadow-lg w-full">
        </div>

        <!-- Include the email form component -->
        <?php include __DIR__ . '/../../app/views/components/email_form.php'; ?>

        <!-- Return Button -->
        <div class="mt-8 left">
            <a href="/Roombooking/public/search.php"
                class="inline-block rounded-lg bg-green-600 px-5 py-3 text-white font-semibold hover:bg-green-700 transition duration-300 ease-in-out shadow-md">
                Return to Booking
            </a>
        </div>
    </div>
</body>