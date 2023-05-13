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
            <h1>Create Category</h1>
        </div>

        <!-- html form to create product will be here -->

        <?php

        if ($_POST) {

            // include database connection
            include 'config/database.php';

            // posted values
            $category_name = htmlspecialchars(strip_tags($_POST['category_name']));
            $category_description = htmlspecialchars(strip_tags($_POST['category_description']));


            $flag = false;



            // Check if any field is empty
            if (empty($category_name)) {
                $cname_err = "Please fill out the category name field.";
                $flag = true;
            }
            if (empty($category_description)) {
                $description_err = "Please fill out the category name field.";
                $flag = true;
            }

            if ($flag == false) {

                // insert query
                $query = "INSERT INTO product_category SET category_name=:category_name, category_description=:category_description,created=:created";
                // prepare query for execution
                $stmt = $con->prepare($query);
                // bind the parameters
                $stmt->bindParam(':category_name', $category_name);
                $stmt->bindParam(':category_description', $category_description);

                // specify when this record was inserted to the database
                $created = date('Y-m-d H:i:s');
                $stmt->bindParam(':created', $created);
                // Execute the query
                if ($stmt->execute()) {
                    echo "<div class='alert alert-success'>Record was saved.</div>";
                    // Clear form fields
                    $category_name = "";
                    $category_description = "";
                } else {
                    echo "<div class='alert alert-danger'>Unable to save record.</div>";
                }
            }
        }







        ?>



        <!-- html form here where the product information will be entered -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Category Name</td>
                    <td><input type='text' name='category_name' class="form-control" value="<?php echo isset($category_name) ? htmlspecialchars($category_name) : ''; ?>" />
                        <?php if (isset($cname_err)) { ?><span class="text-danger"><?php echo $cname_err; ?></span><?php } ?></td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><textarea name='category_description' class="form-control" value="<?php echo isset($category_description) ? htmlspecialchars($category_description) : ''; ?>"></textarea>
                        <?php if (isset($description_err)) { ?><span class="text-danger"><?php echo $description_err; ?></span><?php } ?></td>
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



</div> <!-- end .container -->

</body>

</html>