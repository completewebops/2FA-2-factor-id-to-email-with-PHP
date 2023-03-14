<?php
// Database configuration settings
define('DB_HOST', 'localhost'); // Replace with your database host name
define('DB_USER', 'root'); // Replace with your database user name
define('DB_PASSWORD', ''); // Replace with your database user password
define('DB_NAME', 'user_validation_app'); // Replace with your database name

// Create a database connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
