<?php
session_start();

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

// Check if the email is passed through POST
if (isset($_POST['email'])) {
    $email = $_POST['email'];

    // Query to check if email exists in the database
    $sql = "SELECT email FROM registeration WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Email is registered
        echo 'registered';
    } else {
        // Email is not registered
        echo 'not_registered';
    }

    // Close the connection
    $stmt->close();
    $conn->close();
}
?>
