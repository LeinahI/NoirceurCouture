<?php
session_start();
include('dbcon.php');
include('myFunctions.php');
include('dataEncryption.php');
/* require */

if (isset($_SESSION['auth'])) {
    if (isset($_POST['placeOrderBtn'])) {
        $fName = isset($_POST['fullName']) ? mysqli_real_escape_string($con, $_POST['fullName']) : "";
        $cpNum = isset($_POST['phoneNumber']) ? mysqli_real_escape_string($con, $_POST['phoneNumber']) : "";
        $email = isset($_POST['emailAddress']) ? mysqli_real_escape_string($con, $_POST['emailAddress']) : "";
        $region = isset($_POST['region']) ? mysqli_real_escape_string($con, $_POST['region']) : "";
        $province = isset($_POST['province']) ? mysqli_real_escape_string($con, $_POST['province']) : "";
        $city = isset($_POST['city']) ? mysqli_real_escape_string($con, $_POST['city']) : "";
        $barangay = isset($_POST['barangay']) ? mysqli_real_escape_string($con, $_POST['barangay']) : "";
        $fAddr = isset($_POST['fullAddress']) ? mysqli_real_escape_string($con, $_POST['fullAddress']) : "";

        $encryptedfAddr = encryptData($fAddr);

        $pay_mode = mysqli_real_escape_string($con, $_POST['paymentMode']);
        $payment_id = mysqli_real_escape_string($con, $_POST['paymentID']);

        $phonePatternPH = '/^09\d{9}$/';

        if ($fName == "" || $email == "" || $cpNum == "" || $fAddr == "") {
            redirect("../views/checkOut.php", "All fields are mandatory");
        }

        if (!preg_match($phonePatternPH, $cpNum)) {
            redirect("../views/checkOut.php", "Invalid Philippine phone number format");
        } else {

            $user_ID = $_SESSION['auth_user']['user_ID'];
            $query = "SELECT c.cart_id, c.category_id, c.product_id, c.product_qty, p.product_id as pid, p.product_name, p.product_image, p.product_srp, p.product_original_price, p.product_visibility, cat.category_name FROM carts c
            INNER JOIN products p ON c.product_id = p.product_id
            INNER JOIN categories cat ON p.category_id = cat.category_id
            WHERE c.user_ID='$user_ID' AND p.product_visibility = 0
            ORDER BY c.cart_id DESC";
            $query_run = mysqli_query($con, $query);

            if ($query_run) {
                //* Initialize an empty array to hold items grouped by category_id
                $itemsByCategory = array();

                //*Loop through each row fetched from the query result
                while ($cItem = mysqli_fetch_assoc($query_run)) {
                    //* Extract the category_id of the current item
                    $category_id = $cItem['category_id'];

                    //* Check if the category_id exists as a key in the $itemsByCategory array
                    if (!array_key_exists($category_id, $itemsByCategory)) {
                        /*
                        * If the category_id does not exist, create a new array for it. This array will hold items belonging to the current category_id. 
                        */
                        $itemsByCategory[$category_id] = array();
                    }

                    //* Add the current item to the array corresponding to its category_id
                    $itemsByCategory[$category_id][] = $cItem;
                }

                foreach ($itemsByCategory as $category_id => $items) { //*Insert orders for each category
                    $totalPrice = 0;

                    foreach ($items as $item) { //* calculate total price for items in current category
                        $totalPrice += $item['product_srp'] * $item['product_qty'];
                    }

                    $tracking_no = "nrcrCtr" . substr($cpNum, 2) . rand(1111, 9999); //* Generate tracking number

                    //* Insert order for the current category
                    $placeOrder_query = "INSERT INTO orders(orders_category_id, orders_tracking_no, orders_user_ID, orders_full_name, orders_email, orders_phone, orders_address, orders_region, orders_province, orders_city, orders_barangay,
                    orders_total_price, orders_payment_mode, orders_payment_id)
                    VALUES('$category_id','$tracking_no','$user_ID', '$fName','$email','$cpNum','$encryptedfAddr', '$region', '$province','$city','$barangay','$totalPrice', '$pay_mode', '$payment_id')";
                    $placeOrder_query_run = mysqli_query($con, $placeOrder_query);

                    if ($placeOrder_query_run) {
                        //* Get the order ID
                        $order_id = mysqli_insert_id($con);

                        //* Insert order items for the current category
                        foreach ($items as $cItem) {
                            $prod_id = $cItem['product_id'];
                            $prod_qty = $cItem['product_qty'];
                            $prod_price = $cItem['product_srp'];
                            $prod_Initprice = $cItem['product_original_price'];

                            $insert_items_query = "INSERT INTO order_items(orderItems_order_id, orderItems_product_id, orderItems_qty, orderItems_Initprice, orderItems_price)
                            VALUES('$order_id','$prod_id','$prod_qty','$prod_Initprice','$prod_price')";
                            $insert_items_query_run = mysqli_query($con, $insert_items_query);

                            //* Update product quantity
                            $newQty = $cItem['product_qty'];
                            $updateQty_query = "UPDATE products SET product_qty = product_qty - $newQty WHERE product_id='$prod_id'";
                            $updateQty_query_run = mysqli_query($con, $updateQty_query);
                        }
                    }
                }
                //* After inserting orders, delete cart items
                $deleteCartQuery = "DELETE FROM carts WHERE user_ID='$user_ID'";
                $deleteCartQuery_run = mysqli_query($con, $deleteCartQuery);

                //* Redirect to show success message
                if ($pay_mode == "Cash on Delivery") {
                    redirectSwal("../views/myOrders.php", "Order(s) Placed Successfully", "success");
                    die();
                } else {
                    echo 201;
                }
            }
        }
    }
} else {
    redirectSwal("../index.php", "Something went wrong", "error");
}
