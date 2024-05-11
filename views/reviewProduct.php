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
<div class="py-3 bg-primary">
    <div class="container">
        <h6>
            <a href="#" class="text-dark">Home</a> /
            <a href="myOrders.php" class="text-dark">My Purchase</a> /
            <a href="viewOrderDetails.php?trck=<?= $tracking_no; ?>" class="text-dark">Your Order Details</a> /
            <a href="#" class="text-dark">Review Product</a>
        </h6>
    </div>
</div>
<div class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Review Product</h2>
                <div class="card">
                    <div class="card-header bg-main">
                        <a href="viewOrderDetails.php?trck=<?= $tracking_no; ?>" class="btn btn-primary float-start">Back</a>
                    </div>
                    <div class="card-body bg-main">
                        <div class="row">
                            <!-- Order Item Details -->
                            <div class="col-md-12">
                                <?php
                                $user_id = $_SESSION['auth_user']['user_ID'];
                                $groupedItems = [];
                                $totalPrice = 0;
                                $itemQty = getOrderedItemQty($tracking_no);
                                $order_query = "SELECT o.orders_id as oid, o.orders_tracking_no, o.orders_user_ID, oi.*, p.*, c.category_name, c.category_slug, c.category_isBan
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
                                        }

                                        foreach ($groupedItems as $categoryName => $items) {
                                    ?>
                                            <div class="card mb-3 rounded-3 bg-primary">
                                                <div class="card-header">
                                                    <h5 class="card-title fw-bold">
                                                        <span><?= $categoryName ?></span>
                                                        <span><a href="store.php?category=<?= $item['category_slug'] ?>" class="btn btn-accent"><i class="fa-solid fa-store"></i>&nbsp;View Store</a> <?= ($item['category_isBan'] == 1) ? "<span class='badge bg-danger'>Banned</span>" : "" ?></span>
                                                    </h5>
                                                </div>
                                                <div class="card-body">
                                                    <?php
                                                    foreach ($items as $item) {
                                                    ?>
                                                        <a href="productView.php?product=<?= $item['product_slug'] ?>" class="text-decoration-none">
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
                                                        </a>
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
                                <?php
                                if ($item['category_isBan'] == 1) {
                                ?>
                                    <p class='fs-2 fw-bold text-accent text-center'>"<?= $item['category_name'] ?>" is permanently banned</p>
                                <?php
                                } else {
                                ?>
                                    <hr>
                                    <div class="mt-2">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <h2>Product Quality</h2>
                                                <div class="stars">
                                                    <?php
                                                    $reviews_query = "SELECT * FROM `products_reviews` WHERE `orders_tracking_no` = '$tracking_no'";
                                                    $reviews_query_run = mysqli_query($con, $reviews_query);

                                                    //+ Fetch all reviews and store them in an associative array with product_id as the key
                                                    $product_reviews = [];
                                                    while ($row = mysqli_fetch_assoc($reviews_query_run)) {
                                                        $product_reviews[$row['product_id']] = $row;
                                                    }
                                                    ?>

                                                    <form action="../models/rateProduct.php" method="POST">
                                                        <input type="hidden" name="trackingNumber" value="<?= $tracking_no; ?>">
                                                        <input type="hidden" name="userID" value="<?= $user_id; ?>">

                                                        <div class="mb-3">
                                                            <select name="prodID" class="form-select" onchange="updateReviewAndStars()">
                                                                <?php foreach ($items as $item) : ?>
                                                                    <option value="<?= $item['product_id'] ?>"><?= $item['product_name'] ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>

                                                        <div class="float-left">
                                                            <?php for ($i = 5; $i >= 1; $i--) : ?>
                                                                <input class="star" id="star<?= $i ?>" type="radio" name="star" value="<?= $i ?>" />
                                                                <label class="star" for="star<?= $i ?>"></label>
                                                            <?php endfor; ?>
                                                        </div>

                                                        <div class="mb-5">
                                                            <textarea name="reviewText" id="reviewText" class="col-md-12 rounded rounded-3 border border-accent" maxlength="600" cols="30" placeholder="Write about this product" rows="4"></textarea>
                                                            <div id="the-count">
                                                                <span id="current">0</span>
                                                                <span id="maximum">/ 600</span>
                                                            </div>
                                                        </div>

                                                        <?php if (isset($product_reviews[$item['product_id']]) && $product_reviews[$item['product_id']]['review_isReviewed'] == 1) { ?>
                                                            <?php
                                                            $review_id = $product_reviews[$item['product_id']]['review_id'];
                                                            ?>
                                                            <input type="hidden" name="reviewID" value="<?= $review_id ?>">
                                                            <button type="submit" name="editRateProductBtn" class="btn btn-accent col-md-12">
                                                                Edit Rating
                                                            </button>
                                                        <?php } else { ?>
                                                            <button type="submit" name="rateProductBtn" class="btn btn-accent col-md-12">Rate</button>
                                                        <?php } ?>
                                                    </form>
                                                </div>
                                            </div>
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
    </div>
</div>

<div>
    <?php include('footer.php');
    ?>
</div>

<?php include('../partials/__footer.php');

?>

<script>
    //+ jquery code to adjust the height based on the number of items
    $(document).ready(function() {
        var itemsContainer = $("#itemsContainer");
        var groupedItemsCount = <?= count($groupedItems); ?>;

        //+ Check if there's more than one group, set height accordingly
        if (groupedItemsCount > 1) {
            itemsContainer.css("height", "386px");
        } else {
            itemsContainer.css("height", "auto");
        }
    });

    //+ Function to update review and stars
    function updateReviewAndStars() {
        var select = document.querySelector('select[name="prodID"]');
        var selectedProductId = select.value;
        var reviewTextarea = document.getElementById('reviewText');
        var starsRadios = document.querySelectorAll('input[name="star"]');
        var reviewIdInput = document.querySelector('input[name="reviewID"]'); //+ Fetch reviewID input name

        //+ Check the textarea is focused
        if (document.activeElement === reviewTextarea) {
            return; //+ Don't update the updateReviewAndStars() if textArea is focused
        }

        //+ Check if there's a review available for the selected product
        if (selectedProductId in <?= json_encode($product_reviews); ?>) {
            var reviewData = <?= json_encode($product_reviews); ?>[selectedProductId];
            reviewTextarea.value = reviewData.product_review;
            //+ Set the corresponding star rating
            for (var i = 0; i < starsRadios.length; i++) {
                //+ Compare ratings as integers
                if (parseInt(starsRadios[i].value) === parseInt(reviewData.product_rating)) {
                    starsRadios[i].checked = true;
                } else {
                    starsRadios[i].checked = false;
                }
            }
            //+ Update reviewID value
            reviewIdInput.value = reviewData.review_id;
        } else {
            reviewTextarea.value = '';
            //+ Reset star ratings
            for (var i = 0; i < starsRadios.length; i++) {
                starsRadios[i].checked = false;
            }
            //+ Reset reviewID value
            reviewIdInput.value = '';
        }

        //+ Update character count
        var characterCount = reviewTextarea.value.length;
        $('#current').text(characterCount);

        // Change color based on character count
        if (characterCount < 70) {
            $('#current').css('color', '#666');
        } else if (characterCount >= 70 && characterCount < 90) {
            $('#current').css('color', '#6d5555');
        } else if (characterCount >= 90 && characterCount < 100) {
            $('#current').css('color', '#793535');
        } else if (characterCount >= 100 && characterCount < 120) {
            $('#current').css('color', '#841c1c');
        } else if (characterCount >= 120 && characterCount < 139) {
            $('#current').css('color', '#8f0001');
        }

        //+ Change colors and font weight for maximum count
        if (characterCount >= 140) {
            $('#maximum').css('color', '#8f0001');
            $('#current').css('color', '#8f0001');
            $('#the-count').css('font-weight', 'bold');
        } else {
            $('#maximum').css('color', '#666');
            $('#the-count').css('font-weight', 'normal');
        }
    }

    //+ Call updateReviewAndStars() initially
    updateReviewAndStars();

    //+ Bind keyup event to textarea for character count update
    $('textarea').keyup(function() {
        updateReviewAndStars();
    });

    //+ Bind change event to select dropdown for updating review and stars
    $('select[name="prodID"]').change(function() {
        updateReviewAndStars();
    });
</script>