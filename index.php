<?php
// Ensure that User is logged In

require_once('includes/library.php');
session_start(); //start session
$items = $_POST["items_per_page"] ?? 5;

//check session for stored user info
$username = $_SESSION['username'];
if (!isset($username)) {

    //no user info, so redirect
    header("Location:login.php");
    exit();
}
$pdo = connectDB();

$query = "SELECT name FROM cois3420_assn_users WHERE username=?";
$stmt = $pdo->prepare($query);
$stmt->execute([$username]);

$fname = $stmt->fetchColumn();
$fname_string = (string) $fname;
$query = "SELECT id,cover_url, book_title, book_author FROM cois3420_assn_users ,cois3420_assn_books WHERE cois3420_assn_users.user_ID =cois3420_assn_books.user_id";

$stmt = $pdo->query($query);
if (!$stmt) {
    die("Something went wrong");
}
$results = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <script defer src="./scripts/modal.js"></script>
    <link rel="stylesheet" href="./styles/main.css">

</head>

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
                <li><a href="editaccount.php">Edit User</a></li>
                <li><a href="register.php">Create Account</a></li>
                <li><a href="login.php">Log In</a></li>
            </ul>
        <?php endif; ?>

    </nav>
    <main>

        <section>


            <div>
                <div class="heading">
                    <img src="images/home-page.png" alt="Home Page Icon" height="100">

                    <h2> Good Evening
                        <?php echo $fname_string; ?>!
                    </h2>
                </div>
                <div class="heading">
                    <a href="addbook.php">Add a New Book</a>
                    <a href="search.php">Search Books</a>
                </div>
            </div>
            <h2>Options</h2>

            <!-- From to Dispaly books-->
            <form id="home_page" name="homepage" action="homepage.php" method="post">
                <div>
                    <label for="sort_by">Sort By :</label>
                    <select name="sortby" id="sort_by">
                        <option value="0">Select One</option>
                        <option value="date">Date Added</option>
                        <option value="title">Book title</option>
                        <option value="author">Book Author</option>
                    </select>
                </div>
                <div>
                    <label for="items_per_page">Items Per Page :</label>
                    <input type="number" name="itemsperpage" id="items_per_page">
                </div>

                <button type="submit" name="submit" id="submit">Go</button>

            </form>
            <!-- break -->
            <div class="display">
                <!-- book 1 -->
                <?php foreach ($results as $key => $row): ?>
                    <?php if ($key < $items): ?>
                        <div>
                            <div class="book1">
                                <img src="<?php echo $row['cover_url'] ?>" alt="Dead Silence" height="250">
                                <div class="details"> <strong>
                                        <?php echo $row['book_title'] ?>
                                    </strong><br>
                                    <?php echo $row['book_author'] ?>
                                </div>
                            </div>
                            <div class="buttons">
                                <a id="deleteBtn" onclick="confirmDelete()"
                                    href="deletebook.php?id=<?php echo $row['id'] ?>">Delete</a>
                                <a href="#"> Edit</a>

                                <a class="button" href="details.php?id=<?php echo $row['id'] ?> onclick=" displayDetails('<?php echo $row['id'] ?>')">Details</a>


                            </div>
                            <!-- href="details.php?id=<?php echo $row['id'] ?>" -->
                        </div>
                    <?php endif ?>
                <?php endforeach ?>

            </div>


        </section>

    </main>
    <script defer src="./scripts/delete.js"></script>
    <br>
    <?php include 'includes/footer.php' ?>

</body>

</html>