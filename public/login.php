<?php
// Include the database connection script
include __DIR__ . '/../app/core/db_connect.php';

// Initialize error variable
$error = "";

// Check if the login form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize user input
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Validate input
    if (empty($username) || empty($password)) {
        $error = "Both fields are required.";
    } else {
        try {
            // Prepare and execute the query to fetch user data
            $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE username = ?");
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $stmt->store_result();

            // Check if the user exists
            if ($stmt->num_rows === 1) {
                $stmt->bind_result($id, $hashedPassword, $role);
                $stmt->fetch();

                // Verify the password
                if (password_verify($password, $hashedPassword)) {
                    // Start a session and set user data
                    session_start();
                    $_SESSION['user_id'] = $id;
                    $_SESSION['username'] = $username;
                    $_SESSION['role'] = $role;

                    // Redirect to the homepage or dashboard
                    header('Location: /Roombooking/public/search.php');
                    exit;
                } else {
                    $error = "Invalid password."; // Set error if password is incorrect
                }
            } else {
                $error = "User not found."; // Set error if username doesn't exist
            }
        } catch (Exception $e) {
            $error = "Error: " . $e->getMessage(); // Handle any exceptions
        }
    }
}
?>

<!-- Include the login view -->
<?php $view = __DIR__ . '/../app/views/login.php'; ?>
<?php include __DIR__ . '/../app/views/layouts/main.php'; ?>