<!DOCTYPE HTML>
<?php
session_start();
if (!isset($_SESSION["username"])) {
    // Set the warning message
    $_SESSION["warning"] = "You need to log in to access this page.";

    // Redirect the user to the login page
    header("Location: login.php");
    exit();
}
?>
<html>

<head>
    <title>PDO - Read Records - PHP CRUD Tutorial</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

</head>

<body>
    <?php include 'nav.php' ?>
    <div class="container">
        <div class="page-header">
            <h1>Update Customer</h1>
        </div>
        <?php
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
        // get passed parameter value, in this case, the record ID
        // isset() is a PHP function used to verify if a value is there or not
        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');


        //include database connection
        include 'config/database.php';

        // read current record's data
        try {
            // prepare select query
            $query = "SELECT id, username, pass, first_name, last_name, gender, date_of_birth, account_status FROM customers WHERE id = ?";
            $stmt = $con->prepare($query);

            // this is the first question mark
            $stmt->bindParam(1, $id);

            // execute our query
            $stmt->execute();

            // store retrieved row to a variable
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // values to fill up our form
            $username = $row['username'];
            $pass = $row['pass'];
            $first_name = $row['first_name'];
            $last_name = $row['last_name'];
            $gender = $row['gender'];
            $date_of_birth = $row['date_of_birth'];
            $account_status = $row['account_status'];
        }

        // show error
        catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }
        ?>

        <?php
        ini_set('display_errors', 1);
        error_reporting(E_ALL);


        // check if form was submitted
        if ($_POST) {
            try {
                // write update query
                // in this case, it seemed like we have so many fields to pass and
                // it is better to label them and not use question marks
                $query = "UPDATE customers
                SET pass=:new_pass,
                first_name=:first_name, last_name=:last_name, gender=:gender,
                date_of_birth=:date_of_birth, account_status=:account_status
                WHERE id = :id";

                // prepare query for execution
                $stmt = $con->prepare($query);

                // posted values
                $current_pass = $_POST['current_pass'];
                $new_pass = $_POST['new_pass'];
                $confirm_new_pass = $_POST['confirm_new_pass'];
                $first_name = htmlspecialchars(strip_tags($_POST['first_name']));
                $last_name = htmlspecialchars(strip_tags($_POST['last_name']));
                if (isset($_POST['gender'])) $gender = $_POST['gender'];
                $date_of_birth = htmlspecialchars(strip_tags($_POST['date_of_birth']));
                if (isset($_POST['account_status'])) $account_status = $_POST['account_status'];

                $flag = false;

                // validate current password if it is not empty
                if (!empty($current_pass) && md5($current_pass) !== $row['pass']) {
                    $curpass_err = "Current password is not correct.";
                    $flag = true;
                }

                // validate new password if it is not empty
                if (!empty($new_pass)) {
                    $uppercase = preg_match('@[A-Z]@', $new_pass);
                    $lowercase = preg_match('@[a-z]@', $new_pass);
                    $number = preg_match('@[0-9]@', $new_pass);
                    if (strlen($new_pass) < 8) {
                        $pass_err = "Password must be at least 8 characters long.";
                        $flag = true;
                    } else if (!$uppercase || !$lowercase || !$number) {
                        // Password does not meet the requirements
                        $pass_err = "Password must contain numbers, uppercase and lowercase alphabets.";
                        $flag = true;
                    } else if (empty($confirm_new_pass)) {
                        $confpass_err = "Please fill out the confirmed password field.";
                        $flag = true;
                    } else if ($new_pass === $current_pass) {
                        $newpass_err = "New password must be different from current password.";
                        $flag = true;
                    }
                }


                // validate new password and confirm new password if current password is filled
                if (!empty($current_pass)) {
                    if (empty($new_pass)) {
                        $newpass_err = "Please fill out the new password field.";
                        $flag = true;
                    } else if (empty($confirm_new_pass)) {
                        $confpass_err = "Please fill out the confirmed password field.";
                        $flag = true;
                    } else if ($new_pass !== $confirm_new_pass) {
                        $confpass_err = "New password and confirmed password do not match.";
                        $flag = true;
                    }
                }

                // validate first name and last name are not empty
                if (empty($first_name) && empty($last_name)) {
                    $first_name_err = "First name cannot be empty.";
                    $last_name_err = "Last name cannot be empty.";
                    $flag = true;
                } else if (empty($first_name)) {
                    $first_name_err = "First name cannot be empty.";
                    $flag = true;
                } else if (empty($last_name)) {
                    $last_name_err = "Last name cannot be empty.";
                    $flag = true;
                }



                // bind the parameters
                $stmt->bindParam(':id', $id);
                // check if new password was entered
                if (!empty($new_pass)) {
                    $new_pass_hash = md5($new_pass);
                    $stmt->bindParam(':new_pass', $new_pass_hash);
                } else {
                    // do not update password field
                    $stmt->bindParam(':new_pass', $row['pass']);
                }

                $stmt->bindParam(':first_name', $first_name);
                $stmt->bindParam(':last_name', $last_name);
                $stmt->bindParam(':gender', $gender);
                $stmt->bindParam(':date_of_birth', $date_of_birth);
                $stmt->bindParam(':account_status', $account_status);

                // Execute the query
                if (!$flag && $stmt->execute()) {

                    echo "<div class='alert alert-success'>Record was updated.</div>";
                    $current_pass = "";
                    $new_pass = "";
                } else {
                    echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
                }
            }
            // show errors
            catch (PDOException $exception) {

                die('ERROR: ' . $exception->getMessage());
            }
        } ?>


        <!--we have our html form here where new record information can be updated-->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}"); ?>" method="post">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>First Name</td>
                    <td>
                        <input type='text' name='first_name' value="<?php echo isset($first_name) ? htmlspecialchars($first_name) : ''; ?>" class='form-control' />
                        <?php if (isset($first_name_err)) { ?><span class="text-danger">
                                <br><?php echo $first_name_err; ?></span><?php } ?>

                    </td>
                </tr>

                <tr>
                    <td>Last Name</td>
                    <td><input type='varchar' name='last_name' value="<?php echo isset($last_name) ? htmlspecialchars($last_name) : ''; ?>" class='form-control' />
                        <?php if (isset($last_name_err)) { ?><span class="text-danger">
                                <br><?php echo $last_name_err; ?></span><?php } ?>
                </tr>
                <tr>
                    <td>Current Password</td>
                    <td>
                        <input type='password' name='current_pass' value="<?php echo isset($current_pass) ? htmlspecialchars($current_pass) : ''; ?>" class='form-control' />
                        <?php if (isset($curpass_err)) { ?><span class="text-danger">
                                <br><?php echo $curpass_err; ?></span><?php } ?>
                    </td>
                </tr>
                <tr>
                    <td>New Password</td>
                    <td>
                        <input type='password' name='new_pass' value="<?php echo isset($new_pass) ? htmlspecialchars($new_pass) : ''; ?>" class='form-control' />
                        <small>**Password must be at least 8 characters long, contain at least one uppercase letter, one lowercase letter, and one number.</small>
                        <?php if (isset($newpass_err)) { ?><span class="text-danger">
                                <br><?php echo $newpass_err; ?></span><?php } ?>
                    </td>
                </tr>

                <tr>
                    <td>Confirm New Password</td>
                    <td>
                        <label for='confirm_new_pass'>Retype Password</label>
                        <input type='password' name='confirm_new_pass' value='' class='form-control' />
                        <?php if (isset($confpass_err)) { ?><span class="text-danger"><br><?php echo $confpass_err; ?></span><?php } ?>
                    </td>
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
                    <td><input type='date' name='date_of_birth' class='form-control' value="<?php echo isset($date_of_birth) ? htmlspecialchars($date_of_birth) : ''; ?>" />
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
                    <a href='customer_read.php' class='btn btn-danger'>Back to read customers</a>
                </td>
            </table>
        </form>

    </div>
</body>

</html>