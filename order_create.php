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
                $username = $_POST['username'];
                $product_names = $_POST['product_name'];
                $quantities = $_POST['quantity'];

                $flag = false;

                // Check if any field is empty
                if (empty($username)) {
                    $username_err = "Please fill out the name field.";
                    $flag = true;
                }

                // define $i here
                for ($i = 0; $i < count($product_names); $i++) {
                    $product_name = $product_names[$i];
                    if (empty($product_name)) {
                        $product_name_err = "Please fill out the Product field.";
                        $flag = true;
                    }
                    if (empty($quantities[$i])) {
                        $quantity_err = "Please fill out the Quantity field.";
                        $flag = true;
                    }
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

                        // Insert into order_details table
                        $success = true;
                        $od_query = "INSERT INTO order_detail (order_id, product_id, quantity) VALUES (?, ?, ?)";
                        // prepare query for execution
                        $od_stmt = $con->prepare($od_query);

                        foreach ($product_names as $i => $product_name) {
                            $quantity = $quantities[$i];

                            // Get the product ID from the products table
                            $product_query = "SELECT product_id FROM products WHERE name = :name";
                            $product_stmt = $con->prepare($product_query);
                            $product_stmt->bindParam(':name', $product_name);
                            $product_stmt->execute();
                            $product_id = $product_stmt->fetch(PDO::FETCH_ASSOC)['product_id'];

                            // insert into order_details table
                            $od_stmt->bindParam(1, $lastInsertId);
                            $od_stmt->bindParam(2, $product_id);
                            $od_stmt->bindParam(3, $quantity);


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

                        $products = $stmt->fetchAll(PDO::FETCH_COLUMN);
                        ?>
                        <select name='product_name[]' class="form-control">
                            <option value=''>--Select product--</option>
                            <?php foreach ($products as $product_names) : ?>
                                <option value='<?php echo $product_names; ?>'><?php echo $product_names; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (isset($product_name_err)) { ?><span class="text-danger"><?php echo $product_name_err; ?></span><?php } ?>
                    </td>
                    <td class='col-2'>Quantity</td>
                    <td>
                        <input type='number' name='quantity[]' class='form-control'>
                        <?php if (isset($quantity_err)) { ?><span class="text-danger"><?php echo $quantity_err; ?></span><?php } ?>
                    </td>
                </tr>
                <tr>
                    <td>Product 2</td>
                    <td>
                        <select name='product_name[]' class="form-control">
                            <option value=''>--Select product--</option>
                            <?php foreach ($products as $product_names) : ?>
                                <option value='<?php echo $product_names; ?>'><?php echo $product_names; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (isset($product_name_err)) { ?><span class="text-danger"><?php echo $product_name_err; ?></span><?php } ?>
                    </td>
                    <td class='col-2'>Quantity</td>
                    <td>
                        <input type='number' name='quantity[]' class='form-control'>
                        <?php if (isset($quantity_err)) { ?><span class="text-danger"><?php echo $quantity_err; ?></span><?php } ?>
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