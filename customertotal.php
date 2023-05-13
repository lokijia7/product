<?php
// include database connection
include 'config/database.php';

// select the total number of customers
$query = "SELECT COUNT(username) as total_customers FROM customers";

// prepare and execute the query
$stmt = $con->prepare($query);
if (!$stmt->execute()) {
    // handle query execution error
    echo "<div class='alert alert-danger'>Error executing query.</div>";
    exit();
}

// fetch the result
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// output the result
if ($row) {
    echo "<p>The total number of customers is: " . htmlspecialchars($row['total_customers']) . "</p>";
} else {
    echo "<div class='alert alert-danger'>No records found.</div>";
}
