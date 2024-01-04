<?php
include('dbcon.php');
function getSlideShow()
{
    global $con;
    $table = "slideshow";
    $query = "SELECT * FROM $table";
    $query_run = mysqli_query($con, $query);

    // Check if the query was successful
    if (!$query_run) {
        die("Error in query: " . mysqli_error($con));
    }

    $data = array();

    // Check if there are any rows to fetch
    if (mysqli_num_rows($query_run) > 0) {
        // Fetch rows and add them to the $data array
        while ($row = mysqli_fetch_assoc($query_run)) {
            $data[] = $row;
        }
    }

    return $data; // Return the array of rows
}
