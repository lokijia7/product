<!DOCTYPE HTML>

<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
}
?>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PDO - Create a Record - PHP CRUD Tutorial</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <!-- Latest compiled and minified Bootstrap CSS (Apply your Bootstrap here -->
</head>

<body>
    <?php include 'nav.php' ?>

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
                $pass = $_POST['pass'];
                $confirmed_password = $_POST['confirmed_password'];
                $first_name = htmlspecialchars(strip_tags($_POST['first_name']));
                $last_name = htmlspecialchars(strip_tags($_POST['last_name']));
                if (isset($_POST['gender'])) $gender = $_POST['gender'];
                $date_of_birth = htmlspecialchars(strip_tags($_POST['date_of_birth']));
                if (isset($_POST['account_status'])) $account_status = $_POST['account_status'];

                $uppercase = preg_match('/[A-Z]/', $pass);
                $lowercase = preg_match('/[a-z]/', $pass);
                $number = preg_match('/[0-9]/', $pass);
                $numuser = preg_match('/[0-9]/', $username);
                $username = trim($_POST['username']);

                $flag = false;

                // Check if any field is empty
                if (empty($username)) {
                    $username_err = "Please fill out the username field.";
                    $flag = true;
                } else if (strlen($username) < 6) {
                    $username_err = "Username must be at least 6 characters long";
                    $flag = true;
                } else if ($numuser) {
                    $username_err = "Username must not have number";
                    $flag = true;
                }

                if (empty($pass)) {
                    $pass_err = "Please fill out the password field.";
                    $flag = true;
                } else if (strlen($pass) < 8) {
                    $pass_err = "Password must be at least 8 characters long.";
                    $flag = true;
                } else if (!$uppercase || !$lowercase || !$number) {
                    // Password does not meet the requirements
                    $pass_err = "Password must be contain numbers, uppercase and lowercase alphabets.";
                    $flag = true;
                } else if (empty($confirmed_password)) {
                    $confpass_err = "Please fill out the confirmed password field.";
                    $flag = true;
                }

                // Check if passwords match
                if ($pass != $confirmed_password) {
                    $confpass_err = "Passwords do not match.";
                    $flag = true;
                } else {
                    $pass = md5($pass);
                }


                if (empty($first_name)) {
                    $fname_err = "Please fill out the first name field.";
                    $flag = true;
                }
                if (empty($last_name)) {
                    $lname_err = "Please fill out the last name field.";
                    $flag = true;
                }
                if (empty($gender)) {
                    $gender_err = "Please fill out the gender field.";
                    $flag = true;
                }
                if (empty($date_of_birth)) {
                    $dob_err = "Please fill out the Date of birth field.";
                    $flag = true;
                }
                if (empty($account_status)) {
                    $status_err = "Please fill out the account status field.";
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
                    <td>
                        <input type='name' name='username' value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>" class='form-control' required />
                        <small>**Username must be at least 6 characters long.</small>
                        <?php if (isset($username_err)) { ?><span class="text-danger">
                                <br><?php echo $username_err; ?></span><?php } ?>
                    </td>
                </tr>

                <tr>
                    <td>First Name</td>
                    <td>
                        <input type='text' name='first_name' value="<?php echo isset($first_name) ? htmlspecialchars($first_name) : ''; ?>" class='form-control' />
                        <?php if (isset($fname_err)) { ?><span class="text-danger"><?php echo $fname_err; ?></span><?php } ?>
                    </td>
                </tr>

                <tr>
                    <td>Last Name</td>
                    <td><input type='varchar' name='last_name' value="<?php echo isset($last_name) ? htmlspecialchars($last_name) : ''; ?>" class='form-control' /> <?php if (isset($lname_err)) { ?><span class="text-danger"><?php echo $lname_err; ?></span><?php } ?></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td>
                        <input type='password' name='pass' value="<?php echo isset($pass) ? htmlspecialchars($pass) : ''; ?>" class='form-control' required />
                        <small>**Password must be at least 8 character, contain numbers, uppercase and lowercase alphabets."</small>
                        <?php if (isset($pass_err)) { ?><span class="text-danger">
                                <br><?php echo $pass_err; ?></span><?php } ?>
                    </td>
                </tr>

                <tr>
                    <td>Confirm Password</td>
                    <td><input type='password' name='confirmed_password' value="<?php echo isset($confirmed_password) ? htmlspecialchars($confirmed_password) : ''; ?>" class='form-control' /><?php if (isset($confpass_err)) { ?><span class="text-danger"><?php echo $confpass_err; ?></span><?php } ?></td>
                </tr>

                <tr>
                    <td>Gender</td>
                    <td>
                        <input type='radio' name='gender' <?php if (isset($gender) && $gender == "male") echo "checked"; ?> value='male'>Male
                        <input type='radio' name='gender' <?php if (isset($gender) && $gender == "female") echo "checked"; ?> value='female'>Female
                        <?php if (isset($gender_err)) { ?><span class="text-danger"><?php echo $gender_err; ?></span><?php } ?>
                    </td>
                </tr>
                <tr>
                    <td>Date Of Birth</td>
                    <td><input type='date' name='date_of_birth' class='form-control' /><?php if (isset($dob_err)) { ?><span class="text-danger"><?php echo $dob_err; ?></span><?php } ?></td>
                </tr>
                <tr>
                    <td>Account Status</td>
                    <td>
                        <input type='radio' name='account_status' <?php if (isset($account_status) && $account_status == "active") echo "checked"; ?> value='active'>Active
                        <input type='radio' name='account_status' <?php if (isset($account_status) && $account_status == "inactive") echo "checked"; ?> value='inactive'>Inactive
                        <?php if (isset($status_err)) { ?><span class="text-danger"><?php echo $gender_err; ?></span><?php } ?>
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