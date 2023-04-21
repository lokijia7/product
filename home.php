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
    <title>Store Background Management System</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <!-- Latest compiled and minified Bootstrap CSS (Apply your Bootstrap here) -->
    <style>
        .border {
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <?php include 'nav.php' ?>

    <main class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="border">
                    <h2>Best Seller</h2>
                    <ul>
                        <li><?php
                            // include database connection
                            include 'config/database.php';

                            // select top 3 best sellers
                            $query = "SELECT 
    p.name,
    SUM(od.quantity) as total_sold
FROM 
    orders o 
    JOIN order_detail od ON o.order_id = od.order_id
    JOIN products p ON od.product_id = p.product_id
GROUP BY 
    p.name
ORDER BY 
    total_sold DESC
LIMIT 3";

                            $stmt = $con->prepare($query);
                            $stmt->execute();

                            // this is how to get number of rows returned
                            $num = $stmt->rowCount();

                            // check if more than 0 record found
                            if ($num > 0) {
                                $best_sellers = array();

                                // retrieve our table contents
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    extract($row);

                                    $best_sellers[] = $product_name;
                                }

                                // output the results
                                echo "<h3>Top sellers</h3>";
                                echo "<ul>";
                                foreach ($best_sellers as $product) {
                                    echo "<li>" . $product . "</li>";
                                }
                                echo "</ul>";
                            } else {
                                echo "<div class='alert alert-danger'>No records found.</div>";
                            }
                            ?>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6">
                <div class="border">
                    <h2>Worst Seller</h2>
                    <ul>
                        <li>Product D</li>
                        <li>Product E</li>
                        <li>Product F</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="border">
                    <h2>Most Bought Customer</h2>
                    <ol>
                        <li>John Doe</li>
                        <li>Jane Smith</li>
                        <li>Mike Johnson</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-6">
                <div class="border">
                    <h2>Latest Product</h2>
                    <ul>
                        <li>Product G</li>
                        <li>Product H</li>
                        <li>Product I</li>
                    </ul>
                </div>
            </div>
        </div>
    </main>
</body>

</html>