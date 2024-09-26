<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: /Roombooking/src/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Rooms</title>
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
                <?php echo "Logged in as " . $_SESSION['username']; ?>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto max-w-md p-4">
        <h1 class="text-3xl font-bold text-gray-500">Search Rooms</h1>
        <form action="search.php" method="GET" class="mt-4">
            <div class="mb-4">
                <label for="check_in" class="block text-sm font-medium text-gray-700">Check-in Date</label>
                <input type="date" name="check_in" id="check_in" class="mt-1 block w-full" required>
            </div>
            <div class="mb-4">
                <label for="check_out" class="block text-sm font-medium text-gray-700">Check-out Date</label>
                <input type="date" name="check_out" id="check_out" class="mt-1 block w-full" required>
            </div>
            <div class="mb-4">
                <label for="adults" class="block text-sm font-medium text-gray-700">Adults</label>
                <input type="number" name="adults" id="adults" class="mt-1 block w-full" required>
            </div>
            <div class="mb-4">
                <label for="children" class="block text-sm font-medium text-gray-700">Children</label>
                <input type="number" name="children" id="children" class="mt-1 block w-full" required>
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded">Search</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['check_in'])) {
            require '../config.php'; // Database connection

            $check_in = $_GET['check_in'];
            $check_out = $_GET['check_out'];
            $adults = $_GET['adults'];
            $children = $_GET['children'];

            $stmt = $conn->prepare("SELECT rooms.room_number, room_types.name, room_types.description 
                                    FROM rooms 
                                    JOIN room_types ON rooms.type_id = room_types.id 
                                    WHERE rooms.id NOT IN (
                                        SELECT room_id FROM bookings 
                                        WHERE (check_in <= ? AND check_out >= ?) 
                                        OR (check_in <= ? AND check_out >= ?)
                                    ) 
                                    AND room_types.max_adults >= ? 
                                    AND room_types.max_children >= ?");
            $stmt->bind_param("ssssii", $check_in, $check_in, $check_out, $check_out, $adults, $children);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo "<div class='mt-4'>";
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='p-4 bg-white shadow mb-4'>";
                    echo "<h2 class='text-xl font-bold'>" . $row['name'] . "</h2>";
                    echo "<p>" . $row['description'] . "</p>";
                    echo "<p>Room Number: " . $row['room_number'] . "</p>";
                    echo "</div>";
                }
                echo "</div>";
            } else {
                echo "<p class='text-red-500 text-center mt-4'>No rooms available for the selected dates.</p>";
            }

            $stmt->close();
            $conn->close();
        }
        ?>
    </div>
</body>

</html>