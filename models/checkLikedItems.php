<?php
session_start();
include('dbcon.php');
include('userFunctions.php');

// Assuming you have a function to fetch liked items
$items = getLikesItems();

// Check if there are any liked items
if (mysqli_num_rows($items) > 0) {
    // If there are liked items, output the count
    echo mysqli_num_rows($items);
} else {
    // If there are no liked items, output '0'
    echo 0;
}