<?php
session_start();
include('dbcon.php');
include('userFunctions.php');

$items = getCartItems();
$groupedItems = [];
$itemArray = [];
// Fetch data from the result set and store it in an array
while ($cItem = mysqli_fetch_assoc($items)) {
    $itemArray[] = $cItem;
}
// Group items by category_name
foreach ($items as $cItem) {
    $categoryName = $cItem['category_name'];
    $categslug = $cItem['category_slug'];
    if (!isset($groupedItems[$categoryName])) {
        $groupedItems[$categoryName] = [
            'items' => [],
            'categslug' => $categslug,
        ];
    }
    $groupedItems[$categoryName]['items'][] = $cItem;
}

// Check if there are any liked items
if (count($itemArray) > 0) {

} else {
    echo 0;
}
