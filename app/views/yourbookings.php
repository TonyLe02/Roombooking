<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <!-- Banner Section -->
    <header class="mt-4 rounded-lg bg-gradient-to-r from-[#2E3192] to-[#1BFFFF] text-white py-12 shadow-lg">
        <div class="container mx-auto text-center">
            <h1 class="text-6xl font-extrabold leading-snug">Your Bookings</h1>
            <p class="mt-4 text-2xl italic">Review your current and past bookings</p>
        </div>
    </header>

    <div class="container mx-auto mt-10 p-5">
        <div class="overflow-x-auto rounded-lg shadow-lg">
            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-gradient-to-r from-gray-800 to-gray-700 text-white">
                    <tr>
                        <th class="py-4 px-6 text-left text-sm font-semibold tracking-wider">Booking ID</th>
                        <th class="py-4 px-6 text-left text-sm font-semibold tracking-wider">Room Number</th>
                        <th class="py-4 px-6 text-left text-sm font-semibold tracking-wider">Check-In Date</th>
                        <th class="py-4 px-6 text-left text-sm font-semibold tracking-wider">Check-Out Date</th>
                        <th class="py-4 px-6 text-left text-sm font-semibold tracking-wider">Status</th>
                        <th class="py-4 px-6 text-left text-sm font-semibold tracking-wider">Details</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php
                    foreach ($bookings as $booking) {
                        echo "<tr class='hover:bg-gray-50 hover:shadow-sm transition-all duration-200'>";
                        echo "<td class='border px-6 py-3 text-sm text-gray-700'>" . htmlspecialchars($booking['booking_id']) . "</td>";
                        echo "<td class='border px-6 py-3 text-sm text-gray-700'>" . htmlspecialchars($booking['room_number']) . "</td>";
                        echo "<td class='border px-6 py-3 text-sm text-gray-700'>" . htmlspecialchars($booking['check_in']) . "</td>";
                        echo "<td class='border px-6 py-3 text-sm text-gray-700'>" . htmlspecialchars($booking['check_out']) . "</td>";
                        echo "<td class='border px-6 py-3 text-sm text-gray-700'>" . htmlspecialchars($booking['status']) . "</td>";
                        echo "<td class='border px-6 py-3 text-sm text-gray-700'><a href='http://localhost/Roombooking/public/confirmation.php?booking_id=" . htmlspecialchars($booking['booking_id']) . "' class='text-blue-500 hover:text-blue-700'>View Details</a></td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>