<?php
include('includes/header.php');
include('../middleware/adminMW.php');/* Authenticate.php */

if (isset($_GET['trck'])) {
    $tracking_no = $_GET['trck'];

    $orderData = checkUserTrackingNumValid($tracking_no);
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

<style>
    .scrollBarCO::-webkit-scrollbar {
        display: none;
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span class="fs-2 fw-bold">Order Details</span>
                    <a href="orders.php" class="btn btn-primary float-end">Back</a>
                </div>
                <div class="card-body mb-n3">
                    <div class="row">

                        <div class="col-md-6">
                            <h4>Delivery Address</h4>
                            <hr>
                            <div class="row">
                                <div class="mb-3">
                                    <div class="form-floating col-md-12 ps-0">
                                        <input type="text" class="form-control ps-2" id="delivery_fname" value="<?= $data['orders_full_name']; ?>" readonly placeholder="nasd">
                                        <label for="delivery_fname">Full Name</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-floating col-md-12 ps-0">
                                        <input type="text" class="form-control ps-2" id="delivery_fname" value="<?= $data['orders_email']; ?>" readonly placeholder="nasd">
                                        <label for="delivery_fname">Email</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-floating col-md-12 ps-0">
                                        <input type="text" class="form-control ps-2" id="delivery_fname" value="<?= $data['orders_phone']; ?>" readonly placeholder="nasd">
                                        <label for="delivery_fname">Phone Number</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-floating col-md-12 ps-0">
                                        <input type="text" class="form-control ps-2" id="delivery_fname" value="<?= $data['orders_tracking_no']; ?>" readonly placeholder="nasd">
                                        <label for="delivery_fname">Tracking Number</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-floating col-md-12 ps-0">
                                        <input type="text" class="form-control ps-2" id="delivery_fname" value="<?= $data['orders_address']; ?>" readonly placeholder="nasd">
                                        <label for="delivery_fname">Full Address</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-floating col-md-12 ps-0">
                                        <input type="text" class="form-control ps-2" id="delivery_fname" value="<?= $data['orders_postal_code']; ?>" readonly placeholder="nasd">
                                        <label for="delivery_fname">Postal Code</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h4>Order Item Details</h4>
                            <hr>
                            <div class="scrollBarCO" style="height: 427px; overflow-y: scroll;">
                                <?php
                                /*  $user_id = $_SESSION['auth_user']['user_ID']; */
                                $groupedItems = [];
                                $totalPrice = 0;
                                $itemQty = adminGetOrderedItemQty($tracking_no);
                                $order_query = "SELECT o.orders_id as oid, o.orders_tracking_no, o.orders_user_ID, oi.*, p.*, c.category_name
                                                FROM orders o
                                                INNER JOIN order_items oi ON oi.orderItems_order_id = o.orders_id
                                                INNER JOIN products p ON p.product_id = oi.orderItems_product_id
                                                INNER JOIN categories c ON c.category_id = p.category_id
                                                WHERE o.orders_tracking_no = '$tracking_no'";

                                $order_query_run = mysqli_query($con, $order_query);

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
                                        <div class="card mb-3 border rounded-3">
                                            <div class="card-header">
                                                <h5 class="card-title"><?= $categoryName ?></h5>
                                            </div>
                                            <div class="card-body mt-n5">
                                                <div class="row align-items-center">
                                                    <div class="col-md-2">
                                                        <center>
                                                            <img src="../uploads/products/<?= $item['product_image'] ?>" alt="Product Image" width="80px">
                                                        </center>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <h5><?= $item['product_name'] ?></h5>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <h5 class="text-end">₱<?= number_format($item['orderItems_price'], 2) ?></h5>
                                                    </div>
                                                    <div class="col-md-2 text-center">
                                                        <h5><?= $item['orderItems_qty'] ?></h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                <?php
                                    }
                                } else {
                                    echo "<tr><td>No results found.</td></tr>";
                                }

                                ?>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <h5>Order Total&nbsp;(<span class="text-danger"><?= $itemQty ?>&nbsp;item</span>): <span class="text-danger">₱<?= number_format($totalPrice, 2) ?></span></h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input type="text" class="form-control ps-2" value="<?= $data['orders_payment_mode'] ?>" id="name_input" name="productnameInput" readonly placeholder="Name">
                                                <label for="name_input">Payment Mode</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <form action="authcode.php" method="post">
                                                <input type="hidden" name="trackingNumber" value="<?= $data['orders_tracking_no'] ?>">
                                                <div class="form-floating">
                                                    <select name="orderStatus" class="form-select ps-2" id="orderStat">
                                                        <option value="0" <?= $data['orders_status'] == 0 ? "selected" : "" ?>>Preparing to ship</option>
                                                        <option value="1" <?= $data['orders_status'] == 1 ? "selected" : "" ?>>Parcel is out for delivery</option>
                                                        <option value="2" <?= $data['orders_status'] == 2 ? "selected" : "" ?>>Parcel has been delivered</option>
                                                        <option value="3" <?= $data['orders_status'] == 3 ? "selected" : "" ?>>Parcel has been cancelled</option>
                                                    </select>
                                                    <label for="slug_input">Parcel Status</label>
                                                </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary mt-3 col-md-12" name="updateParcelStatusBtn" type="submit">Update Parcel Status</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>