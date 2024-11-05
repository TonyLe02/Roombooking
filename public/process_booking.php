<?php

// Manually configure environment variables
$databaseConfig = [
    'host' => 'localhost',
    'dbname' => 'your_database',
    'user' => 'your_database_user',
    'password' => 'your_database_password',
];

// Set the view file to be included
$view = __DIR__ . '/../app/views/process_booking.php';

// Include the main layout file
include __DIR__ . '/../app/views/layouts/main.php';
?>