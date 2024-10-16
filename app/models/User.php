<?php
class User {
    private $conn;

    public function __construct($databaseConnection) {
        $this->conn = $databaseConnection;
    }

    // Check if username exists
    public function usernameExists($username) {
        $stmt = $this->conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0; // Returns true if user exists
    }

    // Create a new user
    public function create($username, $password, $role) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hash the password
        $stmt = $this->conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        $stmt->bind_param('sss', $username, $hashedPassword, $role); // Use hashed password
        return $stmt->execute(); // Returns true on success
    }
}
?>
