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
                $flag = false;

                // Check if any field is empty
                if (empty($name)) {
                    echo "<div class='alert alert-danger'>Please fill out the Name field.</div>";
                    $flag = true;
                }
                if (empty($description)) {
                    echo "<div class='alert alert-danger'>Please fill out the Description field.</div>";
                    $flag = true;
                }
                if (empty($price)) {
                    echo "<div class='alert alert-danger'>Please fill out the Price field.</div>";
                    $flag = true;
                }
                if (empty($manufacture_date)) {
                    echo "<div class='alert alert-danger'>Please fill out the Manufacture Date field.</div>";
                    $flag = true;
                }

                // check if promotion price is less than original price
                if (!empty($promotion_price)) {
                    if ($promotion_price >= $price) {
                        echo "<div class='alert alert-danger'>Promotion price must be cheaper than original price.</div>";
                        $flag = true;
                    }
                }
                // check if expiry date is later than manufacture date
                if (!empty($expiry_date)) {
                    if ($expiry_date <= $manufacture_date) {
                        echo "<div class='alert alert-danger'>Expiry date must be later than manufacture date.</div>";
                        $flag = true;
                    }
                }
                if (empty($promotion_price)) {
                    $promotion_price = 0;
                }
                if (empty($expiry_date)) {
                    $expiry_date  = 0;
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
                    <td><input type='varchar' name='name' value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><textarea name='description' value="<?php echo isset($description) ? htmlspecialchars($description) : ''; ?>" class='form-control'></textarea></td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td><input type='number' name='price' value="<?php echo isset($price) ? htmlspecialchars($price) : ''; ?>" class='form-control' /></td>
                </tr>
                <tr>
                <tr>
                    <td>Promotion price</td>
                    <td><input type='number' name='promotion_price' value="<?php echo isset($promotion_price) ? htmlspecialchars($promotion_price) : ''; ?>" class='form-control' /></td>
                </tr>
                <tr>
                <tr>
                    <td>Manufacture date</td>
                    <td><input type='date' name='manufacture_date' value="<?php echo isset($manufacture_date) ? htmlspecialchars($manufacture_date) : ''; ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Expiry date</td>
                    <td><input type='date' name='expiry_date' value="<?php echo isset($expiry_date) ? htmlspecialchars($expiry_date) : ''; ?>" class='form-control' /></td>
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