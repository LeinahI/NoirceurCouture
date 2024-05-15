<?php
session_start();
include('dbcon.php');

if (isset($_SESSION['auth'])) {
    if (isset($_POST['scope'])) {
        $scope = $_POST['scope'];
        switch ($scope) {
            case "addLikes":
                $user_id = $_SESSION['auth_user']['user_ID'];
                $prod_id = $_POST['product_id'];
                $prod_slug = $_POST['product_slug'];

                $chk_existing_cart = "SELECT * FROM likes WHERE product_id='$prod_id' AND user_ID='$user_id' ";
                $chk_existing_cart_run = mysqli_query($con, $chk_existing_cart);

                if (mysqli_num_rows($chk_existing_cart_run) > 0) {
                    echo "existing";
                } else {
                    $insert_query = "INSERT INTO likes(user_ID, product_id, product_slug)
                    VALUES ('$user_id','$prod_id','$prod_slug')";

                    $insert_query_run = mysqli_query($con, $insert_query);

                    if ($insert_query_run) {
                        echo 201;
                    } else {
                        echo 500;
                    }
                }
                break;
            case "deleteLike":
                $user_id = $_SESSION['auth_user']['user_ID'];
                $like_id = $_POST['like_id'];

                $chk_existing_cart = "SELECT * FROM likes WHERE likes_id='$like_id' AND user_ID='$user_id' ";
                $chk_existing_cart_run = mysqli_query($con, $chk_existing_cart);

                if (mysqli_num_rows($chk_existing_cart_run) > 0) {
                    $delete_query = "DELETE FROM likes WHERE likes_id='$like_id'";
                    $delete_query_run = mysqli_query($con, $delete_query);
                    if ($delete_query_run) {
                        echo 200;
                    } else {
                        echo 500;
                    }
                } else {
                    echo "Something went wrong";
                }
                break;
            default:
                echo 500;
        }
    }
} else {
    echo 401;
}
