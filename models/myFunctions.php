<?php
include('dbcon.php');
function getAll($table)
{
    global $con;
    $query = "SELECT * FROM $table";
    $query_run = mysqli_query($con, $query);
    return $query_run; // Return the query result, not the query itself
}

/* getAllproductCateg */
function getByCategAndProduct($id)
{
    global $con;
    $query = "SELECT products.*, categories.*
               FROM products 
               LEFT JOIN categories ON products.category_id  = categories.category_id
               WHERE categories.category_user_ID ='$id'";
    $result = mysqli_query($con, $query);
    return $result;
}
/* getAllbyCategory */
function getAllbyCategory($table, $id)
{
    global $con;
    $query = "SELECT * FROM $table WHERE category_id='$id'";
    $query_run = mysqli_query($con, $query);
    return $query_run; // Return the query result, not the query itself
}


function getAllUsers()
{
    global $con;
    $query = "SELECT * FROM users";
    $query_run = mysqli_query($con, $query);
    return $query_run;
}


/* GetAllSellerApplication */
function GetAllSellerApplication()
{
    global $con;
    $query = "SELECT usd.*, u.user_firstName, u.user_lastName
    FROM users_seller_details usd
    INNER JOIN users u ON usd.seller_user_ID = u.user_ID
    WHERE usd.seller_confirmed = '0'";
    $query_run = mysqli_query($con, $query);
    return $query_run;
}

/* GetAllDeletedAccReq */
function GetAllDeletedAccReq()
{
    global $con;
    $query = "SELECT ud_user_ID, ud_username, ud_role, ud_reason, ud_details, ud_confirmed
    FROM users_deleted_details
    WHERE ud_confirmed = '0'";
    $query_run = mysqli_query($con, $query);
    return $query_run;
}

/********************************
 ************Admin Orders Function
 ********************************/
/* 
0 - Preparing to ship
1 - Parcel is out for delivery
2 - Parcel has been delivered
3 - Parcel has been cancelled
 */
function getAllOrders()
{
    global $con;
    $query = "SELECT * FROM orders";
    $query_run = mysqli_query($con, $query);
    return $query_run;
}

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
/********************************
 ************Seller Orders Function
 ********************************/
/* Most Complex Join */
function getAllOrdersbyStore($id)
{
    global $con;
    $query = "SELECT *
    FROM orders o
    JOIN order_items oi ON o.orders_id = oi.orderItems_order_id
    JOIN products p ON oi.orderItems_product_id = p.product_id
    JOIN categories c ON p.category_id = c.category_id
    WHERE c.category_user_ID = '$id'";
    $query_run = mysqli_query($con, $query);
    return $query_run;
}

function getAllPreparingOrdersbyStore($id)
{
    global $con;
    $query = "SELECT *
    FROM orders o
    JOIN order_items oi ON o.orders_id = oi.orderItems_order_id
    JOIN products p ON oi.orderItems_product_id = p.product_id
    JOIN categories c ON p.category_id = c.category_id
    WHERE c.category_user_ID = '$id' AND o.orders_status='0'";
    $query_run = mysqli_query($con, $query);
    return $query_run;
}

function getAllShippedOutOrdersbyStore($id)
{
    global $con;
    $query = "SELECT *
    FROM orders o
    JOIN order_items oi ON o.orders_id = oi.orderItems_order_id
    JOIN products p ON oi.orderItems_product_id = p.product_id
    JOIN categories c ON p.category_id = c.category_id
    WHERE c.category_user_ID = '$id' AND o.orders_status='1'";
    $query_run = mysqli_query($con, $query);
    return $query_run;
}

function getAllDeliveredOrdersbyStore($id)
{
    global $con;
    $query = "SELECT *
    FROM orders o
    JOIN order_items oi ON o.orders_id = oi.orderItems_order_id
    JOIN products p ON oi.orderItems_product_id = p.product_id
    JOIN categories c ON p.category_id = c.category_id
    WHERE c.category_user_ID = '$id' AND o.orders_status='2'";
    $query_run = mysqli_query($con, $query);
    return $query_run;
}

function getAllCancelledOrdersbyStore($id)
{
    global $con;
    $query = "SELECT *
    FROM orders o
    JOIN order_items oi ON o.orders_id = oi.orderItems_order_id
    JOIN products p ON oi.orderItems_product_id = p.product_id
    JOIN categories c ON p.category_id = c.category_id
    WHERE c.category_user_ID = '$id' AND o.orders_status='3'";
    $query_run = mysqli_query($con, $query);
    return $query_run;
}
/********************************
 ************Seller and Admin Reports Dashboard start
 ********************************/
function getAdminCategories($userid)
{
    global $con;
    $query = "SELECT * FROM categories WHERE category_user_ID = '$userid'";
    $query_run = mysqli_query($con, $query);
    return $query_run; // Return the query result, not the query itself
}

function getCancelledOrdersCount($userid)
{
    global $con;
    $query = "SELECT 
        o.orders_id,
        c.category_id,
        COUNT(o.orders_status) as total_cancelled_orders
        FROM orders o
        JOIN order_items oi ON o.orders_id = oi.orderItems_order_id
        JOIN products p ON p.product_id = oi.orderItems_product_id
        JOIN categories c ON p.category_id = c.category_id
        WHERE c.category_user_ID = '$userid' AND orders_status = 3";
    $query_run = mysqli_query($con, $query);
    return $query_run;
}

function getAllProductsCount($userid)
{
    global $con;
    $query = "SELECT 
    p.product_id,
    p.category_id,
    SUM(p.product_qty) AS total_prod_qty
    FROM products p
    JOIN categories c ON p.category_id = c.category_id
    WHERE c.category_user_ID = '$userid'";
    $query_run = mysqli_query($con, $query);
    return $query_run;
}

function getRevenue($userid)
{
    global $con;
    $query = "SELECT 
    p.product_id,
    p.category_id,
    p.product_srp,
    SUM(p.product_qty * p.product_srp) AS total_if_sold
    FROM products p
    JOIN categories c ON p.category_id = c.category_id
    WHERE c.category_user_ID = '$userid'";
    $query_run = mysqli_query($con, $query);
    return $query_run;
}

function getRevenueDeliver($userid)
{
    global $con;
    $query = "SELECT SUM(orders_total_price) AS total_orders_price
    FROM orders o
    JOIN order_items oi ON o.orders_id = oi.orderItems_order_id
    JOIN products p ON oi.orderItems_product_id = p.product_id
    JOIN categories c ON p.category_id = c.category_id
    WHERE c.category_user_ID = '$userid' AND o.orders_status = 2;";
    $query_run = mysqli_query($con, $query);
    return $query_run;
}

function getTrendingItem($userid)
{
    global $con;
    $query = "SELECT 
    oi.orderItems_order_id,
    MAX(oi.orderItems_qty) as trending,
    c.category_name,
    p.product_name,
    p.product_srp,
    p.product_image,
    o.orders_total_price,
    o.orders_status,
    c.category_user_ID
    FROM order_items oi
    JOIN products p ON oi.orderItems_product_id = p.product_id
    JOIN categories c ON p.category_id = c.category_id
    JOIN orders o ON oi.orderItems_order_id = o.orders_id
    WHERE c.category_user_ID = '$userid' AND o.orders_status = 2
    GROUP BY oi.orderItems_order_id
    ORDER BY trending DESC
    LIMIT 1
";
    $query_run = mysqli_query($con, $query);
    return $query_run;
}

function getTrendingItemSold($userid)
{
    global $con;
    $query = "SELECT 
    oi.orderItems_product_id,
    SUM(oi.orderItems_qty) as item_sold,
    c.category_name,
    p.product_name,
   	SUM(o.orders_total_price) as total_price_sold,
    o.orders_status,
    c.category_user_ID
    FROM order_items oi
    JOIN products p ON oi.orderItems_product_id = p.product_id
    JOIN categories c ON p.category_id = c.category_id
    JOIN orders o ON oi.orderItems_order_id = o.orders_id
    WHERE c.category_user_ID = '$userid' AND o.orders_status = 2
    GROUP BY oi.orderItems_product_id
    ORDER BY item_sold DESC
    LIMIT 1
";
    $query_run = mysqli_query($con, $query);
    return $query_run;
}


/********************************
 ************Seller and Admin Dashboard & Reports end
 ********************************/
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

function getByCategAndUserId($id)
{
    global $con;
    $query = "SELECT users.*, categories.*
               FROM users 
               LEFT JOIN categories ON users.user_ID = categories.category_user_ID
               WHERE users.user_ID ='$id'";
    $result = mysqli_query($con, $query);
    return $result;
}

function getPickupAddress()
{
    global $con;
    $user_id = $_SESSION['auth_user']['user_ID'];
    $query = "SELECT a.*, u.user_ID
    FROM addresses AS a
    INNER JOIN users AS u ON a.address_user_ID = u.user_ID
    WHERE a.address_user_ID = '$user_id'";

    $result = mysqli_query($con, $query);

    return $result;
}

function getByUserandSellerId($id)
{
    global $con;

    $query = "SELECT users.*, users_seller_details.* 
              FROM users 
              LEFT JOIN users_seller_details ON users.user_ID = users_seller_details.seller_user_ID 
              WHERE users.user_ID = '$id'";

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
    INNER JOIN products p ON p.product_id = oi.orderItems_product_id
    INNER JOIN categories c ON c.category_id = p.category_id
    WHERE o.orders_tracking_no = '$tracking_number'
    GROUP BY oi.orderItems_order_id";

    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    $cart_qty = $row['total_qty'];
    return $cart_qty;
}

function sellerGetOrderedItemQty($tracking_number)
{
    global $con;
    $user_id = $_SESSION['auth_user']['user_ID'];
    $query = "SELECT oi.orderItems_order_id, SUM(oi.orderItems_qty) AS total_qty
    FROM order_items oi
    INNER JOIN orders o ON oi.orderItems_order_id = o.orders_id
    INNER JOIN products p ON p.product_id = oi.orderItems_product_id
    INNER JOIN categories c ON c.category_id = p.category_id
    WHERE o.orders_tracking_no = '$tracking_number' AND c.category_user_ID = '$user_id'
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
