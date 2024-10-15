<!-- Admin form or content goes here -->
<div class="container mx-auto max-w-4xl p-4">
    <h1 class="text-3xl font-bold text-gray-900">Admin Dashboard</h1>

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