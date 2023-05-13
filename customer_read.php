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
            <h1>Read Customers</h1>
        </div>

        <nav class="navbar bg-body-tertiary">
            <div class="container-fluid">

                <div class="col-md-6">
                    <?php echo "<a href='customer_create.php' class='btn btn-primary m-b-1em'>Create New Customer</a>"; ?>
                </div>
                <div class="col-md-6 d-flex justify-content-end">
                    <form class="d-flex" role="search" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <input class="form-control me-2 pastel-color" name="search" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success btn-btn-sm" type="submit">Search</button>
                    </form>
                </div>

            </div>
        </nav>

        <?php
        // include database connection
        include 'config/database.php';

        // delete message prompt will be here
        $action = isset($_GET['action']) ? $_GET['action'] : "";

        // if it was redirected from delete.php
        if ($action == 'deleted') {
            echo "<div class='alert alert-success'>Record was deleted.</div>";
        }


        // select all data
        $query = "SELECT * FROM customers";
        if ($_POST) {
            $search = htmlspecialchars(strip_tags($_POST['search']));
            $query = "SELECT * FROM `customers` WHERE 
                    id LIKE '%" . $search . "%' OR 
                    username LIKE '%" . $search . "%' OR 
                    first_name LIKE '%" . $search . "%' OR 
                    account_status LIKE '%" . $search . "%' OR 
                    last_name LIKE '%" . $search . "%'";
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
            echo "<th class='col-1'>ID</th>";
            echo "<th class='col-2'>Username</th>";
            echo "<th class='col-1'>First Name</th>";
            echo "<th class='col-1'>Last Name</th>";
            echo "<th class='col-1'>Account Status</th>";
            echo "<th class='col-2'>Register Date & Time</th>";
            echo "<th class='col-4'>Action</th>";
            echo "</tr>";

            // retrieve our table contents
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // extract row
                // this will make $row['firstname'] to just $firstname only
                extract($row);
                // creating new table row per record
                echo "<tr>";
                echo "<td class='col-1'>{$id}</td>";
                echo "<td class='col-2'>{$username}</td>";
                echo "<td class='col-1'>{$first_name}</td>";
                echo "<td class='col-1'>{$last_name}</td>";
                echo "<td class='col-1'>{$account_status}</td>";
                echo "<td class='col-2'>{$registration_datetime}</td>";
                echo "<td class='col-4'>";

                // read one record
                echo "<div class='button-group1'>";
                echo "<a href='customer_read_one.php?id={$id}' class='btn btn-info btn-sm d-inline'>Read</a>&nbsp;";
                echo "<a href='customer_update.php?id={$id}' class='btn btn-primary btn-sm d-inline'>Edit</a>&nbsp;";
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
    <script type='text/javascript'>
        // confirm record deletion
        function delete_user(id) {

            var answer = confirm('Are you sure?');
            if (answer) {
                // if user clicked ok,
                // pass the id to delete.php and execute the delete query
                window.location = 'customer_delete.php?id=' + id;
            }
        }
    </script>

</body>

</html>