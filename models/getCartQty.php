<?php
session_start();
include('dbcon.php');

function getCartQty($con)
{
    $userId = $_SESSION['auth_user']['user_ID'];

    $sql = "SELECT COUNT(*) AS total_entries
            FROM carts c
            INNER JOIN products p ON c.product_id = p.product_id
            WHERE user_ID = ? AND p.product_qty >= c.product_qty AND p.product_visibility = 0";

    if ($stmt = $con->prepare($sql)) {
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        return $data['total_entries'];
    } else {
        // Handle error
        return 0;
    }
}

header('Content-Type: application/json');

if (isset($_SESSION['auth_user'])) {
    $cartQty = getCartQty($con); // Assuming $con is your database connection
    echo json_encode(['cartQty' => $cartQty]);
} else {
    echo json_encode(['cartQty' => 0]);
}
