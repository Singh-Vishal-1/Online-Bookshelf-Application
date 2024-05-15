<?php
// Start the session
//session_start();


// Include the database connection
require_once 'includes/library.php';


$username = $_GET['username'];
$pdo = connectDB();

// check Query
$check_query = "SELECT * FROM cois3420_assn_users WHERE username =?";
$stmt = $pdo->prepare($check_query);
$stmt->execute([$username]);
$success = true;


// Destroy the session
//session_destroy();


?>