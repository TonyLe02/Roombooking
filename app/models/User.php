<?php
class User {
    // Database connection and table name
    private $conn;
    private $table = 'users';

    // User properties
    public $id;
    public $username;
    public $password;
    public $role;
    public $created_at;

    // Constructor with database connection
    public function __construct($db) {
        $this->conn = $db;
    }

    // Create a new user
    public function create() {
        // SQL query to insert a new user
        $query = "INSERT INTO " . $this->table . " (username, password, role) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        // Sanitize input to prevent SQL injection
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->role = htmlspecialchars(strip_tags($this->role));

        // Bind data to the prepared statement
        $stmt->bind_param('sss', $this->username, $this->password, $this->role);

        // Execute the query and check if it was successful
        if ($stmt->execute()) {
            return true;
        }

        // Return false if the query failed
        return false;
    }
}
?>