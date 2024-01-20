<?php include('../partials/__header.php');

include('../middleware/userMW.php');/* Authenticate.php */
?>

<div>
    <div class="mt-5" style="margin-bottom: 10%;">
        <div class="container">
            <div class="row">
                <?php include('../partials/sidebar.php') ?>
                <div class="col-md-9">
                    <div class="card border rounded-3 shadow bg-main">
                        <div class="card-header">
                            <h5 class="card-title">My Purchase</h5>
                        </div>
                        <div class="card-body" style="height: 700px; overflow-y: scroll; scrollbar-width: none;">
                            <?php
                            $items = getOrderedItems();
                            $groupedItems = [];

                            // Fetch data from the result set and store it in an array
                            while ($cItem = mysqli_fetch_assoc($items)) {
                                $ordersCreatedAt = $cItem['orders_createdAt'];
                                $categoryName = $cItem['category_name'];
                                $categorySlug = $cItem['category_slug'];

                                // Initialize status variables
                                $toShip = 0;
                                $toReceive = 0;
                                $delivered = 0;
                                $cancelled = 0;

                                if (!isset($groupedItems[$ordersCreatedAt][$categoryName])) {
                                    $groupedItems[$ordersCreatedAt][$categoryName] = [
                                        'items' => [],
                                        'statuses' => [
                                            'toShip' => 0,
                                            'toReceive' => 0,
                                            'delivered' => 0,
                                            'cancelled' => 0,
                                        ],
                                    ];
                                }

                                $groupedItems[$ordersCreatedAt][$categoryName]['items'][] = $cItem;

                                // Update status variables based on the current item
                                if ($cItem['orders_status'] == 0) {
                                    $groupedItems[$ordersCreatedAt][$categoryName]['statuses']['toShip'] = 1;
                                } else if ($cItem['orders_status'] == 1) {
                                    $groupedItems[$ordersCreatedAt][$categoryName]['statuses']['toReceive'] = 1;
                                } else if ($cItem['orders_status'] == 2) {
                                    $groupedItems[$ordersCreatedAt][$categoryName]['statuses']['delivered'] = 1;
                                } else if ($cItem['orders_status'] == 3) {
                                    $groupedItems[$ordersCreatedAt][$categoryName]['statuses']['cancelled'] = 1;
                                }
                            }

                            // Display grouped items
                            foreach ($groupedItems as $ordersCreatedAt => $createdAtData) {
                                $totalPrice = 0; // Reset $totalPrice for each ordersCreatedAt
                            ?>
                                <div class="card my-4 border rounded-3 shadow bg-main">
                                    <div class="card-header">
                                        <h5 class="card-title">
                                            <span class="fw-bold"><?= date('F d, Y h:i:s A', strtotime($ordersCreatedAt)) ?></span>
                                            <span class="float-end">
                                                <?php
                                                $displayedStatus = false;
                                                foreach ($createdAtData as $categoryName => $categoryData) {
                                                    if (!$displayedStatus) {
                                                        // Display the corresponding status
                                                        if ($categoryData['statuses']['toShip'] == 1) {
                                                            echo "Preparing to ship";
                                                            $displayedStatus = true;
                                                        } else if ($categoryData['statuses']['toReceive'] == 1) {
                                                            echo "Parcel is out for delivery";
                                                            $displayedStatus = true;
                                                        } else if ($categoryData['statuses']['delivered'] == 1) {
                                                            echo "Parcel has been delivered";
                                                            $displayedStatus = true;
                                                        } else if ($categoryData['statuses']['cancelled'] == 1) {
                                                            echo "Parcel has been cancelled";
                                                            $displayedStatus = true;
                                                        }
                                                    }
                                                }
                                                ?>
                                            </span>
                                        </h5>
                                    </div>
                                    <div class="card-body overflow-x-auto">
                                        <?php
                                        foreach ($createdAtData as $categoryName => $categoryData) {
                                            foreach ($categoryData['items'] as $cItem) {
                                                $itemTotalPrice = $cItem['orderItems_price'] * $cItem['orderItems_qty'];
                                                $totalPrice += $itemTotalPrice;

                                                $orderItemPrice = $cItem['orderItems_price'];
                                                $orig_price = $cItem['product_original_price'];
                                                $discount = $cItem['product_discount'];
                                        ?>
                                                <a href="products.php?category=<?= $cItem['category_slug'] ?>" class="fs-5 text-accent fw-bold"><?= $cItem['category_name'] ?></a>
                                                <a href="viewOrderDetails.php?trck=<?= $cItem['orders_tracking_no'] ?>" class="text-dark text-decoration-none">
                                                    <div class="productData row align-items-center py-2">
                                                        <div class="col-md-2">
                                                            <img src="../assets/uploads/products/<?= $cItem['product_image'] ?>" alt="Product Image" width="100px">
                                                        </div>
                                                        <div class="col-md-5">
                                                            <h5><?= $cItem['product_name'] ?></h5>
                                                            <h5>x<?= $cItem['orderItems_qty'] ?></h5>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <?php
                                                            if ($orderItemPrice == $orig_price) {
                                                            ?>
                                                                <h6 class="float-end d-flex justify-content-center">₱<?= number_format($orderItemPrice, 2) ?></h6>
                                                            <?php
                                                            } else if ($orderItemPrice != $orig_price) {
                                                            ?>
                                                                <span class="float-end d-flex justify-content-center">
                                                                    <h6 class="text-secondary text-decoration-line-through mr-2">₱<?= number_format($orig_price, 2) ?></h6>
                                                                    &nbsp;
                                                                    <h6 class="text-accent">₱<?= number_format($orderItemPrice, 2) ?></h6>
                                                                </span>
                                                            <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </a>
                                        <?php
                                            }
                                        }
                                        ?>
                                        <span class="float-end fs-4">Order Total:&nbsp;&nbsp;<span class="text-accent fw-bold">₱<?= number_format($totalPrice, 2) ?></span></span>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div>
        <?php include('footer.php'); ?>
    </div>
</div>

<?php include('../partials/__footer.php'); ?>