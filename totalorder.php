<?php
// select total number of orders
$query = "SELECT COUNT(*) as total_orders FROM orders";

$stmt = $con->prepare($query);
$stmt->execute();

// retrieve the total number of orders
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$total_orders = $row['total_orders'];

// output the result
echo "Total orders: " . $total_orders;
