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
    <link href="/Roombooking/dist/styles.css" rel="stylesheet">

    <script>
        // Dropdown menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const menuButton = document.getElementById('user-menu-button');
            const dropdownMenu = document.getElementById('dropdown-menu');

            // Toggle dropdown on button click
            menuButton.addEventListener('click', function(event) {
                // Prevent default button behavior (if any)
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
        document.addEventListener('DOMContentLoaded',
            function() {
                const
                    mobileMenuButton =
                    document.getElementById('mobile-menu-button');
                const
                    mobileMenu =
                    document.getElementById('mobile-menu');
                mobileMenuButton.addEventListener('click',
                    function() {
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

    <!-- Navbar -->
    <nav class="bg-gray-800">
        <?php include 'success_toast.php'; ?>
        <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
            <div class="relative flex h-16 items-center justify-between">
                <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                    <!-- Mobile menu button-->
                    <button id="mobile-menu-button" type="button" class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">
                        <span class="absolute -inset-0.5"></span>
                        <span class="sr-only">Open main menu</span>
                        <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                        <svg class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                    <!-- <div class="flex flex-shrink-0 items-center">
                        <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=500" alt="Roombooking">
                    </div> -->
                    <div class="hidden sm:ml-6 sm:block">
                        <div class="flex space-x-4">
                            <a href="/Roombooking/src/index.php" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Home</a>
                            <?php if ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'guest') : ?>
                                <a href="/Roombooking/src/register.php" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Register</a>
                                <a href="/Roombooking/src/login.php" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Login</a>
                            <?php endif; ?>
                            <a href="/Roombooking/src/search.php" class="rounded-md bg-gray-900 px-3 py-2 text-sm font-medium text-white" aria-current="page">Search Rooms</a>
                            <?php if ($_SESSION['role'] == 'admin') : ?>
                                <a href="/Roombooking/src/admin.php" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Admin Dashboard</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="absolute inset-y-0 right-0 flex space-x-4 items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0"">
                <span class="mr-4 text-sm text-gray-300"><?php echo htmlspecialchars($username); ?></span>
                        <button type="button" class="relative rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                            <span class="absolute -inset-1.5"></span>
                            <span class="sr-only">View notifications</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                            </svg>
                        </button>

                    <!-- Profile dropdown -->
                    <div class="relative ml-3">
                        <div>
                            <button type="button" class="relative flex rounded-full bg-gray-800 text-sm text-gray-400 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                <span class="absolute -inset-1.5"></span>
                                <span class="sr-only">Open user menu</span>
                                <svg class="h-8 w-8 rounded-full" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                                </svg>
                            </button>
                        </div>

                        <!-- Dropdown menu -->
                        <div id="dropdown-menu" class="hidden absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700">Your Profile</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700">Settings</a>
                            <form action="index.php" method="POST">
                                <button type="submit" name="logout" class="block px-4 py-2 text-sm text-gray-700">Sign out</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mobile menu, show/hide based on menu state. -->
            <div class="hidden sm:hidden" id="mobile-menu">
                <div class="space-y-1 px-2 pb-3 pt-2">
                    <a href="/Roombooking/src/index.php" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Home</a>
                    <a href="/Roombooking/src/register.php" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Register</a>
                    <a href="/Roombooking/src/login.php" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Login</a>
                    <a href="/Roombooking/src/search.php" class="block rounded-md bg-gray-900 px-3 py-2 text-base font-medium text-white" aria-current="page">Search Rooms</a>
                    <a href="/Roombooking/src/admin.php" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Admin Dashboard</a>
                </div>
            </div>
    </nav>

    <!-- Main content -->
    <?php
    $servername = "localhost";
    $username = "root"; // Default XAMPP MySQL username
    $password = ""; // Default XAMPP MySQL password
    $dbname = "roombooking";

    // Enable error reporting
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    try {
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }

        // Query to fetch room details along with room type
        $sql = "SELECT r.id, r.room_number, rt.name AS room_type, r.available, r.floor, r.proximity_to_elevator
            FROM rooms r
            JOIN room_types rt ON r.type_id = rt.id";

        $result = $conn->query($sql);

        // Start the HTML output
        echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Room Booking</title>
        <link href='https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css' rel='stylesheet'>
    </head>
    <body class='bg-gray-100'>
        <div class='container mx-auto mt-10'>
            <h1 class='text-2xl font-bold mb-5'>Available Rooms</h1>";

        // Check if there are results
        if ($result->num_rows > 0) {
            // Start the Tailwind CSS styled table
            echo "<div class='overflow-x-auto'>
                <table class='min-w-full bg-white border border-gray-300 shadow-md rounded-lg'>
                    <thead class='bg-gray-200 text-gray-700'>
                        <tr>
                            <th class='py-3 px-4 border-b-2 border-gray-300 text-left text-sm font-semibold'>Room Number</th>
                            <th class='py-3 px-4 border-b-2 border-gray-300 text-left text-sm font-semibold'>Room Type</th>
                            <th class='py-3 px-4 border-b-2 border-gray-300 text-left text-sm font-semibold'>Available</th>
                            <th class='py-3 px-4 border-b-2 border-gray-300 text-left text-sm font-semibold'>Floor</th>
                            <th class='py-3 px-4 border-b-2 border-gray-300 text-left text-sm font-semibold'>Proximity to Elevator</th>
                            <th class='py-3 px-4 border-b-2 border-gray-300 text-left text-sm font-semibold'>Action</th>

                            
                        </tr>
                    </thead>
                    <tbody>";

            // Output data for each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr class='hover:bg-gray-100'>
                    <td class='py-3 px-4 border-b border-gray-300'>" . htmlspecialchars($row['room_number']) . "</td>
                    <td class='py-3 px-4 border-b border-gray-300'>" . htmlspecialchars($row['room_type']) . "</td>
                    <td class='py-3 px-4 border-b border-gray-300'>" . ($row['available'] ? 'Yes' : 'No') . "</td>
                    <td class='py-3 px-4 border-b border-gray-300'>" . htmlspecialchars($row['floor']) . "</td>
                    <td class='py-3 px-4 border-b border-gray-300'>" . ($row['proximity_to_elevator'] ? 'Yes' : 'No') . "</td>
                    <td class='py-3 px-4 border-b border-gray-300'>";
                if ($row['available']) {
                    echo "<a href='booking.php?room_id=" . htmlspecialchars($row['id']) . "' class='bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-700'>Book</a>";
                } else {
                    echo "<span class='text-red-500'>Occupied</span>";
                }
                echo "</td>
                  </tr>";
            }
            // End the table
            echo "</tbody></table></div>";
        } else {
            echo "<p class='text-red-500'>No rooms found matching your search.</p>";
        }

        // End the HTML output
        echo "</div>
    </body>
    </html>";
    } catch (Exception $e) {
        // Handle connection error
        echo "Error: " . $e->getMessage();
    } finally {
        // Close connection
        if (isset($conn) && $conn->ping()) {
            $conn->close();
        }
    }
    ?>
    <!-- Include Footer -->
    <?php include 'footer.php'; ?>
</body>

</html>