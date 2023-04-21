<?php
// include database connection
include 'config/database.php';

// select top 3 latest products
$query = "SELECT name FROM products ORDER BY created DESC LIMIT 3";

// prepare and execute the query
$stmt = $con->prepare($query);
if (!$stmt->execute()) {
    // handle query execution error
    echo "<div class='alert alert-danger'>Error executing query.</div>";
    exit();
}

// fetch the results
$latest_products = array();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $latest_products[] = $row['name'];
}

// output the results
if (count($latest_products) > 0) {
    echo "<ul>";
    foreach ($latest_products as $product) {
        echo "<li>" . htmlspecialchars($product) . "</li>";
    }
    echo "</ul>";
} else {
    echo "<div class='alert alert-danger'>No records found.</div>";
}
