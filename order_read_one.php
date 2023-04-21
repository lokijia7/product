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
                <div class="row">
                    <div class="col-md-6">
                        <?php echo "<a href='order_create.php' class='btn btn-primary m-b-1em'>Create New Order</a>"; ?>
                    </div>
                    <div class="col-md-6 d-flex justify-content-end">
                        <form class="d-flex" role="search" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <input class="form-control me-2" name="search" type="search" placeholder="Search" aria-label="Search">
                            <button class="btn btn-outline-success" type="submit">Search</button>


                        </form>
                    </div>
                </div>
            </div>
        </nav>


        <?php
        // include database connection
        include 'config/database.php';

        // get passed parameter value, in this case, the record ID
        // isset() is a PHP function used to verify if a value is there or not
        $id = isset($_GET['order_id']) ? $_GET['order_id'] : die('ERROR: Record ID not found.');

        // select all data
        $query = "SELECT o.order_id, od.product_id, p.name, od.quantity, od.order_detail_id, od.created
        FROM orders o
        JOIN order_detail od ON o.order_id = od.order_id
        JOIN products p ON od.product_id = p.product_id
        WHERE o.order_id = ?";

        if ($_POST) {
            $search = htmlspecialchars(strip_tags($_POST['search']));
            $query .= " WHERE o.order LIKE '%" . $search . "%'";
        }

        $stmt = $con->prepare($query);

        // this is the first question mark
        $stmt->bindParam(1, $id);

        $stmt->execute();

        // this is how to get number of rows returned
        $num = $stmt->rowCount();



        //check if more than 0 record found
        if ($num > 0) {

            echo "<table class='table table-hover table-responsive table-bordered'>"; //start table

            //creating our table heading
            echo "<tr>";
            echo "<th>Order Detail ID</th>";
            echo "<th>Product ID</th>";
            echo "<th>Product Name</th>";
            echo "<th>Quantity</th>";
            echo "<th>Created</th>";
            echo "<th>Action</th>";
            echo "</tr>";

            // retrieve our table contents
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // extract row
                // this will make $row['firstname'] to just $firstname only
                extract($row);
                // creating new table row per record
                echo "<tr>";
                echo "<td>{$order_detail_id}</td>";
                echo "<td>{$product_id}</td>";
                echo "<td>{$name}</td>";
                echo "<td>{$quantity}</td>";
                echo "<td>{$created}</td>";
                echo "<td>";
                // read one record
                echo "<a href='order_read_one.php?order_detail_id={$order_detail_id}' class='btn btn-info m-r-1em'>Read</a>";

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