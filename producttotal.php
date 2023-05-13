<?php
// select total number of products
$query = "SELECT COUNT(*) as total FROM products";

// prepare and execute the query
$stmt = $con->prepare($query);
if (!$stmt->execute()) {
    // handle query execution error
    echo "<div class='alert alert-danger'>Error executing query.</div>";
    exit();
}

// fetch the result
$result = $stmt->fetch(PDO::FETCH_ASSOC);

// output the result
if ($result['total'] > 0) {
    echo "Total number of products: " . $result['total'];
} else {
    echo "<div class='alert alert-danger'>No records found.</div>";
}
