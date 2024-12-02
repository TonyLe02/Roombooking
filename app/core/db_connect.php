<?php

// Include the database configuration file
$config = include __DIR__ . '/../config/database.php';

try {
    // Create a new MySQLi connection using the configuration settings
    $conn = new mysqli(
        $config['host'],
        $config['user'],
        $config['password'],
        $config['dbname']
    );

    // Check connection
    if ($conn->connect_error) {
        // Throw an exception if the connection fails
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
} catch (Exception $e) {
    // Handle the exception and terminate the script
    die("Connection failed: " . $e->getMessage());
}
