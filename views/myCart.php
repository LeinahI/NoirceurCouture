<style>
    #bottomSummary {
        display: none;
    }

    .delText {
        display: none;
    }

    @media (max-width: 991px) {
        .discount {
            display: none !important;
        }

        .origprice {
            display: none !important;
        }
    }

    @media (max-width: 767px) {
        #bottomSummary {
            display: block;
        }

        #sideSummary {
            display: none;
        }
    }

    @media (max-width: 432px) {
        .col-xs-12 {
            flex: 0 0 auto !important;
            width: 100% !important;
        }

        .ITPrice {
            text-align: start;
        }

        .col-5 {
            width: 66.66666667% !important;
        }

        .deleteBtn {
            width: 100% !important;
        }

        .deleteIcon {
            display: none;
        }

        .delText {
            display: block;
        }
    }
</style>
<div id="mycart">
    <?php include('../partials/__header.php');

    include('../middleware/userMW.php');
    ?>
    <div class="py-3 bg-main">
        <div class="container">
            <h6>
                <a href="index.php" class="text-dark">Home</a> /
                <a href="myCart.php" class="text-dark">Cart</a>
            </h6>
        </div>
    </div>

    <div class="cart-items">
        <div class="container">
            <div class="row">
                <div class="text-center">
                    <h1>Cart</h1>
                </div>
                <div class="text-center" id="nocartItems">
                    <p>Currently, there are no goods in your Cart.</p>
                </div>
                <div class="col-sm-12 col-md-8">

                    <?php
                    $items = getCartItems();
                    $groupedItems = [];
                    $itemArray = [];
                    $totalPrice = 0;

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

                    if (count($itemArray) > 0) {
                        // Display grouped items
                        foreach ($groupedItems as $categoryName => $categoryData) {
                            $categslug = $categoryData['categslug'];

                    ?>
                            <div id="categoryCard" class="card mb-4 border rounded-3 bg-tertiary border-0">
                                <div class="card-header border-0 bg-tertiary">
                                    <h5 class="card-title">
                                        <a href="store.php?category=<?= $categslug ?>" class="text-dark">
                                            <?= $categoryName ?>
                                        </a>
                                    </h5>
                                </div>
                                <div id="itemsContainer" class="card-body col-12">
                                    <?php
                                    foreach ($categoryData['items'] as $index => $cItem) {

                                        $itemTotalPrice = $cItem['product_srp'] * $cItem['product_qty'];
                                        $totalPrice += $itemTotalPrice;
                                        $srp = $cItem['product_srp'];
                                        $orig_price = $cItem['product_original_price'];
                                        $discount = $cItem['product_discount'];
                                    ?>
                                        <div id="productList" class="productData row align-items-center <?= ($index < count($categoryData['items']) - 1) ? 'my-2 py-2 border-bottom' : '' ?>">
                                            <!-- Product Image -->
                                            <div class="col-4 col-lg-3 col-md-4 col-sm-4">
                                                <a href="productView.php?product=<?= $cItem['product_slug'] ?>"><img class="w-100" src="../assets/uploads/products/<?= $cItem['product_image'] ?>" alt="Product Image"></a>
                                            </div>
                                            <!-- Product Name -->
                                            <div class="col-5 col-lg-6 col-md-5 col-sm-5 ">
                                                <div>
                                                    <a href="productView.php?product=<?= $cItem['product_slug'] ?>" class="text-dark fs-5">
                                                        <?= $cItem['product_name'] ?>
                                                    </a>
                                                </div>
                                                <div>
                                                    <?php
                                                    if ($srp == $orig_price) {
                                                    ?>
                                                        <h6>₱<?= number_format($srp, 2) ?></h6>

                                                    <?php
                                                    } else if ($srp != $orig_price) {
                                                    ?>
                                                        <span class="d-flex">
                                                            <h6 class="text-secondary text-decoration-line-through mr-2 origprice">₱<?= number_format($orig_price, 2) ?></h6>
                                                            <h6>₱<?= number_format($srp, 2) ?></h6>
                                                        </span>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                                <div>
                                                    <input type="hidden" class="productID" value="<?= $cItem['product_id'] ?>">
                                                    <div class="d-flex justify-content-start">
                                                        <div class="input-group" style="width:120px;">
                                                            <button class="input-group-text decrementProductBtn updateQty btn-main">-</button>
                                                            <input type="text" class="form-control bg-white inputQty text-center" value="<?= $cItem['product_qty'] ?>" readonly data-price="<?= $cItem['product_srp'] ?>" data-remain="<?= $cItem['product_remain'] ?>">
                                                            <button class="input-group-text incrementProductBtn updateQty btn-main">+</button>
                                                        </div>
                                                    </div>
                                                    <small>
                                                        <?= $cItem['product_remain'] ?> items left
                                                    </small>
                                                </div>
                                            </div>

                                            <!-- Delete Btn -->
                                            <div class="col-3 col-xs-12 text-end">
                                                <div class="ITPrice">
                                                    <h5 class="sticky-sm-top">₱<span class="text-accent productPrice"><?= number_format($itemTotalPrice, 2) ?></span></h5>
                                                </div>
                                                <div>
                                                    <button id="deleteItem" class="btn btn-main deleteBtn" value="<?= $cItem['cid'] ?>"><i class="bi bi-trash deleteIcon"></i> <span class="delText">Delete Product</span></button>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>
                <!-- Side -->
                <div class="col-4" id="sideSummary">
                    <div class="card bg-tertiary border-0">
                        <div class="card-body col-12">
                            <h5 class="card-title">Cart Details</h5>
                            <div class="text-dark">
                                <div class="row">
                                    <div class="col-10 text-start">
                                        Product Count
                                    </div>
                                    <div class="col-2 text-end">
                                        <?php if (isset($_SESSION['auth'])) {
                                            $cartQty = getCartQty(); ?>
                                            <span class="text-dark" id="productCount"><?php echo $cartQty; ?></span>
                                        <?php } ?>
                                    </div>
                                </div>
                                <hr>
                                <div class="row fw-bold fs-6">
                                    <div class="col-6 text-start mr-0">
                                        Total Price
                                    </div>
                                    <div class="col-6 text-end">
                                        <span class="">₱<span class="overallPrice"><?= number_format($totalPrice, 2) ?></span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-2">
                                <a href="checkOut.php" class="btn btn-main col-12">Proceed To checkout</a>
                                <a href="storelist.php" class="mt-2 btn btn-tertiary col-12">Continue Shopping</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bottom -->
    <div class="container fixed-bottom" id="bottomSummary">
        <div class="row">
            <div class="col-12">
                <div class="card py-4 px-3 border-0 bg-tertiary rounded-0">
                    <div class="float-end text-dark">
                        <h5>Total (<span><?php if (isset($_SESSION['auth'])) {
                                                echo getCartQty();
                                            } ?>
                            </span>
                            items):
                            <span class="fs-4 fw-bold text-accent">₱<span class="overallPrice"><?= number_format($totalPrice, 2) ?></span></span>
                        </h5>
                        <a href="checkOut.php" class="btn btn-main col-12">Proceed To checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="margin-top:20%;">
        <?php include('footer.php'); ?>
    </div>

    <?php include('../partials/__footer.php'); ?>
</div>