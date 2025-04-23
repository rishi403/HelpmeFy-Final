<?php
require 'db.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    
    $stmt = $conn->prepare("UPDATE users SET is_verified = 1 WHERE verification_token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Email verified successfully!";
    } else {
        echo "Invalid or expired token.";
    }
}
?>
