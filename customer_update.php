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
                  SET id=:id,username=:username, pass=:pass,
                  first_name=:first_name,last_name=:last_name,gender=:gender, date_of_birth=:date_of_birth, account_status=:account_status  WHERE id = :id";
                // prepare query for excecution
                $stmt = $con->prepare($query);

                // posted values
                $username = htmlspecialchars(strip_tags($_POST['username']));
                $pass = $_POST['pass'];
                $confirmed_password = $_POST['confirmed_password'];
                $first_name = htmlspecialchars(strip_tags($_POST['first_name']));
                $last_name = htmlspecialchars(strip_tags($_POST['last_name']));
                if (isset($_POST['gender'])) $gender = $_POST['gender'];
                $date_of_birth = htmlspecialchars(strip_tags($_POST['date_of_birth']));
                if (isset($_POST['account_status'])) $account_status = $_POST['account_status'];

                // bind the parameters
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':pass', $pass);
                $stmt->bindParam(':first_name', $first_name);
                $stmt->bindParam(':last_name', $last_name);
                $stmt->bindParam(':gender', $gender);
                $stmt->bindParam(':date_of_birth', $date_of_birth);
                $stmt->bindParam(':account_status', $account_status);


                // Execute the query
                if ($stmt->execute()) {
                    echo "<div class='alert alert-success'>Record was updated.</div>";
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
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?product_id={$id}"); ?>" method="post">
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
            </table>
        </form>

    </div>
</body>

</html>