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
    <title>Typo-Home page</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <!-- Latest compiled and minified Bootstrap CSS (Apply your Bootstrap here) -->

</head>

<body>
    <?php include 'nav.php' ?>

    <main class="container">
        <div class="grid-container">
            <div class="box total-customers">
                <h2>Total Customers</h2>
                <ul class="no-marker">
                    <li><?php include 'customertotal.php' ?></li>
                </ul>
            </div>
            <div class="box total-products">
                <h2>Total Products</h2>
                <ul class="no-marker">
                    <li><?php include 'producttotal.php' ?></li>
                </ul>
            </div>
            <div class="box total-orders">
                <h2>Total Orders</h2>
                <ul class="no-marker">
                    <li><?php include 'totalorder.php' ?></li>
                </ul>
            </div>
            <div class="box latest-orders">
                <h2>Latest Order</h2>
                <ul class="no-marker">
                    <li><?php include 'latestorder.php' ?></li>
                </ul>
            </div>
            <div class="box best-sellers">
                <h2>Best Selling Product</h2>
                <ul class="no-marker">
                    <li><?php include 'best_seller.php' ?></li>
                </ul>
            </div>
            <div class="box worst-sellers">
                <h2>Worst Selling Product</h2>
                <ul class="no-marker">
                    <li><?php include 'worst_seller.php' ?></li>
                </ul>
            </div>
            <div class="box best-customer">
                <h2>Best Customer</h2>
                <ul class="no-marker">
                    <li><?php include 'best_customer.php' ?></li>
                </ul>
            </div>
            <div class="box latest-product">
                <h2>Latest Product</h2>
                <ul class="no-marker">
                    <li><?php include 'latest_product.php' ?></li>
                </ul>
            </div>
        </div>
    </main>
</body>

</html>