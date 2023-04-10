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


    <!-- PHP read one record will be here -->
    <?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    // include database connection
    include 'config/database.php';

    // get passed parameter value, in this case, the record ID
    // isset() is a PHP function used to verify if a value is there or not
    $id = isset($_GET['category_id']) ? $_GET['category_id'] : die('ERROR: Record ID not found.');

    // query to select the category name
    $category_query = "SELECT category_name FROM product_category WHERE category_id = ?";
    $category_stmt = $con->prepare($category_query);
    $category_stmt->bindParam(1, $id);
    $category_stmt->execute();
    $category_row = $category_stmt->fetch(PDO::FETCH_ASSOC);
    $category_name = $category_row['category_name'];

    // display the header with the category name
    echo "<div class='container'>";
    echo "<div class='page-header'>";
    echo "<h1>" . $category_name . "</h1>";
    echo "</div>";

    // query to select all products that belong to the category name
    $product_query = "SELECT * FROM products JOIN product_category ON products.category_name = product_category.category_name WHERE product_category.category_id = ?";
    $product_stmt = $con->prepare($product_query);
    $product_stmt->bindParam(1, $id);
    $product_stmt->execute();

    // check if more than 0 record found
    $num = $product_stmt->rowCount();

    echo "<a href='category_read.php' class='btn btn-danger'>Back to read categories</a>";

    if ($num > 0) {
        // display products in a table format
        echo "<table class='table table-hover table-responsive table-bordered'>";
        echo "<tr>";
        echo "<th>Product ID</th>";
        echo "<th>Product Name</th>";
        echo "<th>Description</th>";
        echo "<th>Price</th>";
        echo "<th>Promotion Price</th>";
        echo "<th>Manufacture Date</th>";
        echo "<th>Expiry Date</th>";
        echo "<th>Action</th>";
        echo "</tr>";
        while ($row = $product_stmt->fetch(PDO::FETCH_ASSOC)) {
            // extract row
            // this will make $row['firstname'] to just $firstname only
            extract($row);
            // creating new table row per record
            echo "<tr>";
            echo "<td>{$product_id}</td>";
            echo "<td>{$name}</td>";
            echo "<td>{$description}</td>";
            echo "<td>" . 'RM' . number_format($price, 2) . "</td>";
            echo "<td>" . 'RM' . number_format($promotion_price, 2) . "</td>";
            echo "<td>{$manufacture_date}</td>";
            echo "<td>{$expiry_date}</td>";
            echo "<td>";
            // read one record
            echo "<a href='product_read_one.php?product_id={$product_id}' class='btn btn-info m-r-1em'>Read</a>";

            // we will use this links on next part of this post
            echo "<a href='update.php?id={$id}' class='btn btn-primary m-r-1em'>Edit</a>";

            // we will use this links on next part of this post
            echo "<a href='#' onclick='delete_user({$id});'  class='btn btn-danger'>Delete</a>";
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