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
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light" id="mainNav">
        <div class="container px-2 px-lg-3">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto py-4 py-lg-0">
                    <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="index.html">Home</a></li>
                    <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="product_create.php">Create Product</a></li>
                    <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="customer_create.php">Create Customer</a></li>
                    <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="contact.html">Contact Us</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- container -->
    <div class="container">
        <div class="page-header">
            <h1>Create Customer</h1>
        </div>

        <!-- html form to create customer will be here -->

        <?php


        if ($_POST) {
            // include database connection
            include 'config/database.php';
            try {
                // posted values
                $username = htmlspecialchars(strip_tags($_POST['username']));
                $pass = htmlspecialchars(strip_tags($_POST['pass']));
                $confirmed_password = htmlspecialchars(strip_tags($_POST['confirmed_password']));
                $first_name = htmlspecialchars(strip_tags($_POST['first_name']));
                $last_name = htmlspecialchars(strip_tags($_POST['last_name']));
                if (isset($_POST['gender'])) $gender = $_POST['gender'];
                $date_of_birth = htmlspecialchars(strip_tags($_POST['date_of_birth']));
                if (isset($_POST['account_status'])) $account_status = $_POST['account_status'];

                $flag = false;

                // Check if any field is empty
                if (empty($username)) {
                    echo "<div class='alert alert-danger'>Please fill out the username field.</div>";
                    $flag = true;
                } elseif (strlen($username) < 6) {
                    echo "<div class='alert alert-danger'>Username must be at least 6 characters long.</div>";
                    $flag = true;
                }
                if (empty($pass)) {
                    echo "<div class='alert alert-danger'>Please fill out the password field.</div>";
                    $flag = true;
                } elseif (strlen($pass) < 8) {
                    echo "<div class='alert alert-danger'>Password must be at least 8 characters long.</div>";
                    $flag = true;
                } elseif (!preg_match("#[0-9]+#", $pass) || !preg_match("#[a-zA-Z]+#", $pass)) {
                    echo "<div class='alert alert-danger'>Password must contain both numbers and alphabets.</div>";
                    $flag = true;
                }
                if (empty($confirmed_password)) {
                    echo "<div class='alert alert-danger'>Please fill out the confirmed password field.</div>";
                    $flag = true;
                }
                if ($flag == false) {
                    // Check if passwords match
                    if ($pass != $confirmed_password) {
                        echo "<div class='alert alert-danger'>Passwords do not match.</div>";
                        $flag = true;
                    }
                }

                if (empty($first_name)) {
                    echo "<div class='alert alert-danger'>Please fill out the first name field.</div>";
                    $flag = true;
                }
                if (empty($last_name)) {
                    echo "<div class='alert alert-danger'>Please fill out the last name field.</div>";
                    $flag = true;
                }
                if (empty($gender)) {
                    echo "<div class='alert alert-danger'>Please fill out the gender field.</div>";
                    $flag = true;
                }
                if (empty($date_of_birth)) {
                    echo "<div class='alert alert-danger'>Please fill out the Date of birth field.</div>";
                    $flag = true;
                }
                if (empty($account_status)) {
                    echo "<div class='alert alert-danger'>Please fill out the account status field.</div>";
                    $flag = true;
                }

                if ($flag == false) {
                    // insert query
                    $query = "INSERT INTO customers SET username=:username, pass=:pass, first_name=:first_name, last_name=:last_name, gender=:gender,date_of_birth=:date_of_birth, registration_datetime=:registration_datetime,account_status=:account_status;";
                    // prepare query for execution
                    $stmt = $con->prepare($query);
                    // bind the parameters
                    $stmt->bindParam(':username', $username);
                    $stmt->bindParam(':pass', $pass);
                    $stmt->bindParam(':first_name', $first_name);
                    $stmt->bindParam(':last_name', $last_name);
                    $stmt->bindParam(':gender', $gender);
                    $stmt->bindParam(':date_of_birth', $date_of_birth);
                    $stmt->bindParam(':account_status', $account_status);

                    // specify when this record was inserted to the database
                    $registration_datetime = date('Y-m-d H:i:s');
                    $stmt->bindParam(':registration_datetime', $registration_datetime);
                    if ($stmt->execute()) {
                        echo "<div class='alert alert-success'>Record was saved.</div>";
                        // Clear form fields
                        $username = "";
                        $pass = "";
                        $confirmed_password = "";
                        $first_name = "";
                        $last_name = "";
                        $gender = "";
                        $date_of_birth = "";
                        $account_status = "";
                    } else {
                        echo "<div class='alert alert-danger'>Unable to save record.</div>";
                    }
                }
            }
            // show error
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
        }


        ?>



        <!-- html form here where the product information will be entered -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Username</td>
                    <td><input type='varchar' name='username' value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>" class='form-control' /></td>
                </tr>
                <td>First Name</td>
                <td><input type='text' name='first_name' value="<?php echo isset($first_name) ? htmlspecialchars($first_name) : ''; ?>" class='form-control' /></td>
                </tr>

                <tr>
                    <td>Last Name</td>
                    <td><input type='varchar' name='last_name' value="<?php echo isset($last_name) ? htmlspecialchars($last_name) : ''; ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type='password' name='pass' value="<?php echo isset($pass) ? htmlspecialchars($pass) : ''; ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Confirm Password</td>
                    <td><input type='password' name='confirmed_password' value="<?php echo isset($confirmed_password) ? htmlspecialchars($confirmed_password) : ''; ?>" class='form-control' /></td>
                </tr>

                <tr>
                    <td>Gender</td>
                    <td>
                        <input type='radio' name='gender' <?php if (isset($gender) && $gender == "male") echo "checked"; ?> value='male'>Male
                        <input type='radio' name='gender' <?php if (isset($gender) && $gender == "female") echo "checked"; ?> value='female'>Female
                    </td>
                </tr>
                <tr>
                    <td>Date Of Birth</td>
                    <td><input type='date' name='date_of_birth' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Account Status</td>
                    <td>
                        <input type='radio' name='account_status' <?php if (isset($account_status) && $account_status == "active") echo "checked"; ?> value='active'>Active
                        <input type='radio' name='account_status' <?php if (isset($account_status) && $account_status == "inactive") echo "checked"; ?> value='inactive'>Inactive
                    </td>
                </tr>




                <td></td>
                <td>
                    <input type='submit' value='Save' class='btn btn-primary' />
                </td>
                </tr>
            </table>
        </form>


    </div>
    <!-- end .container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>