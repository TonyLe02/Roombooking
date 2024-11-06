<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <!-- Banner Section -->
    <header class="mt-4 rounded-lg bg-gradient-to-r from-[#2E3192] to-[#1BFFFF] text-white py-12 shadow-lg">
        <div class="container mx-auto text-center">
            <h1 class="text-6xl font-extrabold leading-snug">Admin Dashboard</h1>
            <p class="mt-4 text-2xl italic">Manage Room Availability with Ease</p>
            <p class="mt-2 text-lg">Oversee bookings, check availability, and ensure seamless operations</p>
        </div>
    </header>

    <div class="container">
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
                            <th class="py-4 px-6 text-left text-sm font-semibold tracking-wider">Edit</th>

                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr class="hover:bg-gray-50 hover:shadow-sm transition-all duration-200">
                                <td class="border px-6 py-3 text-sm text-gray-700"><?php echo htmlspecialchars($row['room_number']); ?></td>
                                <td class="border px-6 py-3 text-sm text-gray-700"><?php echo htmlspecialchars($row['room_type']); ?></td>
                                <td class="border px-6 py-3 text-sm text-gray-700"><?php echo htmlspecialchars($row['room_description']); ?></td>

                                <!-- Availability cell -->
                                <td class="border px-6 py-3 text-sm text-gray-700">
                                    <span class="<?php echo $row['available'] ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-500'; ?> px-2 py-1 rounded-full text-xs font-semibold">
                                        <?php echo $row['available'] ? 'Yes' : 'No'; ?>
                                    </span>
                                </td>

                                <td class="border px-6 py-3 text-sm text-gray-700"><?php echo htmlspecialchars($row['floor']); ?></td>
                                <td class="border px-6 py-3 text-sm text-gray-700">
                                    <span class="<?php echo $row['proximity_to_elevator'] ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-500'; ?> px-2 py-1 rounded-full text-xs font-semibold">
                                        <?php echo $row['proximity_to_elevator'] ? 'Yes' : 'No'; ?>
                                    </span>
                                </td>
                                <td class="border px-6 py-3 text-sm text-gray-700">
                                    <button class="text-gray-500 hover:text-gray-700 edit-button" data-room-id="<?php echo $row['id']; ?>" data-room-number="<?php echo htmlspecialchars($row['room_number']); ?>" data-room-type="<?php echo htmlspecialchars($row['room_type']); ?>" data-room-description="<?php echo htmlspecialchars($row['room_description']); ?>" data-availability="<?php echo $row['available']; ?>" data-floor="<?php echo htmlspecialchars($row['floor']); ?>" data-proximity="<?php echo $row['proximity_to_elevator']; ?>">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="editModal" class="fixed inset-0 items-start justify-center pt-10 hidden z-50" style="backdrop-filter: blur(10px);">
        <div class="relative mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center pb-3">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Edit Room</h3>
                <button id="closeModalX" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form method="POST" action="admin.php" class="space-y-4">
                <input type="hidden" name="room_id" id="modal-room-id">
                <div>
                    <label for="modal-room-number" class="block text-sm font-medium text-gray-700">Room Number</label>
                    <input type="text" name="room_number" id="modal-room-number" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2">
                </div>
                <div>
                    <label for="modal-room-type" class="block text-sm font-medium text-gray-700">Room Type</label>
                    <input type="text" name="room_type" id="modal-room-type" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2">
                </div>
                <div>
                    <label for="modal-room-description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="room_description" id="modal-room-description" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2"></textarea>
                </div>
                <div>
                    <label for="modal-availability" class="block text-sm font-medium text-gray-700">Available</label>
                    <select name="availability" id="modal-availability" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
                <div>
                    <label for="modal-floor" class="block text-sm font-medium text-gray-700">Floor</label>
                    <input type="number" name="floor" id="modal-floor" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2">
                </div>
                <div>
                    <label for="modal-proximity" class="block text-sm font-medium text-gray-700">Proximity to Elevator</label>
                    <select name="proximity_to_elevator" id="modal-proximity" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
                <div class="mt-4 flex justify-end space-x-2">
                    <button type="button" id="closeModal" class="bg-gray-500 text-white px-4 py-2 rounded-md">Cancel</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Save</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editButtons = document.querySelectorAll('.edit-button');
            const modal = document.getElementById('editModal');
            const closeModalButtons = document.querySelectorAll('#closeModal, #closeModalX');
            const navbar = document.getElementById('navbar');

            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const roomId = this.getAttribute('data-room-id');
                    const roomNumber = this.getAttribute('data-room-number');
                    const roomType = this.getAttribute('data-room-type');
                    const roomDescription = this.getAttribute('data-room-description');
                    const availability = this.getAttribute('data-availability');
                    const floor = this.getAttribute('data-floor');
                    const proximity = this.getAttribute('data-proximity');

                    document.getElementById('modal-room-id').value = roomId;
                    document.getElementById('modal-room-number').value = roomNumber;
                    document.getElementById('modal-room-type').value = roomType;
                    document.getElementById('modal-room-description').value = roomDescription;
                    document.getElementById('modal-availability').value = availability;
                    document.getElementById('modal-floor').value = floor;
                    document.getElementById('modal-proximity').value = proximity;

                    modal.classList.remove('hidden');
                    navbar.classList.add('hidden');
                });
            });

            closeModalButtons.forEach(button => {
                button.addEventListener('click', function() {
                    modal.classList.add('hidden');
                    navbar.classList.remove('hidden');
                });
            });
        });
    </script>
</body>