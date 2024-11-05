<?php
include __DIR__ . '/../app/core/db_connect.php';

// Check if form is submitted to update room availability
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $room_id = $_POST['room_id'];
    $availability = $_POST['availability'];

    // Update the availability of the room
    $update_sql = "UPDATE rooms SET available = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ii", $availability, $room_id);
    if ($stmt->execute()) {
        echo "Room availability updated successfully!";
    } else {
        echo "Error updating room availability: " . $conn->error;
    }
}

// Fetch all rooms from the database again to display the updated information
$sql = "SELECT r.id, r.room_number, rt.name AS room_type, rt.description AS room_description, 
               r.available, r.floor, r.proximity_to_elevator 
        FROM rooms r 
        JOIN room_types rt ON r.type_id = rt.id";
$result = $conn->query($sql);

// Close the connection
$conn->close();

// Set the view file to be included
$view = __DIR__ . '/../app/views/admin.php';

// Include the main layout file
include __DIR__ . '/../app/views/layouts/main.php';
