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
                    <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="product_read.php">Products List</a></li>
                    <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="customer_create.php">Create Customer</a></li>
                    <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="customer_read.php">Customers List</a></li>
                    <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="contact.html">Contact Us</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- container -->
    <div class="container">
        <div class="page-header">
            <h1>Create Product</h1>
        </div>

        <!-- html form to create product will be here -->

        <?php

        if ($_POST) {

            // include database connection
            include 'config/database.php';
            try {
                // posted values
                $name = htmlspecialchars(strip_tags($_POST['name']));
                $description = htmlspecialchars(strip_tags($_POST['description']));
                $price = htmlspecialchars(strip_tags($_POST['price']));
                $promotion_price = htmlspecialchars(strip_tags($_POST['promotion_price']));
                $manufacture_date = htmlspecialchars(strip_tags($_POST['manufacture_date']));
                $expiry_date = htmlspecialchars(strip_tags($_POST['expiry_date']));

                $name = trim($_POST['name']);

                $flag = false;



                // Check if any field is empty
                if (empty($name)) {
                    $name_err = "Please fill out the Name field.";
                    $flag = true;
                } elseif (strlen(trim($name)) == 0) {
                    $name_err = "Please enter a valid Name.";
                    $flag = true;
                }

                if (empty($price)) {
                    $price_err = "Please fill out the Price field.";
                    $flag = true;
                }
                if (empty($manufacture_date)) {
                    $manu_err = "Please fill out the Manufacture Date field.</div>";
                    $flag = true;
                }

                // check if promotion price is less than original price
                if (!empty($promotion_price)) {
                    if ($promotion_price >= $price) {
                        $promo_err = "Promotion price must be cheaper than original price.";
                        $flag = true;
                    }
                }
                // check if expiry date is later than manufacture date
                if (!empty($expiry_date)) {
                    if ($expiry_date <= $manufacture_date) {
                        $exp_err = "Expiry date must be later than manufacture date.";
                        $flag = true;
                    }
                }
                // Set default values for non-required fields
                if (empty($promotion_price)) {
                    $promotion_price = 0;
                    $flag = false;
                }
                if (empty($expiry_date)) {
                    $expiry_date  = null;
                    $flag = false;
                }




                if ($flag == false) {

                    // insert query
                    $query = "INSERT INTO products SET name=:name, description=:description, price=:price, promotion_price=:promotion_price, manufacture_date=:manufacture_date,expiry_date=:expiry_date,created=:created";
                    // prepare query for execution
                    $stmt = $con->prepare($query);
                    // bind the parameters
                    $stmt->bindParam(':name', $name);
                    $stmt->bindParam(':description', $description);
                    $stmt->bindParam(':price', $price);
                    $stmt->bindParam(':promotion_price', $promotion_price);
                    $stmt->bindParam(':manufacture_date', $manufacture_date);
                    $stmt->bindParam(':expiry_date', $expiry_date);
                    // specify when this record was inserted to the database
                    $created = date('Y-m-d H:i:s');
                    $stmt->bindParam(':created', $created);
                    // Execute the query
                    if ($stmt->execute()) {
                        echo "<div class='alert alert-success'>Record was saved.</div>";
                        // Clear form fields
                        $name = "";
                        $description = "";
                        $price = "";
                        $promotion_price = "";
                        $manufacture_date = "";
                        $expiry_date = "";
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
                    <td>Name</td>
                    <td><input type='text' name='name' class="form-control" required value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>" />
                        <?php if (isset($name_err)) { ?><span class="text-danger"><?php echo $name_err; ?></span><?php } ?></td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><textarea name='description' class="form-control" value="<?php echo isset($description) ? htmlspecialchars($description) : ''; ?>"></textarea>
                        <?php if (isset($description_err)) { ?><span class="text-danger"><?php echo $description_err; ?></span><?php } ?></td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td><input type='number' name='price' class='form-control' value="<?php echo isset($price) ? htmlspecialchars($price) : ''; ?>" />
                        <?php if (isset($price_err)) { ?><span class="text-danger"><?php echo $price_err; ?></span><?php } ?></td>
                </tr>
                <tr>
                <tr>
                    <td>Promotion price</td>
                    <td><input type='number' name='promotion_price' class='form-control' value="<?php echo isset($promotion_price) ? htmlspecialchars($promotion_price) : ''; ?>" /><?php if (isset($pro_err)) { ?><span class="text-danger"><?php echo $pro_err; ?></span><?php } ?></td>
                </tr>
                <tr>
                <tr>
                    <td>Manufacture date</td>
                    <td><input type='date' name='manufacture_date' class='form-control' value="<?php echo isset($manufacture_date) ? htmlspecialchars($manufacture_date) : ''; ?>" />
                        <?php if (isset($manu_err)) { ?><span class="text-danger"><?php echo $manu_err; ?></span><?php } ?></td>
                </tr>
                <tr>
                    <td>Expiry date</td>
                    <td><input type='date' name='expiry_date' class='form-control' value="<?php echo isset($expiry_date) ? htmlspecialchars($expiry_date) : ''; ?>" />
                        <?php if (isset($exp_err)) { ?><span class="text-danger"><?php echo $manu_err; ?></span><?php } ?></td>
                </tr>


                <td></td>
                <td>
                    <input type='submit' value='Save' class='btn btn-primary' />
                    <a href='index.php' class='btn btn-danger'>Back to read products</a>
                </td>
                </tr>
            </table>
        </form>


    </div>
    <!-- end .container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>