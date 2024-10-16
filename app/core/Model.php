<?php

class Model {
    protected $conn; // Database connection

    // Constructor to initialize database connection
    public function __construct($databaseConnection) {
        $this->conn = $databaseConnection;
    }

    // Optional: You might include a method for closing the connection
    public function close() {
        $this->conn->close();
    }
}
