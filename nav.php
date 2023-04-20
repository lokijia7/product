<!DOCTYPE html>
<html lang="en">
<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light" id="mainNav">
        <div class="container px-2 px-lg-3">
            <a class="navbar-brand" href="#">
                <img src="images/21454-01.png" alt="Logo" id="logo-img">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto py-4 py-lg-0">
                    <li class="nav-item <?php if ($currentPage == 'home.php') {
                                            echo 'active';
                                        } ?>"><a class="nav-link px-lg-3 py-3 py-lg-4" href="home.php">Home</a></li>
                    <li class="nav-item <?php if ($currentPage == 'product_create.php' || $currentPage == 'product_read.php') {
                                            echo 'active';
                                        } ?> dropdown">
                        <a class="nav-link px-lg-3 py-3 py-lg-4 dropdown-toggle" href="#" id="navbarDropdownProduct" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Product
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownProduct">
                            <li><a class="dropdown-item" href="product_create.php">Create Product</a></li>
                            <li><a class="dropdown-item" href="product_read.php">Product List</a></li>
                        </ul>
                    </li>
                    <li class="nav-item <?php if ($currentPage == 'category_create.php' || $currentPage == 'category_read.php') {
                                            echo 'active';
                                        } ?> dropdown">
                        <a class="nav-link px-lg-3 py-3 py-lg-4 dropdown-toggle" href="#" id="navbarDropdownProduct" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Category
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownProduct">
                            <li><a class="dropdown-item" href="category_create.php">Create Category</a></li>
                            <li><a class="dropdown-item" href="category_read.php">Category List</a></li>
                        </ul>
                    </li>
                    <li class="nav-item <?php if ($currentPage == 'customer_create.php' || $currentPage == 'customer_read.php') {
                                            echo 'active';
                                        } ?> dropdown">
                        <a class="nav-link px-lg-3 py-3 py-lg-4 dropdown-toggle" href="#" id="navbarDropdownProduct" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Customer
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownProduct">
                            <li><a class="dropdown-item" href="customer_create.php">Create customer</a></li>
                            <li><a class="dropdown-item" href="customer_read.php">Customer List</a></li>
                        </ul>
                    </li>
                    <li class="nav-item <?php if ($currentPage == 'contact.php') {
                                            echo 'active';
                                        } ?>"><a class="nav-link px-lg-3 py-3 py-lg-4" href="contact.php">Contact</a></li>

                    <li class="nav-item <?php if ($currentPage == 'order_create.php' || $currentPage == 'order_read.php') {
                                            echo 'active';
                                        } ?> dropdown">
                        <a class="nav-link px-lg-3 py-3 py-lg-4 dropdown-toggle" href="#" id="navbarDropdownProduct" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Order
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownProduct">
                            <li><a class="dropdown-item" href="order_create.php">Create Order</a></li>
                            <li><a class="dropdown-item" href="order_read.php">Order List</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="logout.php" name="logout">Log out</a></li>
                </ul>
            </div>
        </div>
    </nav>

</html>

<style>
    .dropdown:hover .dropdown-menu {
        display: block;
    }
</style>