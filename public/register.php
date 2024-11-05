<?php
// Include the database connection script
include __DIR__ . '/../app/core/db_connect.php';

// Initialize error variable
$error = "";

// Check if the registration form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize user input
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = $_POST['role'];

    // Validate input
    if (empty($username) || empty($password) || empty($role)) {
        $error = "All fields are required.";
    } else {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        try {
            // Check if the username already exists
            $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $error = "Username already exists. Please choose another.";
            } else {
                // Insert the new user
                $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
                $stmt->bind_param('sss', $username, $hashedPassword, $role);
                $stmt->execute();

                // Redirect to login page after successful registration
                header('Location: /Roombooking/public/login.php');
                exit;
            }
        } catch (Exception $e) {
            $error = "Error: " . $e->getMessage();
        }
    }
}

// Set the view file to be included
$view = __DIR__ . '/../app/views/register.php';

// Include the main layout file
include __DIR__ . '/../app/views/layouts/main.php';
