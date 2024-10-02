<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: /Roombooking/src/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="/Roombooking/dist/styles.css" rel="stylesheet">
    <script>
        <!-- Mobile menu toggle 
        -->
        document.addEventListener('DOMContentLoaded',
        function
        ()
        {
        const
        mobileMenuButton
        =
        document.getElementById('mobile-menu-button');
        const
        mobileMenu
        =
        document.getElementById('mobile-menu');
        mobileMenuButton.addEventListener('click',
        function
        ()
        {
        mobileMenu.classList.toggle('hidden');
        });
        });
    </script>
</head>

<body class="bg-gray-100 text-gray-900">
    <!-- Navbar -->
    <nav class="bg-gray-800">
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
                            <a href="/Roombooking/src/register.php" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Register</a>
                            <a href="/Roombooking/src/login.php" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Login</a>
                            <a href="/Roombooking/src/search.php" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Search Rooms</a>
                            <a href="/Roombooking/src/admin.php" class="rounded-md bg-gray-900 px-3 py-2 text-sm font-medium text-white" aria-current="page">Admin Dashboard</a>
                        </div>
                    </div>
                </div>
                <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                    <button type="button" class="relative rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                        <span class="absolute -inset-1.5"></span>
                        <span class="sr-only">View notifications</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                        </svg>
                    </button>

                    <!-- Profile dropdown -->
                    <!-- <div class="relative ml-3">
                        <div>
                            <button type="button" class="relative flex rounded-full bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                <span class="absolute -inset-1.5"></span>
                                <span class="sr-only">Open user menu</span>
                                <img class="h-8 w-8 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                            </button>
                        </div>
                        <div class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-0">Your Profile</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-1">Settings</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-2">Sign out</a>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>

        <!-- Mobile menu, show/hide based on menu state. -->
        <div class="sm:hidden" id="mobile-menu">
            <div class="space-y-1 px-2 pb-3 pt-2">
                <a href="/Roombooking/src/index.php" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Home</a>
                <a href="/Roombooking/src/register.php" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Register</a>
                <a href="/Roombooking/src/login.php" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Login</a>
                <a href="/Roombooking/src/search.php" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Search Rooms</a>
                <a href="/Roombooking/src/admin.php" class="block rounded-md bg-gray-900 px-3 py-2 text-base font-medium text-white" aria-current="page">Admin Dashboard</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto max-w-4xl p-4">
        <h1 class="text-3xl font-bold text-gray-500">Admin Dashboard</h1>

        <!-- Add Room Type Form -->
        <div class="mt-8">
            <h2 class="text-2xl font-bold text-gray-500">Add Room Type</h2>
            <form action="admin.php" method="POST" class="mt-4">
                <div class="mb-4">
                    <label for="room_type_name" class="block text-sm font-medium text-gray-700">Room Type Name</label>
                    <input type="text" name="room_type_name" id="room_type_name" class="mt-1 block w-full" required>
                </div>
                <div class="mb-4">
                    <label for="room_type_description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="room_type_description" id="room_type_description" class="mt-1 block w-full" required></textarea>
                </div>
                <div class="mb-4">
                    <label for="max_adults" class="block text-sm font-medium text-gray-700">Max Adults</label>
                    <input type="number" name="max_adults" id="max_adults" class="mt-1 block w-full" required>
                </div>
                <div class="mb-4">
                    <label for="max_children" class="block text-sm font-medium text-gray-700">Max Children</label>
                    <input type="number" name="max_children" id="max_children" class="mt-1 block w-full" required>
                </div>
                <button type="submit" name="add_room_type" class="w-full bg-blue-500 text-white py-2 px-4 rounded">Add Room Type</button>
            </form>
        </div>

        <!-- Add Room Form -->
        <div class="mt-8">
            <h2 class="text-2xl font-bold text-gray-500">Add Room</h2>
            <form action="admin.php" method="POST" class="mt-4">
                <div class="mb-4">
                    <label for="room_number" class="block text-sm font-medium text-gray-700">Room Number</label>
                    <input type="text" name="room_number" id="room_number" class="mt-1 block w-full" required>
                </div>
                <div class="mb-4">
                    <label for="room_type_id" class="block text-sm font-medium text-gray-700">Room Type</label>
                    <select name="room_type_id" id="room_type_id" class="mt-1 block w-full" required>
                        <?php
                        require '../config.php'; // Database connection
                        $result = $conn->query("SELECT id, name FROM room_types");
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                        }
                        $result->close();
                        ?>
                    </select>
                </div>
                <button type="submit" name="add_room" class="w-full bg-blue-500 text-white py-2 px-4 rounded">Add Room</button>
            </form>
        </div>

        <!-- Display Room Types -->
        <div class="mt-8">
            <h2 class="text-2xl font-bold text-gray-500">Room Types</h2>
            <?php
            $result = $conn->query("SELECT * FROM room_types");
            if ($result->num_rows > 0) {
                echo "<table class='min-w-full bg-white'>";
                echo "<thead><tr><th class='py-2'>Name</th><th class='py-2'>Description</th><th class='py-2'>Max Adults</th><th class='py-2'>Max Children</th></tr></thead>";
                echo "<tbody>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td class='border px-4 py-2'>" . $row['name'] . "</td>";
                    echo "<td class='border px-4 py-2'>" . $row['description'] . "</td>";
                    echo "<td class='border px-4 py-2'>" . $row['max_adults'] . "</td>";
                    echo "<td class='border px-4 py-2'>" . $row['max_children'] . "</td>";
                    echo "</tr>";
                }
                echo "</tbody></table>";
            } else {
                echo "<p class='text-red-500'>No room types found.</p>";
            }
            $result->close();
            ?>
        </div>

        <!-- Display Rooms -->
        <div class="mt-8">
            <h2 class="text-2xl font-bold text-gray-500">Rooms</h2>
            <?php
            $result = $conn->query("SELECT rooms.room_number, room_types.name AS room_type FROM rooms JOIN room_types ON rooms.type_id = room_types.id");
            if ($result->num_rows > 0) {
                echo "<table class='min-w-full bg-white'>";
                echo "<thead><tr><th class='py-2'>Room Number</th><th class='py-2'>Room Type</th></tr></thead>";
                echo "<tbody>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td class='border px-4 py-2'>" . $row['room_number'] . "</td>";
                    echo "<td class='border px-4 py-2'>" . $row['room_type'] . "</td>";
                    echo "</tr>";
                }
                echo "</tbody></table>";
            } else {
                echo "<p class='text-red-500'>No rooms found.</p>";
            }
            $result->close();
            $conn->close();
            ?>
        </div>
    </div>

    <?php
    // Handle form submissions
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        require '../config.php'; // Database connection

        if (isset($_POST['add_room_type'])) {
            $name = $_POST['room_type_name'];
            $description = $_POST['room_type_description'];
            $max_adults = $_POST['max_adults'];
            $max_children = $_POST['max_children'];

            $stmt = $conn->prepare("INSERT INTO room_types (name, description, max_adults, max_children) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssii", $name, $description, $max_adults, $max_children);

            if ($stmt->execute()) {
                echo "<p class='text-green-500 text-center mt-4'>Room type added successfully!</p>";
            } else {
                echo "<p class='text-red-500 text-center mt-4'>Error: " . $stmt->error . "</p>";
            }

            $stmt->close();
        }

        if (isset($_POST['add_room'])) {
            $room_number = $_POST['room_number'];
            $room_type_id = $_POST['room_type_id'];

            $stmt = $conn->prepare("INSERT INTO rooms (room_number, type_id) VALUES (?, ?)");
            $stmt->bind_param("si", $room_number, $room_type_id);

            if ($stmt->execute()) {
                echo "<p class='text-green-500 text-center mt-4'>Room added successfully!</p>";
            } else {
                echo "<p class='text-red-500 text-center mt-4'>Error: " . $stmt->error . "</p>";
            }

            $stmt->close();
        }

        $conn->close();
        // Refresh the page to show the updated data
        header("Location: admin.php");
        exit();
    }
    ?>
</body>

</html>