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
            <h1>Update Product</h1>
        </div>
        <?php
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
        // get passed parameter value, in this case, the record ID
        // isset() is a PHP function used to verify if a value is there or not
        $id = isset($_GET['product_id']) ? $_GET['product_id'] : die('ERROR: Record ID not found.');


        //include database connection
        include 'config/database.php';

        // read current record's data
        try {
            // prepare select query
            $query = "SELECT product_id, name, description, price, promotion_price,category_name, manufacture_date, expiry_date FROM products WHERE product_id = ?";
            $stmt = $con->prepare($query);

            // this is the first question mark
            $stmt->bindParam(1, $id);

            // execute our query
            $stmt->execute();

            // store retrieved row to a variable
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // values to fill up our form
            $name = $row['name'];
            $description = $row['description'];
            $price = $row['price'];
            $promotion_price = $row['promotion_price'];
            $manufacture_date = $row['manufacture_date'];
            $expiry_date = $row['expiry_date'];
            $category_name = $row['category_name'];
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
                // include database connection
                include 'config/database.php';

                // get the record ID
                $id = isset($_GET['product_id']) ? $_GET['product_id'] : die('ERROR: Record ID not found.');

                // get the posted values
                $name = htmlspecialchars(strip_tags($_POST['name']));
                $description = htmlspecialchars(strip_tags($_POST['description']));
                $price = htmlspecialchars(strip_tags($_POST['price']));
                $category_name = isset($_POST['category_name']) ? $_POST['category_name'] : null;
                $promotion_price = htmlspecialchars(strip_tags($_POST['promotion_price']));
                $manufacture_date = htmlspecialchars(strip_tags($_POST['manufacture_date']));
                $expiry_date = htmlspecialchars(strip_tags($_POST['expiry_date']));

                // check if manufacture date and expiry date are empty
                if (empty($manufacture_date) && empty($expiry_date)) {
                    // update query without manufacture date and expiry date
                    $query = "UPDATE products
        SET name=:name, description=:description, price=:price, promotion_price=:promotion_price, category_name=:category_name
        WHERE product_id=:product_id";
                } else {
                    // update query with manufacture date and/or expiry date
                    $query = "UPDATE products
        SET name=:name, description=:description, price=:price, promotion_price=:promotion_price, category_name=:category_name";

                    if (!empty($manufacture_date)) {
                        $query .= ", manufacture_date=:manufacture_date";
                    }
                    if (!empty($expiry_date)) {
                        $query .= ", expiry_date=:expiry_date";
                    }

                    $query .= " WHERE product_id=:product_id";
                }

                // prepare query for execution
                $stmt = $con->prepare($query);

                // bind the parameters
                $stmt->bindParam(':product_id', $id);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':description', $description);
                $stmt->bindParam(':price', $price);
                $stmt->bindParam(':category_name', $category_name);
                $stmt->bindParam(':promotion_price', $promotion_price);

                if (!empty($manufacture_date)) {
                    $stmt->bindParam(':manufacture_date', $manufacture_date);
                }
                if (!empty($expiry_date)) {
                    $stmt->bindParam(':expiry_date', $expiry_date);
                }

                // execute the query
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
        }
        ?>



        <!--we have our html form here where new record information can be updated-->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?product_id={$id}"); ?>" method="post">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Name</td>
                    <td><input type='text' name='name' value="<?php echo htmlspecialchars($name, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><textarea name='description' class='form-control'><?php echo htmlspecialchars($description, ENT_QUOTES);  ?></textarea></td>
                </tr>
                <tr>
                    <td>Category</td>
                    <td>
                        <?php
                        // include database connection
                        include 'config/database.php';

                        // select all categories
                        $query = "SELECT category_name FROM product_category";
                        $stmt = $con->prepare($query);
                        $stmt->execute();

                        // fetch the category list
                        $product_category = $stmt->fetchAll(PDO::FETCH_COLUMN);
                        ?>
                        <select name='category_name' class="form-control">
                            <option value=''>--Select Category--</option>
                            <?php foreach ($product_category as $category) { ?>
                                <option value="<?php echo $category; ?>"><?php echo $category; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>


                <tr>
                    <td>Price</td>
                    <td><input type='number' name='price' class='form-control' value="<?php echo isset($price) ? htmlspecialchars($price) : ''; ?>" />
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
                </tr>
                <tr>
                    <td>Expiry date</td>
                    <td><input type='date' name='expiry_date' class='form-control' value="<?php echo isset($expiry_date) ? htmlspecialchars($expiry_date) : ''; ?>" />
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save Changes' class='btn btn-primary' />
                        <a href='product_read.php' class='btn btn-danger'>Back to read products</a>
                    </td>
                </tr>
            </table>
        </form>

    </div>
</body>

</html>