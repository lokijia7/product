<?php
// include database connection
include 'config/database.php';

// select bottom 3 worst sellers
$query = "SELECT name FROM products ORDER BY created DESC LIMIT 3";


$stmt = $con->prepare($query);
$stmt->execute();

// this is how to get number of rows returned
$num = $stmt->rowCount();

// check if more than 0 record found
if ($num > 0) {
    $latest_product = array();

    // retrieve our table contents
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $latest_product[] = $name;
    }

    // output the results
    echo "<ul>";
    foreach ($latest_product as $product) {
        echo "<li>" . $product . "</li>";
    }
    echo "</ul>";
} else {
    echo "<div class='alert alert-danger'>No records found.</div>";
}
