<?php
// backend/db.php

// Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'Manu');
define('DB_PASS', 'Manu@2308');
define('DB_NAME', 'feedback');

// Create Connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Connection Error Handling
if ($conn->connect_error) {
    error_log("❌ Database connection error: " . $conn->connect_error);
    die("Database error. Please try again later.");
}

// Set UTF-8 Charset
if (!$conn->set_charset("utf8mb4")) {
    error_log("❌ Charset error: " . $conn->error);
    die("Character encoding issue.");
}
?>
