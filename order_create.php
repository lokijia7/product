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
            <h1>Create Order</h1>
        </div>

        <!-- html form to create product will be here -->

        <?php
        ini_set('display_errors', 1);
        error_reporting(E_ALL);

        if ($_POST) {

            // include database connection
            include 'config/database.php';
            try {
                // posted values
                if (isset($_POST['username'])) $username = $_POST['username'];
                if (isset($_POST['name'])) $name = $_POST['name'];


                $flag = false;



                // Check if any field is empty
                if (empty($username)) {
                    $name_err = "Please fill out the Name field.";
                    $flag = true;
                }
                // Check if any field is empty
                if (empty($name)) {
                    $product_name_err = "Please fill out the Product field.";
                    $flag = true;
                }





                if ($flag == false) {

                    // insert query
                    $query = "INSERT INTO orders SET username=:username,created=:created";
                    // prepare query for execution
                    $stmt = $con->prepare($query);
                    // bind the parameters
                    $stmt->bindParam(':username', $username);

                    // specify when this record was inserted to the database
                    $created = date('Y-m-d H:i:s');
                    $stmt->bindParam(':created', $created);
                    // Execute the query
                    if ($stmt->execute()) {
                        echo "<div class='alert alert-success'>Record was saved.</div>";
                        // Clear form fields
                        $username = "";
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
                    <td>Customer</td>
                    <td>
                        <?php
                        // include database connection
                        include 'config/database.php';

                        // select all categories
                        $query = "SELECT username FROM customers";
                        $stmt = $con->prepare($query);
                        $stmt->execute();

                        // fetch the category list
                        $customers = $stmt->fetchAll(PDO::FETCH_COLUMN);
                        ?>
                        <select name='username' class="form-control">
                            <option value=''>--Select customer--</option>
                            <?php foreach ($customers as $customers) { ?>
                                <option value="<?php echo $customers; ?>"><?php echo $customers; ?></option>
                            <?php } ?>
                        </select>
                        <?php if (isset($name_err)) { ?><span class="text-danger"><?php echo $name_err; ?></span><?php } ?>
                    </td>
                </tr>
                <tr>
                    <td>Product 1</td>
                    <td>
                        <?php
                        // include database connection
                        include 'config/database.php';

                        // select all categories
                        $query = "SELECT name FROM products";
                        $stmt = $con->prepare($query);
                        $stmt->execute();

                        // fetch the category list
                        $products = $stmt->fetchAll(PDO::FETCH_COLUMN);
                        ?>
                        <select name='name' class="form-control">
                            <option value=''>--Select product--</option>
                            <?php foreach ($products as $products) { ?>
                                <option value="<?php echo $products; ?>"><?php echo $products; ?></option>
                            <?php } ?>
                        </select>
                        <?php if (isset($product_name_err)) { ?><span class="text-danger"><?php echo $product_name_err; ?></span><?php } ?>
                        <input type="number" name="quantity" class="form-control" placeholder="Enter quantity" min="1" required>
                    </td>
                </tr>

                <tr>
                    <td>Product 2</td>
                    <td>
                        <?php
                        // include database connection
                        include 'config/database.php';

                        // select all categories
                        $query = "SELECT name FROM products";
                        $stmt = $con->prepare($query);
                        $stmt->execute();

                        // fetch the category list
                        $products = $stmt->fetchAll(PDO::FETCH_COLUMN);
                        ?>
                        <select name='name' class="form-control">
                            <option value=''>--Select product--</option>
                            <?php foreach ($products as $products) { ?>
                                <option value="<?php echo $products; ?>"><?php echo $products; ?></option>
                            <?php } ?>
                        </select>
                        <?php if (isset($product_name_err)) { ?><span class="text-danger"><?php echo $product_name_err; ?></span><?php } ?>
                        <input type="number" name="quantity" class="form-control" placeholder="Enter quantity" min="1" required>
                    </td>
                </tr>

                <tr>
                    <td>Product 3</td>
                    <td>
                        <?php
                        // include database connection
                        include 'config/database.php';

                        // select all products
                        $query = "SELECT name FROM products";
                        $stmt = $con->prepare($query);
                        $stmt->execute();

                        // fetch the product list
                        $products = $stmt->fetchAll(PDO::FETCH_COLUMN);
                        ?>
                        <select name='name' class="form-control">
                            <option value=''>--Select product--</option>
                            <?php foreach ($products as $product) { ?>
                                <option value="<?php echo $product; ?>"><?php echo $product; ?></option>
                            <?php } ?>
                        </select>
                        <?php if (isset($product_name_err)) { ?><span class="text-danger"><?php echo $product_name_err; ?></span><?php } ?>
                        <input type="number" name="quantity" class="form-control" placeholder="Enter quantity" min="1" required>
                    </td>
                </tr>




                <td></td>
                <td>
                    <input type='submit' value='Save' class='btn btn-primary' />
                    <a href='product_read.php' class='btn btn-danger'>Back to read products</a>
                </td>
                </tr>
            </table>
        </form>


    </div>
    <!-- end .container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>