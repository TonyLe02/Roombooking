<?php
// Include the database connection script
include __DIR__ . '/../app/core/db_connect.php';

// Include the User model
include __DIR__ . '/../app/models/User.php';

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
                // Instantiate the User model
                $user = new User($conn);

                // Set the properties
                $user->username = $username;
                $user->password = $hashedPassword;
                $user->role = $role;

                // Create the user
                if ($user->create()) {

                    $toastMessage = "Your booking account has been successfully created. You can now log in and start booking!";
                } else {
                    $error = "Error: Could not create user.";
                }
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
