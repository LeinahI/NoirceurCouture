<?php
session_start();
date_default_timezone_set('Asia/Manila');
include('../../models/dbcon.php');
include('../../models/myFunctions.php');

if (isset($_POST['addSlideshowBtn'])) {
    $category_id = $_POST['selectBrandID'];

    // Check if category_id already exists in slideshow table
    $check_query = "SELECT * FROM slideshow WHERE category_id = ?";
    $stmt_check = mysqli_prepare($con, $check_query);
    mysqli_stmt_bind_param($stmt_check, "i", $category_id);
    mysqli_stmt_execute($stmt_check);
    mysqli_stmt_store_result($stmt_check);

    if (mysqli_stmt_num_rows($stmt_check) > 0) {
        redirectSwal("../addSlideshow.php", "Image for this Category is already existing!", "error");
    } else {
        // File upload
        $image = $_FILES['uploadSlideshowImage']['name'];
        $image_tmp = $_FILES['uploadSlideshowImage']['tmp_name'];

        $path = "../../assets/uploads/slideshow/";
        $image_ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'webp', 'avif', 'gif'];

        if (!in_array($image_ext, $allowed_extensions)) {
            redirectSwal("../addSlideshow.php", "Invalid image file format. Only JPG, JPEG, PNG, WebP, AVIF, and GIF files are allowed.", "error");
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
                    redirectSwal("../addSlideshow.php", "Image added successfully!", "success");
                } else {
                    redirectSwal("../addSlideshow.php", "Failed to add image. Please try again.", "error");
                }
            } else {
                // Print the error message for debugging
                redirectSwal("../addSlideshow.php", "Error executing statement. Please try again.", "error");
            }

            mysqli_stmt_close($stmt_insert);
        } else {
            // Print the error message for debugging
            redirectSwal("../addSlideshow.php", "Error preparing statement. Please try again.", "error");
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
        if (file_exists("../../assets/uploads/slideshow/") . $image_delete) {
            unlink("../../assets/uploads/slideshow/" . $image_delete); //Delete Image
        }
        redirectSwal("../slideshow.php", "Image deleted successfully!", "success");
    } else {
        redirectSwal("../slideshow.php", "Something went wrong. Please try again later.", "error");
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
        redirectSwal("../editSlideshow.php?id=$ss_id", "Slideshow Image on this brand already exists. Please choose a different brand.", "error");
    } else {
        $old_image = $_POST['oldSlideShowImage'];
        $new_image = $_FILES['uploadSlideshowImage']['name'];
        $image_tmp = $_FILES['uploadSlideshowImage']['tmp_name'];

        if ($new_image != "") {
            // Set the file name if a new image is uploaded
            $date = date("m-d-Y-H-i-s");
            $fileName = $date . '.' . pathinfo($new_image, PATHINFO_EXTENSION);
            $destination = "../../assets/uploads/slideshow/" . $fileName;

            if (file_exists("../../assets/uploads/slideshow/" . $old_image)) {
                unlink("../../assets/uploads/slideshow/" . $old_image); // Delete Old Image
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
                if (file_exists("../../assets/uploads/slideshow/" . $old_image)) {
                    unlink("../../assets/uploads/slideshow/" . $old_image); // Delete Old Image
                }
            }
            redirectSwal("../editSlideshow.php?id=$ss_id", "Image updated successfully!", "success");
        } else {
            redirectSwal("../editSlideshow.php?id=$ss_id", "Something went wrong. Please try again later.", "error");
        }
    }
}
