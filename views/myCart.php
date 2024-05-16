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
                <div class="col-md-12">
                    <div class="text-center">
                        <h1 class="mb-3">Cart</h1>
                    </div>

                    <div class="card p-3 border rounded-3 bg-tertiary">
                        <div class="row">
                            <div class="col-md-5">
                                <h6>Product</h6>
                            </div>
                            <div class="col-md-2 pl-2 d-flex justify-content-center">
                                <h6>Unit Price</h6>
                            </div>
                            <div class="col-md-2 pl-0 d-flex justify-content-center">
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

                    <div class="text-center mt-3" id="nocartItems">
                        <p>Currently, there are no goods in your Cart.</p>
                    </div>
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
                            <div id="categoryCard" class="card my-4 border rounded-3 bg-tertiary">
                                <div class="card-header">
                                    <h5 class="card-title">
                                        <a href="store.php?category=<?= $categslug ?>" class="text-dark">
                                            <?= $categoryName ?>
                                        </a>
                                    </h5>
                                </div>
                                <div id="itemsContainer" class="card-body overflow-x-auto">
                                    <?php
                                    foreach ($categoryData['items'] as $index => $cItem) {

                                        $itemTotalPrice = $cItem['product_srp'] * $cItem['product_qty'];
                                        $totalPrice += $itemTotalPrice;
                                        $srp = $cItem['product_srp'];
                                        $orig_price = $cItem['product_original_price'];
                                        $discount = $cItem['product_discount'];
                                    ?>
                                        <div id="productList" class="productData row align-items-center <?= ($index < count($categoryData['items']) - 1) ? 'mb-3' : '' ?>">


                                            <!-- Product Image -->
                                            <div class="col-md-2">
                                                <center>
                                                    <a href="productView.php?product=<?= $cItem['product_slug'] ?>"><img src="../assets/uploads/products/<?= $cItem['product_image'] ?>" alt="Product Image" width="100px"></a>
                                                </center>
                                            </div>
                                            <!-- Product Name -->
                                            <div class="col-md-3">
                                                <a href="productView.php?product=<?= $cItem['product_slug'] ?>" class="text-dark">
                                                    <h5><?= $cItem['product_name'] ?></h5>
                                                </a>
                                            </div>
                                            <!-- Product Price -->
                                            <div class="col-md-2">
                                                <?php
                                                if ($srp == $orig_price) {
                                                ?>
                                                    <h6 class="d-flex justify-content-center">₱<?= number_format($srp, 2) ?></h6>
                                                <?php
                                                } else if ($srp != $orig_price) {
                                                ?>
                                                    <span class="d-flex justify-content-center">
                                                        <h6 class="text-secondary text-decoration-line-through mr-2">₱<?= number_format($orig_price, 2) ?></h6>
                                                        &nbsp;
                                                        <h6>₱<?= number_format($srp, 2) ?></h6>
                                                    </span>
                                                    <span class="d-flex justify-content-center text-accent">
                                                        Discount <?= $discount ?>%
                                                    </span>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                            <!-- Product Quantity -->
                                            <div class="col-md-2">
                                                <input type="hidden" class="productID" value="<?= $cItem['product_id'] ?>">
                                                <div class="d-flex justify-content-center">
                                                    <div class="input-group mb-2" style="width:120px;">
                                                        <button class="input-group-text decrementProductBtn updateQty btn-main">-</button>
                                                        <input type="text" class="form-control bg-white inputQty text-center" value="<?= $cItem['product_qty'] ?>" readonly data-price="<?= $cItem['product_srp'] ?>" data-remain="<?= $cItem['product_remain'] ?>">
                                                        <button class="input-group-text incrementProductBtn updateQty btn-main">+</button>
                                                    </div>
                                                </div>
                                                <span class="d-flex justify-content-center text-accent itemLeft">
                                                    <?= $cItem['product_remain'] ?> items left
                                                </span>
                                            </div>

                                            <!-- Total Price -->
                                            <div class="col-md-2 text-accent">
                                                <h5>₱<span class="productPrice"><?= number_format($itemTotalPrice, 2) ?></span></h5>
                                            </div>
                                            <!-- Delete Btn -->
                                            <div class="col-md-1">
                                                <button id="deleteItem" class="btn btn-main" value="<?= $cItem['cid'] ?>">Delete</button>
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
            </div>
        </div>
    </div>

    <div class="container fixed-bottom">
        <div class="row">
            <div class="col-md-12">
                <!-- Footer -->
                <footer class="bg-tertiary text-center text-white shadow">
                    <div class="p-4">
                        <section class="pb-5">
                            <div class="float-end text-dark">
                                <h5>Total (<span><?php if (isset($_SESSION['auth'])) {
                                                        echo getCartQty();
                                                    } ?>
                                    </span>
                                    items):
                                    <span class="fs-4 fw-bold text-accent">₱<span class="overallPrice"><?= number_format($totalPrice, 2) ?></span></span>
                                    <a href="checkOut.php" class="ml-3 btn btn-main">Check out</a>
                                </h5>
                            </div>
                        </section>
                    </div>
                </footer>
                <!-- Footer -->
            </div>
        </div>
    </div>

    <div style="margin-top:20%;">
        <?php include('footer.php'); ?>
    </div>

    <?php include('../partials/__footer.php'); ?>
</div>