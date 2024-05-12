<?php
include('dbcon.php');

function hideEmailCharacters($email)
{
    $parts = explode('@', $email);
    $username = $parts[0];
    $domain = $parts[1];
    
    // Get the first character of the username
    $firstChar = substr($username, 0, 1);
    
    // Get the last character of the username
    $lastChar = substr($username, -1);
    
    // Replace characters between the first and last characters with asterisks
    $hiddenUsername = $firstChar . str_repeat('*', strlen($username) - 2) . $lastChar;
    
    return $hiddenUsername . '@' . $domain;
}

//Generate OTP for Buyer account
function verificationCode($length = 6)
{
    $otp = '';
    for ($i = 0; $i < $length; $i++) {
        $otp .= mt_rand(0, 9);
    }
    return $otp;
}

function generateToken($length = 32)
{
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $Acode = '';
    for ($i = 0; $i < $length; $i++) {
        $Acode .= $characters[mt_rand(0, strlen($characters) - 1)];
    }
    return $Acode;
}

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

function getSellerNotifications() //+For Seller
{
    global $con;
    $user_id = $_SESSION['auth_user']['user_ID'];
    $query = "SELECT * FROM notification where receiver_id ='$user_id' ORDER BY notif_CreatedAt DESC";
    $result = mysqli_query($con, $query);
    return $result;
}

function getProductRatingsByProductIDOnAdmin($id) //+For Seller/Admin
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

function calculateAverageRatingOnAdmin($reviews) //+For Seller/Admin
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

function getRatingCountByProductIDOnAdmin($id) //+For Seller/Admin
{
    global $con;
    $query = "SELECT COUNT(pr.product_id) as ratingCount 
    FROM products_reviews pr 
    JOIN products p ON pr.product_id= p.product_id
    WHERE pr.product_id = '$id'";
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

function getAllConfirmedDeletedUsers()
{
    global $con;
    $query = "SELECT * FROM users_deleted_details WHERE ud_confirmed = 1";
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
//+ Admin Orders Function
 ********************************/
/* 
0 - Preparing to ship
1 - Parcel is out for delivery
2 - Parcel has been delivered
3 - Parcel has been cancelled
 */
function getAllBuyersList()
{
    global $con;
    $query = "SELECT COUNT(*) as total_buyers FROM users WHERE user_role = 0";
    $query_run = mysqli_query($con, $query);
    return $query_run;
}
function getAllSellerList()
{
    global $con;
    $query = "SELECT COUNT(*) as total_sellers FROM users u
    JOIN users_seller_details usd ON u.user_ID = usd.seller_user_ID
    WHERE user_role = 2 AND usd.seller_confirmed = 1";
    $query_run = mysqli_query($con, $query);
    return $query_run;
}
function getAllBannedBuyer()
{
    global $con;
    $query = "SELECT COUNT(*) as total_ban_buyer FROM users WHERE user_role = 0 AND user_isBan = 1";
    $query_run = mysqli_query($con, $query);
    return $query_run;
}
function getAllBannedSeller()
{
    global $con;
    $query = "SELECT COUNT(*) as total_stores FROM categories c
    JOIN users u ON c.category_user_ID = u.user_ID
    WHERE u.user_role = 2 AND c.category_isBan = 1";
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
    $query = "SELECT 
    o.orders_id, 
    o.orders_full_name, 
    o.orders_tracking_no, 
    o.orders_createdAt
    FROM orders o
    JOIN categories c ON o.orders_category_id = c.category_id
    WHERE c.category_user_ID = '$id'";
    $query_run = mysqli_query($con, $query);
    return $query_run;
}

function getAllPreparingOrdersbyStore($id)
{
    global $con;
    $query = "SELECT DISTINCT o.orders_id, o.orders_full_name, o.orders_tracking_no, o.orders_createdAt, o.orders_tracking_no, o.orders_status
    FROM orders o
    JOIN categories c ON o.orders_category_id = c.category_id
    WHERE c.category_user_ID = '$id' AND o.orders_status='0'";
    $query_run = mysqli_query($con, $query);
    return $query_run;
}

function getAllShippedOutOrdersbyStore($id)
{
    global $con;
    $query = "SELECT DISTINCT o.orders_id, o.orders_full_name, o.orders_tracking_no, o.orders_createdAt, o.orders_tracking_no, o.orders_status
    FROM orders o
    JOIN categories c ON orders_category_id = c.category_id
    WHERE c.category_user_ID = '$id' AND o.orders_status='1'";
    $query_run = mysqli_query($con, $query);
    return $query_run;
}

function getAllDeliveredOrdersbyStore($id)
{
    global $con;
    $query = "SELECT DISTINCT o.*
    FROM orders o
    JOIN categories c ON o.orders_category_id = c.category_id
    WHERE c.category_user_ID = '$id' AND o.orders_status='2'";
    $query_run = mysqli_query($con, $query);
    return $query_run;
}

function getAllCancelledOrdersbyStore($id)
{
    global $con;
    $query = "SELECT DISTINCT o.*
    FROM orders o
    JOIN categories c ON o.orders_category_id = c.category_id
    WHERE c.category_user_ID = '$id' AND o.orders_status='3'";
    $query_run = mysqli_query($con, $query);
    return $query_run;
}
/********************************
 ************Seller and Admin Reports Dashboard start
 ********************************/

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

function sellerGetOrderedItemQty($tracking_number)
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

// Function to encrypt data
function encryptData($data)
{
    $cipher_algo = 'aes-256-cbc'; //+ Set the cipher algorithm to AES-256-CBC
    $key = 'NZhJtqrGwocU9CHdBP6tHYB0CUaiX8UJ'; //+ Set the encryption key 
    $options = 0; //+ Choose the cipher method and options
    $iv_length = openssl_cipher_iv_length($cipher_algo); //+ Get the length of the initialization vector (IV) for the chosen cipher algorithm
    $iv = openssl_random_pseudo_bytes($iv_length); //+ // Generate a random IV (Initialization Vector)

    $encryptedData = openssl_encrypt($data, $cipher_algo, $key, $options, $iv); //+ Encrypt the data using OpenSSL encrypt function

    $encryptedDataWithIV = base64_encode($iv . $encryptedData); //+ Combine IV and encrypted data and encode it using base64

    return $encryptedDataWithIV; //+ Return the encrypted data with IV
}

function generateSlug($string, $uniqueIdentifier = null)
{
    // Convert accented characters to ASCII
    $string = iconv('UTF-8', 'ASCII//TRANSLIT', $string);

    // Replace non-alphanumeric characters with dashes
    $string = preg_replace('/[^a-z0-9]+/', '-', strtolower($string));

    // Remove leading/trailing dashes
    $string = trim($string, '-');

    // Check if the string already contains a Unix timestamp
    if (preg_match('/-\d{10}$/', $string)) {
        // If it does, remove the existing timestamp
        $string = preg_replace('/-\d{10}$/', '', $string);
    }

    // Append unique identifier if provided
    if ($uniqueIdentifier !== null) {
        $string .= '-' . $uniqueIdentifier;
    }

    return $string;
}

// Function to decrypt data
function decryptData($encryptedData)
{
    $cipher_algo = 'aes-256-cbc'; //+ Set the cipher algorithm to AES-256-CBC
    $key = 'NZhJtqrGwocU9CHdBP6tHYB0CUaiX8UJ'; //+ Set the encryption key
    $options = 0; //+ Choose the cipher method and options
    $encryptedDataWithIV = base64_decode($encryptedData);  //+ Decode the base64-encoded string to extract IV and encrypted data
    $iv_length = openssl_cipher_iv_length($cipher_algo); //+ Get the length of the initialization vector (IV) for the chosen cipher algorithm
    $iv = substr($encryptedDataWithIV, 0, $iv_length); //+ Extract IV from the combined IV and encrypted data string

    $encrptedDataWithoutIV = substr($encryptedDataWithIV, $iv_length); //+ Extract encrypted data after IV

    $decryptedData = openssl_decrypt($encrptedDataWithoutIV, $cipher_algo, $key, $options, $iv); //+ Decrypt the data using OpenSSL decrypt function

    return $decryptedData; //+ Return the decrypted data
}


include(__DIR__ . '/../partials/scripts.php');
