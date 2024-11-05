<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <!-- Banner Section -->
    <header class="mt-4 rounded-lg bg-gradient-to-r from-[#2E3192] to-[#1BFFFF] text-white py-12 shadow-lg">
        <div class="container mx-auto text-center">
            <h1 class="text-6xl font-extrabold leading-snug">Admin Dashboard</h1>
            <p class="mt-4 text-2xl italic">Manage Room Availability with Ease</p>
            <p class="mt-2 text-lg">Oversee bookings, check availability, and ensure seamless operations</p>
        </div>
    </header>
    
    <div class="container mx-auto max-w-4xl p-6">
        <div class="mt-10">
            <h2 class="text-3xl font-bold mb-8 text-center text-gray-800">All Rooms</h2>
            <div class="overflow-x-auto rounded-lg shadow-lg">
                <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                    <thead class="bg-gradient-to-r from-gray-800 to-gray-700 text-white">
                        <tr>
                            <th class="py-4 px-6 text-left text-sm font-semibold tracking-wider">Room Number</th>
                            <th class="py-4 px-6 text-left text-sm font-semibold tracking-wider">Room Type</th>
                            <th class="py-4 px-6 text-left text-sm font-semibold tracking-wider">Description</th>
                            <th class="py-4 px-6 text-left text-sm font-semibold tracking-wider">Available</th>
                            <th class="py-4 px-6 text-left text-sm font-semibold tracking-wider">Floor</th>
                            <th class="py-4 px-6 text-left text-sm font-semibold tracking-wider">Proximity to Elevator</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr class="hover:bg-gray-50 hover:shadow-sm transition-all duration-200">
                                <td class="border px-6 py-3 text-sm text-gray-700"><?php echo htmlspecialchars($row['room_number']); ?></td>
                                <td class="border px-6 py-3 text-sm text-gray-700"><?php echo htmlspecialchars($row['room_type']); ?></td>
                                <td class="border px-6 py-3 text-sm text-gray-700"><?php echo htmlspecialchars($row['room_description']); ?></td>
                                
                                <!-- Editable availability cell -->
                                <td class="border px-6 py-3 text-sm text-gray-700">
                                    <form method="POST" action="admin.php">
                                        <input type="hidden" name="room_id" value="<?php echo $row['id']; ?>">
                                        <select name="availability" class="border border-gray-300 rounded px-2 py-1">
                                            <option value="1" <?php echo $row['available'] ? 'selected' : ''; ?>>Yes</option>
                                            <option value="0" <?php echo !$row['available'] ? 'selected' : ''; ?>>No</option>
                                        </select>
                                        <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded ml-2">Update</button>
                                    </form>
                                </td>
                                
                                <td class="border px-6 py-3 text-sm text-gray-700"><?php echo htmlspecialchars($row['floor']); ?></td>
                                <td class="border px-6 py-3 text-sm text-gray-700">
                                    <span class="<?php echo $row['proximity_to_elevator'] ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-600'; ?> px-2 py-1 rounded-full text-xs font-semibold">
                                        <?php echo $row['proximity_to_elevator'] ? 'Yes' : 'No'; ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
