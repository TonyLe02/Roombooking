<?php
require_once '../models/User.php'; // Adjust if needed

class AuthController extends Controller {
    private $userModel;

    public function __construct($databaseConnection) {
        $this->userModel = new User($databaseConnection); // Create a new User instance
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

            try {
                // Check if the username already exists
                if ($this->userModel->usernameExists($username)) {
                    throw new Exception("Username already exists. Please choose another.");
                }

                // Store user in the database using the User model
                $this->userModel->create($username, $password, $role);

                // Redirect to login page
                header('Location: /Roombooking/public/login.php');
                exit;
            } catch (Exception $e) {
                $this->render('register', ['title' => 'Register Page', 'error' => $e->getMessage()]);
            }
        } else {
            // Render the register view
            $this->render('register', ['title' => 'Register Page']);
        }
    }

    public function login() {
        // Login logic using User model...
    }
}
?>
