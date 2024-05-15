<?php


session_start(); //start session


//check session for whatever user info was stored
if (!isset($_SESSION['username'])) {
    //no user info, redirect
    header("Location:login.php");
    exit();
}


require_once('includes/library.php');
$username = $_SESSION['username'];
$id = $_SESSION['user_ID'];

$bookcover = $_POST['cover'] ?? NULL;
$coverurl = $_POST['cover-image-url'] ?? null;
$ebook_file = $_POST['ebook'] ?? null;
$booktitle = $_POST['title'] ?? null;
$bookauthor = $_POST['author'] ?? null;
$description = $_POST['desc'] ?? null;
$rating = $_POST['rating'] ?? null;
$pubDate = $_POST['date'] ?? null;
$isbn = $_POST['isbn'] ?? null;
$tags = $_POST['tags'] ?? null;

if (isset($_POST['submit'])) {
    $pdo = connectDB();

    $query = "INSERT INTO cois3420_assn_books VALUES(NULL, ?, ?, ?, ?,?,?,?,?,?,?,?)";

    $pdo->prepare($query)->execute([$bookcover, $coverurl, $ebook_file, $booktitle, $bookauthor, $rating, $description, $pubDate, $isbn, $tags, $id]);
    header("Location:index.php");
    exit();
}


?>


<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book</title>
    <script defer src="./scripts/addbook.js"></script>
    <link rel="stylesheet" href="./styles/main.css">
</head>

<body>

    <body>
        <?php include 'includes/header.php' ?>
        <nav>
            <label class="logo">VISHALPEDIA</label>
            <?php if (isset($_SESSION['username'])): ?>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="editaccount.php">Edit User</a></li>
                    <li><a href="register.php">Create Account</a></li>
                    <li><a href="logout.php">Log Out</a></li>
                </ul>
            <?php else: ?>
                <ul>
                    <li><a href="index.php">Home</a></li>

                    <li><a href="register.php">Create Account</a></li>
                    <li><a href="login.php">Log In</a></li>
                </ul>
            <?php endif; ?>

        </nav>
        <!-- This is the main container for the addbook form -->
        <main class="addbook_main">
            <!-- The form element that wraps all the input fields -->
            <section>
                <div class="addbook">
                    <img src="images/book.png" alt="Add book Icon" height="100">
                    <h2>ADD A NEW BOOK</h2>
                </div>

                <form action="<?= htmlentities($_SERVER['PHP_SELF']) ?>" id="add_book" name="addbook_form" method="post"
                    class="addbook_form">


                    <div>
                        <label for="cover">Book Cover (Image):</label>
                        <input type="file" id="cover" name="cover" accept="image/*">
                        <span class="error" style="display: none; color:red;">Error: Please selct a Cover Image</span>
                    </div>


                    <div>
                        <label for="cover-image-url">Cover Image URL:</label>
                        <input type="url" id="cover-image-url" name="cover-image-url"><br>
                        <span class="error" style="display: none; color:red;">Error: Please enter a valid URL</span>
                    </div>


                    <div>
                        <label for="ebook">eBook:</label>
                        <input type="file" id="ebook" name="ebook" accept="application/pdf">
                    </div>


                    <div>
                        <label for="title">Book Title</label>
                        <input type="text" id="title" name="title" placeholder="Book Title">
                        <span class="error" style="display: none; color:red;">Error: Please enter a valid Book
                            Title</span>
                    </div>
                    </div>


                    <div>
                        <label for="author">Author</label>
                        <input type="text" id="author" name="author" placeholder="Author">
                        <span class="error" style="display: none; color:red;">Error: Please enter a valid Book
                            Author</span>
                    </div>
                    </div>


                    <div>
                        <label for="rating">Rating</label>
                        <input type="range" id="rating" name="rating" min="1" max="5">
                        <span class="error" style="display: none; color:red;">Error: Please selcet a valid rating</span>
                    </div>


                    <div>
                        <label for="desc">Description</label>
                        <textarea name="desc" id="desc" cols="30" rows="10" placeholder="Description"
                            class="addbook-input"></textarea>
                        <div>Characters Used: <span id="char-counter"></span></div>
                    </div>


                    <div>
                        <label for="date">Publish Date</label>
                        <input type="date" id="date" name="date" class="addbook-input">
                        <span class="error" style="display: none; color:red;">Error: Please enter a Publication
                            Date</span>
                    </div>


                    <div>
                        <label for="isbn">ISBN</label>
                        <input type="text" id="isbn" name="isbn" placeholder="ISBN" class="addbook-input">
                        <span class="error" style="display: none; color:red;">Error: Please enter a valid ISBN</span>
                    </div>


                    <div>
                        <label for="tags">Tags</label>
                        <input type="text" id="tags" name="tags" placeholder="User tags" class="addbook-input">
                    </div>

                    <div>
                        <button name="submit" id="submit" type="submit">Submit</button>
                        <button name="clear" id="reset" type="button" class="addbook-btn-addbook-clear-btn">Clear
                            Form</button>
                        <button name="auto" type="button" class="addbook-btn-addbook-auto-btn">Auto-Complete</button>
                    </div>

                </form>
            </section>
        </main>

        <?php include 'includes/footer.php'; ?>
    </body>

</html>