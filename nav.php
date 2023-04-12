<nav class="navbar navbar-expand-lg navbar-light" id="mainNav">
    <div class="container px-2 px-lg-3">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto py-4 py-lg-0">
                <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="home.php">Home</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link px-lg-3 py-3 py-lg-4 dropdown-toggle" href="#" id="navbarDropdownProduct" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Product
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownProduct">
                        <li><a class="dropdown-item" href="product_create.php">Create Product</a></li>
                        <li><a class="dropdown-item" href="product_read.php">Product List</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link px-lg-3 py-3 py-lg-4 dropdown-toggle" href="#" id="navbarDropdownCategory" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Category
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownCategory">
                        <li><a class="dropdown-item" href="category_create.php">Create Category</a></li>
                        <li><a class="dropdown-item" href="category_read.php">Category List</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link px-lg-3 py-3 py-lg-4 dropdown-toggle" href="#" id="navbarDropdownCustomer" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Customer
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownCustomer">
                        <li><a class="dropdown-item" href="customer_create.php">Create Customer</a></li>
                        <li><a class="dropdown-item" href="customer_read.php">Customers List</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="contact.php">Contact Us</a></li>
                <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="logout.php" name="logout">Log out</a></li>
            </ul>
        </div>
    </div>
</nav>

<style>
    .dropdown:hover .dropdown-menu {
        display: block;
    }
</style>