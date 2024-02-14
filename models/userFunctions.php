<?php
/* session_start(); */
include('dbcon.php');
ob_start(); //Ouput buffering
date_default_timezone_set('Asia/Manila');

function getAllActive($table)
{
    global $con;
    $query = "SELECT * FROM $table WHERE category_onVacation='0' AND category_isBan='0'";
    $query_run = mysqli_query($con, $query);
    return $query_run; // Return the query result, not the query itself
}

function getAllPopular() /* Trending */
{
    global $con;
    $query = "SELECT * FROM products WHERE product_popular='1' AND product_visibility != '1'";
    $query_run = mysqli_query($con, $query);
    return $query_run; // Return the query result, not the query itself
}

function getAllSameShop($id) /* Trending */
{
    global $con;
    $query = "SELECT * FROM products WHERE category_id='$id' AND product_visibility != '1'";
    $query_run = mysqli_query($con, $query);
    return $query_run; // Return the query result, not the query itself
}

function getProdByCategory($category_id)
{
    global $con;
    $query = "SELECT p.*, c.category_onVacation, c.category_isBan FROM products p
    JOIN categories c ON p.category_id = c.category_id
    WHERE p.category_id = '$category_id' AND p.product_visibility='0'";
    $result = mysqli_query($con, $query);
    return $result;
}

function getCategoryByID($category_id)
{
    global $con;
    $query = "SELECT * FROM categories WHERE category_id = '$category_id'";
    $result = mysqli_query($con, $query);
    return $result;
}

function getProductRatingsByProductID($id)
{
    global $con;
    $query = "SELECT pr.*, u.user_username, u.user_profile_image
    FROM products_reviews pr
    INNER JOIN orders o ON pr.orders_tracking_no = o.orders_tracking_no
    INNER JOIN products p ON pr.product_id =p.product_id
    LEFT JOIN users u ON pr.user_ID = u.user_ID
    WHERE pr.product_id = '$id'
    ORDER BY PR.review_createdAt DESC";
    $result = mysqli_query($con, $query);
    return $result;
}

function getSoldCountByProductID($id)
{
    global $con;
    $query = "SELECT COUNT(oi.orderItems_product_id) as itemSold 
    FROM order_items oi 
    JOIN orders o ON oi.orderItems_order_id = o.orders_id 
    WHERE oi.orderItems_product_id = '$id' AND o.orders_status = 2";
    $result = mysqli_query($con, $query);
    return $result;
}

function getRatingCountByProductID($id)
{
    global $con;
    $query = "SELECT COUNT(pr.product_id) as ratingCount 
    FROM products_reviews pr 
    JOIN products p ON pr.product_id= p.product_id
    WHERE pr.product_id = '$id'";
    $result = mysqli_query($con, $query);
    return $result;
}

// Function to calculate average rating
function calculateAverageRating($reviews)
{
    $totalRating = 0;
    $numberOfReviews = mysqli_num_rows($reviews);

    while ($row = mysqli_fetch_assoc($reviews)) {
        $totalRating += $row['product_rating'];
    }

    if ($numberOfReviews > 0) {
        $averageRating = $totalRating / $numberOfReviews;
        return $averageRating;
    } else {
        return 0; // Return 0 if there are no reviews
    }
}

function getSlugActiveCategories($slug)
{
    global $con;
    $query = "SELECT * FROM categories WHERE category_slug = '$slug' LIMIT 1";
    $result = mysqli_query($con, $query);
    return $result;
}

function getProductsCountByCategoryByID($category_id)
{
    global $con;
    $query = "SELECT COUNT(*) AS allproduct FROM products WHERE category_id = '$category_id' AND product_visibility = 0";
    $result = mysqli_query($con, $query);
    return $result;
}

function getSellerStateCityByCategoryByID($category_id)
{
    global $con;
    $query = "SELECT adr.address_barangay, adr.address_region, adr.address_province, adr.address_city FROM addresses AS adr
    JOIN users AS u ON adr.address_user_ID = u.user_ID
    JOIN categories AS c ON u.user_ID = c.category_user_ID
    WHERE c.category_id = '$category_id'";
    $result = mysqli_query($con, $query);
    return $result;
}
function getSellerProductRatingsByCategoryByID($category_id)
{
    global $con;
    $query = "SELECT 
	COUNT(pr.product_rating) AS ratings_count,
    ROUND(SUM(pr.product_rating) / COUNT(*), 1) AS overall_rating
    FROM products_reviews pr
    INNER JOIN orders o ON pr.orders_tracking_no = o.orders_tracking_no
    INNER JOIN products p ON pr.product_id = p.product_id
    INNER JOIN categories c ON p.category_id = c.category_id
    WHERE c.category_id = '$category_id'";
    $result = mysqli_query($con, $query);
    return $result;
}

function getSlugActiveProducts($table, $slug)
{
    global $con;
    $query = "SELECT p.*, c.category_onVacation, c.category_isBan
            FROM $table p
            JOIN categories c ON p.category_id = c.category_id
            WHERE product_slug = '$slug' LIMIT 1";
    $result = mysqli_query($con, $query);
    return $result;
}
function deleteExcessCartItems($user_id)
{
    global $con;
    $deleteQuery = "DELETE c
    FROM carts c
    INNER JOIN products p ON c.product_id = p.product_id
    WHERE c.user_ID = '$user_id' AND c.product_qty > p.product_qty;
    ";

    $result = mysqli_query($con, $deleteQuery);

    if (!$result) {
        // Handle the case where the query failed
        echo "Delete query failed: " . mysqli_error($con);
    }
}

function getCartItems()
{
    global $con;
    $user_id = $_SESSION['auth_user']['user_ID'];

    deleteExcessCartItems($user_id);

    $query = "SELECT c.cart_id as cid, c.product_id, c.product_qty, c.product_slug, p.product_id as pid, p.product_name, p.product_image,
    p.product_srp, p.product_original_price, p.product_discount, p.product_qty as product_remain, cat.category_name, cat.category_slug
    FROM carts c
    INNER JOIN products p ON c.product_id = p.product_id
    INNER JOIN categories cat ON p.category_id = cat.category_id
    WHERE c.user_ID='$user_id'AND p.product_qty >= c.product_qty  
    ORDER BY c.cart_id DESC;";

    $result = mysqli_query($con, $query);
    return $result;
}

function getOrderedItems()
{
    global $con;
    $user_id = $_SESSION['auth_user']['user_ID'];

    $query = "SELECT o.orders_id as oid, o.orders_tracking_no, o.orders_user_ID, o.orders_last_update_time, o.orders_status, oi.*, p.*, c.category_name, c.category_slug
        FROM orders o
        INNER JOIN order_items oi ON oi.orderItems_order_id = o.orders_id
        INNER JOIN products p ON p.product_id = oi.orderItems_product_id
        INNER JOIN categories c ON c.category_id = p.category_id
        WHERE o.orders_user_ID = '$user_id' ORDER BY orders_id DESC";

    $result = mysqli_query($con, $query);
    return $result;
}
function getOrderIsRated($trackingNo)
{
    global $con;
    $query = "SELECT orders_tracking_no, review_isReviewed AS israted
    FROM products_reviews pr
    WHERE pr.review_isReviewed = 1 AND pr.orders_tracking_no ='$trackingNo'";

    $result = mysqli_query($con, $query);
    return $result;
}

function getCartQty()
{
    global $con;
    $user_id = $_SESSION['auth_user']['user_ID'];
    $query = "SELECT COUNT(*) AS total_entries
    FROM carts c
    INNER JOIN products p ON c.product_id = p.product_id
    WHERE user_ID = '$user_id' AND p.product_qty >= c.product_qty ";

    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    $cart_qty = $row['total_entries'];

    return $cart_qty;
}



function getLikesItems()
{
    global $con;
    $user_id = $_SESSION['auth_user']['user_ID'];
    $query = "SELECT l.likes_Id as lid, l.product_id, l.product_slug, p.product_id as pid, p.product_name, p.product_image, p.product_srp, cat.category_name, cat.category_slug
    FROM likes l
    INNER JOIN products p ON l.product_id = p.product_id
    INNER JOIN categories cat ON p.category_id = cat.category_id
    WHERE l.user_ID='$user_id'
    ORDER BY l.likes_Id DESC";

    $result = mysqli_query($con, $query);
    return $result;
}

function getLikesQty()
{
    global $con;
    $user_id = $_SESSION['auth_user']['user_ID'];
    $query = "SELECT COUNT(*) AS total_entries
          FROM likes
          WHERE user_ID = '$user_id'";

    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    $cart_qty = $row['total_entries'];

    return $cart_qty;
}

function getAllItemQty()
{
    global $con;
    $user_id = $_SESSION['auth_user']['user_ID'];
    $query = "SELECT SUM(product_qty) AS total_qty
    FROM carts
    WHERE user_ID='$user_id'";

    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    $cart_qty = $row['total_qty'];

    return $cart_qty;
}

function getUserDetails()
{
    global $con;
    $user_id = $_SESSION['auth_user']['user_ID'];
    $query = "SELECT * FROM users where user_ID ='$user_id'";
    $result = mysqli_query($con, $query);
    return $result;
}

function getUserAddress($user_id)
{
    global $con;
    $query = "SELECT 
        (SELECT COUNT(*) FROM addresses WHERE address_user_ID = ?) AS addrUserQTY,
        a.*, 
        u.user_ID
        FROM 
        addresses AS a
        INNER JOIN 
        users AS u ON a.address_user_ID = u.user_ID
        WHERE 
        a.address_user_ID = ?
        ORDER BY 
        address_isDefault DESC";

    $stmt = mysqli_prepare($con, $query);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ii", $user_id, $user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);
        return $result;
    } else {
        // Handle query preparation error
        return false;
    }
}

function getDefaultUserAddress($user_id)
{
    global $con;
    $query = "SELECT
        a.*, 
        u.user_ID
        FROM 
        addresses AS a
        INNER JOIN 
        users AS u ON a.address_user_ID = u.user_ID
        WHERE 
        a.address_user_ID = ? AND a.address_isDefault = 1";

    $stmt = mysqli_prepare($con, $query);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);
        return $result;
    } else {
        // Handle query preparation error
        return false;
    }
}

function getUserAddressByaddrID($addrID)
{
    global $con;
    $query = "SELECT 
    a.*, 
    u.user_ID
    FROM 
    addresses AS a
    INNER JOIN 
    users AS u ON a.address_user_ID = u.user_ID
    WHERE 
    a.address_id = ?";

    $stmt = mysqli_prepare($con, $query);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $addrID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);
        return $result;
    } else {
        // Handle query preparation error
        return false;
    }
}

function checkItemExists()
{
    global $con;
    $user_id = $_SESSION['auth_user']['user_ID'];
    $query = "SELECT * FROM carts WHERE user_ID='$user_id'";
    $result = mysqli_query($con, $query);
    return $result;
}

function getOrders()
{
    global $con;
    $user_id = $_SESSION['auth_user']['user_ID'];
    $query = "SELECT * FROM orders WHERE orders_user_ID='$user_id' ORDER BY orders_id DESC";
    $result = mysqli_query($con, $query);
    return $result;
}

function checkTrackingNumValid($trackingNo)
{
    global $con;
    $user_id = $_SESSION['auth_user']['user_ID'];
    $query = "SELECT * FROM orders WHERE orders_tracking_no='$trackingNo' AND orders_user_ID='$user_id' ";
    return mysqli_query($con, $query);
}

function getOrderedItemQty($tracking_number)
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



function redirect($url, $Errormsg)
{
    $_SESSION['Errormsg'] = $Errormsg;
    header('Location: ' . $url);
    exit();
}

function redirectSwal($url, $status, $status_code)
{
    $_SESSION['status'] = $status;
    $_SESSION['status_code'] = $status_code;
    header('Location: ' . $url);
    exit();
}
