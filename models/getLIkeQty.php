<?php
session_start();
include('dbcon.php');

function getLikeQty($con)
{
    $userId = $_SESSION['auth_user']['user_ID'];

    $sql = "SELECT COUNT(*) AS like_total FROM likes WHERE user_ID = ?";

    if ($stmt = $con->prepare($sql)) {
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        return $data['like_total'];
    } else {
        // Handle error
        return 0;
    }
}

header('Content-Type: application/json');

if (isset($_SESSION['auth_user'])) {
    $cartQty = getLikeQty($con); // Assuming $con is your database connection
    echo json_encode(['likeQty' => $cartQty]);
} else {
    echo json_encode(['likeQty' => 0]);
}
