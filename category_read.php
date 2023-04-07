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
    <?php include 'nav.php' ?>

    <!-- container -->
    <div class="container">
        <div class="page-header">
            <h1>Create Category</h1>
        </div>

        <?php
        // include database connection
        include 'config/database.php';
        // Get the selected category from the URL parameter
        $category_name = $_GET["category_name"];

        // Define the SQL query
        $query = "SELECT * FROM products WHERE category_name = '$category_name'";

        // Execute the query and store the results in a variable
        $result = mysqli_query($conn, $query);

        // Close the database connection
        mysqli_close($conn);
        ?>

        <!DOCTYPE html>
        <html>

        <head>
            <title>Products</title>
        </head>

        <body>
            <h1><?php echo $category; ?></h1>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row["name"]; ?></td>
                        <td><?php echo $row["description"]; ?></td>
                        <td><?php echo $row["price"]; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </body>

        </html>
        ?>


        <!-- end .container -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>