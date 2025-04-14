<?php

// Check if form data exists before accessing
$name = isset($_POST['name']) ? $_POST['name'] : null;
$email = isset($_POST['email']) ? $_POST['email'] : null;
$phone = isset($_POST['phone']) ? $_POST['phone'] : null;
$incident_date = isset($_POST['incident_date']) ? $_POST['incident_date'] : null;
$location = isset($_POST['location']) ? $_POST['location'] : null;
$incident_details = isset($_POST['incident_details']) ? $_POST['incident_details'] : null;
$witness = isset($_POST['witness']) ? $_POST['witness'] : null;

// File upload handling
$file_upload = null; // Default null
if (isset($_FILES['file_upload']) && $_FILES['file_upload']['error'] == UPLOAD_ERR_OK) {
    $target_dir = "uploads/"; // Ensure this directory exists and is writable
    $file_upload = $target_dir . basename($_FILES['file_upload']['name']);
    if (!move_uploaded_file($_FILES['file_upload']['tmp_name'], $file_upload)) {
        $file_upload = null; // Reset if upload fails
    }
}

// Database connection
$conn = new mysqli('localhost', 'root', '', 'register');

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Prepare SQL statement
$stmt = $conn->prepare("INSERT INTO Complaint (name, email, phone, incident_date, location, incident_details, file_upload, witness) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

// Bind parameters
$stmt->bind_param("ssssssss", $name, $email, $phone, $incident_date, $location, $incident_details, $file_upload, $witness);

// Execute query
if ($stmt->execute()) {
    echo "<script>
        alert('Complaint successfully submitted.');
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



