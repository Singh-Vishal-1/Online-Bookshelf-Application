<?php

require_once('includes/library.php');

$username = $_POST['username'] ?? null;
$password = $_POST['password'] ?? null;
$errors = array();


if (isset($_POST['submit'])) {
    $pdo = connectDB();

    $query = "SELECT * FROM cois3420_assn_users WHERE username=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$username]);
    $result = $stmt->fetch();

    if ($result == true && password_verify($password, $result['password'])) {

        session_start();

        $_SESSION['username'] = $username;
        $_SESSION['user_ID'] = $result['user_ID'];
        $_SESSION['name'] = $result['name'];
        $_SESSION['email'] = $result['email'];

        header('Location: index.php');
        exit();

    } else {
        $errors['user'] = true;
    }
}





?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    $page_title = "Login";
    ?>
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

                <li><a href="register.php">Create Account</a></li>
                <li><a href="login.php">Log In</a></li>
            </ul>
        <?php endif; ?>

    </nav>
    <main class="login_main">



        <section>
            <div class="login">
                <img src="images/enter.png" alt="Login Icon" height="100">
                <h2>LOGIN</h2>
            </div>


            <form action="<?= htmlentities($_SERVER['PHP_SELF']) ?>" method="POST" autocomplete="off">
                <div>
                    <label for="user_name">Username:</label>
                    <input required type="text" name="username" id="user_name" placeholder="Enter Username"
                        value="<?= $username; ?>">
                    <!-- <img src="images/cancel.png" height="18" alt=""> Username doesn't exist. -->

                </div>



                <div>
                    <label for="pass_word">Password:</label>
                    <input type="password" name="password" id="pass_word" placeholder="Enter Password">
                    <!-- <img src="images/cancel.png" height="18" alt=""> Incorrect Password -->
                </div>

                <div>

                    <input type="checkbox" name="rememberme" id="remember_me">
                    Remember Me

                </div>




                <div class="login">
                    <button type="submit" name="submit" id="submit">Log In</button>

                </div>

                <?php if (isset($errors['user'])): ?>
                    <span style="color: red"> Error: Wrong Username or Password, Try Again</span>
                <?php endif ?>



                <div class="login2">
                    <div><a href="register.php"> Create Account </a></div>
                    <div><a href="forgot.php"> Forgot Password</a></div>
                </div>



            </form>

        </section>

    </main>
    <br>
    <?php include 'includes/footer.php' ?>


</body>

</html>