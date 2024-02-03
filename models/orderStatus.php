<?php
session_start();
date_default_timezone_set('Asia/Manila');
include('dbcon.php');
include('myFunctions.php');

if (isset($_POST['cancelOrderBtn'])) {
    $track_num = $_POST['trackingNumber'];
    $orderId = $_POST['ordersID'];
    $cancelReason = $_POST['reasonCancelOrder'];
    $order_stat = 3; // = 3 cancelled

    $updateStatus_query = "UPDATE orders SET orders_status='$order_stat', orders_cancel_reason='$cancelReason' WHERE orders_tracking_no='$track_num'";
    mysqli_query($con, $updateStatus_query);

    if ($order_stat == 3) {
        // Get the order items
        $orderItemsQuery = "SELECT orderItems_product_id, orderItems_qty FROM order_items WHERE orderItems_order_id = '$orderId'";
        $orderItemsResult = mysqli_query($con, $orderItemsQuery);

        // Update the product quantities
        while ($orderItem = mysqli_fetch_array($orderItemsResult)) {
            $productId = $orderItem['orderItems_product_id'];
            $orderItemQty = $orderItem['orderItems_qty'];

            // Update the product_qty in the products table
            $updateProductQtyQuery = "UPDATE products SET product_qty = product_qty + '$orderItemQty' WHERE product_id = '$productId'";
            mysqli_query($con, $updateProductQtyQuery);
        }
    }

    // Update the orders_status in the orders table
    $updateOrderStatusQuery = "UPDATE orders SET orders_status = '$order_stat' WHERE orders_id = '$orderId'";
    mysqli_query($con, $updateOrderStatusQuery);
    // Redirect or display success message

    redirectSwal("../views/viewOrderDetails.php?trck=$track_num", "Your order has been Cancelled!", "success");
} else if (isset($_POST['orderRcvBtn'])) {
    $track_num = $_POST['trackingNumber'];
    $orderId = $_POST['ordersID'];
    $order_stat = 2; // = 2 received

    // Update the orders_status in the orders table
    $updateOrderStatusQuery = "UPDATE orders SET orders_status = '$order_stat' WHERE orders_id = '$orderId'";
    mysqli_query($con, $updateOrderStatusQuery);
    // Redirect or display success message

    redirectSwal("../views/viewOrderDetails.php?trck=$track_num", "Your order has been Received!", "success");
}
