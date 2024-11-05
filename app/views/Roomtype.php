<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "roombooking";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$room = $_GET['room'] ?? 'single';

// Fetch room details from the database
$sql = "SELECT name, description, max_adults, max_children FROM room_types WHERE name LIKE ?";
$stmt = $conn->prepare($sql);
$roomType = ucfirst($room) . " Room";
$stmt->bind_param('s', $roomType);
$stmt->execute();
$result = $stmt->get_result();
$roomInfo = $result->fetch_assoc();

if (!$roomInfo) {
    // Default to single room if no match found
    $roomInfo = [
        'name' => 'Single Room',
        'description' => 'A cozy single room perfect for solo travelers.',
        'max_adults' => 1,
        'max_children' => 0
    ];
}

$imagePath = "/Roombooking/public/images/" . ucfirst($room) . ".webp";

$conn->close();
?>

<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <main class="container mx-auto mt-6">
        <section class="text-center mb-10">
            <h2 class="text-4xl font-bold mb-4 leading-normal bg-clip-text text-transparent bg-gradient-to-r from-[#2E3192] to-[#1BFFFF]"><?php echo htmlspecialchars($roomInfo['name']); ?></h2>
            <img src="<?php echo htmlspecialchars($imagePath); ?>" alt="<?php echo htmlspecialchars($roomInfo['name']); ?>" class="w-1/2 h-auto object-cover rounded-lg shadow-lg mx-auto">
            <div class="mt-8 flex justify-center">
                <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="py-4 px-6 text-left text-sm font-semibold text-gray-700">Description</td>
                            <td class="py-4 px-6 text-left text-sm text-gray-700"><?php echo htmlspecialchars($roomInfo['description']); ?></td>
                        </tr>
                        <tr>
                            <td class="py-4 px-6 text-left text-sm font-semibold text-gray-700">Max Adults</td>
                            <td class="py-4 px-6 text-left text-sm text-gray-700"><?php echo htmlspecialchars($roomInfo['max_adults']); ?></td>
                        </tr>
                        <tr>
                            <td class="py-4 px-6 text-left text-sm font-semibold text-gray-700">Max Children</td>
                            <td class="py-4 px-6 text-left text-sm text-gray-700"><?php echo htmlspecialchars($roomInfo['max_children']); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>