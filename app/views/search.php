<!-- Search form or content goes here -->
<div class="container mx-auto mt-10 p-5 bg-white shadow-md rounded-lg">
    <h1 class="text-3xl font-bold mb-8 text-center text-gray-800">Available Rooms</h1>

    <div id="room-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
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
                    echo "<div class='shadow-lg rounded-xl overflow-hidden border border-gray-200 transition-transform duration-300 transform hover:scale-105 " . $bgColor . "'>
                    <div class='p-6'>
                        <h2 class='text-2xl font-semibold text-gray-900'>" . htmlspecialchars($row['room_number']) . "</h2>
                        <p class='text-gray-600 mt-1'>" . htmlspecialchars($row['room_type']) . "</p>
                        <div class='mt-4'>
                            <p class='text-gray-700'><strong>Available:</strong> " . ($row['available'] ? '<span class="text-green-600">Yes</span>' : '<span class="text-red-600">No</span>') . "</p>
                            <p class='text-gray-700'><strong>Floor:</strong> " . htmlspecialchars($row['floor']) . "</p>
                            <p class='text-gray-700'><strong>Proximity to Elevator:</strong> " . ($row['proximity_to_elevator'] ? 'Yes' : 'No') . "</p>
                            <p class='text-gray-700'><strong>Max Adults:</strong> " . htmlspecialchars($row['max_adults']) . "</p>
                            <p class='text-gray-700'><strong>Max Children:</strong> " . htmlspecialchars($row['max_children']) . "</p>
                        </div>
                        <div class='mt-6'>";
                    if ($row['available']) {
                        echo "<a href='booking.php?room_id=" . htmlspecialchars($row['id']) . "' class='bg-green-600 text-white px-5 py-2 rounded-full hover:bg-green-700 transition duration-300 ease-in-out shadow-md inline-block'>Book Now</a>";
                    } else {
                        echo "<span class='text-red-500 font-semibold'>Occupied</span>";
                    }
                    echo "      </div>
                    </div>
                  </div>";
                }
            } else {
                echo "<p class='text-center text-gray-500'>No available rooms found.</p>";
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }

        $conn->close();
        ?>
    </div>
</div>