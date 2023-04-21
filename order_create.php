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
                if (isset($_POST['product1_name'])) {
                    $product1 = $_POST['product1_name'];
                }
                if (isset($_POST['product2_name'])) {
                    $product2 = $_POST['product2_name'];
                }
                if (isset($_POST['product3_name'])) {
                    $product3 = $_POST['product3_name'];
                }
                if (isset($_POST['product1_quantity'])) {
                    $quantity1 = $_POST['product1_quantity'];
                }
                if (isset($_POST['product2_quantity'])) {
                    $quantity2 = $_POST['product2_quantity'];
                }
                if (isset($_POST['product3_quantity'])) {
                    $quantity3 = $_POST['product3_quantity'];
                }
                $flag = false;



                // Check if any product field is empty
                if (empty($username)) {
                    $username_err = "Please fill out the name field.";
                    $flag = true;
                }
                if (empty($product1)) {
                    $product1_name_err = "Please fill out the Product field.";
                    $flag = true;
                }
                if (empty($product2)) {
                    $product2_name_err = "Please fill out the Product field.";
                    $flag = true;
                }
                if (empty($product3)) {
                    $product3_name_err = "Please fill out the Product field.";
                    $flag = true;
                }

                // Check if any quantity field is empty
                if (empty($quantity1)) {
                    $product1_quantity_err = "Please fill out the Quantity field.";
                    $flag = true;
                }
                if (empty($quantity2)) {
                    $product2_quantity_err = "Please fill out the Quantity field.";
                    $flag = true;
                }
                if (empty($quantity3)) {
                    $product3_quantity_err = "Please fill out the Quantity field.";
                    $flag = true;
                }





                if ($flag == false) {

                    // insert query
                    $order_query = "INSERT INTO orders SET username=:username,created=:created";
                    // prepare query for execution
                    $order_stmt = $con->prepare($order_query);
                    // bind the parameters
                    $order_stmt->bindParam(':username', $username);
                    // specify when this record was inserted to the database
                    $created = date('Y-m-d H:i:s');
                    $order_stmt->bindParam(':created', $created);
                    // Execute the query
                    if ($order_stmt->execute()) {
                        $lastInsertId = $con->lastInsertId(); // get the last inserted order ID
                        // Clear form fields
                        $username = "";

                        // Insert into order_details table
                        $product_name1 = $_POST['product1_name'];
                        $product_name2 = $_POST['product2_name'];
                        $product_name3 = $_POST['product3_name'];
                        $quantity1 = $_POST['product1_quantity'];
                        $quantity2 = $_POST['product2_quantity'];
                        $quantity3 = $_POST['product3_quantity'];
                        $created = date('Y-m-d H:i:s');

                        // Get the product ID from the products table for each product separately
                        $product1_query = "SELECT product_id FROM products WHERE name = :name1";
                        $product1_stmt = $con->prepare($product1_query);
                        $product1_stmt->bindParam(':name1', $product_name1);
                        $product1_stmt->execute();
                        $product1_id = $product1_stmt->fetch(PDO::FETCH_ASSOC)['product_id'];

                        $product2_query = "SELECT product_id FROM products WHERE name = :name2";
                        $product2_stmt = $con->prepare($product2_query);
                        $product2_stmt->bindParam(':name2', $product_name2);
                        $product2_stmt->execute();
                        $product2_id = $product2_stmt->fetch(PDO::FETCH_ASSOC)['product_id'];

                        $product3_query = "SELECT product_id FROM products WHERE name = :name3";
                        $product3_stmt = $con->prepare($product3_query);
                        $product3_stmt->bindParam(':name3', $product_name3);
                        $product3_stmt->execute();
                        $product3_id = $product3_stmt->fetch(PDO::FETCH_ASSOC)['product_id'];

                        // insert into order_details table
                        $success = true;
                        $od_query = "INSERT INTO order_detail (order_id, product_id, quantity, created) VALUES (?, ?, ?, ?)";
                        // prepare query for execution
                        $od_stmt = $con->prepare($od_query);

                        // insert order details for product 1
                        if (!empty($product_name1)) {
                            $detail_id1 = uniqid(); // generate a unique detail ID
                            $od_stmt->bindParam(1, $lastInsertId);
                            $od_stmt->bindParam(2, $product1_id);
                            $od_stmt->bindParam(3, $quantity1);
                            $od_stmt->bindParam(4, $created);
                            if (!$od_stmt->execute()) {
                                $success = false;
                            }
                        }

                        // insert order details for product 2
                        if (!empty($product_name2)) {
                            $detail_id2 = uniqid(); // generate a unique detail ID
                            $od_stmt->bindParam(1, $lastInsertId);
                            $od_stmt->bindParam(2, $product2_id);
                            $od_stmt->bindParam(3, $quantity2);
                            $od_stmt->bindParam(4, $created);
                            if (!$od_stmt->execute()) {
                                $success = false;
                            }
                        }

                        // insert order details for product 3
                        if (!empty($product_name3)) {
                            $detail_id3 = uniqid(); // generate a unique detail ID
                            $od_stmt->bindParam(1, $lastInsertId);
                            $od_stmt->bindParam(2, $product3_id);
                            $od_stmt->bindParam(3, $quantity3);
                            $od_stmt->bindParam(4, $created);
                            if (!$od_stmt->execute()) {
                                $success = false;
                            }
                        }

                        if ($success) {
                            echo "<div class='alert alert-success'>Record was saved.</div>";
                        } else {
                            echo "<div class='alert alert-danger'>Unable to save record.</div>";
                        }
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

                        // select all customers
                        $query = "SELECT username FROM customers";
                        $stmt = $con->prepare($query);
                        $stmt->execute();

                        // fetch the customer list
                        $customers = $stmt->fetchAll(PDO::FETCH_COLUMN);
                        ?>
                        <select name='username' class="form-control">
                            <option value=''>--Select customer--</option>
                            <?php foreach ($customers as $customer) : ?>
                                <option value='<?php echo $customer; ?>'><?php echo $customer; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (isset($username_err)) { ?><span class="text-danger"><?php echo $username_err; ?></span><?php } ?>
                    </td>
                </tr>
                <tr>
                    <td>Product 1</td>
                    <td>
                        <?php
                        // select all products
                        $query = "SELECT name FROM products";
                        $stmt = $con->prepare($query);
                        $stmt->execute();

                        // fetch the product list
                        $products = $stmt->fetchAll(PDO::FETCH_COLUMN);
                        ?>
                        <select name='product1_name' class="form-control">
                            <option value=''>--Select product--</option>
                            <?php foreach ($products as $product_name1) : ?>
                                <option value='<?php echo $product_name1; ?>'><?php echo $product_name1; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (isset($product1_name_err)) { ?><span class="text-danger"><?php echo $product1_name_err; ?></span><?php } ?>
                    </td>
                    <td>
                        <input type='number' name='product1_quantity' class='form-control'>
                    </td>
                </tr>
                <tr>
                    <td>Product 2</td>
                    <td>
                        <select name='product2_name' class="form-control">
                            <option value=''>--Select product--</option>
                            <?php foreach ($products as $product_name2) : ?>
                                <option value='<?php echo $product_name2; ?>'><?php echo $product_name2; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (isset($product2_name_err)) { ?><span class="text-danger"><?php echo $product2_name_err; ?></span><?php } ?>
                    </td>
                    <td>
                        <input type='number' name='product2_quantity' class='form-control'>
                    </td>
                </tr>
                <tr>
                    <td>Product 3</td>
                    <td>
                        <?php
                        // select all products
                        $query = "SELECT name FROM products";
                        $stmt = $con->prepare($query);
                        $stmt->execute();

                        // fetch the product list
                        $products = $stmt->fetchAll(PDO::FETCH_COLUMN);
                        ?>
                        <select name='product3_name' class="form-control">
                            <option value=''>--Select product--</option>
                            <?php foreach ($products as $product_name3) : ?>
                                <option value='<?php echo $product_name3; ?>'><?php echo $product_name3; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (isset($product3_name_err)) { ?><span class="text-danger"><?php echo $product3_name_err; ?></span><?php } ?>
                    </td>
                    <td>
                        <input type='number' name='product3_quantity' class='form-control'>
                    </td>
                </tr>
            </table>
            <input type='submit' value='Create Order' class='btn btn-primary'>
        </form>



    </div>
    <!-- end .container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>