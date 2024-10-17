<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <!-- Banner Section -->
    <header class="mt-4 rounded-lg bg-gradient-to-r from-[#2E3192] to-[#1BFFFF] text-white py-12 shadow-lg">
        <div class="container mx-auto text-center">
            <h1 class="text-6xl font-extrabold leading-snug">Available Rooms</h1>
            <p class="mt-4 text-2xl italic">Find the perfect room for your needs</p>
            <p class="mt-2 text-lg">Check availability and book your room easily</p>
        </div>
    </header>

    <!-- Search Page Content -->
    <main class="container mx-auto mt-10 p-5">

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
                        // Background color based on availability
                        $bgColor = $row['available'] ? 'bg-white' : 'bg-white';

                        echo "<div class='shadow-lg rounded-xl overflow-hidden border border-gray-200 transition-transform duration-300 transform hover:scale-105 hover:shadow-xl " . $bgColor . "'>
                        <div class='p-6'>
                            <h2 class='text-2xl font-semibold text-gray-900'>" . htmlspecialchars($row['room_number']) . "</h2>
                            <p class='text-gray-600 mt-1'>" . htmlspecialchars($row['room_type']) . "</p>
                            <div class='mt-4'>
                                <p class='text-gray-700 flex items-center'>
                                    <strong>Available:</strong> 
                                    <span class='ml-2 px-2 py-1 rounded-full text-sm " . ($row['available'] ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600') . "'>
                                        " . ($row['available'] ? 'Yes' : 'No') . "
                                    </span>
                                </p>
                                <p class='text-gray-700 flex items-center mt-2'>
                                    <strong>Floor:</strong> 
                                    <span class='ml-2'>" . htmlspecialchars($row['floor']) . "</span>
                                </p>
                                <p class='text-gray-700 flex items-center mt-2'>
                                    <strong>Proximity to Elevator:</strong> 
                                    <span class='ml-2 text-sm flex items-center'>
                                        " . ($row['proximity_to_elevator'] ? '<span class="bg-green-100 text-green-600 px-2 py-1 rounded-full">Yes</span>' : '<span class="bg-red-100 text-red-600 px-2 py-1 rounded-full">No</span>') . "
                                    </span>
                                </p>
                                <p class='text-gray-700 flex items-center mt-2'>
                                    <strong>Max Adults:</strong> 
                                    <span class='ml-2'>" . htmlspecialchars($row['max_adults']) . "</span>
                                </p>
                                <p class='text-gray-700 flex items-center mt-2'>
                                    <strong>Max Children:</strong> 
                                    <span class='ml-2'>" . htmlspecialchars($row['max_children']) . "</span>
                                </p>
                            </div>
                            <div class='mt-6'>";
                        if ($row['available']) {
                            echo "<a href='booking.php?room_id=" . htmlspecialchars($row['id']) . "' class='bg-green-600 text-white px-5 py-2 rounded-full hover:bg-green-700 transition duration-300 ease-in-out shadow-md inline-block'>
                                    Book Now
                                  </a>";
                        } else {
                            echo "<span class='text-red-500 font-semibold bg-red-100 px-3 py-1 rounded-full shadow-sm'>Occupied</span>";
                        }
                        echo "      </div>
                        </div>
                      </div>";
                    }
                } else {
                    echo "<p class='text-center text-red-600'>No available rooms found.</p>";
                }
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }

            $conn->close();
            ?>
        </div>
    </main>
</body>