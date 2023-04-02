<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PDO - Create a Record - PHP CRUD Tutorial</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <!-- Latest compiled and minified Bootstrap CSS (Apply your Bootstrap here -->
</head>

<body>

    <?php
    include("database.php"); // include database connection file  
    // start session
    session_start();

    // check if the login form is submitted
    if (isset($_POST['login'])) {
        // get the username/email and password from the form
        $username_email = $_POST['username_email'];
        $password = $_POST['password'];

        // check if the username/email and password are not empty
        if (!empty($username_email) && !empty($password)) {
            // create a SQL query to check if the user exists and the password is correct
            $query = "SELECT * FROM users WHERE (username = '$username_email' OR email = '$username_email') AND password = '$password'";
            $result = mysqli_query($conn, $query);

            // check if the query returned a result
            if (mysqli_num_rows($result) == 1) {
                // get the user data from the database
                $user = mysqli_fetch_assoc($result);

                // check if the user account is active
                if ($user['status'] == 'active') {
                    // set the user session variables
                    $_SESSION['id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['email'] = $user['username'];

                    // redirect the user to the home page
                    header('Location: home.php');
                    exit;
                } else {
                    // show an error message if the user account is inactive
                    $error_msg = 'Your account is inactive. Please contact the administrator.';
                }
            } else {
                // show an error message if the username/email or password is incorrect
                $error_msg = 'Invalid username/email or password.';
            }
        } else {
            // show an error message if the username/email or password is empty
            if (empty($username_email)) {
                $error_msg = 'Please enter your username/email.';
            } else {
                $error_msg = 'Please enter your password.';
            }
        }
    }
    ?>


    <div id="login">
        <h3 class="text-center text-white pt-5">Login form</h3>
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                        <form id="login-form" class="form" action="" method="post">
                            <h3 class="text-center text-info">Login</h3>
                            <div class="form-group">
                                <label for="username or email" class="text-info">Username / Email:</label><br>
                                <input type="text" name="username" id="username" class="form-control">
                                <?php if (isset($error_msg)) { ?><span class="text-danger"><?php echo $error_msg; ?></span><?php } ?>
                            </div>
                            <div class="form-group">
                                <label for="password" class="text-info">Password:</label><br>
                                <input type="password" name="password" id="password" class="form-control">
                                <?php if (isset($error_msg)) { ?><span class="text-danger"><?php echo $error_msg; ?></span><?php } ?>
                            </div>
                            <div class="form-group">
                                <label for="remember-me" class="text-info"><span>Remember me</span> <span><input id="remember-me" name="remember-me" type="checkbox"></span></label><br>
                                <input type="submit" name="login" class="btn btn-info btn-md" value="login">
                            </div>
                            <div id="register-link" class="text-right">
                                <a href="#" class="text-info">Register here</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>