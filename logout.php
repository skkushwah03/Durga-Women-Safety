<?php
// Start the session
session_start();

// Destroy all session data
session_unset(); // Remove all session variables
session_destroy(); // Destroy the session

// Redirect to the homepage
header("Location: Durga.html"); // Replace 'index.php' with your homepage file name
exit;
?>
