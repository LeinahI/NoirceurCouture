<?php
session_start();
date_default_timezone_set('Asia/Manila');
include('../../models/dbcon.php');
include('../../models/myFunctions.php');
include('../../models/addBGToPng.php');

if (isset($_POST['addProductBtn'])) { //!Add Product into specific category
    $category_id = mysqli_real_escape_string($con, $_POST['selectBrandCategoryID']);
    $name = mysqli_real_escape_string($con, $_POST['productnameInput']);
    $slug = mysqli_real_escape_string($con, $_POST['productslugInput']);
    $slug = strtolower($slug);
    $slug = preg_replace('/[^a-zA-Z0-9]/', '', $slug);
    $slug = str_replace(' ', '', $slug);
    $desc = trim($_POST['productdescriptionInput']);
    $orig_price = mysqli_real_escape_string($con, $_POST['originalPriceInput']);
    $discount = mysqli_real_escape_string($con, $_POST['priceDiscount']);
    $srp = mysqli_real_escape_string($con, $_POST['suggestedRetailPriceInput']);
    $qty = mysqli_real_escape_string($con, $_POST['quantityInput']);
    $product_popular = mysqli_real_escape_string($con, isset($_POST['productpopularCheckbox']) ? '1' : '0');
    $meta_title = mysqli_real_escape_string($con, $_POST['productmetaTitleInput']);
    $meta_desc = trim($_POST['productmetaDescriptionInput']);

    // Check if product name already exists
    $check_query = "SELECT * FROM products WHERE product_name = ?";
    $stmt = mysqli_prepare($con, $check_query);
    mysqli_stmt_bind_param($stmt, "s", $name);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    // Check if product slug already exists
    $check_product_slug_query = "SELECT * FROM products WHERE product_slug = ?";
    $check_product_slug_stmt = mysqli_prepare($con, $check_product_slug_query);
    mysqli_stmt_bind_param($check_product_slug_stmt, "s", $slug);
    mysqli_stmt_execute($check_product_slug_stmt);
    mysqli_stmt_store_result($check_product_slug_stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        redirectSwal("../addProduct.php", "Product name already exists. Please try a different name.", "error");
    } else if (mysqli_stmt_num_rows($check_product_slug_stmt) > 0) {
        redirectSwal("../addProduct.php", "Product slug already exists. Please choose a different slug.", "error");
    } else {
        $image = $_FILES['uploadProductImageInput']['name'];
        $image_tmp = $_FILES['uploadProductImageInput']['tmp_name'];

        $file_extension = strtolower(pathinfo($image, PATHINFO_EXTENSION));

        $allowed_extensions = ['jpg', 'jpeg', 'png'];

        if (!in_array($file_extension, $allowed_extensions)) {
            redirectSwal("../addProduct.php", "Invalid image file format. Only JPEG and PNG files are allowed.", "error");
        } else {
            /* Set the file name */
            $date = date("m-d-Y-H-i-s");
            $extension = pathinfo($image, PATHINFO_EXTENSION);
            $fileName = $slug . '-' . $date . '.' . $extension;
            $destination = "../../assets/uploads/products/" . $fileName;

            move_uploaded_file($image_tmp, $destination);
            addBackgroundToPng($destination, $extension);

            $product_categ_query = "INSERT INTO products (category_id, product_name, product_slug, product_description, product_original_price,
                product_discount, product_srp, product_image, product_qty, product_popular, product_meta_title, product_meta_description)
                VALUES('$category_id','$name','$slug','$desc','$orig_price','$discount','$srp','$fileName','$qty','$product_popular',
                '$meta_title','$meta_desc')";
            $product_categ_query_run = mysqli_query($con, $product_categ_query);
            if ($product_categ_query_run) {
                move_uploaded_file($image_tmp, $destination);
                redirectSwal("../addProduct.php", "Product added successfully!", "success");
            } else {
                redirectSwal("../addProduct.php", "Something went wrong. Please try again later.", "error");
            }
        }
    }
} else if (isset($_POST['updateProductBtn'])) { //!Update product details
    $product_id = mysqli_real_escape_string($con, $_POST['productID']);
    $category_id = mysqli_real_escape_string($con, $_POST['selectBrandCategoryID']);
    $name = mysqli_real_escape_string($con, $_POST['productnameInput']);
    $slug = mysqli_real_escape_string($con, $_POST['productslugInput']);
    $slug = strtolower($slug);
    $slug = preg_replace('/[^a-zA-Z0-9]/', '', $slug);
    $slug = str_replace(' ', '', $slug);
    $desc = trim($_POST['productdescriptionInput']);
    $orig_price = mysqli_real_escape_string($con, $_POST['originalPriceInput']);
    $discount = mysqli_real_escape_string($con, $_POST['priceDiscount']);
    $srp = mysqli_real_escape_string($con, $_POST['suggestedRetailPriceInput']);
    $qty = mysqli_real_escape_string($con, $_POST['quantityInput']);
    $product_visibility = mysqli_real_escape_string($con, isset($_POST['productstatusCheckbox']) ? '1' : '0');
    $product_popular = mysqli_real_escape_string($con, isset($_POST['productpopularCheckbox']) ? '1' : '0');
    $meta_title = mysqli_real_escape_string($con, $_POST['productmetaTitleInput']);
    $meta_desc = trim($_POST['productmetaDescriptionInput']);

    // Check if category name already exists
    $check_query = "SELECT * FROM products WHERE product_name = ? AND product_id != ?";
    $stmt = mysqli_prepare($con, $check_query);
    mysqli_stmt_bind_param($stmt, "si", $name, $product_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    // Check if product slug already exists
    $check_product_slug_query = "SELECT * FROM products WHERE product_slug = ? AND product_id != ?";
    $check_product_slug_stmt = mysqli_prepare($con, $check_product_slug_query);
    mysqli_stmt_bind_param($check_product_slug_stmt, "si", $slug, $product_id);
    mysqli_stmt_execute($check_product_slug_stmt);
    mysqli_stmt_store_result($check_product_slug_stmt);

    $old_image = $_POST['oldProductImage'];
    $new_image = $_FILES['uploadProductImageInput']['name'];
    $image_tmp = $_FILES['uploadProductImageInput']['tmp_name'];

    $image_ext = strtolower(pathinfo($new_image, PATHINFO_EXTENSION));
    $allowed_extensions = ['jpg', 'jpeg', 'png'];

    if (mysqli_stmt_num_rows($stmt) > 0) {
        redirectSwal("../editProduct.php?id=$product_id", "Product name already exists. Please choose a different name.", "error");
    } else if (mysqli_stmt_num_rows($check_product_slug_stmt) > 0) {
        redirectSwal("../editProduct.php?id=$product_id", "Product slug already exists. Please choose a different slug.", "error");
    } else {

        if ($new_image != "") {
            // Set the file name if a new image is uploaded
            $date = date("m-d-Y-H-i-s");
            $pathinfo = pathinfo($new_image, PATHINFO_EXTENSION);
            $fileName = $slug . '-' . $date . '.' . $pathinfo;
            $destination = "../../assets/uploads/products/" . $fileName;
            if (!in_array($image_ext, $allowed_extensions)) {
                redirectSwal("../editProduct.php?id=$product_id", "Invalid image file format. Only JPEG and PNG files are allowed.", "error");
            } else if (file_exists("../../assets/uploads/products/" . $old_image)) {
                unlink("../../assets/uploads/products/" . $old_image); // Delete Old Image
            }

            move_uploaded_file($image_tmp, $destination);
            addBackgroundToPng($destination, $pathinfo);
        } else {
            // Keep the original file name if no new image is uploaded
            $fileName = $old_image;
        }

        $categ_query = "UPDATE products SET category_id = ?, product_name = ?, product_slug = ?, product_description = ?,
        product_original_price = ?, product_discount = ?, product_srp = ?, product_image = ?, product_qty = ?, product_visibility = ?, product_popular = ?, product_meta_title = ?,
        product_meta_description = ? WHERE product_id = ?";
        $stmt = mysqli_prepare($con, $categ_query);
        mysqli_stmt_bind_param(
            $stmt,
            "isssdidsiiissi",
            $category_id,
            $name,
            $slug,
            $desc,
            $orig_price,
            $discount,
            $srp,
            $fileName,
            $qty,
            $product_visibility,
            $product_popular,
            $meta_title,
            $meta_desc,
            $product_id
        );
        $categ_query_run = mysqli_stmt_execute($stmt);

        if ($categ_query_run) {
            if ($new_image != "") {
                move_uploaded_file($image_tmp, $destination);
                if (file_exists("../../assets/uploads/products/" . $old_image)) {
                    unlink("../../assets/uploads/products/" . $old_image); // Delete Old Image
                }
            }
            redirectSwal("../editProduct.php?id=$product_id", "Product updated successfully!", "success");
        } else {
            redirectSwal("../editProduct.php?id=$product_id", "Something went wrong. Please try again later.", "error");
        }
    }
} else if (isset($_POST['deleteProductBtn'])) { //!Delete product details
    $category_id = mysqli_real_escape_string($con, $_POST['productID']);

    $category_query = "SELECT * FROM products WHERE product_id='$category_id'";
    $category_query_run = mysqli_query($con, $category_query);
    $category_data = mysqli_fetch_array($category_query_run);

    $prodid = $category_data['product_id'];
    $categid = $category_data['category_id'];
    $prodName = $category_data['product_name'];
    $prodSlug = $category_data['product_slug'];
    $prodOP = $category_data['product_original_price'];
    $prodDisc = $category_data['product_discount'];
    $prodSRP = $category_data['product_srp'];
    $prodImage = $category_data['product_image'];

    // Add "deleted" to the filename
    $deletedImage = 'deleted_' . $prodImage;

    // Check if orders are preparing
    $check_query = "SELECT o.* FROM orders o
    JOIN order_items oi ON oi.orderItems_order_id = o.orders_id
    JOIN products p ON p.product_id = oi.orderItems_product_id
    WHERE p.product_id = ? AND orders_status = 0";
    $stmt = mysqli_prepare($con, $check_query);
    mysqli_stmt_bind_param($stmt, "i", $prodid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        redirectSwal("../product.php", "Product cannot be deleted, if orders are preparing.", "error");
    } else {

        $product_categ_query = "INSERT INTO products_deleted_details (pd_product_id, pd_category_id, pd_product_name, pd_product_slug,  pd_original_price, pd_product_discount,
                        pd_srp, pd_image, pd_confirmed)
                        VALUES('$prodid','$categid','$prodName','$prodSlug','$prodOP','$prodDisc','$prodSRP','$deletedImage','1')";
        $product_categ_query_run = mysqli_query($con, $product_categ_query);

        if ($product_categ_query_run) {
            if (file_exists("../../assets/uploads/products/" . $prodImage)) {
                // Move old image to "deleted" folder
                rename("../../assets/uploads/products/" . $prodImage, "../../assets/uploads/products/" . $deletedImage);
            }
        }
        $delete_query = "DELETE FROM products WHERE product_id='$category_id'";
        $delete_query_run = mysqli_query($con, $delete_query);

        if ($delete_query_run) {
            redirectSwal("../product.php", "Product deleted successfully!", "success");
        } else {
            redirectSwal("../product.php", "Something went wrong. Please try again later.", "error");
        }
    }
}
