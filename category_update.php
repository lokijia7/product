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
            <h1>Update Category</h1>
        </div>
        <?php
        ini_set('display_errors', 1);
        error_reporting(E_ALL);

        //include database connection
        include 'config/database.php';

        // get passed parameter value, in this case, the record ID
        // isset() is a PHP function used to verify if a value is there or not
        $id = isset($_GET['category_id']) ? $_GET['category_id'] : die('ERROR: Record ID not found.');

        // read current record's data
        try {
            // prepare select query
            $query = "SELECT category_id, category_name, category_description FROM product_category WHERE category_id = ?";
            $stmt = $con->prepare($query);

            // this is the first question mark
            $stmt->bindParam(1, $id);

            // execute our query
            $stmt->execute();

            // store retrieved row to a variable
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // values to fill up our form
            $category_name = $row['category_name'];
            $category_description = $row['category_description'];
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
                $query = "UPDATE product_category
                SET category_name=:category_name,
                category_description=:category_description
                WHERE category_id = :category_id";


                // prepare query for execution
                $stmt = $con->prepare($query);

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

                // bind the parameters
                $stmt->bindParam(':category_id', $id);
                $stmt->bindParam(':category_name', $category_name);
                $stmt->bindParam(':category_description', $category_description);

                // Execute the query
                if (!$flag && $stmt->execute()) {
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
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?category_id={$id}"); ?>" method="post">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Category Name</td>
                    <td><input type='text' name='category_name' class="form-control" value="<?php echo isset($category_name) ? htmlspecialchars($category_name) : ''; ?>" />
                        <?php if (isset($cname_err)) { ?><span class="text-danger"><?php echo $cname_err; ?></span><?php } ?></td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td> <textarea class="form-control" name="category_description"><?php echo htmlspecialchars($category_description, ENT_QUOTES); ?></textarea>
                        <?php if (isset($description_err)) { ?><span class="text-danger"><?php echo $description_err; ?></span><?php } ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save Changes' class='btn btn-primary' />
                        <a href='category_read.php' class='btn btn-danger'>Back to read Categories</a>
                    </td>
                </tr>
            </table>
        </form>

    </div>
</body>

</html>