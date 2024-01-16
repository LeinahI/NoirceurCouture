<?php
session_start();
include('../../models/dbcon.php');

function getAdminProductsCount($userId, $categoryId)
{
    global $con;
    $query = "SELECT 
        p.product_id,
        p.category_id,
        SUM(p.product_qty) AS total_prod_qty
        FROM products p
        JOIN categories c ON p.category_id = c.category_id
        WHERE c.category_user_ID = ? AND c.category_id = ?";

    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "ii", $userId, $categoryId);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);

    return $result;
}

function getAdminRevenue($userId, $categoryId)
{
    global $con;
    $query = "SELECT 
    p.product_id,
    p.category_id,
    p.product_srp,
    SUM(p.product_qty * p.product_srp) AS total_if_sold
    FROM products p
    JOIN categories c ON p.category_id = c.category_id
    WHERE c.category_user_ID = ? AND c.category_id = ?";

    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "ii", $userId, $categoryId);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);

    return $result;
}

function getCancelledOrdersCount($userId, $categoryId)
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
        WHERE c.category_user_ID = ? AND orders_status = 3 AND c.category_id = ?";

    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "ii", $userId, $categoryId);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);

    return $result;
}

function getAdminRevenueDeliver($userId, $categoryId)
{
    global $con;
    $query = "SELECT SUM(orders_total_price) AS total_orders_price
    FROM orders o
    JOIN order_items oi ON o.orders_id = oi.orderItems_order_id
    JOIN products p ON oi.orderItems_product_id = p.product_id
    JOIN categories c ON p.category_id = c.category_id
    WHERE c.category_user_ID = ? AND o.orders_status = 2 AND c.category_id = ?";

    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "ii", $userId, $categoryId);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);

    return $result;
}

function getAdminTrendingItem($userId, $categoryId)
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
    WHERE c.category_user_ID = ? AND o.orders_status = 2 AND c.category_id = ?
    GROUP BY oi.orderItems_order_id
    ORDER BY trending DESC
    LIMIT 1";

    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "ii", $userId, $categoryId);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);

    return $result;
}

function getAdminTrendingItemSold($userId, $categoryId)
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
    WHERE c.category_user_ID = ? AND o.orders_status = 2 AND c.category_id = ?
    GROUP BY oi.orderItems_product_id
    ORDER BY item_sold DESC
    LIMIT 1";

    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "ii", $userId, $categoryId);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);

    return $result;
}

function getByAdminCategAndUserId($userId, $categoryId)
{
    global $con;
    $query = "SELECT 
    u.user_ID,
    c.category_user_ID,
    c.category_name,
    c.category_image
    FROM users u
    LEFT JOIN categories c ON u.user_ID = c.category_user_ID
    WHERE u.user_ID = ? AND c.category_id = ? ";

    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "ii", $userId, $categoryId);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);

    return $result;
}

// Set default values for $userId and $categoryId
$userId = isset($_POST['userID']) ? $_POST['userID'] : 0;
$categoryId = isset($_POST['categoryId']) ? $_POST['categoryId'] : 0;

if (isset($_POST['categoryId']) && isset($_POST['userID'])) {
    try {
        $productCountResult = getAdminProductsCount($userId, $categoryId);
        $productCount = mysqli_fetch_assoc($productCountResult);

        $revenueResult = getAdminRevenue($userId, $categoryId);
        $revenueTotal = mysqli_fetch_assoc($revenueResult);

        $cancelResult = getCancelledOrdersCount($userId, $categoryId);
        $cancelTotal = mysqli_fetch_assoc($cancelResult);

        $revenueDeliverResult = getAdminRevenueDeliver($userId, $categoryId);
        $revenueDeliverTotal = mysqli_fetch_assoc($revenueDeliverResult);

        $trendItem = getAdminTrendingItem($userId, $categoryId);
        $trendResult = mysqli_fetch_assoc($trendItem);

        $itemTrendSold = getAdminTrendingItemSold($userId, $categoryId);
        $itemSold = mysqli_fetch_assoc($itemTrendSold);

        $IDResult = getByAdminCategAndUserId($userId, $categoryId);
        $categoryResult = mysqli_fetch_assoc($IDResult);

        // Output the product count and revenue total as JSON
        $response = array(
            'productCount' => $productCount['total_prod_qty'] ?? '0',
            'revenueTotal' => number_format($revenueTotal['total_if_sold'] ??  '0', 2),
            'cancelTotal' => $cancelTotal['total_cancelled_orders'] ?? '0',
            'revenueDeliverTotal' => number_format($revenueDeliverTotal['total_orders_price'] ?? '0', 2),

            'trendName' => $trendResult['product_name'] ?? 'none',
            'trendPrice' => number_format($trendResult['product_srp'] ?? '0', 2),
            'trendImage' => $trendResult['product_image'] ?? 'none',

            'itemSold' => $itemSold['item_sold'] ?? '0',
            'priceSold' => number_format($itemSold['total_price_sold'] ?? '0', 2),

            'categName' => $categoryResult['category_name'] ?? 'none',
            'categImage' => $categoryResult['category_image'] ?? 'none',
        );

        echo json_encode($response);
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
} else {
    echo 'Error: Category ID or User ID not set in the POST request';
}
