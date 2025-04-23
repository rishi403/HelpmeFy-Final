<?php
// Database configuration
define('DB_SERVER', 'localhost'); // Database server (often 'localhost')
define('DB_USERNAME', 'root'); // Database username
define('DB_PASSWORD', ''); // Database password (usually empty for local environments)
define('DB_NAME', 'helpmefy'); // Name of your database

// Attempt to connect to MySQL database
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($conn === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Session settings
session_start();

// Security: Use cookies to store session IDs
ini_set('session.cookie_lifetime', 3600); // Set session cookie lifetime (e.g., 1 hour)

// Ensure session timeout if user is inactive for 30 minutes
$inactive_time = 1800; // 30 minutes
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $inactive_time) {
    session_unset(); // Unset all session variables
    session_destroy(); // Destroy session
}
$_SESSION['last_activity'] = time(); // Update last activity time

?>
