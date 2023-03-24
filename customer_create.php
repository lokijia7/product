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
                $password = htmlspecialchars(strip_tags($_POST['password']));
                $confirm_password = htmlspecialchars(strip_tags($_POST['confirm_password']));
                $first_name = htmlspecialchars(strip_tags($_POST['first_name']));
                $last_name = htmlspecialchars(strip_tags($_POST['last_name']));
                $gender = $_POST['gender'];
                $date_of_birth = htmlspecialchars(strip_tags($_POST['date_of_birth']));
                $registration_datetime = htmlspecialchars(strip_tags($_POST['registration_datetime']));
                $account_status = $_POST['account_status'];
                $flag = false;

                // Check if any field is empty
                if (empty($username)) {
                    echo "<div class='alert alert-danger'>Please fill out the username field.</div>";
                    $flag = true;
                }
                if (empty($password)) {
                    echo "<div class='alert alert-danger'>Please fill out the password field.</div>";
                    $flag = true;
                }
                if (empty($confirm_password)) {
                    echo "<div class='alert alert-danger'>Please fill out the confirmed password field.</div>";
                    $flag = true;
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
                    $query = "INSERT INTO customers SET name=:username, password=:password, first_name=:first_name, last_name=:last_name,gender=:gender,date_of_birth=:date_of_birth,registration_datetime=:registration_datetime,account_status=:account_status,created=:created";
                    // prepare query for execution
                    $stmt = $con->prepare($query);
                    // bind the parameters
                    $stmt->bindParam(':username', $username);
                    $stmt->bindParam(':password', $password);
                    $stmt->bindParam(':first_name', $first_name);
                    $stmt->bindParam(':last_name', $last_name);
                    $stmt->bindParam(':gender', $gender);
                    $stmt->bindParam(':date_of_birth', $date_of_birth);
                    $stmt->bindParam(':registration_datetime', $created);
                    $stmt->bindParam(':account_status', $account_status);
                    // specify when this record was inserted to the database
                    $created = date('Y-m-d H:i:s');
                    $stmt->bindParam(':created', $created);
                    // Execute the query
                    if ($stmt->execute()) {
                        echo "<div class='alert alert-success'>Record was saved.</div>";
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
                    <td><input type='varchar' name='name' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type='password' name='password' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Confirm Password</td>
                    <td><input type='password' name='password' class='form-control' /></td>
                </tr>
                <tr>
                    <td>First Name</td>
                    <td><input type='varchar' name='firstname' class='form-control' /></td>
                </tr>
                <tr>
                <tr>
                    <td>Last Name</td>
                    <td><input type='varchar' name='lastname' class='form-control' /></td>
                </tr>
                <tr>
                <tr>
                    <td>Gender</td>
                    <td>
                        <div class='form-check form-check-inline'>
                            <input type='radio' name='gender' value='male' class='form-check-input' id='gender-male' required />
                            <label class='form-check-label' for='gender-male'>Male</label>
                        </div>
                        <div class='form-check form-check-inline'>
                            <input type='radio' name='gender' value='female' class='form-check-input' id='gender-female' required />
                            <label class='form-check-label' for='gender-female'>Female</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Date Of Birth</td>
                    <td><input type='date' name='birth_date' class='form-control' /></td>
                </tr>
                <tr>
                <tr>
                    <td>Account status</td>
                    <div class='form-check form-check-inline'>
                        <input type='radio' name='account_status' value='active' class='form-check-input' id='account_status-active' required />
                        <label class='form-check-label' for='account_status-active'>Active</label>
                    </div>
                    <div class='form-check form-check-inline'>
                        <input type='radio' name='account_status' value='inactive' class='form-check-input' id='account_status-inactive' required />
                        <label class='form-check-label' for='account_status-inactive'>Inactive</label>
                    </div>
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