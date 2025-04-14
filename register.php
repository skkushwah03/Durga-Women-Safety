<?php
// Check if form data exists before accessing
$name = isset($_POST['name']) ? $_POST['name'] : null;
$address = isset($_POST['address']) ? $_POST['address'] : null;
$email = isset($_POST['email']) ? $_POST['email'] : null;
$phone = isset($_POST['phone']) ? $_POST['phone'] : null;
$password = isset($_POST['password']) ? $_POST['password'] : null;
$confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : null;
$location = isset($_POST['location']) ? $_POST['location'] : null;

// Check if all required fields are filled
if (!$name || !$address || !$email || !$phone || !$password || !$location) {
    echo "<script>
        alert('All fields are required.');
        window.history.back();
    </script>";
    exit;
}

// Ensure passwords match
if ($password !== $confirm_password) {
    echo "<script>
        alert('Passwords do not match.');
        window.history.back();
    </script>";
    exit;
}

// Hash the password for security
// $hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Database connection
$conn = new mysqli('localhost', 'root', '', 'register');

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Check if email or phone already exists
$check_query = $conn->prepare("SELECT * FROM registeration WHERE email = ? OR phone = ?");
$check_query->bind_param("ss", $email, $phone);
$check_query->execute();
$result = $check_query->get_result();

if ($result->num_rows > 0) {
    echo "<script>
        alert('Email or phone number already exists. Please login.');
        window.location.href = 'login.html';
    </script>";
    $check_query->close();
    $conn->close();
    exit;
}

$check_query->close();

// Prepare SQL statement
$stmt = $conn->prepare("INSERT INTO registeration (name, address, email, phone, password, location) VALUES (?, ?, ?, ?, ?, ?)");

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

// Bind parameters
$stmt->bind_param("ssssss", $name, $address, $email, $phone, $password, $location);

// Execute query
if ($stmt->execute()) {
    echo "<script>
        alert('Registration successful.');
        window.location.href = 'login.html'; // Redirect to login page
    </script>";
} else {
    echo "<script>
        alert('An error occurred. Please try again later.');
        window.history.back();
    </script>";
}

// Close connection
$stmt->close();
$conn->close();
?>
