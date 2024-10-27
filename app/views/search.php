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
        <div class="container mx-auto max-w-4xl p-6">
            <!-- Search Bar for Dates and Guest Info -->
            <form method="GET" class="mb-6 gap-6 p-8 bg-white rounded-2xl shadow-lg border border-gray-200">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="checkin_date" class="block text-sm font-medium text-gray-700 mb-2">Check-In Date</label>
                        <input type="date" id="checkin_date" name="checkin_date" required
                            class="p-3 border border-gray-300 rounded-lg w-full transition duration-200 ease-in-out focus:border-blue-500 focus:ring-2 focus:ring-blue-200 placeholder-gray-400"
                            value="<?php echo isset($_GET['checkin_date']) ? htmlspecialchars($_GET['checkin_date']) : ''; ?>">
                    </div>
                    <div>
                        <label for="checkout_date" class="block text-sm font-medium text-gray-700 mb-2">Check-Out Date</label>
                        <input type="date" id="checkout_date" name="checkout_date" required
                            class="p-3 border border-gray-300 rounded-lg w-full transition duration-200 ease-in-out focus:border-blue-500 focus:ring-2 focus:ring-blue-200 placeholder-gray-400"
                            value="<?php echo isset($_GET['checkout_date']) ? htmlspecialchars($_GET['checkout_date']) : ''; ?>">
                    </div>
                    <div>
                        <label for="adults" class="block text-sm font-medium text-gray-700 mb-2">Adults</label>
                        <input type="number" name="adults" min="1" required
                            class="p-3 border border-gray-300 rounded-lg w-full transition duration-200 ease-in-out focus:border-blue-500 focus:ring-2 focus:ring-blue-200 placeholder-gray-400"
                            value="<?php echo isset($_GET['adults']) ? htmlspecialchars($_GET['adults']) : '1'; ?>">
                    </div>
                    <div>
                        <label for="children" class="block text-sm font-medium text-gray-700 mb-2">Children</label>
                        <input type="number" name="children" min="0"
                            class="p-3 border border-gray-300 rounded-lg w-full transition duration-200 ease-in-out focus:border-blue-500 focus:ring-2 focus:ring-blue-200 placeholder-gray-400"
                            value="<?php echo isset($_GET['children']) ? htmlspecialchars($_GET['children']) : '0'; ?>">
                    </div>
                </div>
                <div class="mt-6 flex justify-center">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                        Search Rooms
                    </button>
                </div>
            </form>
        </div>

        <div id="room-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php
            // Enable error reporting
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

            try {
                // Initialize variables to check if filters are applied
                $filtersApplied = isset($_GET['checkin_date'], $_GET['checkout_date'], $_GET['adults']) && !empty($_GET['checkin_date']) && !empty($_GET['checkout_date']) && !empty($_GET['adults']);

                // Check if the user has provided filters
                if ($filtersApplied) {
                    $checkIn = $_GET['checkin_date'];
                    $checkOut = $_GET['checkout_date'];
                    $adults = (int)$_GET['adults'];
                    $children = isset($_GET['children']) ? (int)$_GET['children'] : 0;

                    // Check if the input dates are valid
                    if ($checkIn >= $checkOut) {
                        echo "<p class='text-center text-red-600'>Check-out date must be after the check-in date.</p>";
                        exit;
                    }

                    // Update room availability based on check-out date
                    $currentDate = date('Y-m-d');
                    $updateSql = "UPDATE rooms r
                      LEFT JOIN bookings b ON r.id = b.room_id
                      SET r.available = TRUE
                      WHERE b.check_out < ?";
                    $stmt = $conn->prepare($updateSql);
                    $stmt->bind_param('s', $currentDate);
                    $stmt->execute();

                    // SQL to find available rooms that meet the guest's requirements
                    $sql = "SELECT r.id, r.room_number, rt.name AS room_type, r.available, r.floor, r.proximity_to_elevator, rt.max_adults, rt.max_children
                FROM rooms r
                JOIN room_types rt ON r.type_id = rt.id
                WHERE r.available = TRUE 
                  AND rt.max_adults >= ? 
                  AND rt.max_children >= ? 
                  AND r.id NOT IN (
                      SELECT room_id FROM bookings 
                      WHERE (check_in < ? AND check_out > ?) OR (check_in < ? AND check_out > ?)
                  )
                ORDER BY r.available DESC";

                    // Prepare and execute the query
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('iissss', $adults, $children, $checkOut, $checkIn, $checkOut, $checkIn);
                    $stmt->execute();
                    $result = $stmt->get_result();
                } else {
                    // No filters applied, show all rooms
                    $sql = "SELECT r.id, r.room_number, rt.name AS room_type, r.available, r.floor, r.proximity_to_elevator, rt.max_adults, rt.max_children
                FROM rooms r
                JOIN room_types rt ON r.type_id = rt.id
                ORDER BY r.available DESC"; // Sort by availability

                    $result = $conn->query($sql);
                }

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
                            echo "<a href='booking.php?room_id=" . htmlspecialchars($row['id']) . "&check_in=" . htmlspecialchars($checkIn ?? '') . "&check_out=" . htmlspecialchars($checkOut ?? '') . "&adults=" . htmlspecialchars($adults ?? 1) . "&children=" . htmlspecialchars($children ?? 0) . "' class='bg-green-600 text-white px-5 py-2 rounded-full hover:bg-green-700 transition duration-300 ease-in-out shadow-md inline-block'>
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
                    echo "<p class='text-center text-red-600'>No available rooms found for the selected dates and criteria.</p>";
                }
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }

            $conn->close();
            ?>

        </div>
    </main>
</body>
<!-- Include Flatpickr JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    // Initialize Flatpickr for both date fields
    flatpickr("#checkin_date", {
        dateFormat: "Y-m-d",
        minDate: "today",
        onChange: function(selectedDates) {
            const checkinDate = selectedDates[0];
            if (checkinDate) {
                // Update the checkout date picker
                checkoutFlatpickr.set('minDate', new Date(checkinDate.getTime() + 86400000)); // Add one day to the check-in date
                checkoutFlatpickr.clear();
            }
        }
    });

    const checkoutFlatpickr = flatpickr("#checkout_date", {
        dateFormat: "Y-m-d",
        minDate: "today",
    });
</script>