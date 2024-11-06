<?php
include __DIR__ . '/../app/core/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $room_id = $_POST['room_id'];
    $room_description = $_POST['room_description'];
    $availability = $_POST['availability'];
    $floor = $_POST['floor'];
    $proximity_to_elevator = $_POST['proximity_to_elevator'];

    // Update the room details
    $stmt = $conn->prepare("UPDATE rooms SET description = ?, available = ?, floor = ?, proximity_to_elevator = ? WHERE id = ?");
    $stmt->bind_param('siiii', $room_description, $availability, $floor, $proximity_to_elevator, $room_id);
    $stmt->execute();
    $stmt->close();

    // Redirect to avoid form resubmission
    header('Location: admin.php');
    exit;
}

// Fetch rooms data
$sql = "SELECT r.id, r.room_number, r.description AS room_description, r.available, r.floor, r.proximity_to_elevator, rt.name AS room_type 
        FROM rooms r 
        JOIN room_types rt ON r.type_id = rt.id";
$result = $conn->query($sql);

// Close the connection
$conn->close();

// Set the view file to be included
$view = __DIR__ . '/../app/views/admin.php';

// Include the main layout file
include __DIR__ . '/../app/views/layouts/main.php';
?>