<?php
session_start();
date_default_timezone_set('Asia/Manila');
include('../../models/dbcon.php');
include('../../models/myFunctions.php');

if (isset($_POST['addProductBtn'])) { //!Add Product into specific category
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
        redirectSwal("../addProduct.php", "Product name already exists. Please try a different name.", "error");
    } else {
        $image = $_FILES['uploadProductImageInput']['name'];
        $image_tmp = $_FILES['uploadProductImageInput']['tmp_name'];

        $path = "../../assets/uploads/products/";
        $image_ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'webp', 'avif', 'gif'];

        if (!in_array($image_ext, $allowed_extensions)) {
            redirectSwal("../addProduct.php", "Invalid image file format. Only JPG, JPEG, PNG, WebP, AVIF, and GIF files are allowed.", "error");
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
            redirectSwal("../addProduct.php", "Product added successfully!", "success");
        } else {
            redirectSwal("../addProduct.php", "Something went wrong. Please try again later.", "error");
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
        redirectSwal("../editProduct.php?id=$product_id", "Product name already exists. Please choose a different name.", "error");
    } else {
        $old_image = $_POST['oldProductImage'];
        $new_image = $_FILES['uploadProductImageInput']['name'];
        $image_tmp = $_FILES['uploadProductImageInput']['tmp_name'];

        if ($new_image != "") {
            // Set the file name if a new image is uploaded
            $date = date("m-d-Y-H-i-s");
            $fileName = $slug . '-' . $date . '.' . pathinfo($new_image, PATHINFO_EXTENSION);
            $destination = "../../assets/uploads/products/" . $fileName;

            if (file_exists("../../assets/uploads/products/" . $old_image)) {
                unlink("../../assets/uploads/products/" . $old_image); // Delete Old Image
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
    $image_delete = $category_data['product_image'];

    $delete_query = "DELETE FROM products WHERE product_id='$category_id'";
    $delete_query_run = mysqli_query($con, $delete_query);

    if ($delete_query_run) {
        if (file_exists("../../assets/uploads/products/") . $image_delete) {
            unlink("../../assets/uploads/products/" . $image_delete); //Delete Image
        }
        redirectSwal("../product.php", "Product deleted successfully!", "success");
    } else {
        redirectSwal("../product.php", "Something went wrong. Please try again later.", "error");
    }
}
