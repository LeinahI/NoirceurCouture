<?php
session_start();
date_default_timezone_set('Asia/Manila');
include('../../models/dbcon.php');
include('../../models/myFunctions.php');

if (isset($_POST['banCategoryBtn'])) { //!BAN Category
    $categoryID = $_POST['categID'];
    $categoryUserID = $_POST['categUserID'];
    $banConfirm = 1;

    /* Check if user is already ban */
    $check_ban_query = "SELECT categBan_category_id FROM categories_banned WHERE categBan_category_id = ?";
    $check_ban_stmt = mysqli_prepare($con, $check_ban_query);
    mysqli_stmt_bind_param($check_ban_stmt, 'i', $categoryID);
    mysqli_stmt_execute($check_ban_stmt);
    $check_ban_result = mysqli_stmt_get_result($check_ban_stmt);

    if (mysqli_num_rows($check_ban_result) > 0) {
        redirectSwal("../category.php", "User has already been banned", "error");
    } else {
        //! BAN Category 
        $update_category_query = "UPDATE categories SET category_isBan=? WHERE category_id=?";
        $stmt_category = mysqli_prepare($con, $update_category_query);
        mysqli_stmt_bind_param($stmt_category, "ii", $banConfirm, $categoryID);
        $update_category_query_run = mysqli_stmt_execute($stmt_category);

        //! BAN User 
        $update_user_query = "UPDATE users SET user_isBan=? WHERE user_ID=?";
        $stmt_user = mysqli_prepare($con, $update_user_query);
        mysqli_stmt_bind_param($stmt_user, "ii", $banConfirm, $categoryUserID);
        $update_query_run = mysqli_stmt_execute($stmt_user);

        //! add banned Category on category_banned tbl
        $insert_userCateg_query = "INSERT INTO categories_banned (categBan_category_id, categBan_userID) VALUES('$categoryID','$categoryUserID')";
        $insert_userCateg_query_run = mysqli_query($con, $insert_userCateg_query);

        //! add banned users on users_banned tbl
        $insert_user_query = "INSERT INTO users_banned (ban_user_ID) VALUES('$categoryUserID')";
        $insert_user_query_run = mysqli_query($con, $insert_user_query);

        if ($insert_userCateg_query_run) {
            // Insertion successful, proceed with the update
            if ($update_query_run) {
                redirectSwal("../category.php", "Store has been banned", "success");
            } else {
                redirectSwal("../category.php", "Something went wrong with the update", "error");
            }
        } else {
            // Insertion failed, do not proceed with the update
            redirectSwal("../category.php", "Something went wrong with the insertion", "error");
        }
    }
} else if (isset($_POST['revertBanCategoryBtn'])) { //!REVERT BAN Category
    $categoryID = $_POST['categID'];
    $categoryUserID = $_POST['categUserID'];
    $revertBanConfirm = 0;

    /* Check if user is already ban */
    $check_ban_query = "SELECT categBan_category_id FROM categories_banned WHERE categBan_category_id = ?";
    $check_ban_stmt = mysqli_prepare($con, $check_ban_query);
    mysqli_stmt_bind_param($check_ban_stmt, 'i', $categoryID);
    mysqli_stmt_execute($check_ban_stmt);
    $check_ban_result = mysqli_stmt_get_result($check_ban_stmt);

    if (mysqli_num_rows($check_ban_result) < 0) {
        redirectSwal("../category.php", "User is not banned", "error");
    } else {
        //! REVERT BAN Category 
        $update_category_query = "UPDATE categories SET category_isBan=? WHERE category_id=?";
        $stmt_category = mysqli_prepare($con, $update_category_query);
        mysqli_stmt_bind_param($stmt_category, "ii", $revertBanConfirm, $categoryID);
        $update_category_query_run = mysqli_stmt_execute($stmt_category);

        //! REVERT BAN User 
        $update_user_query = "UPDATE users SET user_isBan=? WHERE user_ID=?";
        $stmt_user = mysqli_prepare($con, $update_user_query);
        mysqli_stmt_bind_param($stmt_user, "ii", $revertBanConfirm, $categoryUserID);
        $update_query_run = mysqli_stmt_execute($stmt_user);

        //! DELETE banned Category on category_banned tbl
        $insert_userCateg_query = "DELETE FROM categories_banned WHERE categBan_category_id = $categoryID";
        $insert_userCateg_query_run = mysqli_query($con, $insert_userCateg_query);

        //! DELETE banned users on users_banned tbl
        $insert_user_query = "DELETE FROM users_banned WHERE ban_user_ID = $categoryUserID";
        $insert_user_query_run = mysqli_query($con, $insert_user_query);

        if ($insert_userCateg_query_run) {
            // Insertion successful, proceed with the update
            if ($update_query_run) {
                redirectSwal("../category.php", "Store ban status has been reverted", "success");
            } else {
                redirectSwal("../category.php", "Something went wrong with the update", "error");
            }
        } else {
            // Insertion failed, do not proceed with the update
            redirectSwal("../category.php", "Something went wrong with the insertion", "error");
        }
    }
}
