<?php
include('../partials/__header.php');
include('../middleware/userMW.php');/* Authenticate.php */
?>
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

$regionCode = isset($data['orders_region']) ? $data['orders_region'] : '';
$provinceCode = isset($data['orders_province']) ? $data['orders_province'] : '';
$cityCode = isset($data['orders_city']) ? $data['orders_city'] : '';
$barangayCode = isset($data['orders_barangay']) ? $data['orders_barangay'] : '';
?>

<style>
    input.star {
        display: none;
    }

    label.star {
        padding-left: 10px;
        padding-right: 10px;
        font-size: 36px;
        color: #FED420;
        transition: all .2s;
        float: right;
    }

    input.star:checked~label.star:before {
        content: '\f005';
        color: #FD4;
        transition: all .25s;
    }

    label.star:before {
        content: '\f006';
        font-family: FontAwesome;
    }

    input.star-1:checked~label.star:before {
        color: #FED420;
    }

    label.star:before {
        content: '\f006';
        font-family: FontAwesome;
    }

    #the-count {
        float: right;
        padding: 0.1rem 0 0 0;
        font-size: 0.875rem;
    }
</style>

<div class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Review Product</h2>
                <div class="card">
                    <div class="card-header bg-main">
                        <a href="viewOrderDetails.php?trck=<?= $tracking_no; ?>" class="btn btn-primary float-start">Back</a>
                        <span class="fs-6 float-end">
                            <span class="float-end">NRCRXpress</span>
                            <br>
                            <?= $tracking_no; ?>
                        </span>
                    </div>
                    <div class="card-body bg-main">
                        <div class="row">
                            <!-- Order Item Details -->
                            <div class="col-md-12">
                                <!-- <h2>Order Item Details</h2>
                                <hr> -->
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
                                $data = mysqli_fetch_assoc($order_query_run);

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
                                        }

                                        foreach ($groupedItems as $categoryName => $items) {
                                    ?>
                                            <div class="card mb-3 rounded-3 bg-primary">
                                                <div class="card-header">
                                                    <h5 class="card-title fw-bold">
                                                        <span><?= $categoryName ?></span>
                                                    </h5>
                                                </div>
                                                <div class="card-body">
                                                    <?php
                                                    foreach ($items as $item) {
                                                    ?>
                                                        <!-- <a href="productView.php?product=<?= $item['product_slug'] ?>" class="text-decoration-none"> -->
                                                        <div class="row align-items-center mb-2">
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
                                                        <!-- </a> -->
                                                    <?php
                                                    }
                                                    ?>
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
                                        <div class="row">
                                            <h2>Product Quality</h2>
                                            <div class="stars">
                                                <form action="../models/rateProduct.php" method="POST">
                                                    <input type="hidden" name="trackingNumber" value="<?= $tracking_no; ?>">
                                                    <input type="hidden" name="prodID" value="<?= $data['product_id'] ?>">
                                                    <input type="hidden" name="userID" value="<?= $user_id; ?>">

                                                    <div class="float-left">
                                                        <input class="star star-5" id="star-5" type="radio" name="star" value="5" checked />
                                                        <label class="star star-5" for="star-5"></label>

                                                        <input class="star star-4" id="star-4" type="radio" name="star" value="4" />
                                                        <label class="star star-4" for="star-4"></label>

                                                        <input class="star star-3" id="star-3" type="radio" name="star" value="3" />
                                                        <label class="star star-3" for="star-3"></label>

                                                        <input class="star star-2" id="star-2" type="radio" name="star" value="2" />
                                                        <label class="star star-2" for="star-2"></label>

                                                        <input class="star star-1" id="star-1" type="radio" name="star" value="1" />
                                                        <label class="star star-1" for="star-1"></label>
                                                    </div>

                                                    <div class="mb-5">
                                                        <textarea name="reviewText" class="col-md-12 rounded rounded-3 border border-accent" id="the-textarea" maxlength="600" cols="30" placeholder="Write about this product" rows="4"></textarea>
                                                        <div id="the-count">
                                                            <span id="current">0</span>
                                                            <span id="maximum">/ 600</span>
                                                        </div>
                                                    </div>

                                                    <button type="submit" name="rateProductBtn" class="btn btn-accent col-md-12">Rate</button>
                                                </form>
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
    <?php include('footer.php');
    include('../assets/js/ph-address-selector.php');
    ?>
</div>

<?php include('../partials/__footer.php');

?>

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

    /* text area character count */
    $('textarea').keyup(function() {

        var characterCount = $(this).val().length,
            current = $('#current'),
            maximum = $('#maximum'),
            theCount = $('#the-count');

        current.text(characterCount);


        /*This isn't entirely necessary, just playin around*/
        if (characterCount < 70) {
            current.css('color', '#666');
        }
        if (characterCount > 70 && characterCount < 90) {
            current.css('color', '#6d5555');
        }
        if (characterCount > 90 && characterCount < 100) {
            current.css('color', '#793535');
        }
        if (characterCount > 100 && characterCount < 120) {
            current.css('color', '#841c1c');
        }
        if (characterCount > 120 && characterCount < 139) {
            current.css('color', '#8f0001');
        }

        if (characterCount >= 140) {
            maximum.css('color', '#8f0001');
            current.css('color', '#8f0001');
            theCount.css('font-weight', 'bold');
        } else {
            maximum.css('color', '#666');
            theCount.css('font-weight', 'normal');
        }
    });
</script>