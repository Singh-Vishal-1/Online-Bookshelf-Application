<?php

$errors = array(); //declare empty array to add errors too

include 'includes/library.php';


//get name from post or set to NULL if doesn't exist
$username = $_POST['username'] ?? null;
$firstname = $_POST['firstname'] ?? null;
$email = $_POST['email'] ?? null;
$verifyemail = $_POST['verifyemail'] ?? null;
$password = $_POST['password'] ?? null;
$verifypassword = $_POST['verifypassword'] ?? null;




if (isset($_POST['submit'])) { //only do this code if the form has been submitted



    //validate user has entered a username which is atleast 6 characters in length too
    //if (!isset($username) || strlen($username) < 6) {
    //  $errors['username'] = true;
    // }

    // //validate user has entered a firstname
    // if (!isset($firstname) || strlen($firstname) === 0) {
    //     $errors['firstname'] = true;
    // }

    //validate user has entered a valid email 
    // if ((!isset($email) || strlen($email) === 0) || (!strpos($email, '@') && !strpos($email, '.'))) {
    //     $errors['email'] = true;
    // }

    // //validate user has entered a valid email in 'verfiy email' field
    // if (!isset($verifyemail) || strlen($verifyemail) === 0) {
    //     $errors['verifyemail'] = true;
    // }

    //check if both the entered emails match
    if (!(($email) == ($verifyemail))) {
        $errors['emailMatch'] = true;
    }


    // // regular expression to match password requirements
    // $regex = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^\w\d\s:])(?=.*[^\w\d\s:])\S{8,}$/';

    // if (!(preg_match($regex, $password))) {
    //     $errors['password'] = true;
    // }
    // if (!isset($verifypassword) || strlen($verifypassword) === 0) {
    //     $errors['verifypassword'] = true;
    // }

    // // check if passwords match
    // if (!(($password) == ($verifypassword))) {
    //     $errors['passwordMatch'] = true;
    // }



    //if no errors found create account and log them in to the account.

    if (count($errors) == 0) {

        // Connect to Database
        $pdo = connectdb();

        //Check the database if username already exists
        $pdo = connectDB();

        $query = $pdo->prepare('SELECT * FROM cois3420_assn_users WHERE username = ?');
        $query->execute([$username]);
        $user = $query->fetch();

        if ($user) {
            $errors['user'] = true;
        } else {

            // Hash the password
            $hash = password_hash($password, PASSWORD_DEFAULT);

            // Insert the user into the database
            $query = "INSERT INTO cois3420_assn_users (user_ID, username, password, email, name ) VALUES (NULL,'$username', '$hash', '$email', '$firstname')";

            if ($pdo->query($query)) {
                $success = true;
                header("Location:login.php");
                exit();

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
    <title>Register Page</title>
    <script defer src="./scripts/register.js"></script>
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
    <main class="register_main">


        <!-- Register Form -->
        <section>
            <div class="register">
                <img src="images/register.png" alt="Register Icon" height="100">
                <h2> CREATE ACCOUNT</h2>
            </div>


            <form id="register_form" name="registerform" action="<?= htmlentities($_SERVER['PHP_SELF']); ?>"
                method="post">
                <div>
                    <label for="user_name">Username:</label>

                    <input type="text" name="username" id="user_name" placeholder="Enter Username"
                        value="<?php echo $username; ?>">
                    <span class="error" style="display: none; color:red;">Error: Please enter a valid Username</span>



                    <!--
                        <span style="color: red; font-size:1.2em">Username already exists</span>
                  -->
                    <!-- <img src="images/cancel.png" height="18" > Username already exists. -->
                    <!-- <img src="images/cancel.png" height="18" > Username is too short. -->
                </div>

                <div>
                    <label for="first_name">First name:</label>
                    <input type="text" name="firstname" id="first_name" placeholder="Enter Firstname"
                        value="<?php echo $firstname; ?>">
                    <span class="error" style="display: none; color:red;">Error: Please enter a Name</span>

                    <!-- <?php if (isset($errors['firstname'])): ?>
                        <span style="color: red"><img src="images/cancel.png" height="18"> Please Enter a Valid First
                            Name</span>
                    <?php endif ?> -->
                    <!--<img src="images/cancel.png" height="18" > Name is too short.-->
                </div>

                <div>
                    <label for="e_mail">Email:</label>
                    <input type="email" name="email" id="e_mail" placeholder="abc@xyz.com"
                        value="<?php echo $email; ?>">

                    <span class="error" style="display: none; color:red;">Error: Please enter a valid Email</span>


                    <label for="verify_email">Verify Email:</label>
                    <input type="text" name="verifyemail" id="verify_email" placeholder="abc@xyz.com"
                        value="<?php echo $verifyemail; ?>">


                    <!-- <?php if (isset($errors['verifyemail'])): ?>
                        <span style="color: red"><img src="images/cancel.png" height="18"> Please Re-Enter the Email</span>
                    <?php endif ?> -->

                    <?php if (isset($errors['emailMatch'])): ?>
                        <span style="color: red"><img src="images/cancel.png" height="18"> Email addresses don't
                            match</span>
                    <?php endif ?>

                    <!-- <img src="images/cancel.png" height="15"> Email address already in use.
                    <img src="images/cancel.png" height="18" >Email addresses do not match
                    <img src="images/cancel.png" height="18">Invalid email address. -->
                </div>
                <div>
                    <label for="pass_word">Password:</label>
                    <input type="password" name="password" id="pass_word" placeholder="Enter Password">

                    <div id="strMessage">Password Strength: <span id="strength"></span></div>

                    <label for="verify_password">Verify Password:</label>
                    <input type="password" name="verifypassword" id="verify_password" placeholder=" Verfiy Password">
                    <span class="error" style="display: none; color:red;"> Error: Password's Do not match</span>
                    <span class="error" style="display: none; color:red;"> <img src="images/cancel.png"
                            height="18">Please enter a Password</span>

                    <!-- <?php if (isset($errors['password'])): ?>
                        <span style="color: red"><img src="images/cancel.png" height="18"> Please Enter a valid
                            Password</span>
                    <?php endif ?>

                    <?php if (isset($errors['verifypassword'])): ?>
                        <span style="color: red"><img src="images/cancel.png" height="18"> Please Re-Enter the
                            Password</span>
                    <?php endif ?> -->




                    <?php if (isset($errors['passwordMatch'])): ?>
                        <span style="color: red"><img src="images/cancel.png" height="18"> Password's don't match</span>
                    <?php endif ?>
                    <!-- <img src="images/cancel.png" height="18">Passwords do not match.
                    <img src="images/cancel.png" height="18">Password does not meet the requirements. -->

                </div>

                <div class="requirements"><img src="images/cancel.png" height="18">Password Requirements</div>
                <div class="validation">
                    <ul>
                        <li id="lower"> &#x2714; At least One Lower Case Letter</li>
                        <li id="upper"> &#x2714; At least One Upper Case Letter</li>
                        <li id="special">&#x2714; At least One Special character</li>
                        <li id="number"> &#x2714; At least One Number</li>
                        <li id="length"> &#x2714; At least 8 characters</li>
                    </ul>

                </div>



                <div><button type="submit" name="submit" id="submit">Create Account</button>
                    <button type="reset" name="reset" id="reset">Reset</button>
                </div>
                <!-- Display success or error message if applicable -->
                <?php
                if (isset($success)) {
                    echo '<p style="color: green">' . $success . '</p>';
                } elseif (isset($error)) {
                    echo '<p style="color: red">' . $error . '</p>';
                }

                ?>

            </form>

        </section>

    </main>

    <?php include 'includes/footer.php' ?>


</body>

</html>