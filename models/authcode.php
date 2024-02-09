<?php
include('dbcon.php');
include('myFunctions.php');
session_start();

/* User Registration statement */
if (isset($_POST['userRegisterBtn'])) {
    $fname = mysqli_real_escape_string($con, $_POST['firstName']);
    $lname = mysqli_real_escape_string($con, $_POST['lastName']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phoneNum = mysqli_real_escape_string($con, $_POST['phoneNumber']);
    $uname = mysqli_real_escape_string($con, $_POST['username']);
    $uPass = mysqli_real_escape_string($con, $_POST['userPassword']);
    $uCPass = mysqli_real_escape_string($con, $_POST['userConfirmPassword']);
    $phonePatternPH = '/^09\d{9}$/';

    $check_email_query = "SELECT user_email FROM users WHERE user_email = '$email'";
    $check_email_query_run = mysqli_query($con, $check_email_query);

    $check_uname_query = "SELECT user_username FROM users WHERE user_username = '$uname'";
    $check_uname_query_run = mysqli_query($con, $check_uname_query);

    $check_phoneNum_query = "SELECT user_phone FROM users WHERE user_phone = '$phoneNum'";
    $check_phoneNum_query_run = mysqli_query($con, $check_phoneNum_query);

    if (!preg_match($phonePatternPH, $phoneNum)) {
        redirect("../views/register.php", "Invalid Philippine phone number format");
    } else if (mysqli_num_rows($check_email_query_run) > 0) {
        redirect("../views/register.php", "Email already in use try something different");
    } else if (mysqli_num_rows($check_uname_query_run) > 0) {
        redirect("../views/register.php", "username already in use try something different");
    } else if (mysqli_num_rows($check_phoneNum_query_run) > 0) {
        redirect("../views/register.php", "phone number already in use try something different");
    } else {
        if ($uPass == $uCPass) {
            //Insert User Data
            $insert_query = "INSERT INTO users (user_firstName, user_lastName, user_email, user_phone, user_username, user_password)
                VALUES('$fname','$lname','$email','$phoneNum','$uname','$uPass')";
            $insert_query_run = mysqli_query($con, $insert_query);
            if ($insert_query_run) {
                /* Swal */
                redirectSwal("../views/login.php", "New account added", "success");
            } else {
                redirect("../views/register.php", "something went wrong");
            }
        } else {
            redirect("../views/register.php", "Passwords doesn't match");
        }
    }
}

/* Seller Registration statement */
if (isset($_POST['sellerRegisterBtn'])) {
    $fname = mysqli_real_escape_string($con, $_POST['firstName']);
    $lname = mysqli_real_escape_string($con, $_POST['lastName']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phoneNum = mysqli_real_escape_string($con, $_POST['phoneNumber']);
    $uname = mysqli_real_escape_string($con, $_POST['username']);
    $uPass = mysqli_real_escape_string($con, $_POST['userPassword']);
    $uCPass = mysqli_real_escape_string($con, $_POST['userConfirmPassword']);
    $role = 2;/* 0 = buyer, 1 = admin, 2 seller */
    $phonePatternPH = '/^09\d{9}$/';
    $sellerType = isset($_POST['sellerType']) ? mysqli_real_escape_string($con, $_POST['sellerType']) : 'individual';

    $check_email_query = "SELECT user_email FROM users WHERE user_email = '$email'";
    $check_email_query_run = mysqli_query($con, $check_email_query);

    $check_uname_query = "SELECT user_username FROM users WHERE user_username = '$uname'";
    $check_uname_query_run = mysqli_query($con, $check_uname_query);

    $check_phoneNum_query = "SELECT user_phone FROM users WHERE user_phone = '$phoneNum'";
    $check_phoneNum_query_run = mysqli_query($con, $check_phoneNum_query);

    if (!preg_match($phonePatternPH, $phoneNum)) {
        redirect("../seller/seller-registration.php", "Invalid Philippine phone number format");
    } else if (mysqli_num_rows($check_email_query_run) > 0) {
        redirect("../seller/seller-registration.php", "Email already in use try something different");
    } else if (mysqli_num_rows($check_uname_query_run) > 0) {
        redirect("../seller/seller-registration.php", "username already in use try something different");
    } else if (mysqli_num_rows($check_phoneNum_query_run) > 0) {
        redirect("../seller/seller-registration.php", "phone number already in use try something different");
    } else {
        if ($uPass == $uCPass) {
            //Insert User Data
            $insert_query = "INSERT INTO users (user_firstName, user_lastName, user_email, user_phone, user_username, user_password, user_role)
                VALUES('$fname','$lname','$email','$phoneNum','$uname','$uPass','$role')";

            $insert_query_run = mysqli_query($con, $insert_query);
            if ($insert_query_run) {
                // Get the last inserted user ID of user
                $lastUserID = mysqli_insert_id($con);

                // Insert into users_seller_details
                $seller_details_query = "INSERT INTO users_seller_details (seller_user_ID, seller_seller_type) VALUES ('$lastUserID', '$sellerType')";
                $seller_details_query_run = mysqli_query($con, $seller_details_query);

                if ($seller_details_query_run) {
                    // Redirect with success message
                    redirectSwal("../views/login.php", "Seller account added. Wait for administrator confirmation.", "success");
                } else {
                    // Handle the error and redirect
                    redirect("../seller/seller-registration.php", "Error inserting seller details: " . mysqli_error($con));
                }
            } else {
                redirect("../seller/seller-registration.php", "something went wrong");
            }
        } else {
            redirect("../seller/seller-registration.php", "Passwords doesn't match");
        }
    }
}

/* User Log in statement */
if (isset($_POST['loginBtn'])) {
    $loginInput = mysqli_real_escape_string($con, $_POST['loginInput']);
    $loginPass = mysqli_real_escape_string($con, $_POST['loginPasswordInput']);

    $login_Inputs_query = "SELECT u.*, s.seller_confirmed FROM users u
        LEFT JOIN users_seller_details s ON u.user_ID = s.seller_user_ID
        WHERE 
        (u.user_email = '$loginInput' AND u.user_password = '$loginPass')
        OR (u.user_username = '$loginInput' AND u.user_password = '$loginPass')
        OR (u.user_phone = '$loginInput' AND u.user_password = '$loginPass')";
    $login_Inputs_query_run = mysqli_query($con, $login_Inputs_query);

    if (mysqli_num_rows($login_Inputs_query_run) > 0) {
        $userdata = mysqli_fetch_array($login_Inputs_query_run);
        $userid = $userdata['user_ID'];
        $userRole = $userdata['user_role'];
        $isAccountBanned = $userdata['user_isBan'];

        if ($isAccountBanned == 1) {
            redirect('../views/login.php', 'Your account has been banned permanently');
        } else {
            $_SESSION['auth'] = true;

            $username = $userdata['user_username'];
            $fname = $userdata['user_firstName'];
            $useremail = $userdata['user_email'];
            $sellerConfirmed = $userdata['seller_confirmed'];

            $_SESSION['auth_user'] = [
                'user_ID' => $userid,
                'user_username' => $username,
                'user_firstName' => $fname,
                'user_email' => $useremail,
                'seller_confirmed' => $sellerConfirmed,
                'user_role' => $userRole,
                'user_isBan' => $isAccountBanned
            ];

            $_SESSION['user_role'] = $userRole;
            $_SESSION['seller_confirmed'] = $sellerConfirmed;
            $_SESSION['user_isBan'] = $isAccountBanned;

            if ($userRole == 1) {
                header('Location: ../admin/index.php');
            } else if ($userRole == 2) {
                $check_address_query = "SELECT * FROM addresses WHERE address_user_ID = '$userid' ";
                $check_address_query_run = mysqli_query($con, $check_address_query);

                if (mysqli_num_rows($check_address_query_run) == 0) {
                    redirectSwal('../seller/account-details.php', 'Add your pickup address first', 'warning');
                } else {
                    header('Location: ../seller/index.php');
                }
            } else if ($userRole == 0) {
                header('Location: ../views/index.php');
            }
        }
    } else {
        redirect('../views/login.php', 'Invalid Credentials. Try again');
    }
}


/* User Profile Update statement */
if (isset($_POST['userUpdateAccBtn'])) {
    $userId = mysqli_real_escape_string($con, $_POST['userID']);
    $firstName = mysqli_real_escape_string($con, $_POST['firstName']);
    $lastName = mysqli_real_escape_string($con, $_POST['lastName']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phoneNum = mysqli_real_escape_string($con, $_POST['phoneNumber']);
    $uPass = mysqli_real_escape_string($con, $_POST['userPassword']);
    $phonePatternPH = '/^09\d{9}$/';

    $check_email_query = "SELECT user_email FROM users WHERE user_email = '$email' AND user_id != '$userId'";
    $check_email_query_run = mysqli_query($con, $check_email_query);

    $check_phoneNum_query = "SELECT user_phone FROM users WHERE user_phone = '$phoneNum' AND user_id != '$userId'";
    $check_phoneNum_query_run = mysqli_query($con, $check_phoneNum_query);

    if (!preg_match($phonePatternPH, $phoneNum)) {
        header("Location: ../views/myAccount.php");
        $_SESSION['Errormsg'] = "Invalid Philippine phone number format";
    } else if (mysqli_num_rows($check_email_query_run) > 0) {
        header("Location: ../views/myAccount.php");
        $_SESSION['Errormsg'] = "Email already in use, please try something different";
    } else if (mysqli_num_rows($check_phoneNum_query_run) > 0) {
        header("Location: ../views/myAccount.php");
        $_SESSION['Errormsg'] = "Phone number already in use, please try something different";
    } else {
        if ($uPass) {
            // Update User Data
            $update_query = "UPDATE users SET user_firstName=?, user_lastName=?, user_email=?, user_phone=?, user_password=? WHERE user_ID=?";
            $stmt = mysqli_prepare($con, $update_query);
            mysqli_stmt_bind_param($stmt, "sssssi", $firstName, $lastName, $email, $phoneNum, $uPass, $userId);
            $update_query_run = mysqli_stmt_execute($stmt);

            if ($update_query_run) {
                header("Location: ../views/myAccount.php");
                $_SESSION['Successmsg'] = "Account updated successfully";
            } else {
                header("Location: ../views/myAccount.php");
                $_SESSION['Errormsg'] = "Something went wrong";
            }
        }
    }
}

/* User Address Add statement */
if (isset($_POST['userAddAddrBtn'])) {
    $userId = $_POST['userID'];
    $fullN = $_POST['fullName'];
    $email = $_POST['email'];
    $phoneNum = $_POST['phoneNumber'];
    $region = $_POST['region'];
    $province = $_POST['province'];
    $city = $_POST['city'];
    $barangay = $_POST['barangay'];
    $fullAddr = $_POST['fullAddress'];

    // Check if there is already an address for the user
    $stmt_check_address = $con->prepare("SELECT address_id FROM addresses WHERE address_user_ID = ?");
    $stmt_check_address->bind_param("i", $userId);
    $stmt_check_address->execute();
    $result_check_address = $stmt_check_address->get_result();

    // Determine whether to set the address as default
    $addrDefault = ($result_check_address->num_rows == 0 || isset($_POST['defaultAddr'])) ? '1' : '0';

    // Check phone pattern
    $phonePatternPH = '/^09\d{9}$/';

    if (!preg_match($phonePatternPH, $phoneNum)) {
        header("Location: ../views/myAddress.php");
        $_SESSION['Errormsg'] = "Invalid Philippine phone number format";
    } else {
        // If there is a default address and $addrDefault is 1, update its address_isDefault value to 0
        if ($addrDefault == '1') {
            $stmt_update_default = $con->prepare("UPDATE addresses SET address_isDefault = 0 WHERE address_user_ID = ? AND address_isDefault = 1");
            $stmt_update_default->bind_param("i", $userId);
            $stmt_update_default->execute();
            $stmt_update_default->close();
        }

        // Prepare and bind the parameters for inserting a new address
        $stmt = $con->prepare("INSERT INTO addresses (address_user_ID, address_isDefault, address_fullName, address_email, address_region, address_province, address_city, address_barangay, address_phone, address_fullAddress)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iissssssss", $userId, $addrDefault, $fullN, $email, $region, $province, $city, $barangay, $phoneNum, $fullAddr);

        if ($stmt->execute()) {
            header("Location: ../views/myAddress.php");
            $_SESSION['Errormsg'] = "Address added successfully";
        } else {
            header("Location: ../views/myAddress.php");
            $_SESSION['Errormsg'] = "Something went wrong";
        }
        $stmt->close();
    }
}

/* User Address Update statement */
if (isset($_POST['userUpdateAddrBtn'])) {
    $addrId = $_POST['updateAddrID'];
    $userId = $_POST['updateuserID'];
    $fullN = $_POST['fullName'];
    $email = $_POST['email'];
    $phoneNum = $_POST['phoneNumber'];
    $fullAddr = $_POST['fullAddress'];
    $region = $_POST['region'];
    $province = $_POST['province'];
    $city = $_POST['city'];
    $barangay = $_POST['barangay'];

    //Check if address_isDefault existing
    $stmt_check_isDefault = $con->prepare("SELECT address_id, address_isDefault FROM addresses WHERE address_id = ?");
    $stmt_check_isDefault->bind_param("i", $addrId);
    $stmt_check_isDefault->execute();
    $result_check_isDefault = $stmt_check_isDefault->get_result();
    $row = $result_check_isDefault->fetch_assoc();

    //Look whether to set the address as default
    if ($row['address_isDefault'] == 0 && isset($_POST['defaultAddr'])) {
        $addrDefault = 1; //*set current address as the default address

        //*update prev default addres sto be non-default
        $stmt_update_default = $con->prepare("UPDATE addresses SET address_isDefault = 0 WHERE address_user_ID = ? AND address_isDefault = 1");
        $stmt_update_default->bind_param("i", $userId);
        $stmt_update_default->execute();
        $stmt_update_default->close();
    } else {
        $addrDefault = $row['address_isDefault']; //!keep address_isDefault on default state
    }

    $phonePatternPH = '/^09\d{9}$/';

    if (!preg_match($phonePatternPH, $phoneNum)) {
        header("Location: ../views/myAddressEdit.php?addrID=$addrId");
        $_SESSION['Errormsg'] = "Invalid Philippine phone number format";
    } else {
        // Prepare and bind the parameters
        $stmt = $con->prepare("UPDATE addresses SET address_fullName = ?, address_email = ?, address_region =?, address_province = ?, address_city = ?, address_barangay = ?, address_phone = ?, address_fullAddress = ?, address_isDefault = ? WHERE address_id = ?");
        $stmt->bind_param("sssssssssi", $fullN, $email, $region, $province, $city, $barangay, $phoneNum, $fullAddr, $addrDefault, $addrId);

        if ($stmt->execute()) {
            header("Location: ../views/myAddressEdit.php?addrID=$addrId");
            $_SESSION['Errormsg'] = "Address updated successfully";
        } else {
            header("Location: ../views/myAddressEdit.php?addrID=$addrId");
            $_SESSION['Errormsg'] = "Something went wrong";
        }
        $stmt->close();
    }
}

/* User set Default Address */
if (isset($_POST['setDefaultAddrBtn'])) {
    $addrId = $_POST['addrID'];
    $userId = $_POST['userID'];

    // Check if there is already a default address for the user
    $stmt_check_default = $con->prepare("SELECT address_id FROM addresses WHERE address_user_ID = ? AND address_isDefault = 1");
    $stmt_check_default->bind_param("i", $userId);
    $stmt_check_default->execute();
    $result_check_default = $stmt_check_default->get_result();

    // If there is a default address, update its address_isDefault value to 0
    if ($result_check_default->num_rows > 0) {
        $row = $result_check_default->fetch_assoc();
        $defaultAddrId = $row['address_id'];

        // Update the existing default address
        $stmt_update_default = $con->prepare("UPDATE addresses SET address_isDefault = 0 WHERE address_id = ?");
        $stmt_update_default->bind_param("i", $defaultAddrId);
        $stmt_update_default->execute();
        $stmt_update_default->close();
    }

    // Set the new address as default
    $stmt_set_default = $con->prepare("UPDATE addresses SET address_isDefault = 1 WHERE address_id = ?");
    $stmt_set_default->bind_param("i", $addrId);
    if ($stmt_set_default->execute()) {
        $_SESSION['Errormsg'] = "Address set as Default shipping address";
    } else {
        $_SESSION['Errormsg'] = "Something went wrong";
    }

    // Close statements
    $stmt_check_default->close();
    $stmt_set_default->close();

    // Redirect to myAddress.php
    header("Location: ../views/myAddress.php");
    exit(); // Terminate script execution
}

/* User Delete Address */
if (isset($_POST['deleteAddrBtn'])) {
    $addrId = $_POST['deleteAddrID'];
    $userId = $_POST['deleteAddruserID'];

    // Proceed with deletion
    $stmt_delete_address = $con->prepare("DELETE FROM addresses WHERE address_id = ?");
    $stmt_delete_address->bind_param("i", $addrId);
    if ($stmt_delete_address->execute()) {
        $_SESSION['Errormsg'] = "Address has been deleted";
    } else {
        $_SESSION['Errormsg'] = "Failed to delete address";
    }
    // Close $stmt_delete_address only if it's initialized
    if (isset($stmt_delete_address)) {
        $stmt_delete_address->close();
    }

    // Redirect to myAddress.php
    header("Location: ../views/myAddress.php");
    exit(); // Terminate script execution
}
