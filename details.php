<?php

require_once('includes/library.php');
session_start(); //start session
$book_id = $_GET['id'];

//check session for whatever user info was stored
if (!isset($_SESSION['username'])) {
    //no user info, redirect
    header("Location:login.php");
    exit();
}
$pdo = connectDB();
$query = "SELECT *FROM cois3420_assn_books WHERE id=$book_id";

$stmt = $pdo->query($query);
if (!$stmt) {
    die("Something went  wrong");
}
$results = $stmt->fetch();
?>
<!-- <!DOCTYPE html>
<html lang="en"> -->

 <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Details</title>
    <link rel="stylesheet" href="./styles/main.css">

</head> 

<body>
    <header>
        <h1>
            <?php echo $results['book_title']; ?>
        </h1>
    </header>
    <main class="details_main">
        <img src="<?php echo $results['cover_url']; ?>" class="book-img" alt="Book cover" height="480">

        <div class="container-1">
            <strong>
                <?php echo $results['book_author'] ?>
            </strong>
            <p>
                <?php echo $results['description']; ?> Source:
                <cite>Goodreads.com</cite>
            </p>
            <strong>
                <?php echo $results['tags']; ?>
            </strong>
            <div><strong>Rating:
                    <?php echo $results['rating']; ?><img src="images/star.png">
                </strong> </div>
            <div><strong>
                    <?php echo $results['publishDate']; ?>
                </strong></div>

            <strong> ISBN:
                <?php echo $results['ISBN']; ?>
            </strong>
            
            <div class="button"><button>Read Book</button></div>


        </div>


    </main>
    <?php include 'includes/footer.php' ?>


</body>

<!-- </html> -->