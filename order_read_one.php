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
            <h1>Read Order's Detail</h1>
        </div>
        <nav class="navbar bg-body-tertiary">
            <div class="container-fluid">

                <div class="col-md-6">
                    <?php echo "<a href='order_read.php' class='btn btn-primary m-b-1em'>Read Orders</a>"; ?>
                </div>
            </div>
            <?php
            // include database connection
            include 'config/database.php';

            // get passed parameter value, in this case, the record ID
            $id = isset($_GET['order_id']) ? $_GET['order_id'] : die('ERROR: Record ID not found.');

            // select all data
            $query = "SELECT o.order_id,o.username, od.product_id, p.name, p.price, p.promotion_price, od.quantity, od.order_detail_id
        FROM orders o
        JOIN order_detail od ON o.order_id = od.order_id
        JOIN products p ON od.product_id = p.product_id
        WHERE o.order_id = ?";

            $stmt = $con->prepare($query);

            // this is the first question mark
            $stmt->bindParam(1, $id);

            $stmt->execute();

            // this is how to get number of rows returned
            $num = $stmt->rowCount();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);


            echo "<div class='container'>";
            echo "<div class='page-header'>";
            echo "<h1>" . $row['username'] . "</h1>";
            echo "</div>";



            //check if more than 0 record found
            if ($num > 0) {

                echo "<table class='table table-hover table-responsive table-bordered'>"; //start table

                //creating our table heading
                echo "<tr>";
                echo "<th class='col-1'>Order Detail ID</th>";
                echo "<th class='col-1'>Product ID</th>";
                echo "<th class='col-2'>Product Name</th>";
                echo "<th class='col-1'>Quantity</th>";
                echo "<th class='col-2'>Price</th>";
                echo "<th class='col-2'>Promotion Price</th>";
                echo "<th class='col-2'>Total</th>";
                echo "</tr>";

                // retrieve our table contents
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    // extract row
                    // this will make $row['firstname'] to just $firstname only
                    extract($row);
                    // creating new table row per record
                    // creating new table row per record
                    echo "<tr>";
                    echo "<td class='col-1'>{$order_detail_id}</td>";
                    echo "<td class='col-1'>{$product_id}</td>";
                    echo "<td class='col-2'>{$name}</td>";
                    echo "<td class='col-1'>{$quantity}</td>";
                    echo "<td class='col-2' style='text-align: right'>" . 'RM' . number_format($price, 2) . "</td>";
                    echo "<td class='col-2' style='text-align: right'>" . ($promotion_price ? 'RM' . number_format($promotion_price, 2) : '') . "</td>";
                    echo "<td class='col-2' style='text-align: right'>" . 'RM' . number_format(($promotion_price ? $promotion_price : $price) * $quantity, 2) . "</td>"; // new column data

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