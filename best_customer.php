<?php
// include database connection
include 'config/database.php';

// select customer with highest number of orders
$query = "SELECT customers.username, COUNT(orders.order_id) as total_orders 
          FROM customers 
          JOIN orders ON customers.username = orders.username
          GROUP BY customers.username 
          ORDER BY total_orders DESC 
          LIMIT 1";

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
    echo "<p>The customer who has placed the most orders is: " . htmlspecialchars($row['username'])
        . " with a total of " . htmlspecialchars($row['total_orders']) . " orders</p>";
    echo "<tr>";
} else {
    echo "<div class='alert alert-danger'>No records found.</div>";
}
