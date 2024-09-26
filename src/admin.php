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
</head>

<body class="bg-gray-100 text-gray-900">
    <!-- Navbar -->
    <nav class="bg-white shadow">
        <div class="container mx-auto p-4 flex justify-between items-center">
            <div class="text-gray-700 font-bold">Roombooking</div>
            <ul class="flex justify-center space-x-4">
                <li><a href="/Roombooking/src/index.php" class="text-blue-500 hover:underline">Home</a></li>
                <li><a href="/Roombooking/src/register.php" class="text-blue-500 hover:underline">Register</a></li>
                <li><a href="/Roombooking/src/login.php" class="text-blue-500 hover:underline">Login</a></li>
                <li><a href="/Roombooking/src/search.php" class="text-blue-500 hover:underline">Search Rooms</a></li>
                <li><a href="/Roombooking/src/admin.php" class="text-blue-500 hover:underline">Admin Dashboard</a></li>
            </ul>
            <div class="text-gray-700 font-bold">
                <?php echo "Logged in as: " . $_SESSION['username']; ?>
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