<?php
$search = $_POST['search'] ?? "";
$errors = array();

if (isset($_POST['submit'])) {
    if(isset($_POST['search'])) {
        $search = $_POST['search'];
        $search = htmlentities(strip_tags($search));

        if ($search == "") {
            $errors['search'] = true;
        }

        if($search == 'title') {
            // user is searching by book title
            if (!count($errors)) {
        
                require_once "includes/library.php";
                $pdo = connectdb();
                $query = "select * from cois3420_assn_books where title like ?";
                $stmt = $pdo->prepare($query);
                $stmt->execute(['%' . $search . '%']);
        
            }
        } elseif($search == 'author') {
            // user is searching by book author
            if (!count($errors)) {
        
                require_once "includes/library.php";
                $pdo = connectdb();
                $query = "select * from cois3420_assn_books where author like ?";
                $stmt = $pdo->prepare($query);
                $stmt->execute(['%' . $search . '%']);
        
            }
        } elseif($search == 'genre') {
            // user is searching by book genre
            if (!count($errors)) {
        
                require_once "includes/library.php";
                $pdo = connectdb();
                $query = "select * from cois3420_assn_books where genre like ?";
                $stmt = $pdo->prepare($query);
                $stmt->execute(['%' . $search . '%']);
        
            }
        } elseif($search == 'date') {
            // user is searching by date added
            if (!count($errors)) {
        
                require_once "includes/library.php";
                $pdo = connectdb();
                $query = "select * from cois3420_assn_books where date like ?";
                $stmt = $pdo->prepare($query);
                $stmt->execute(['%' . $search . '%']);
        
            }
        } 
    }
    
    
   

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search books</title>
    <link rel="stylesheet" href="./styles/main.css">
</head>

<body class="searchbody">
    <?php include 'includes/header.php' ?>
    <nav>
        <?php if (isset($_SESSION['user'])): ?>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="#">Edit User</a></li>
                <li><a href="register.php">Create Account</a></li>
                <li><a href="login.php">Log Out</a></li>
            </ul>
        <?php else: ?>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="#">Edit User</a></li>
                <li><a href="register.php">Create Account</a></li>
                <li><a href="login.php">Log In</a></li>
            </ul>
        <?php endif; ?>
    </nav>
    <main>
        <h2>Search and Browse Books</h2>
        <div class="genres"><a href="#"> Art </a> <a href="#"> Biography </a> <a href="#"> Business </a><a href="#">
                Childrens </a><a href="#"> Classics </a><a href="#"> Comics </a> <a href="#"> Ebooks </a> <br> <a
                href="#"> Fantasy </a> </div>
        <div class="genres">
            <a href="#"> Fiction </a> <a href="#"> History </a> <a href="#"> Horror</a> <a href="#"> Poetry </a> <a
                href="#"> Psychology </a> <a href="#"> Romance </a> <a href="#"> Science </a>
        </div>

        <form class="search-form" id="search_form" name="searchform" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        
            <div>
                <fieldset>
                    <legend>Search by</legend>
                    <div>
                        <input type="radio" name="search" id="booktitle" value="title">
                        <label for="booktitle">Book Title</label>
                    </div>
                    <div>
                        <input type="radio" name="search" id="bookauthor" value="author">
                        <label for="bookauthor">Book Author</label>
                    </div>
                    <div>
                        <input type="radio" name="search" id="genre" value="genre">
                        <label for="genre">Genre</label>
                    </div>
                    <div>
                        <input type="radio" name="search" id="dateadded" value="date">
                        <label for="dateadded">Date Added</label>
                    </div>

                </fieldset>


                <div>
                    <label for="searchbar">Input:</label>
                    <input type="text" name="search" id="searchbar" placeholder="Enter title/Author/Genre" value"<?php echo $search; ?>" />
                    <span class="<?php echo isset($errors['search']) ? "error" : "noerror"; ?>">
                        You must eneter a Search item
                    </span>

                </div>
                <div>
                    <label for="date">Date Added (optional):</label>
                    <input type="date" name="date" id="date">
                    <button type="submit" name="submit" id="submit">Search</button>
                </div>
            </div>
            <h2>Display Results</h2>
        </form>
        <?php if (isset($_POST['submit']) && !count($errors)): ?>

            <h2>Searching for the records matching
                <?php echo $search; ?> in our Database
            </h2>
            <?php if ($stmt->rowCount() <= 0): ?>
                <p>No Results Found</p>
            <?php else: ?>
                <ul>
                    <?php foreach ($stmt as $row): ?>
                        <li> Course:
                            <?php echo "$row[title] ($row[code])"; ?>
                        </li>
                    <?php endforeach ?>
                    </ul? <?php endif ?> <?php endif ?> </ul>
                    
            <!-- book 1 -->
            <div class="display">
                <!-- book 1 -->
                <div>
                    <div class="book1">
                        <img src="images/book1.jpg" alt="Dead Silence" height="250">
                        <div class="details"> <strong>Dead Silence</strong><br> S.A. Barnes</div>
                    </div>
                    <div class="buttons">
                        <a href="#">Delete</a><a href="#"> Edit</a><a href="details.php">Details</a>
                    </div>

                </div>

                <!-- book 2 -->
                <div>
                    <div class="book2">
                        <img src="images/book2.jpg" alt="Sea of Tranquilty" height="250">
                        <div class="details"> <strong>Sea Of Tranquility</strong><br> Emily St. John Mandel</div>
                    </div>

                    <div class="buttons">
                        <a href="#">Delete</a><a href="#"> Edit</a><a href="details.php">Details</a>
                    </div>

                </div>

                <!-- book 3 -->
                <div>
                    <div class="book3">
                        <img src="images/book3.jpg" alt="Rich Dad Poor Dad" height="250">
                        <div class="details"><strong>Rich Dad Poor Dad</strong><br> Robert T. Kiyosaki</div>
                    </div>
                    <div class="buttons">
                        <a href="#">Delete</a><a href="#"> Edit</a><a href="details.php">Details</a>
                    </div>
                </div>

            </div>



    </main>
    <br>
    <?php include 'includes/footer.php' ?>


</body>

</html>