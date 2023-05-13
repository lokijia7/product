<?php
// select customer with latest order ID and summary
$query = "SELECT 
orders.order_id as latest_order_id,
customers.username as customer_name,
orders.created as transaction_date,
SUM(CASE WHEN products.promotion_price IS NOT NULL THEN products.promotion_price * order_detail.quantity ELSE products.price * order_detail.quantity END) as purchase_amount
FROM 
orders 
JOIN customers ON orders.username = customers.username
JOIN order_detail ON orders.order_id = order_detail.order_id
JOIN products ON order_detail.product_id = products.product_id
GROUP BY 
orders.order_id
ORDER BY 
orders.order_id DESC
LIMIT 
1";


$stmt = $con->prepare($query);
if (!$stmt->execute()) {
    // handle query execution error
    echo "<div class='alert alert-danger'>Error executing query.</div>";
    exit();
}

$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row) {
    echo "<p>The customer with the latest order is: " . htmlspecialchars($row['customer_name'])
        . " with an order ID of " . htmlspecialchars($row['latest_order_id'])
        . " on " . htmlspecialchars($row['transaction_date'])
        . " with a purchase amount of RM " . htmlspecialchars($row['purchase_amount']) . "</p>";
} else {
    echo "<div class='alert alert-danger'>No records found.</div>";
}
