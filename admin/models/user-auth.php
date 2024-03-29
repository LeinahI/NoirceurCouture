<?php
session_start();
date_default_timezone_set('Asia/Manila');
include('../../models/dbcon.php');
include('../../models/myFunctions.php');

if (isset($_POST['banUserBtn'])) { //!BAN User
    $userId = $_POST['userID'];
    $banConfirm = 1;

    /* Check if user is already ban */
    $check_ban_query = "SELECT ban_user_ID FROM users_banned WHERE ban_user_ID = ?";
    $check_ban_stmt = mysqli_prepare($con, $check_ban_query);
    mysqli_stmt_bind_param($check_ban_stmt, 'i', $userId);
    mysqli_stmt_execute($check_ban_stmt);
    $check_ban_result = mysqli_stmt_get_result($check_ban_stmt);

    if (mysqli_num_rows($check_ban_result) > 0) {
        redirectSwal("../users.php", "User has already been banned", "error");
    } else {
        //! BAN User 
        $update_query = "UPDATE users SET user_isBan=? WHERE user_ID=?";
        $stmt = mysqli_prepare($con, $update_query);
        mysqli_stmt_bind_param($stmt, "ii", $banConfirm, $userId);
        $update_query_run = mysqli_stmt_execute($stmt);

        //! add banned users on users_banned tbl
        $insert_query = "INSERT INTO users_banned (ban_user_ID) VALUES('$userId')";
        $insert_query_run = mysqli_query($con, $insert_query);

        //* Also ban User Category if exist
        $update_category_query = "UPDATE categories SET category_isBan=? WHERE category_user_ID=?";
        $stmt_category = mysqli_prepare($con, $update_category_query);
        mysqli_stmt_bind_param($stmt_category, "ii", $banConfirm, $userId);
        $update_category_query_run = mysqli_stmt_execute($stmt_category);

        //*Select category_id from database to put it from categories_banned
        $select_category_query = "SELECT category_id FROM categories WHERE `category_user_ID` = '$userId' LIMIT 1";
        $select_category_query_run = mysqli_query($con, $select_category_query);
        $category_row = mysqli_fetch_assoc($select_category_query_run);
        $categoryID = $category_row['category_id'];

        //* Also banned Category on category_banned tbl
        $insert_userCateg_query = "INSERT INTO categories_banned (categBan_category_id, categBan_userID) VALUES('$categoryID','$userId')";
        $insert_userCateg_query_run = mysqli_query($con, $insert_userCateg_query);

        if ($insert_query_run) {
            // Insertion successful, proceed with the update
            if ($update_query_run) {
                redirectSwal("../users.php", "User has been banned", "success");
            } else {
                redirectSwal("../users.php", "Something went wrong with the update", "error");
            }
        } else {
            // Insertion failed, do not proceed with the update
            redirectSwal("../users.php", "Something went wrong with the insertion", "error");
        }
    }
}
