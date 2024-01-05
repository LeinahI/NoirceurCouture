<?php
session_start();
date_default_timezone_set('Asia/Manila');
include('../models/dbcon.php');
include('../models/myFunctions.php');

if (isset($_POST['addCategoryBtn'])) { //!Add Brand Category
    $name = $_POST['nameInput'];
    $slug = $_POST['slugInput'];
    $slug = strtolower($slug);
    $slug = preg_replace('/[^a-zA-Z0-9]/', '', $slug);
    $slug = str_replace(' ', '', $slug);
    $desc = $_POST['descriptionInput'];
    $categ_status = isset($_POST['statusCheckbox']) ? '1' : '0';
    $categ_popular = isset($_POST['popularCheckbox']) ? '1' : '0';
    $meta_title = $_POST['metaTitleInput'];
    $meta_desc = $_POST['metaDescriptionInput'];
    $meta_kw = $_POST['metaKeywordsInput'];

    // Check if category name already exists
    $check_query = "SELECT * FROM categories WHERE category_name = ?";
    $stmt = mysqli_prepare($con, $check_query);
    mysqli_stmt_bind_param($stmt, "s", $name);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        redirectSwal("addCategory.php", "Category name already exists. Please choose a different name.", "error");
    } else {
        $image = $_FILES['uploadImageInput']['name'];
        $image_tmp = $_FILES['uploadImageInput']['tmp_name'];

        $path = "../assets/uploads/brands/";
        $image_ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'webp', 'avif', 'gif'];

        if (!in_array($image_ext, $allowed_extensions)) {
            redirectSwal("addCategory.php", "Invalid image file format. Only JPG, JPEG, PNG, WebP, AVIF, and GIF files are allowed.", "error");
        }

        /* Set the file name */
        $date = date("m-d-Y-H-i-s");
        $fileName = $slug . '-' . $date . '.' . $image_ext;
        $destination = $path . $fileName;

        $categ_query = "INSERT INTO categories (category_name, category_slug, category_description, category_status, category_popular, category_image,
                category_meta_title, category_meta_description, category_meta_keywords)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($con, $categ_query);
        mysqli_stmt_bind_param(
            $stmt,
            "sssiissss",
            $name,
            $slug,
            $desc,
            $categ_status,
            $categ_popular,
            $fileName,
            $meta_title,
            $meta_desc,
            $meta_kw
        );
        $categ_query_run = mysqli_stmt_execute($stmt);


        if ($categ_query_run) {
            move_uploaded_file($image_tmp, $destination);
            redirectSwal("addCategory.php", "Category added successfully!", "success");
        } else {
            redirectSwal("addCategory.php", "Something went wrong. Please try again later.", "error");
        }
    }
} else if (isset($_POST['updateCategoryBtn'])) { //!Update Brand Category details
    $category_id = $_POST['categoryID'];
    $name = $_POST['nameInput'];
    $slug = $_POST['slugInput'];
    $slug = strtolower($slug);
    $slug = preg_replace('/[^a-zA-Z0-9]/', '', $slug);
    $slug = str_replace(' ', '', $slug);
    $desc = $_POST['descriptionInput'];
    $categ_status = isset($_POST['statusCheckbox']) ? '1' : '0';
    $categ_popular = isset($_POST['popularCheckbox']) ? '1' : '0';
    $meta_title = $_POST['metaTitleInput'];
    $meta_desc = $_POST['metaDescriptionInput'];
    $meta_kw = $_POST['metaKeywordsInput'];

    // Check if category name already exists
    $check_query = "SELECT * FROM categories WHERE category_name = ? AND category_id != ?";
    $stmt = mysqli_prepare($con, $check_query);
    mysqli_stmt_bind_param($stmt, "si", $name, $category_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        redirectSwal("editCategory.php?id=$category_id", "Category name already exists. Please choose a different name.", "error");
    } else {
        $old_image = $_POST['oldImage'];
        $new_image = $_FILES['uploadNewImageInput']['name'];
        $image_tmp = $_FILES['uploadNewImageInput']['tmp_name'];

        if ($new_image != "") {
            // Set the file name if a new image is uploaded
            $date = date("m-d-Y-H-i-s");
            $fileName = $slug . '-' . $date . '.' . pathinfo($new_image, PATHINFO_EXTENSION);
            $destination = "../assets/uploads/brands/" . $fileName;

            if (file_exists("../assets/uploads/brands/" . $old_image)) {
                unlink("../assets/uploads/brands/" . $old_image); // Delete Old Image
            }
            move_uploaded_file($image_tmp, $destination);
        } else {
            // Keep the original file name if no new image is uploaded
            $fileName = $old_image;
        }

        $categ_query = "UPDATE categories SET category_name = ?, category_slug = ?, category_description = ?, category_status = ?, category_popular = ?,
                        category_image = ?, category_meta_title = ?, category_meta_description = ?, category_meta_keywords = ? WHERE category_id = ?";
        $stmt = mysqli_prepare($con, $categ_query);
        mysqli_stmt_bind_param($stmt, "sssiissssi", $name, $slug, $desc, $categ_status, $categ_popular, $fileName, $meta_title, $meta_desc, $meta_kw, $category_id);
        $categ_query_run = mysqli_stmt_execute($stmt);

        if ($categ_query_run) {
            redirectSwal("editCategory.php?id=$category_id", "Category updated successfully!", "success");
        } else {
            redirectSwal("editCategory.php?id=$category_id", "Something went wrong. Please try again later.", "error");
        }
    }
} else if (isset($_POST['deleteCategoryBtn'])) { //!Delete whole Brand Category
    $category_id = mysqli_real_escape_string($con, $_POST['categoryID']);

    // Fetch category data
    $category_query = "SELECT * FROM categories WHERE category_id=?";
    $stmt_category = mysqli_prepare($con, $category_query);
    mysqli_stmt_bind_param($stmt_category, "i", $category_id);
    mysqli_stmt_execute($stmt_category);
    $category_data = mysqli_stmt_get_result($stmt_category);
    $category_data = mysqli_fetch_array($category_data);
    $image_delete = $category_data['category_image'];

    // Fetch product data
    $products_query = "SELECT product_image FROM products WHERE category_id=?";
    $stmt_products = mysqli_prepare($con, $products_query);
    mysqli_stmt_bind_param($stmt_products, "i", $category_id);
    mysqli_stmt_execute($stmt_products);
    $product_images_result = mysqli_stmt_get_result($stmt_products);

    // Delete products associated with the category
    $delete_products_query = "DELETE FROM products WHERE category_id=?";
    $stmt_delete_products = mysqli_prepare($con, $delete_products_query);
    mysqli_stmt_bind_param($stmt_delete_products, "i", $category_id);
    mysqli_stmt_execute($stmt_delete_products);

    // Delete the category
    $delete_category_query = "DELETE FROM categories WHERE category_id=?";
    $stmt_delete_category = mysqli_prepare($con, $delete_category_query);
    mysqli_stmt_bind_param($stmt_delete_category, "i", $category_id);
    $delete_category_query_run = mysqli_stmt_execute($stmt_delete_category);

    if ($delete_category_query_run) {
        // Delete the category image
        if (file_exists("../assets/uploads/brands/" . $image_delete)) {
            unlink("../assets/uploads/brands/" . $image_delete);
        }

        // Delete associated product images
        while ($product_image_data = mysqli_fetch_assoc($product_images_result)) {
            $product_image = $product_image_data['product_image'];
            if (file_exists("../assets/uploads/products/" . $product_image)) {
                unlink("../assets/uploads/products/" . $product_image);
            }
        }

        redirectSwal("category.php", "Category and associated products deleted successfully!", "success");
    } else {
        redirectSwal("category.php", "Something went wrong. Please try again later.", "error");
    }

    mysqli_stmt_close($stmt_category);
    mysqli_stmt_close($stmt_products);
    mysqli_stmt_close($stmt_delete_products);
    mysqli_stmt_close($stmt_delete_category);
} else if (isset($_POST['addProductBtn'])) { //!Add Product into specific category
    $category_id = $_POST['selectBrandCategoryID'];
    $name = $_POST['productnameInput'];
    $slug = $_POST['productslugInput'];
    $slug = strtolower($slug);
    $slug = preg_replace('/[^a-zA-Z0-9]/', '', $slug);
    $slug = str_replace(' ', '', $slug);
    $sm_desc = $_POST['smallDescriptionInput'];
    $desc = $_POST['productdescriptionInput'];
    $orig_price = $_POST['originalPriceInput'];
    $srp = $_POST['suggestedRetailPriceInput'];
    $qty = $_POST['quantityInput'];
    $product_status = isset($_POST['productstatusCheckbox']) ? '1' : '0';
    $product_popular = isset($_POST['productpopularCheckbox']) ? '1' : '0';
    $meta_title = $_POST['productmetaTitleInput'];
    $meta_desc = $_POST['productmetaDescriptionInput'];
    $meta_kw = $_POST['productmetaKeywordsInput'];

    // Check if product name already exists
    $check_query = "SELECT * FROM products WHERE product_name = ?";
    $stmt = mysqli_prepare($con, $check_query);
    mysqli_stmt_bind_param($stmt, "s", $name);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        redirectSwal("addProduct.php", "Product name already exists. Please try a different name.", "error");
    } else {
        $image = $_FILES['uploadProductImageInput']['name'];
        $image_tmp = $_FILES['uploadProductImageInput']['tmp_name'];

        $path = "../assets/uploads/products/";
        $image_ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'webp', 'avif', 'gif'];

        if (!in_array($image_ext, $allowed_extensions)) {
            redirectSwal("addProduct.php", "Invalid image file format. Only JPG, JPEG, PNG, WebP, AVIF, and GIF files are allowed.", "error");
        }

        /* Set the file name */
        $date = date("m-d-Y-H-i-s");
        $fileName = $slug . '-' . $date . '.' . $image_ext;
        $destination = $path . $fileName;

        $product_categ_query = "INSERT INTO products (category_id, product_name, product_slug, product_small_description, product_description, product_original_price,
                        product_srp, product_image, product_qty, product_status, product_popular, product_meta_title, product_meta_keywords, product_meta_description)
                        VALUES('$category_id','$name','$slug','$sm_desc','$desc','$orig_price','$srp','$fileName','$qty','$product_status','$product_popular',
                        '$meta_title','$meta_desc','$meta_kw')";
        $product_categ_query_run = mysqli_query($con, $product_categ_query);
        if ($product_categ_query_run) {
            move_uploaded_file($image_tmp, $destination);
            redirectSwal("addProduct.php", "Product added successfully!", "success");
        } else {
            redirectSwal("addProduct.php", "Something went wrong. Please try again later.", "error");
        }
    }
} else if (isset($_POST['updateProductBtn'])) { //!Update product details
    $product_id = $_POST['productID'];
    $category_id = $_POST['selectBrandCategoryID'];
    $name = $_POST['productnameInput'];
    $slug = $_POST['productslugInput'];
    $slug = strtolower($slug);
    $slug = preg_replace('/[^a-zA-Z0-9]/', '', $slug);
    $slug = str_replace(' ', '', $slug);
    $sm_desc = $_POST['smallDescriptionInput'];
    $desc = $_POST['productdescriptionInput'];
    $orig_price = $_POST['originalPriceInput'];
    $srp = $_POST['suggestedRetailPriceInput'];
    $qty = $_POST['quantityInput'];
    $product_status = isset($_POST['productstatusCheckbox']) ? '1' : '0';
    $product_popular = isset($_POST['productpopularCheckbox']) ? '1' : '0';
    $meta_title = $_POST['productmetaTitleInput'];
    $meta_desc = $_POST['productmetaDescriptionInput'];
    $meta_kw = $_POST['productmetaKeywordsInput'];

    // Check if category name already exists
    $check_query = "SELECT * FROM products WHERE product_name = ? AND product_id != ?";
    $stmt = mysqli_prepare($con, $check_query);
    mysqli_stmt_bind_param($stmt, "si", $name, $product_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        redirectSwal("editProduct.php?id=$product_id", "Product name already exists. Please choose a different name.", "error");
    } else {
        $old_image = $_POST['oldProductImage'];
        $new_image = $_FILES['uploadProductImageInput']['name'];
        $image_tmp = $_FILES['uploadProductImageInput']['tmp_name'];

        if ($new_image != "") {
            // Set the file name if a new image is uploaded
            $date = date("m-d-Y-H-i-s");
            $fileName = $slug . '-' . $date . '.' . pathinfo($new_image, PATHINFO_EXTENSION);
            $destination = "../assets/uploads/products/" . $fileName;

            if (file_exists("../assets/uploads/products/" . $old_image)) {
                unlink("../assets/uploads/products/" . $old_image); // Delete Old Image
            }
            move_uploaded_file($image_tmp, $destination);
        } else {
            // Keep the original file name if no new image is uploaded
            $fileName = $old_image;
        }

        $categ_query = "UPDATE products SET category_id = ?, product_name = ?, product_slug = ?, product_small_description = ?, product_description = ?,
        product_original_price = ?, product_srp = ?, product_image = ?, product_qty = ?, product_status = ?, product_popular = ?, product_meta_title = ?,
        product_meta_keywords = ?, product_meta_description = ? WHERE product_id = ?";
        $stmt = mysqli_prepare($con, $categ_query);
        mysqli_stmt_bind_param(
            $stmt,
            "issssddsiiisssi",
            $category_id,
            $name,
            $slug,
            $sm_desc,
            $desc,
            $orig_price,
            $srp,
            $fileName,
            $qty,
            $product_status,
            $product_popular,
            $meta_title,
            $meta_kw,
            $meta_desc,
            $product_id
        );
        $categ_query_run = mysqli_stmt_execute($stmt);

        if ($categ_query_run) {
            if ($new_image != "") {
                move_uploaded_file($image_tmp, $destination);
                if (file_exists("../assets/uploads/products/" . $old_image)) {
                    unlink("../assets/uploads/products/" . $old_image); // Delete Old Image
                }
            }
            redirectSwal("editProduct.php?id=$product_id", "Product updated successfully!", "success");
        } else {
            redirectSwal("editProduct.php?id=$product_id", "Something went wrong. Please try again later.", "error");
        }
    }
} else if (isset($_POST['deleteProductBtn'])) { //!Delete product details
    $category_id = mysqli_real_escape_string($con, $_POST['productID']);

    $category_query = "SELECT * FROM products WHERE product_id='$category_id'";
    $category_query_run = mysqli_query($con, $category_query);
    $category_data = mysqli_fetch_array($category_query_run);
    $image_delete = $category_data['product_image'];

    $delete_query = "DELETE FROM products WHERE product_id='$category_id'";
    $delete_query_run = mysqli_query($con, $delete_query);

    if ($delete_query_run) {
        if (file_exists("../assets/uploads/products/") . $image_delete) {
            unlink("../assets/uploads/products/" . $image_delete); //Delete Image
        }
        redirectSwal("product.php", "Product deleted successfully!", "success");
    } else {
        redirectSwal("product.php", "Something went wrong. Please try again later.", "error");
    }
} else if (isset($_POST['updateParcelStatusBtn'])) {
    $track_num = $_POST['trackingNumber'];
    $order_stat = $_POST['orderStatus'];
    $orderId = $_POST['ordersID'];

    $updateStatus_query = "UPDATE orders SET orders_status='$order_stat' WHERE orders_tracking_no='$track_num'";
    $updateStatus_query_run = mysqli_query($con, $updateStatus_query);

    if ($order_stat == 3) {
        // Get the order items
        $orderItemsQuery = "SELECT orderItems_product_id, orderItems_qty FROM order_items WHERE orderItems_order_id = '$orderId'";
        $orderItemsResult = mysqli_query($con, $orderItemsQuery);

        // Update the product quantities
        while ($orderItem = mysqli_fetch_array($orderItemsResult)) {
            $productId = $orderItem['orderItems_product_id'];
            $orderItemQty = $orderItem['orderItems_qty'];

            // Update the product_qty in the products table
            $updateProductQtyQuery = "UPDATE products SET product_qty = product_qty + '$orderItemQty' WHERE product_id = '$productId'";
            mysqli_query($con, $updateProductQtyQuery);
        }
    }

    // Update the orders_status in the orders table
    $updateOrderStatusQuery = "UPDATE orders SET orders_status = '$order_stat' WHERE orders_id = '$orderId'";
    mysqli_query($con, $updateOrderStatusQuery);
    // Redirect or display success message

    redirectSwal("viewOrderDetails.php?trck=$track_num", "Parcel status updated successfully!", "success");
} else if (isset($_POST['deleteUserBtn'])) { //!Delete user
    $user_id = mysqli_real_escape_string($con, $_POST['user_ID']);

    // Check if the user with the specified user_ID exists
    $check_user_query = "SELECT * FROM users WHERE user_ID=?";
    $stmt_check_user = mysqli_prepare($con, $check_user_query);
    mysqli_stmt_bind_param($stmt_check_user, "i", $user_id);
    mysqli_stmt_execute($stmt_check_user);
    $check_user_query_run = mysqli_stmt_get_result($stmt_check_user);

    if (mysqli_num_rows($check_user_query_run) > 0) {
        // User exists, proceed with deletion
        $delete_query = "DELETE FROM users WHERE user_ID=?";
        $stmt_delete_user = mysqli_prepare($con, $delete_query);
        mysqli_stmt_bind_param($stmt_delete_user, "i", $user_id);
        $delete_query_run = mysqli_stmt_execute($stmt_delete_user);

        if ($delete_query_run) {
            redirectSwal("users.php", "User deleted successfully!", "success");
        } else {
            redirectSwal("users.php", "Something went wrong. Please try again later.", "error");
        }
    } else {
        // User does not exist
        redirectSwal("users.php", "User not found.", "error");
    }

    mysqli_stmt_close($stmt_check_user);
    mysqli_stmt_close($stmt_delete_user);
} else if (isset($_POST['updateUserBtn'])) { //!Update User Details
    $userId = $_POST['userID'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $phoneNum = $_POST['phoneNumber'];
    $uname = $_POST['username'];
    $uPass = $_POST['userPassword'];
    $role = $_POST['userRole'];
    $phonePatternPH = '/^09\d{9}$/';

    // Check if user already exists
    $check_email_query = "SELECT user_email FROM users WHERE user_email = '$email' AND user_id != '$userId'";
    $check_email_query_run = mysqli_query($con, $check_email_query);

    $check_phoneNum_query = "SELECT user_phone FROM users WHERE user_phone = '$phoneNum' AND user_id != '$userId'";
    $check_phoneNum_query_run = mysqli_query($con, $check_phoneNum_query);

    if (!preg_match($phonePatternPH, $phoneNum)) {
        redirectSwal("editusers.php?id=$userId", "Invalid Philippine phone number format.", "error");
    } else if (mysqli_num_rows($check_email_query_run) > 0) {
        redirectSwal("editusers.php?id=$userId", "Email already in use, please try something different.", "error");
    } else if (mysqli_num_rows($check_phoneNum_query_run) > 0) {
        redirectSwal("editusers.php?id=$userId", "Phone number already in use, please try something different.", "error");
    } else {
        if ($uPass) {
            // Update User Data
            $update_query = "UPDATE users SET user_firstName=?, user_lastName=?, user_email=?, user_username=?, user_phone=?, user_password=?, user_role=? WHERE user_ID=?";
            $stmt = mysqli_prepare($con, $update_query);
            mysqli_stmt_bind_param($stmt, "ssssssii", $firstName, $lastName, $email, $uname, $phoneNum, $uPass, $role, $userId);
            $update_query_run = mysqli_stmt_execute($stmt);
            if ($update_query_run) {
                redirectSwal("editusers.php?id=$userId", "Account updated successfully", "success");
            } else {
                redirectSwal("editusers.php?id=$userId", "Something went wrong", "error");
            }
        }
    }
} else if (isset($_POST['addSlideshowBtn'])) {
    $category_id = $_POST['selectBrandID'];

    // Check if category_id already exists in slideshow table
    $check_query = "SELECT * FROM slideshow WHERE category_id = ?";
    $stmt_check = mysqli_prepare($con, $check_query);
    mysqli_stmt_bind_param($stmt_check, "i", $category_id);
    mysqli_stmt_execute($stmt_check);
    mysqli_stmt_store_result($stmt_check);

    if (mysqli_stmt_num_rows($stmt_check) > 0) {
        redirectSwal("addImage.php", "Image for this Category is already existing!", "error");
    } else {
        // File upload
        $image = $_FILES['uploadSlideshowImage']['name'];
        $image_tmp = $_FILES['uploadSlideshowImage']['tmp_name'];

        $path = "../assets/uploads/slideshow/";
        $image_ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'webp', 'avif', 'gif'];

        if (!in_array($image_ext, $allowed_extensions)) {
            redirectSwal("addImage.php", "Invalid image file format. Only JPG, JPEG, PNG, WebP, AVIF, and GIF files are allowed.", "error");
        }

        // Set the file name
        $date = date("m-d-Y-H-i-s");
        $fileName = $category_id . '-' . $date . '.' . $image_ext;
        $destination = $path . $fileName;

        // Insert category_id and image filename into the slideshow table
        $slideshow_query = "INSERT INTO slideshow (category_id, ss_image) VALUES (?, ?)";
        $stmt_insert = mysqli_prepare($con, $slideshow_query);

        if ($stmt_insert) {
            mysqli_stmt_bind_param($stmt_insert, "is", $category_id, $fileName);
            $execute_result = mysqli_stmt_execute($stmt_insert);

            if ($execute_result) {
                if (mysqli_stmt_affected_rows($stmt_insert) > 0) {
                    move_uploaded_file($image_tmp, $destination);
                    redirectSwal("addImage.php", "Image added successfully!", "success");
                } else {
                    redirectSwal("addImage.php", "Failed to add image. Please try again.", "error");
                }
            } else {
                // Print the error message for debugging
                redirectSwal("addImage.php", "Error executing statement. Please try again.", "error");
            }

            mysqli_stmt_close($stmt_insert);
        } else {
            // Print the error message for debugging
            redirectSwal("addImage.php", "Error preparing statement. Please try again.", "error");
        }
    }
} else if (isset($_POST['deleteSlideshowBtn'])) {
    $ss_id = $_POST['ssID'];

    $ss_query = "SELECT * FROM slideshow WHERE ss_id='$ss_id'";
    $ss_query_run = mysqli_query($con, $ss_query);
    $ss_data = mysqli_fetch_array($ss_query_run);
    $image_delete = $ss_data['ss_image'];

    $delete_query = "DELETE FROM slideshow WHERE ss_id='$ss_id'";
    $delete_query_run = mysqli_query($con, $delete_query);

    if ($delete_query_run) {
        if (file_exists("../assets/uploads/slideshow/") . $image_delete) {
            unlink("../assets/uploads/slideshow/" . $image_delete); //Delete Image
        }
        redirectSwal("slideshow.php", "Image deleted successfully!", "success");
    } else {
        redirectSwal("slideshow.php", "Something went wrong. Please try again later.", "error");
    }
} else if (isset($_POST['updateSlideshowBtn'])) { //!Update product details
    $ss_id = $_POST['ssID'];
    $category_id = $_POST['selectBrandID'];

    // Check if category_id already exists in slideshow table
    $check_query = "SELECT * FROM slideshow WHERE category_id = ? AND ss_id != ?";
    $stmt = mysqli_prepare($con, $check_query);
    mysqli_stmt_bind_param($stmt, "ii", $category_id, $ss_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);


    if (mysqli_stmt_num_rows($stmt) > 0) {
        redirectSwal("editImage.php?id=$ss_id", "Slideshow Image on this brand already exists. Please choose a different brand.", "error");
    } else {
        $old_image = $_POST['oldSlideShowImage'];
        $new_image = $_FILES['uploadSlideshowImage']['name'];
        $image_tmp = $_FILES['uploadSlideshowImage']['tmp_name'];

        if ($new_image != "") {
            // Set the file name if a new image is uploaded
            $date = date("m-d-Y-H-i-s");
            $fileName = $date . '.' . pathinfo($new_image, PATHINFO_EXTENSION);
            $destination = "../assets/uploads/slideshow/" . $fileName;

            if (file_exists("../assets/uploads/slideshow/" . $old_image)) {
                unlink("../assets/uploads/slideshow/" . $old_image); // Delete Old Image
            }
            move_uploaded_file($image_tmp, $destination);
        } else {
            // Keep the original file name if no new image is uploaded
            $fileName = $old_image;
        }

        $categ_query = "UPDATE slideshow SET category_id = ?, ss_image = ? WHERE ss_id = ?";
        $stmt = mysqli_prepare($con, $categ_query);
        mysqli_stmt_bind_param(
            $stmt,
            "isi",
            $category_id,
            $fileName,
            $ss_id
        );
        $categ_query_run = mysqli_stmt_execute($stmt);

        if ($categ_query_run) {
            if ($new_image != "") {
                move_uploaded_file($image_tmp, $destination);
                if (file_exists("../assets/uploads/slideshow/" . $old_image)) {
                    unlink("../assets/uploads/slideshow/" . $old_image); // Delete Old Image
                }
            }
            redirectSwal("editImage.php?id=$ss_id", "Image updated successfully!", "success");
        } else {
            redirectSwal("editImage.php?id=$ss_id", "Something went wrong. Please try again later.", "error");
        }
    }
}
