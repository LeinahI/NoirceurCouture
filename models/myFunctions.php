<?php
include('dbcon.php');
function getAll($table)
{
    global $con;
    $query = "SELECT * FROM $table";
    $query_run = mysqli_query($con, $query);
    return $query_run; // Return the query result, not the query itself
}

/* SlideShow */




function getAllUsers()
{
    global $con;
    $query = "SELECT * FROM users";
    $query_run = mysqli_query($con, $query);
    return $query_run;
}

function getAllOrders()
{
    global $con;
    $query = "SELECT * FROM orders";
    $query_run = mysqli_query($con, $query);
    return $query_run;
}

/* 
0 - Preparing to ship
1 - Parcel is out for delivery
2 - Parcel has been delivered
3 - Parcel has been cancelled
 */

function getAllPreparingOrders()
{
    global $con;
    $query = "SELECT * FROM orders WHERE orders_status='0'";
    $query_run = mysqli_query($con, $query);
    return $query_run;
}

function getAllShippedOutOrders()
{
    global $con;
    $query = "SELECT * FROM orders WHERE orders_status='1'";
    $query_run = mysqli_query($con, $query);
    return $query_run;
}

function getAllDeliveredOrders()
{
    global $con;
    $query = "SELECT * FROM orders WHERE orders_status='2'";
    $query_run = mysqli_query($con, $query);
    return $query_run;
}

function getAllCancelledOrders()
{
    global $con;
    $query = "SELECT * FROM orders WHERE orders_status='3'";
    $query_run = mysqli_query($con, $query);
    return $query_run;
}

function getAllUserCount()
{
    global $con;
    $query = "SELECT COUNT(*) AS user_count FROM users WHERE user_role = 0";
    $query_run = mysqli_query($con, $query);
    return $query_run;
}


function getAllProductsCount()
{
    global $con;
    $query = "SELECT SUM(`product_qty`) AS prod_total FROM products";
    $query_run = mysqli_query($con, $query);
    return $query_run;
}

function getRevenue()
{
    global $con;
    $query = "SELECT SUM(total_original_price) AS overall_total_original_price
    FROM (
        SELECT 
            product_id,
            SUM(product_qty * product_srp) AS total_original_price
        FROM
            products
        GROUP BY
            product_id
    ) AS subquery;";
    $query_run = mysqli_query($con, $query);
    return $query_run;
}

function getRevenueDeliver()
{
    global $con;
    $query = "SELECT SUM(orders_total_price) AS total_orders_price
    FROM orders
    WHERE orders_status = 2;";
    $query_run = mysqli_query($con, $query);
    return $query_run;
}

function redirect($url, $Errormsg)
{
    $_SESSION['Errormsg'] = $Errormsg;
    header('Location: ' . $url);
    exit();
}

function getById($table, $id)
{
    global $con;
    $query = "SELECT * FROM $table WHERE category_id = '$id'";
    $result = mysqli_query($con, $query);
    return $result;
}
function getByUserId($table, $id)
{
    global $con;
    $query = "SELECT * FROM $table WHERE user_ID = '$id'";
    $result = mysqli_query($con, $query);
    return $result;
}

/* Get by slideshow id */
function slideShowId($table, $id)
{
    global $con;
    $query = "SELECT * FROM $table WHERE ss_id = '$id'";
    $result = mysqli_query($con, $query);
    return $result;
}

function getByIdProduct($table, $id)
{
    global $con;
    $query = "SELECT * FROM $table WHERE product_id = '$id'";
    $result = mysqli_query($con, $query);
    return $result;
}

function getBrandName($categoryID)
{
    global $con;
    $query = "SELECT category_name FROM categories WHERE category_id = '$categoryID'";
    $result = mysqli_query($con, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['category_name'];
    } else {
        return "Unknown Brand";
    }
}

function checkUserTrackingNumValid($trackingNo)
{
    global $con;
    $query = "SELECT * FROM orders WHERE orders_tracking_no='$trackingNo' ";
    return mysqli_query($con, $query);
}

function adminGetOrderedItemQty($tracking_number)
{
    global $con;
    $query = "SELECT oi.orderItems_order_id, SUM(oi.orderItems_qty) AS total_qty
    FROM order_items oi
    INNER JOIN orders o ON oi.orderItems_order_id = o.orders_id
    WHERE o.orders_tracking_no = '$tracking_number'
    GROUP BY oi.orderItems_order_id";

    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    $cart_qty = $row['total_qty'];
    return $cart_qty;
}

function redirectSwal($url, $status, $status_code)
{
    $_SESSION['status'] = $status;
    $_SESSION['status_code'] = $status_code;
    header('Location: ' . $url);
    exit();
}
include(__DIR__ . '/../partials/scripts.php');
