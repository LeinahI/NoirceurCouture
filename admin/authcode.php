<?php
session_start();
include('../config/dbcon.php');
include('../functions/myFunctions.php');

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

        $path = "../uploads/brands/";
        $image_ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'webp', 'avif', 'gif'];

        if (!in_array($image_ext, $allowed_extensions)) {
            redirectSwal("addCategory.php", "Invalid image file format. Only JPG, JPEG, PNG, WebP, AVIF, and GIF files are allowed.", "error");
        }

        // Image size validation
        $image_info = getimagesize($image_tmp);
        $original_width = $image_info[0];
        $original_height = $image_info[1];

        if ($original_width != 720 || $original_height != 400) {
            redirectSwal("addCategory.php", "Invalid image dimensions. The image must be exactly 400px height and 720px width.", "error");
        }

        $fileName = time() . '.' . $image_ext;
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
            $image_info = getimagesize($image_tmp);
            $original_width = $image_info[0];
            $original_height = $image_info[1];

            if ($original_width != 720 || $original_height != 400) {
                redirectSwal("editCategory.php?id=$category_id", "Invalid image dimensions. The image must be exactly 400px height and 720px width.", "error");
            }

            $updated_fileName = $new_image;
            $image_tmp = $_FILES['uploadNewImageInput']['tmp_name'];
        } else {
            $updated_fileName = $old_image;
        }

        $path = "../uploads/brands/";
        $image_ext = strtolower(pathinfo($updated_fileName, PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'webp', 'avif', 'gif'];

        if (!in_array($image_ext, $allowed_extensions)) {
            redirectSwal("editCategory.php?id=$category_id", "Invalid image file format. Only JPG, JPEG, PNG, WebP, AVIF, and GIF files are allowed.", "error");
        }

        $fileName = $updated_fileName;
        $destination = $path . $fileName;

        $categ_query = "UPDATE categories SET category_name = ?, category_slug = ?, category_description = ?, category_status = ?, category_popular = ?,
                    category_image = ?, category_meta_title = ?, category_meta_description = ?, category_meta_keywords = ? WHERE category_id = ?";
        $stmt = mysqli_prepare($con, $categ_query);
        mysqli_stmt_bind_param($stmt, "sssiissssi", $name, $slug, $desc, $categ_status, $categ_popular, $fileName, $meta_title, $meta_desc, $meta_kw, $category_id);
        $categ_query_run = mysqli_stmt_execute($stmt);

        if ($categ_query_run) {
            if ($new_image != "") {
                if (file_exists("../uploads/brands/" . $old_image)) {
                    unlink("../uploads/brands/" . $old_image); // Delete Old Image
                }
                move_uploaded_file($image_tmp, $destination);
            }
            redirectSwal("editCategory.php?id=$category_id", "Category updated successfully!", "success");
        } else {
            redirectSwal("editCategory.php?id=$category_id", "Something went wrong. Please try again later.", "error");
        }
    }
} else if (isset($_POST['deleteCategoryBtn'])) { //!Delete whole Brand Category
    $category_id = mysqli_real_escape_string($con, $_POST['categoryID']);

    $category_query = "SELECT * FROM categories WHERE category_id='$category_id'";
    $category_query_run = mysqli_query($con, $category_query);
    $category_data = mysqli_fetch_array($category_query_run);
    $image_delete = $category_data['category_image'];

    $delete_query = "DELETE FROM categories WHERE category_id='$category_id'";
    $delete_query_run = mysqli_query($con, $delete_query);

    if ($delete_query_run) {
        if (file_exists("../uploads/brands/") . $image_delete) {
            unlink("../uploads/brands/" . $image_delete); //Delete Image
        }
        redirectSwal("category.php", "Category deleted successfully!", "success");
    } else {
        redirectSwal("category.php", "Something went wrong. Please try again later.", "error");
    }
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

        $path = "../uploads/products/";
        $image_ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'webp', 'avif', 'gif'];

        if (!in_array($image_ext, $allowed_extensions)) {
            redirectSwal("addProduct.php", "Invalid image file format. Only JPG, JPEG, PNG, WebP, AVIF, and GIF files are allowed.", "error");
        }

        // Image size validation
        $image_info = getimagesize($image_tmp);
        $original_width = $image_info[0];
        $original_height = $image_info[1];

        if ($original_width != 1000 || $original_height != 1000) {
            redirectSwal("addProduct.php", "Invalid image dimensions. The image must be exactly 1000px height and width.", "error");
        }

        $fileName = time() . '.' . $image_ext;
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
            $updated_fileName = $new_image;
        } else {
            $updated_fileName = $old_image;
        }

        $path = "../uploads/products/";
        $image_ext = strtolower(pathinfo($updated_fileName, PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'webp', 'avif', 'gif'];

        if (!in_array($image_ext, $allowed_extensions)) {
            redirectSwal("editProduct.php?id=$product_id", "Invalid image file format. Only JPG, JPEG, PNG, WebP, AVIF, and GIF files are allowed.", "error");
        }

        $fileName = $updated_fileName;
        $destination = $path . $fileName;

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
                if (file_exists("../uploads/products/" . $old_image)) {
                    unlink("../uploads/products/" . $old_image); // Delete Old Image
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
        if (file_exists("../uploads/products/") . $image_delete) {
            unlink("../uploads/products/" . $image_delete); //Delete Image
        }
        redirectSwal("product.php", "Product deleted successfully!", "success");
    } else {
        redirectSwal("product.php", "Something went wrong. Please try again later.", "error");
    }
} else if (isset($_POST['updateParcelStatusBtn'])) {
    $track_num = $_POST['trackingNumber'];
    $order_stat = $_POST['orderStatus'];

    $updateStatus_query = "UPDATE orders SET orders_status='$order_stat' WHERE orders_tracking_no='$track_num'";
    $updateStatus_query_run = mysqli_query($con, $updateStatus_query);

    redirectSwal("viewOrderDetails.php?trck=$track_num", "Parcel status updated successfully!", "success");
}
