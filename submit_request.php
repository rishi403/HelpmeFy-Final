<?php

$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "emergency_services"; 


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'];
$phone = $_POST['phone'];
$service = $_POST['service'];
$location = $_POST['location'];


$stmt = $conn->prepare("INSERT INTO requests (name, phone, service, location) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $phone, $service, $location);


if ($stmt->execute()) {
    echo "New record created successfully";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
