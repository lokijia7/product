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
            <h1>Read Products</h1>
        </div>

        <nav class="navbar bg-body-tertiary">
            <div class="container-fluid">
                <div class="col-md-6">
                    <?php echo "<a href='product_create.php' class='btn btn-primary m-b-1em'>Create New Product</a>"; ?>
                </div>
                <div class="col-md-6 d-flex justify-content-end">
                    <form class="d-flex" role="search" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <input class="form-control me-2 pastel-color" name="search" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success m-b-1em btn-btn-sm" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </nav>



        <?php
        // include database connection
        include 'config/database.php';

        // select all data
        $query = "SELECT * FROM products";
        if ($_POST) {
            $search = htmlspecialchars(strip_tags($_POST['search']));
            $query = "SELECT * FROM `products` WHERE 
            product_id LIKE '%" . $search . "%' OR 
            name LIKE '%" . $search . "%' OR 
            description LIKE '%" . $search . "%' OR 
            category_name LIKE '%" . $search . "%'";
        }

        $stmt = $con->prepare($query);
        $stmt->execute();

        // this is how to get number of rows returned
        $num = $stmt->rowCount();


        //check if more than 0 record found
        if ($num > 0) {

            echo "<table class='table table-hover table-responsive table-bordered'>"; //start table

            //creating our table heading
            echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>Name</th>";
            echo "<th>Description</th>";
            echo "<th>Price</th>";
            echo "<th>Promotion Price</th>";
            echo "<th>Action</th>";
            echo "</tr>";

            // retrieve our table contents
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // extract row
                // this will make $row['firstname'] to just $firstname only
                extract($row);
                // creating new table row per record
                echo "<tr>";
                echo "<td>{$product_id}</td>";
                echo "<td>{$name}</td>";
                echo "<td>{$description}</td>";
                echo "<td>" . 'RM' . number_format($price, 2) . "</td>";
                echo "<td>" . ($promotion_price ? 'RM' . number_format($promotion_price, 2) : '') . "</td>";
                echo "<td>";
                // read one record
                echo "<div class='button-group1'>";
                echo "<a href='product_read_one.php?product_id={$product_id}' class='btn btn-info btn-sm d-inline'>Read</a>";
                echo "</div>";
                echo "<div class='button-group2'>";
                echo "<a href='update.php?id={$id}' class='btn btn-primary btn-sm d-inline'>Edit</a>";
                echo "</div>";
                echo "<div class='button-group3'>";
                echo "<a href='#' onclick='delete_user({$id});'  class='btn btn-danger btn-sm d-inline'>Delete</a>";
                echo "</div>";
                echo "</td>";
                echo "</tr>";
            }

            // end table
            echo "</table>";
        }
        // if no records found
        else {
            echo "<div class='alert alert-danger'>No records found.</div>";
        }

        ?>



    </div> <!-- end .container -->

    <!-- confirm delete record will be here -->

</body>

</html>