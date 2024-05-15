<?php

require_once('includes/library.php');

//check if form is submitted 
if (isset($_POST['submit'])) {
    //get username
    $errors = array();
    $username = $_POST['username'] ?? null;
    $pdo = connectDB();
    //query to check username 
    $query = "SELECT * FROM cois3420_assn_users WHERE username=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$username]);
    $result = $stmt->fetch();

    //query to get email
    $query = "SELECT email FROM cois3420_assn_users WHERE username=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$username]);
    $email = $stmt->fetchColumn();
    $email_string = (string) $email;

    //if username is found 
    if ($result == true) {

        $password = $_POST['password'] ?? null;
        $hash_password = password_hash($password, PASSWORD_DEFAULT);
        //update user's password in database 
        $update_query = "UPDATE cois3420_assn_users SET password ='$hash_password' WHERE username=?";
        $stmt = $pdo->prepare($update_query);
        $stmt->execute([$username]);
        //send email 
        include 'includes/mail.php';


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
    <title>Password Reset</title>
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
                <li><a href="login.php">Log Out</a></li>
            </ul>
        <?php else: ?>
            <ul>
                <li><a href="index.php">Home</a></li>

                <li><a href="register.php">Create Account</a></li>
                <li><a href="login.php">Log In</a></li>
            </ul>
        <?php endif; ?>

    </nav>
    <main class="forgot_main">



        <!-- Password Reset Form -->
        <section>
            <div class="forgot">
                <img src="images/reset-password.png" alt="Reset Password Icon" height="100">
                <h2>RESET PASSWORD</h2>
            </div>


            <form id="register_form" name="forgot" action="<?= htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
                <div>
                    <label for="user_name">User Name :</label>
                    <input required type="text" name="username" id="user_name" placeholder="Enter Username">

                </div>


                <label for="e_mail">Email Address:</label>
                <input required type="email" name="email" id="e_mail" placeholder="abc@xyz.com">
                <div>
                    <label for="New_password">New Password:</label>
                    <input type="password" name="password" id="New_password">
                </div>




                <p>*Note: An email confirmation would be sent to this Email</p>

                <div class="forgot">
                    <button type="submit" name="submit" id="submit">Submit Request</button>
                </div>

                <?php if (isset($errors['user'])): ?>
                    <span style="color: red; font-size:1.2em">Error: Username Doesn't exist</span>
                <?php endif ?>


            </form>

        </section>

    </main>
    <br>
    <?php include 'includes/footer.php' ?>


</body>

</html>