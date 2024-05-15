<?php


session_start();
if (isset($_SESSION['username'])) {

    require_once 'includes/library.php';

    $user_ID = $_SESSION['user_ID'];
    $username = $_SESSION['username'];
    $name = $_SESSION['name'];
    $email = $_SESSION['email'];
}
if (!(isset($_POST['submit']))) { //Only do if the form is not submitted
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Register Page</title>
        <link rel="stylesheet" href="./styles/main.css">
    </head>

    <body>
        <?php include 'includes/header.php' ?>
        <nav>

            <label class="logo">VISHALPEDIA</label>
            <?php if (isset($_SESSION['username'])): ?>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="deleteaccount.php">Delete User</a></li>
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
        <main class="register_main">


            <!-- Register Form -->
            <section>
                <div class="register">
                    <img src="images/register.png" alt="Register Icon" height="100">
                    <h2> EDIT ACCOUNT</h2>
                </div>


                <form id="register_form" name="registerform" action="<?= htmlentities($_SERVER['PHP_SELF']); ?>"
                    method="post">
                    <div>
                        <label for="user_name">Username:</label>
                        <input required type="text" name="newusername" id="user_name" value="<?php echo $username; ?>">
                        <?php if (isset($errors['username'])): ?>
                            <span style="color: red"><img src="images/cancel.png" height="18"> Please Enter a Valid Username
                                with Atleast 6
                                letters</span>
                        <?php endif ?>
                        <?php if (isset($errors['user'])): ?>
                            <span style="color: red; font-size:1.2em">Username already exists</span>
                        <?php endif ?>
                        <!-- <img src="images/cancel.png" height="18" > Username already exists. -->
                        <!-- <img src="images/cancel.png" height="18" > Username is too short. -->

                    </div>
                    <div>
                        <label for="first_name">First name:</label>
                        <input type="text" name="newfirstname" id="first_name" value="<?php echo $name; ?>">
                        <?php if (isset($errors['firstname'])): ?>
                            <span style="color: red"><img src="images/cancel.png" height="18"> Please Enter a Valid First
                                Name</span>
                        <?php endif ?>
                        <!--<img src="images/cancel.png" height="18" > Name is too short.-->
                    </div>
                    <div>
                        <label for="e_mail">Email:</label>
                        <input required type="email" name="newemail" id="e_mail" value="<?php echo $email; ?>">


                        <?php if (isset($errors['email'])): ?>
                            <span style="color: red"><img src="images/cancel.png" height="18"> Please Enter a Valid Email</span>
                        <?php endif ?>


                        <!-- <img src="images/cancel.png" height="15"> Email address already in use.
                    <img src="images/cancel.png" height="18" >Email addresses do not match
                    <img src="images/cancel.png" height="18">Invalid email address. -->
                    </div>




                    <div class="submit"><button type="submit" name="submit" id="submit">Update</button></div>



                </form>

            </section>

        </main>

        <?php include 'includes/footer.php' ?>


    </body>

    </html>

    <?php
} else { //only do this code if the form has been submitted

    $errors = array(); //declare empty array to add errors too

    require_once 'includes/library.php';


    //get name from post or set to NULL if doesn't exist
    $newusername = $_POST['newusername'] ?? null;
    $newfirstname = $_POST['newfirstname'] ?? null;
    $newemail = $_POST['newemail'] ?? null;


    //validate user has entered a username which is atleast 6 characters in length too
    if (!isset($newusername) || strlen($newusername) < 6) {
        $errors['username'] = true;
    }

    //validate user has entered a firstname
    if (!isset($newfirstname) || strlen($newfirstname) === 0) {
        $errors['firstname'] = true;
    }

    //validate user has entered a valid email 
    if ((!isset($newemail) || strlen($newemail) === 0) || (!strpos($newemail, '@') && !strpos($newemail, '.'))) {
        $errors['email'] = true;
    }


    //if no errors found 

    if (count($errors) == 0) {

        // check if the username was changed
        if ($username != $newusername) {
            $pdo = connectDB();
            $query = $pdo->prepare('SELECT * FROM cois3420_assn_users WHERE username = ?');
            $query->execute([$newusername]);
            $user = $query->fetch();

            if ($user) {
                $errors['user'] = true;
            } else {
                $update_query = "UPDATE cois3420_assn_users SET username ='$newusername' WHERE username=?";
                $stmt = $pdo->prepare($update_query);
                $stmt->execute([$username]);
                $success = true;

            }
        } else {

            $pdo = connectDB();
            $update_query = "UPDATE cois3420_assn_users SET  name = '$newfirstname' , email ='$newemail' WHERE username=?";
            $stmt = $pdo->prepare($update_query);
            $stmt->execute([$username]);
            $success = true;

        }

        ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Register Page</title>
            <link rel="stylesheet" href="main.css">
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
            <main class="register_main">


                <!-- Register Form -->
                <section>
                    <div class="register">
                        <img src="images/register.png" alt="Register Icon" height="100">
                        <h2> EDIT ACCOUNT</h2>
                    </div>


                    <form id="register_form" name="registerform" action="<?= htmlentities($_SERVER['PHP_SELF']); ?>"
                        method="post">
                        <div>
                            <label for="user_name">Username:</label>
                            <input required type="text" name="newusername" id="user_name" value="<?php echo $newusername; ?>">
                            <?php if (isset($errors['username'])): ?>
                                <span style="color: red"><img src="images/cancel.png" height="18"> Please Enter a Valid Username
                                    with Atleast 6
                                    letters</span>
                            <?php endif ?>
                            <?php if (isset($errors['user'])): ?>
                                <span style="color: red; font-size:1.2em">Username already exists</span>
                            <?php endif ?>
                            <!-- <img src="images/cancel.png" height="18" > Username already exists. -->
                            <!-- <img src="images/cancel.png" height="18" > Username is too short. -->

                        </div>
                        <div>
                            <label for="first_name">First name:</label>
                            <input type="text" name="nrwfirstname" id="first_name" value="<?php echo $newfirstname; ?>">
                            <?php if (isset($errors['firstname'])): ?>
                                <span style="color: red"><img src="images/cancel.png" height="18"> Please Enter a Valid First
                                    Name</span>
                            <?php endif ?>
                            <!--<img src="images/cancel.png" height="18" > Name is too short.-->
                        </div>
                        <div>
                            <label for="e_mail">Email:</label>
                            <input required type="email" name="newemail" id="e_mail" value="<?php echo $newemail; ?>">


                            <?php if (isset($errors['email'])): ?>
                                <div style="color: red"><img src="images/cancel.png" height="18"> Please Enter a Valid Email</div>
                            <?php endif ?>


                            <!-- <img src="images/cancel.png" height="15"> Email address already in use.
                    <img src="images/cancel.png" height="18" >Email addresses do not match
                    <img src="images/cancel.png" height="18">Invalid email address. -->
                        </div>




                        <div class="submit"><button type="submit" name="submit" id="submit">Update</button></div>

                        <!-- Display success or error message if applicable -->

                        <?php if (isset($success)): ?>
                            <span style="color: Green; font-weight:bold "> Success: Update Successfull</span>
                        <?php endif ?>

                    </form>

                </section>

            </main>

            <?php include 'includes/footer.php' ?>


        </body>

        </html>
    <?php
    }
}


?>