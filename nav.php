<!-- Navigation-->
<?php $base = basename($_SERVER['PHP_SELF'], '.php') ?>
<nav class="navbar navbar-expand-lg navbar-light" id="mainNav">
    <div class="container px-2 px-lg-3">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto py-4 py-lg-0">
                <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="home.php">Home</a></li>
                <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="product_create.php">Create Product</a></li>
                <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="product_read.php">Products List</a></li>
                <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="customer_create.php">Create Customer</a></li>
                <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="customer_read.php">Customers List</a></li>
                <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="contact.php">Contact Us</a>
                <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="login.php">Log out</a>
                </li>
            </ul>
        </div>
    </div>
</nav>