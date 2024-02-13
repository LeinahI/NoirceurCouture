<?php
session_start();
date_default_timezone_set('Asia/Manila');
include('../../models/dbcon.php');
include('../../models/myFunctions.php');

if (isset($_POST['updateParcelStatusBtn'])) {
    $track_num = $_POST['trackingNumber'];
    $order_stat = $_POST['orderStatus'];
    $orderId = $_POST['ordersID'];
    $currentTime = date("Y-m-d H:i:s");

    if ($order_stat == 3 /* Cancel Order */) {
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
    $updateOrderStatusQuery = "UPDATE orders SET orders_status = '$order_stat', orders_last_update_time='$currentTime' WHERE orders_id = '$orderId'";
    mysqli_query($con, $updateOrderStatusQuery);
    // Redirect or display success message

    redirectSwal("../viewOrderDetails.php?trck=$track_num", "Parcel status updated successfully!", "success");
}
