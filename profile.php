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

// Query to fetch the user's details from the registeration table using email
$sql = "SELECT name, email, phone, address, location FROM registeration WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email); // "s" denotes string type for email
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Fetch the user's details
    $row = $result->fetch_assoc();
    $name = $row['name'];
    $email = $row['email'];
    $phone = $row['phone'];
    $address = $row['address'];
    $location = $row['location'];

    // Display user details in a table format within a box
    echo "<div class='profile-container'>
            <h2>User Profile</h2>
            <table>
                <tr>
                    <th>Name</th>
                    <td>$name</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>$email</td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td>$phone</td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td>$address</td>
                </tr>
                <tr>
                    <th>Location</th>
                    <td>$location</td>
                </tr>
            </table>";

    // Provide a form to update user details (excluding email)
    
} else {
    echo "<h2>Error: User not found.</h2>";
}

// Close the database connection
$stmt->close();
$conn->close();
?>

<!-- Add CSS for styling the profile page -->
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f7fc;
        margin: 0;
        padding: 0;
    }

    .profile-container {
        width: 80%;
        margin: 40px auto;
        padding: 20px;
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    h2 {
        text-align: center;
        color: #333;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th, td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #f4f7fc;
        color: #333;
    }

    tr:hover {
        background-color: #f9f9f9;
    }

    form {
        margin-top: 30px;
    }

    label {
        font-size: 14px;
        color: #333;
    }

    input[type="text"] {
        width: 100%;
        padding: 10px;
        margin: 8px 0;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 14px;
    }

    input[type="submit"] {
        padding: 12px 20px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }

    input[type="submit"]:hover {
        background-color: #45a049;
    }
</style>
