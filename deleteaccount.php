<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_ID'])) {

    // If the user is not logged in, redirect to login page
    header('Location: login.php');
    exit();
}

// Include the database connection
require_once 'includes/library.php';

// Get the user ID from the session
$user_ID = $_SESSION['user_ID'];
$pdo = connectDB();
// Delete all books associated with the user
$delete_query = "DELETE FROM cois3420_assn_books WHERE id=?";
$stmt = $pdo->prepare($delete_query);
$stmt->execute([$user_ID]);
$success = true;

// Delete the user data
$delete_query = "DELETE FROM cois3420_assn_users WHERE user_ID =?";
$stmt = $pdo->prepare($delete_query);
$stmt->execute([$user_ID]);
$success = true;


// Destroy the session
session_destroy();

// Redirect to login page

header('Location: login.php');
exit();
?>