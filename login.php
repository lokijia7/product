<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PDO - Create a Record - PHP CRUD Tutorial</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <!-- Latest compiled and minified Bootstrap CSS (Apply your Bootstrap here -->

</head>

<body class="login-page">
    <?php

    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    include('config/database.php');
    session_start(); // Start the session

    // Check if there is a warning message
    if (isset($_SESSION["warning"])) {
        echo "<div class='alert alert-warning'>" . $_SESSION["warning"] . "</div>";

        // Unset the warning message so that it doesn't show again
        unset($_SESSION["warning"]);
    }

    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $pass = $_POST['pass'];

        // check if the username/email and password are not empty
        if (!empty($username) && !empty($pass)) {
            // create a SQL query to check if the user exists
            $query = "SELECT * FROM customers WHERE username=:username";
            $stmt = $con->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            // check if the query returned a result
            if ($stmt->rowCount() == 1) {
                // get the user data from the database
                $user = $stmt->fetch();

                // check if the entered password matches the password in the database
                if ($user['pass'] == md5($pass)) {
                    // check if the user account is active
                    if ($user['account_status'] == 'active') {
                        // set the user session variables
                        $_SESSION['username'] = $username;

                        // redirect the user to the home page
                        header('Location: home.php');
                        exit;
                    } else {
                        // show an error message if the user account is inactive
                        echo "<div class='alert alert-danger'>Your account is inactive. Please contact the administrator.</div>";
                    }
                } else {
                    // show an error message if the password is incorrect
                    echo "<div class='alert alert-danger'>Incorrect password.</div>";
                }
            } else {
                // show an error message if the username/email is invalid
                echo "<div class='alert alert-danger'>Invalid username/email.</div>";
            }
        } else {
            // show an error message if the username/email or password is empty
            if (empty($username)) {
                $error_msg_ue = 'Please enter your username/email.';
            }
            if (empty($pass)) {
                $error_msg_p = 'Please enter your password.';
            }
        }
    }
    ?>



    <div id="login">
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <img src="images/21454-01.png" alt="logo">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                        <form id="login-form" class="form" action="" method="post">
                            <h3 class="text-center text-info">Login</h3>
                            <div class="form-group">
                                <label for="username or email" class="text-info">Username / Email:</label><br>
                                <input type="text" name="username" id="username" class="form-control">
                                <?php if (isset($error_msg_ue)) { ?><span class="text-danger"><?php echo $error_msg_ue; ?></span><?php } ?>
                            </div>
                            <div class="form-group">
                                <label for="password" class="text-info">Password:</label><br>
                                <input type="password" name="pass" id="password" class="form-control">
                                <?php if (isset($error_msg_p)) { ?><span class="text-danger"><?php echo $error_msg_p; ?></span><?php } ?>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="login" class="btn btn-info btn-md" value="login">
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
</body>

</html>