<?php
session_start();
date_default_timezone_set('Asia/Manila');
include('../../models/dbcon.php');
include('../../models/myFunctions.php');
include('../../models/addBGToPng.php');

if (isset($_POST['addCategoryBtn'])) { //!Add Brand Category
    $user_ID = mysqli_real_escape_string($con, $_POST['userID']);
    $name = mysqli_real_escape_string($con, $_POST['nameInput']);
    $slug = mysqli_real_escape_string($con, $_POST['slugInput']);
    $slug = strtolower($slug);
    $slug = preg_replace('/[^a-zA-Z0-9]/', '', $slug);
    $slug = str_replace(' ', '', $slug);
    $desc = mysqli_real_escape_string($con, $_POST['descriptionInput']);
    $meta_title = mysqli_real_escape_string($con, $_POST['metaTitleInput']);
    $meta_desc = mysqli_real_escape_string($con, $_POST['metaDescriptionInput']);

    // Check if category name already exists
    $check_query = "SELECT * FROM categories WHERE category_name = ?";
    $stmt = mysqli_prepare($con, $check_query);
    mysqli_stmt_bind_param($stmt, "s", $name);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    // Check if category slug already exists
    $check_category_slug_query = "SELECT * FROM categories WHERE category_slug = ?";
    $check_category_slug_stmt = mysqli_prepare($con, $check_category_slug_query);
    mysqli_stmt_bind_param($check_category_slug_stmt, "s", $slug);
    mysqli_stmt_execute($check_category_slug_stmt);
    mysqli_stmt_store_result($check_category_slug_stmt);

    /* Check if seller have pickup addr */
    $check_address_query = "SELECT * FROM addresses WHERE address_user_ID = '$user_ID' ";
    $check_address_query_run = mysqli_query($con, $check_address_query);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        redirectSwal("../your-store.php", "Store name already exists. Please choose a different name.", "error");
    } else if (mysqli_stmt_num_rows($check_category_slug_stmt) > 0) {
        redirectSwal("../your-store.php", "Store slug already exists. Please choose a different slug.", "error");
    } else if (mysqli_num_rows($check_address_query_run) <= 0) {
        redirectSwal("../account-details.php", "Add your pickup address first before creating a store", "warning");
    } else {
        $image = $_FILES['uploadImageInput']['name'];
        $image_tmp = $_FILES['uploadImageInput']['tmp_name'];

        $path = "../../assets/uploads/brands/";
        $image_ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png'];

        if (!in_array($image_ext, $allowed_extensions)) {
            redirectSwal("../your-store.php", "Invalid image file format. Only JPEG, PNG files are allowed.", "error");
        }

        /* Set the file name */
        $date = date("m-d-Y-H-i-s");
        $fileName = $slug . '-' . $date . '.' . $image_ext;
        $destination = $path . $fileName;

        addBackgroundToPng($destination, $image);

        $categ_query = "INSERT INTO categories (category_user_ID, category_name, category_slug, category_description, category_image,
                category_meta_title, category_meta_description)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($con, $categ_query);
        mysqli_stmt_bind_param(
            $stmt,
            "issssss",
            $user_ID,
            $name,
            $slug,
            $desc,
            $fileName,
            $meta_title,
            $meta_desc,
        );
        $categ_query_run = mysqli_stmt_execute($stmt);




        if ($categ_query_run) {

            move_uploaded_file($image_tmp, $destination);
            redirectSwal("../your-store.php", "Store added successfully!", "success");
        } else {
            redirectSwal("../your-store.php", "Something went wrong. Please try again later.", "error");
        }
    }
} else if (isset($_POST['updateCategoryBtn'])) { //!Update Brand Category details
    $category_id = mysqli_real_escape_string($con, $_POST['categoryID']);
    $name = mysqli_real_escape_string($con, $_POST['nameInput']);
    $slug = mysqli_real_escape_string($con, $_POST['slugInput']);
    $slug = strtolower($slug);
    $slug = preg_replace('/[^a-zA-Z0-9]/', '', $slug);
    $slug = str_replace(' ', '', $slug);
    $desc = trim($_POST['descriptionInput']);
    $meta_title = mysqli_real_escape_string($con, $_POST['metaTitleInput']);
    $meta_desc = trim($_POST['metaDescriptionInput']);
    $visibility = isset($_POST['visibilityCheckbox']) ? '1' : '0';

    // Check if category name already exists
    $check_categ_name_query = "SELECT * FROM categories WHERE category_name = ? AND category_id != ?";
    $check_categ_name_stmt = mysqli_prepare($con, $check_categ_name_query);
    mysqli_stmt_bind_param($check_categ_name_stmt, "si", $name, $category_id);
    mysqli_stmt_execute($check_categ_name_stmt);
    mysqli_stmt_store_result($check_categ_name_stmt);

    // Check if category slug already exists
    $check_category_slug_query = "SELECT * FROM categories WHERE category_slug = ? AND category_id != ?";
    $check_category_slug_stmt = mysqli_prepare($con, $check_category_slug_query);
    mysqli_stmt_bind_param($check_category_slug_stmt, "si", $slug, $category_id);
    mysqli_stmt_execute($check_category_slug_stmt);
    mysqli_stmt_store_result($check_category_slug_stmt);

    if (mysqli_stmt_num_rows($check_categ_name_stmt) > 0) {
        redirectSwal("../your-store.php", "Store name already exists. Please choose a different name.", "error");
    } else if (mysqli_stmt_num_rows($check_category_slug_stmt) > 0) {
        redirectSwal("../your-store.php", "Store slug already exists. Please choose a different slug.", "error");
    } else {
        $old_image = $_POST['oldImage'];
        $new_image = $_FILES['uploadImageInput']['name'];
        $image_tmp = $_FILES['uploadImageInput']['tmp_name'];

        $image_ext = strtolower(pathinfo($new_image, PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png'];

        if ($new_image != "") {
            if (!in_array($image_ext, $allowed_extensions)) {
                redirectSwal("../your-store.php", "Invalid image file format. Only JPEG, PNG files are allowed.", "error");
            } else {
                // Set the file name if a new image is uploaded
                $date = date("m-d-Y-H-i-s");
                $extension = pathinfo($new_image, PATHINFO_EXTENSION);
                $fileName = $slug . '-' . $date . '.' . $extension;
                $destination = "../../assets/uploads/brands/" . $fileName;

                if (file_exists("../../assets/uploads/brands/" . $old_image)) {
                    unlink("../../assets/uploads/brands/" . $old_image); // Delete Old Image
                }
                move_uploaded_file($image_tmp, $destination);

                addBackgroundToPng($destination, $extension);
            }
        } else {
            // Keep the original file name if no new image is uploaded
            $fileName = $old_image;
        }

        $categ_query = "UPDATE categories SET category_name = ?, category_description = ?, category_slug = ?, category_onVacation = ?,
                        category_image = ?, category_meta_title = ?, category_meta_description = ? WHERE category_id = ?";
        $stmt = mysqli_prepare($con, $categ_query);
        mysqli_stmt_bind_param($stmt, "sssisssi", $name, $desc, $slug, $visibility, $fileName, $meta_title, $meta_desc, $category_id);
        $categ_query_run = mysqli_stmt_execute($stmt);

        if ($categ_query_run) {
            redirectSwal("../your-store.php", "Store updated successfully!", "success");
        } else {
            redirectSwal("../your-store.php", "Something went wrong. Please try again later.", "error");
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

    // Fetch slideshow data
    $slideshow_query = "SELECT ss_image FROM slideshow WHERE category_id=?";
    $stmt_slideshow = mysqli_prepare($con, $slideshow_query);
    mysqli_stmt_bind_param($stmt_slideshow, "i", $category_id);
    mysqli_stmt_execute($stmt_slideshow);
    $slideshow_images_result = mysqli_stmt_get_result($stmt_slideshow);

    // Delete products associated with the category
    $delete_products_query = "DELETE FROM products WHERE category_id=?";
    $stmt_delete_products = mysqli_prepare($con, $delete_products_query);
    mysqli_stmt_bind_param($stmt_delete_products, "i", $category_id);
    mysqli_stmt_execute($stmt_delete_products);

    // Delete slideshow associated with the category
    $delete_slideshow_query = "DELETE FROM slideshow WHERE category_id=?";
    $stmt_delete_slideshow = mysqli_prepare($con, $delete_slideshow_query);
    mysqli_stmt_bind_param($stmt_delete_slideshow, "i", $category_id);
    mysqli_stmt_execute($stmt_delete_slideshow);

    // Delete the category
    $delete_category_query = "DELETE FROM categories WHERE category_id=?";
    $stmt_delete_category = mysqli_prepare($con, $delete_category_query);
    mysqli_stmt_bind_param($stmt_delete_category, "i", $category_id);
    $delete_category_query_run = mysqli_stmt_execute($stmt_delete_category);

    if ($delete_category_query_run) {
        // Delete the category image
        if (file_exists("../../assets/uploads/brands/" . $image_delete)) {
            unlink("../../assets/uploads/brands/" . $image_delete);
        }

        // Delete associated product images
        while ($product_image_data = mysqli_fetch_assoc($product_images_result)) {
            $product_image = $product_image_data['product_image'];
            if (file_exists("../../assets/uploads/products/" . $product_image)) {
                unlink("../../assets/uploads/products/" . $product_image);
            }
        }

        // Delete associated slideshow images
        while ($slideshow_image_data = mysqli_fetch_assoc($slideshow_images_result)) {
            $slideshow_image = $slideshow_image_data['ss_image'];
            if (file_exists("../../assets/uploads/slideshow/" . $slideshow_image)) {
                unlink("../../assets/uploads/slideshow/" . $slideshow_image);
            }
        }

        redirectSwal("../category.php", "Category and associated product, & image deleted successfully!", "success");
    } else {
        redirectSwal("../category.php", "Something went wrong. Please try again later.", "error");
    }

    mysqli_stmt_close($stmt_category);
    mysqli_stmt_close($stmt_products);
    mysqli_stmt_close($stmt_delete_products);
    mysqli_stmt_close($stmt_delete_category);
}
