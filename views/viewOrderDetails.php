<?php
include('../partials/__header.php');
include('../middleware/userMW.php');/* Authenticate.php */
?>
<div class="py-3 bg-primary">
    <div class="container">
        <h6>
            <a href="#" class="text-dark">Home /</a>
            <a href="myOrders.php" class="text-dark">My Purchase /</a>
            <a href="#" class="text-dark">Your Order Details</a>
        </h6>
    </div>
</div>
<?php

if (isset($_GET['trck'])) {
    $tracking_no = $_GET['trck'];

    $orderData = checkTrackingNumValid($tracking_no);
    if (mysqli_num_rows($orderData) < 0) {
?>
        <div class="text-center">
            <h1>Something went wrong.</h1>
        </div>
    <?php
        die();
    }
} else {
    ?>
    <div class="text-center">
        <h1>Something went wrong.</h1>
    </div>
<?php
    die();
}

$data = mysqli_fetch_array($orderData);
?>

<div class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-main">
                        <a href="myOrders.php" class="btn btn-primary float-start">Back</a>
                        <span class="fs-6 float-end">
                            <span class="float-end">NRCRXpress</span>
                            <br>
                            <?= $data['orders_tracking_no']; ?>
                        </span>
                    </div>
                    <div class="card-body bg-main">
                        <div class="row">
                            <!-- Deliver Address -->
                            <div class="col-md-12">
                                <h2>Delivery Address</h2>
                                <hr>
                                <div class="row">
                                    <div>
                                        <div class="col-md-12 ps-0">
                                            <h3><?= $data['orders_full_name']; ?></h3>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="col-md-12 ps-0">
                                            <h5>
                                                <span><?= $data['orders_phone']; ?>&nbsp;|&nbsp;<?= $data['orders_email']; ?></span>
                                                <br>
                                                <span><?= $data['orders_address']; ?>,</span>
                                                <br>
                                                <span>
                                                    <span><?= $data['orders_city']; ?>,</span>
                                                    <span><?= $data['orders_state']; ?>,</span>
                                                    <span><?= $data['orders_postal_code']; ?>,</span>
                                                    <span><?= $data['orders_country']; ?></span>
                                                </span>
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Item Details -->
                            <div class="col-md-12 mt-4">
                                <h2>Order Item Details</h2>
                                <hr>
                                <?php
                                $user_id = $_SESSION['auth_user']['user_ID'];
                                $groupedItems = [];
                                $totalPrice = 0;
                                $itemQty = getOrderedItemQty($tracking_no);
                                $order_query = "SELECT o.orders_id as oid, o.orders_tracking_no, o.orders_user_ID, oi.*, p.*, c.category_name, c.category_slug
                                                FROM orders o
                                                INNER JOIN order_items oi ON oi.orderItems_order_id = o.orders_id
                                                INNER JOIN products p ON p.product_id = oi.orderItems_product_id
                                                INNER JOIN categories c ON c.category_id = p.category_id
                                                WHERE o.orders_user_ID = '$user_id' AND o.orders_tracking_no = '$tracking_no'";

                                $order_query_run = mysqli_query($con, $order_query);

                                ?>
                                <div id="itemsContainer" style="height: <?= count($groupedItems) > 1 ? '386px' : 'auto'; ?>; overflow-y: scroll; scrollbar-width: none;">
                                    <?php
                                    if (mysqli_num_rows($order_query_run) > 0) {
                                        foreach ($order_query_run as $item) {
                                            $itemTotalPrice = $item['orderItems_price'] * $item['orderItems_qty'];
                                            $totalPrice += $itemTotalPrice;

                                            $categoryName = $item['category_name'];
                                            if (!isset($groupedItems[$categoryName])) {
                                                $groupedItems[$categoryName] = [];
                                            }
                                            $groupedItems[$categoryName][] = $item;
                                    ?>
                                            <div class="card mb-3 rounded-3 bg-primary">
                                                <div class="card-header">
                                                    <h5 class="card-title fw-bold">
                                                        <span><?= $categoryName ?></span>
                                                        <span><a href="store.php?category=<?= $item['category_slug'] ?>" class="btn btn-accent"><i class="fa-solid fa-store"></i>&nbsp;View Store</a></span>
                                                    </h5>
                                                </div>
                                                <div class="card-body">
                                                    <a href="productView.php?product=<?= $item['product_slug'] ?>" class="text-decoration-none">
                                                        <div class="row align-items-center">
                                                            <div class="col-md-1">
                                                                <img src="../assets/uploads/products/<?= $item['product_image'] ?>" class="border" alt="Product Image" width="80px">
                                                            </div>
                                                            <div class="col-md-6 text-dark">
                                                                <h5><?= $item['product_name'] ?></h5>
                                                                <h5>x<?= $item['orderItems_qty'] ?></h5>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <h5 class="text-end">
                                                                    <?php
                                                                    if ($item['product_srp'] == $item['product_original_price']) {
                                                                    ?>
                                                                        <span class="text-accent">₱<?= number_format($item['orderItems_price'], 2) ?></span>
                                                                    <?php
                                                                    } else {
                                                                    ?>
                                                                        <span class="text-secondary text-decoration-line-through">₱<?= number_format($item['product_original_price'], 2) ?></span>&nbsp;<span class="text-accent">₱<?= number_format($item['orderItems_price'], 2) ?></span>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </h5>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                    <?php
                                        }
                                    } else {
                                        echo "<tr><td>No results found.</td></tr>";
                                    }

                                    ?>
                                </div>
                                <hr>
                                <div class="mt-2">
                                    <div class="col-md-12">
                                        <div class="col-md-6 float-end">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h5 class="text-end">Order Total</h5>
                                                    <h5 class="text-end">Item Total</h5>
                                                    <h5 class="text-end">Order Status</h5>
                                                    <h5 class="text-end">Payment Method</h5>
                                                </div>
                                                <div class="col-md-6">
                                                    <h5 class="text-end fw-bold text-accent">₱<?= number_format($totalPrice, 2) ?></h5>
                                                    <h5 class="text-end"><?= $itemQty ?></h5>
                                                    <h5 class="text-end">
                                                        <?php if ($data['orders_status'] == 0) {
                                                            echo "Preparing to ship";
                                                        } else if ($data['orders_status'] == 1) {
                                                            echo "Parcel is out for delivery";
                                                        } else if ($data['orders_status'] == 2) {
                                                            echo "Parcel has been delivered";
                                                        } else if ($data['orders_status'] == 3) {
                                                            echo "Parcel has been cancelled";
                                                        }
                                                        ?>
                                                    </h5>
                                                    <h5 class="text-end"><?= $data['orders_payment_mode'] ?></h5>
                                                </div>

                                                <?php
                                                if ($data['orders_status'] == 0) {
                                                ?>
                                                    <div class="mt-3">
                                                        <!-- Button trigger modal -->
                                                        <button type="button" class="btn btn-accent float-end col-md-10" data-bs-toggle="modal" data-bs-target="#cancelOrderModal">
                                                            Cancel Order
                                                        </button>


                                                        <!-- Modal -->
                                                        <div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-labelledby="cancelOrderModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <form action="../models/orderStatus.php" method="post">
                                                                    <div class="modal-content bg-main">
                                                                        <div class="modal-header text-center">
                                                                            <p class="modal-title w-100 fs-3" id="cancelOrderModalLabel">Select Cancellation Reason</p>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <!-- Tracking Number & OrdersID -->
                                                                            <input type="hidden" name="trackingNumber" value="<?= $data['orders_tracking_no']; ?>" readonly>
                                                                            <input type="hidden" name="ordersID" value="<?= $data['orders_id']; ?>" readonly>
                                                                            <!-- Reason 1 -->
                                                                            <div class="form-check fs-4">
                                                                                <input class="form-check-input" type="radio" name="reasonCancelOrder" id="reason_1" value="1">
                                                                                <label class="form-check-label" for="reason_1">
                                                                                    Need to change delivery address
                                                                                </label>
                                                                            </div>
                                                                            <!-- Reason 2 -->
                                                                            <div class="form-check fs-4">
                                                                                <input class="form-check-input" type="radio" name="reasonCancelOrder" id="reason_2" value="2">
                                                                                <label class="form-check-label " for="reason_2">
                                                                                    Seller is not responsive to my inquiries
                                                                                </label>
                                                                            </div>
                                                                            <!-- Reason 3 -->
                                                                            <div class="form-check fs-4">
                                                                                <input class="form-check-input" type="radio" name="reasonCancelOrder" id="reason_3" value="3">
                                                                                <label class="form-check-label" for="reason_3">
                                                                                    Modify Quantity Order
                                                                                </label>
                                                                            </div>
                                                                            <!-- Reason 4 -->
                                                                            <div class="form-check fs-4">
                                                                                <input class="form-check-input" type="radio" name="reasonCancelOrder" id="reason_4" value="4">
                                                                                <label class="form-check-label" for="reason_4">
                                                                                    Others / Change of mind
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="submit" name="cancelOrderBtn" class="btn btn-accent">Confirm</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php
                                                }

                                                if ($data['orders_status'] == 1) {
                                                ?>
                                                    <div class="mt-3">
                                                        <form action="../models/orderStatus.php" method="post">
                                                            <input type="hidden" name="trackingNumber" value="<?= $data['orders_tracking_no']; ?>" readonly>
                                                            <input type="hidden" name="ordersID" value="<?= $data['orders_id']; ?>" readonly>
                                                            <button type="submit" name="orderRcvBtn" class="btn btn-accent float-end col-md-10">Order Received</button>
                                                        </form>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div>
    <?php include('footer.php'); ?>
</div>

<?php include('../partials/__footer.php'); ?>

<script>
    // jquery code to adjust the height based on the number of items
    $(document).ready(function() {
        var itemsContainer = $("#itemsContainer");
        var groupedItemsCount = <?= count($groupedItems); ?>;

        // Check if there's more than one group, set height accordingly
        if (groupedItemsCount > 1) {
            itemsContainer.css("height", "386px");
        } else {
            itemsContainer.css("height", "auto");
        }
    });
</script>