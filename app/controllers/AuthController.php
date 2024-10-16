<?php

class AuthController extends Controller {
    public function login() {
        session_start(); // Start the session

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Authenticate user
            if ($this->authenticate($username, $password)) {
                // Store username in session
                $_SESSION['username'] = $username;

                // Redirect to search page
                header('Location: /Roombooking/public/search.php');
                exit;
            } else {
                // Render login view with error message
                $this->render('login', ['title' => 'Login Page', 'error' => 'Invalid username or password']);
            }
        } else {
            // Render login view
            $this->render('login', ['title' => 'Login Page']);
        }
    }

    public function register() {
        session_start(); // Start the session

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $role = $_POST['role'];

            // Validate input
            if (empty($username) || empty($password) || empty($role)) {
                $this->render('register', ['title' => 'Register Page', 'error' => 'All fields are required']);
                return;
            }

            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Store user in database
            if ($this->storeUser($username, $hashedPassword, $role)) {
                // Redirect to login page
                header('Location: /Roombooking/public/login.php');
                exit;
            } else {
                $this->render('register', ['title' => 'Register Page', 'error' => 'Failed to create account']);
            }
        } else {
            // Render register view
            $this->render('register', ['title' => 'Register Page']);
        }
    }

    private function storeUser($username, $hashedPassword, $role) {
        // Include the database connection script
        include __DIR__ . '/../core/db_connect.php';

        // Prepare and execute the query
        $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param('sss', $username, $hashedPassword, $role);
        if (!$stmt->execute()) {
            die("Execute failed: " . $stmt->error);
        }
        return $stmt->execute();
    }

    private function authenticate($username, $password) {
        // Include the database connection script
        include __DIR__ . '/../core/db_connect.php';

        // Prepare and execute the query
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            // Verify password
            if (password_verify($password, $user['password'])) {
                // Start session and store user information
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                return true;
            }
        }

        return false;
    }
}