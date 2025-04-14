<?php
session_start();

// Check if the user is logged in by checking the session variable (email)
if (!isset($_SESSION['email'])) {
    echo "Error: User not logged in.";
    exit;
}

// Database connection details
$servername = "localhost"; // Database server
$username = "root";        // Database username
$password = "";            // Database password
$dbname = "register";      // Database name

// Connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the user's email from the session
$email = $_SESSION['email']; 

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $location = $_POST['location'];

    // Query to update the user's details in the registeration table (excluding email)
    $sql = "UPDATE registeration SET name = ?, phone = ?, address = ?, location = ? WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $name, $phone, $address, $location, $email);

    if ($stmt->execute()) {
        echo "<h2>Profile updated successfully!</h2>";
        echo "<a href='user.html'>Go back to your profile</a>";
    } else {
        echo "<h2>Error: Unable to update profile.</h2>";
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
