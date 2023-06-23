<?php
session_start();
include('../config/dbcon.php');
include('myFunctions.php');
/* require */

if (isset($_SESSION['auth'])) {
    if (isset($_POST['placeOrderBtn'])) {
        $fName = mysqli_real_escape_string($con, $_POST['fullName']);
        $email = mysqli_real_escape_string($con, $_POST['emailAddress']);
        $cpNum = mysqli_real_escape_string($con, $_POST['phoneNumber']);
        $pCode = mysqli_real_escape_string($con, $_POST['postalCode']);
        $fAddr = mysqli_real_escape_string($con, $_POST['fullAddress']);
        $pay_mode = mysqli_real_escape_string($con, $_POST['paymentMode']);
        /* $payment_id = mysqli_real_escape_string($con, $_POST['paymentID']); */
        $payment_id = rand(1111, 99999) . substr($cpNum, 2);

        $phonePatternPH = '/^09\d{9}$/';

        if ($fName == "" || $email == "" || $cpNum == "" || $pCode == "" || $fAddr == "") {
            redirect("../checkOut.php", "All fields are mandatory");
        }

        if (!preg_match($phonePatternPH, $cpNum)) {
            redirect("../checkOut.php", "Invalid Philippine phone number format");
        } else {

            $user_ID = $_SESSION['auth_user']['user_ID'];
            $query = "SELECT c.cart_id as cid, c.product_id, c.product_qty, p.product_id as pid, p.product_name, p.product_image, p.product_srp, cat.category_name FROM carts c
            INNER JOIN products p ON c.product_id = p.product_id
            INNER JOIN categories cat ON p.category_id = cat.category_id
            WHERE c.user_ID='$user_ID'
            ORDER BY c.cart_id DESC";
            $query_run = mysqli_query($con, $query);

            $totalPrice = 0;
            if ($query_run) {
                while ($cItem = mysqli_fetch_assoc($query_run)) {
                    $totalPrice += $cItem['product_srp'] * $cItem['product_qty'];
                }
            }

            $tracking_no = "nrcrCtr" . rand(1111, 9999) . substr($cpNum, 2);
            $placeOrder_query = "INSERT INTO orders(orders_tracking_no, orders_user_ID, orders_full_name, orders_email, orders_phone, orders_address, orders_postal_code,
            orders_total_price, orders_payment_mode, orders_payment_id)
            VALUES('$tracking_no','$user_ID', '$fName','$email','$cpNum','$fAddr','$pCode','$totalPrice', '$pay_mode', '$payment_id')";
            $placeOrder_query_run = mysqli_query($con, $placeOrder_query);

            if ($placeOrder_query_run) {
                $order_id = mysqli_insert_id($con);
                foreach ($query_run as $cItem) {
                    $prod_id = $cItem['product_id'];
                    $prod_qty = $cItem['product_qty'];
                    $prod_price = $cItem['product_srp'];

                    $insert_items_query = "INSERT INTO order_items(orderItems_order_id, orderItems_product_id, orderItems_qty, orderItems_price)
                    VALUES('$order_id','$prod_id','$prod_qty','$prod_price')";
                    $insert_items_query_run = mysqli_query($con, $insert_items_query);

                    $product_query = "SELECT * FROM products WHERE product_id='$prod_id' LIMIT 1";
                    $product_query_run = mysqli_query($con, $product_query);

                    $productData = mysqli_fetch_array($product_query_run);
                    $currentQty = $productData['product_qty'];

                    $newQty = $currentQty - $prod_qty;

                    $updateQty_query = "UPDATE products SET product_qty='$newQty' WHERE product_id='$prod_id' ";
                    $updateQty_query_run = mysqli_query($con, $updateQty_query);
                }

                $deleteCartQuery = "DELETE FROM carts WHERE user_ID='$user_ID'";
                $deleteCartQuery_run = mysqli_query($con, $deleteCartQuery);

                redirectSwal("../myOrders.php", "Order Placed Successfully", "success");
                die();
            }
        }
    }
} else {
    redirectSwal("../index.php", "Something went wrong", "error");
}
