<?php include('includes/header.php');

include('middleware/userMW.php');
?>
<div class="py-3 bg-primary">
    <div class="container">
        <h6 class="text-white">
            <a href="#" class="text-white">Home /</a>
            <a href="#" class="text-white">Cart</a>
        </h6>
    </div>
</div>

<div id="mycart">
    <div class="mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card p-3 border rounded-3 shadow">
                        <div class="row">
                            <div class="col-md-5">
                                <h6>Product</h6>
                            </div>
                            <div class="col-md-2">
                                <h6>Unit Price</h6>
                            </div>
                            <div class="col-md-2">
                                <h6>Quantity</h6>
                            </div>
                            <div class="col-md-2">
                                <h6>Total Price</h6>
                            </div>
                            <div class="col-md-1">
                                <h6>Action</h6>
                            </div>
                        </div>
                    </div>
                    <div>
                        <?php
                        $items = getCartItems();
                        $groupedItems = [];
                        $totalPrice = 0;
                        // Group items by category_name
                        foreach ($items as $cItem) {
                            $categoryName = $cItem['category_name'];
                            if (!isset($groupedItems[$categoryName])) {
                                $groupedItems[$categoryName] = [];
                            }
                            $groupedItems[$categoryName][] = $cItem;
                        }

                        if (mysqli_num_rows($items) > 0) {
                            // Display grouped items
                            foreach ($groupedItems as $categoryName => $categoryItems) {
                        ?>
                                <div class="card my-4 p-3 border rounded-3 shadow">
                                    <div class="card-header">
                                        <h5 class="card-title"><?= $categoryName ?></h5>
                                    </div>
                                    <div class="card-body">
                                        <?php foreach ($categoryItems as $index => $cItem) {
                                            $itemTotalPrice = $cItem['product_srp'] * $cItem['product_qty'];
                                            $totalPrice += $itemTotalPrice;
                                        ?>
                                            <div class="productData row align-items-center <?= ($index < count($categoryItems) - 1) ? 'mb-3' : '' ?>">
                                                <div class="col-md-2">
                                                    <center>
                                                        <a href="productView.php?product=<?= $cItem['product_slug'] ?>"><img src="uploads/products/<?= $cItem['product_image'] ?>" alt="Product Image" width="100px"></a>
                                                    </center>
                                                </div>
                                                <div class="col-md-3">
                                                    <a href="productView.php?product=<?= $cItem['product_slug'] ?>" class="text-dark">
                                                        <h5><?= $cItem['product_name'] ?></h5>
                                                    </a>
                                                </div>
                                                <div class="col-md-2">
                                                    <h5>₱<?= number_format($cItem['product_srp'], 2) ?></h5>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="hidden" class="productID" value="<?= $cItem['product_id'] ?>">
                                                    <div class="input-group mb-3" style="width:120px;">
                                                        <button class="input-group-text decrementProductBtn updateQty">-</button>
                                                        <input type="text" class="form-control bg-white inputQty text-center" value="<?= $cItem['product_qty'] ?>" readonly data-price="<?= $cItem['product_srp'] ?>">
                                                        <button class="input-group-text incrementProductBtn updateQty">+</button>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <h5 class="productPrice">₱<?= number_format($itemTotalPrice, 2) ?></h5>
                                                </div>
                                                <div class="col-md-1">
                                                    <button class="btn btn-danger deleteItem" value="<?= $cItem['cid'] ?>">Delete</button>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php
                            }
                        } else {
                            ?>
                            <div class="mt-5 text-center">
                                <h1>Your cart is empty</h1>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container fixed-bottom">
        <div class="row">
            <div class="col-md-12">
                <!-- Footer -->
                <footer class="bg-dark text-center text-white">
                    <div class="p-4">
                        <section class="pb-5">
                            <div class="float-end">
                                <h5>Total (<span><?php if (isset($_SESSION['auth'])) {
                                                        echo getCartQty();
                                                    } ?></span> items): ₱<span><?= number_format($totalPrice, 2) ?>
                                        &nbsp;&nbsp;&nbsp;</span><a href="checkOut.php" class="btn btn-primary text-white chkOutBtn">Check out</a></h5>
                            </div>
                        </section>
                    </div>
                </footer>
                <!-- Footer -->
            </div>
        </div>
    </div>
</div>

<div style="margin-top:20%;">
    <?php include('ftr.php'); ?>
</div>

<?php include('includes/footer.php'); ?>