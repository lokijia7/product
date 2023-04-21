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

</head>

<body>
    <?php include 'nav.php' ?>

    <main class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="border pastel">
                    <h2>Best Sellers</h2>
                    <ul>
                        <li><?php include 'best_seller.php' ?></li>
                    </ul>
                </div>
            </div>

            <div class="col-md-6">
                <div class="border">
                    <h2>Worst Seller</h2>
                    <ul>
                        <li><?php include 'worst_seller.php' ?></li>
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
                        <li><?php include 'latest_product.php' ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </main>
</body>

</html>