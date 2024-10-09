<?php
session_start();
$username = isset($_SESSION['username']) ? $_SESSION['username'] : null;
$showToast = isset($_SESSION['logged_success']) && $_SESSION['logged_success'];

if (!isset($_SESSION['username'])) {
    header("Location: /Roombooking/src/login.php");
    exit();
}
unset($_SESSION['logged_success']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Rooms</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <script>
        // Dropdown menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const menuButton = document.getElementById('user-menu-button');
            const dropdownMenu = document.getElementById('dropdown-menu');

            // Toggle dropdown on button click
            menuButton.addEventListener('click', function(event) {
                event.preventDefault();
                dropdownMenu.classList.toggle('hidden');
            });

            // Close dropdown if clicking outside
            document.addEventListener('click', function(event) {
                const isClickInside = menuButton.contains(event.target) || dropdownMenu.contains(event.target);
                if (!isClickInside) {
                    dropdownMenu.classList.add('hidden');
                }
            });
        });

        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenuButton.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });
        });

        // Toast message
        document.addEventListener('DOMContentLoaded', function() {
            const showToast = <?php echo json_encode($showToast); ?>;
            if (showToast) {
                const toast = document.getElementById('toast');
                toast.classList.remove('hidden');
                setTimeout(() => {
                    toast.classList.add('hidden');
                }, 3500);
            }
        });
    </script>
</head>

<body class="bg-gray-100 text-gray-900">

    <!-- Sticky Navbar -->
    <?php include 'navbar_search.php'; ?>

    <!-- Toast Notification -->
    <div id="toast" class="hidden fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded shadow-lg">
        Successfully logged in!
    </div>

    <!-- Main content -->
    <div class="container mx-auto mt-10 p-5 bg-white shadow-md rounded-lg">
        <h1 class="text-3xl font-bold mb-5 text-center">Available Rooms</h1>

        <div id="room-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php
            $servername = "localhost";
            $dbUsername = "root"; // Default XAMPP MySQL username
            $dbPassword = ""; // Default XAMPP MySQL password
            $dbname = "roombooking";

            // Enable error reporting
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

            try {
                // Create connection
                $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

                // Check connection
                if ($conn->connect_error) {
                    throw new Exception("Connection failed: " . $conn->connect_error);
                }

                // Update room availability based on check-out date
                $currentDate = date('Y-m-d');
                $updateSql = "UPDATE rooms r
                              JOIN bookings b ON r.id = b.room_id
                              SET r.available = TRUE
                              WHERE b.check_out < ?";
                $stmt = $conn->prepare($updateSql);
                $stmt->bind_param('s', $currentDate);
                $stmt->execute();

                // Query to fetch room details along with room type, sorted by availability
                $sql = "SELECT r.id, r.room_number, rt.name AS room_type, r.available, r.floor, r.proximity_to_elevator
                        FROM rooms r
                        JOIN room_types rt ON r.type_id = rt.id
                        ORDER BY r.available DESC"; // Sort by availability first

                $result = $conn->query($sql);

                // Check if there are results
                if ($result->num_rows > 0) {
                    // Output data for each room
                    while ($row = $result->fetch_assoc()) {
                        $bgColor = $row['available'] ? 'bg-green-50' : 'bg-red-50'; // Distinguishing background color
                        echo "<div class='shadow-lg rounded-lg overflow-hidden border border-gray-300 transition-transform duration-300 transform hover:scale-105 " . $bgColor . "'>
                            <div class='p-5'>
                                <h2 class='text-xl font-bold'>" . htmlspecialchars($row['room_number']) . "</h2>
                                <p class='text-gray-700'>" . htmlspecialchars($row['room_type']) . "</p>
                                <p class='text-gray-700'><strong>Available:</strong> " . ($row['available'] ? 'Yes' : 'No') . "</p>
                                <p class='text-gray-700'><strong>Floor:</strong> " . htmlspecialchars($row['floor']) . "</p>
                                <p class='text-gray-700'><strong>Proximity to Elevator:</strong> " . ($row['proximity_to_elevator'] ? 'Yes' : 'No') . "</p>
                                <div class='mt-4'>";
                        if ($row['available']) {
                            echo "<a href='booking.php?room_id=" . htmlspecialchars($row['id']) . "' class='bg-green-500 text-white px-4 py-2 rounded hover:bg-green-700 transition duration-200'>Book</a>";
                        } else {
                            echo "<span class='text-red-500'>Occupied</span>";
                        }
                        echo "</div>
                            </div>
                        </div>";
                    }
                } else {
                    echo "<p class='text-red-500 text-center'>No rooms found matching your search.</p>";
                }
            } catch (Exception $e) {
                // Handle connection error
                echo "<p class='text-red-500'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
            } finally {
                // Close connection
                if (isset($conn) && $conn->ping()) {
                    $conn->close();
                }
            }
            ?>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'footer.php'; ?>
</body>

</html>