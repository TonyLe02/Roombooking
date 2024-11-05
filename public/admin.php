<?php
// Database connection
include __DIR__ . '/../app/core/db_connect.php';

// Fetch all rooms from the database
$sql = "SELECT r.room_number, rt.name AS room_type, rt.description AS room_description, r.available, r.floor, r.proximity_to_elevator 
        FROM rooms r 
        JOIN room_types rt ON r.type_id = rt.id";
$result = $conn->query($sql);

// Close the connection
$conn->close();

// Manually configure environment variables
$databaseConfig = [
    'host' => 'localhost',
    'dbname' => 'your_database',
    'user' => 'your_database_user',
    'password' => 'your_database_password',
];

// Set the view file to be included
$view = __DIR__ . '/../app/views/admin.php';

// Include the main layout file
include __DIR__ . '/../app/views/layouts/main.php';
