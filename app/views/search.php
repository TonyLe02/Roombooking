<!-- Search form or content goes here -->
<div class="container mx-auto mt-10 p-5 bg-white shadow-md rounded-lg">
    <h1 class="text-3xl font-bold mb-5 text-center">Available Rooms</h1>

    <div id="room-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php
        // Enable error reporting
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        try {
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
            $sql = "SELECT r.id, r.room_number, rt.name AS room_type, r.available, r.floor, r.proximity_to_elevator, rt.max_adults, rt.max_children
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
                        <p class='text-gray-700'><strong>Max Adults:</strong> " . htmlspecialchars($row['max_adults']) . "</p>
                        <p class='text-gray-700'><strong>Max Children:</strong> " . htmlspecialchars($row['max_children']) . "</p>
                        <div class='mt-4'>";
                    if ($row['available']) {
                        echo "<a href='booking.php?room_id=" . htmlspecialchars($row['id']) . "' class='bg-green-500 text-white px-4 py-2 rounded hover:bg-green-700 transition duration-200'>Book</a>";
                    } else {
                        echo "<span class='text-red-500'>Occupied</span>";
                    }
                    echo "      </div>
                    </div>
                  </div>";
                }
            } else {
                echo "<p>No available rooms found.</p>";
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }

        $conn->close();
        ?>
    </div>
</div>