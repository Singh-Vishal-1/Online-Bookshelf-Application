<?php
session_start(); //start session
$book_id = $_GET['id'];


if (!isset($_SESSION['username'])) {
    //no user info, redirect
    header("Location:login.php");
    exit();
}


require_once('includes/library.php');
$pdo = connectDB();
$query = "DELETE FROM cois3420_assn_books WHERE id=$book_id";
$stmt = $pdo->prepare($query);
$stmt->execute();
header("Location: index.php");
exit();
?>