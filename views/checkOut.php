<?php include('../partials/__header.php');
include('../middleware/userMW.php');
include('../models/dbcon.php');

$cartCheck = checkItemExists();
if (mysqli_num_rows($cartCheck) < 1) {
    redirectSwal("myCart.php", "Your cart is empty", "error");
}
?>
<div class="py-3 bg-primary">
    <div class="container">
        <h6>
            <a href="#" class="text-dark">Home /</a>
            <a href="myCart.php" class="text-dark">Cart /</a>
            <a href="#" class="text-dark">Check out /</a>
        </h6>
    </div>
</div>

<div class="mt-5 mb-5">
    <div class="container">
        <?php
        if (isset($_SESSION['Errormsg'])) {
        ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-triangle-exclamation" style="color: #58151C;"></i>
                <?= $_SESSION['Errormsg']; ?>.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php
            /* Alert popup will show here */
            unset($_SESSION['Errormsg']);
        }
        ?>
        <div class="card shadow">
            <div class="card-body bg-main">
                <form action="../models/placeOrder.php" method="POST">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Delivery Address</h5>
                            <hr>
                            <div class="row">
                                <?php
                                $user = getUserAddress();
                                $data = mysqli_fetch_array($user);
                        
                                $fname = isset($data['address_fullName']) ? $data['address_fullName'] : '';
                                $email = isset($data['address_email']) ? $data['address_email'] : '';
                                $pcode = isset($data['address_postal_code']) ? $data['address_postal_code'] : '';
                                $phone = isset($data['address_phone']) ? $data['address_phone'] : '';
                                $fulladdr = isset($data['address_fullAddress']) ? $data['address_fullAddress'] : '';

                                ?>
                                <div class="form-floating col-md-6 mb-3">
                                    <div class="form-floating ps-0 mb-3">
                                        <input type="text" class="form-control" id="delivery_fname" value="<?= $fname ?>" name="fullName" placeholder="nasd">
                                        <label for="floatingInput">Full Name</label>
                                        <small class="text-danger name"></small>
                                    </div>
                                </div>
                                <div class="form-floating col-md-6 mb-3">
                                    <div class="form-floating ps-0 mb-3">
                                        <input type="email" class="form-control" id="delivery_emailAddr" value="<?= $email ?>" name="emailAddress" placeholder="asd@g.co">
                                        <label for="floatingInput">Email Address</label>
                                        <small class="text-danger email"></small>
                                    </div>
                                </div>
                                <div class="form-floating col-md-6 mb-3">
                                    <div class="form-floating ps-0 mb-3">
                                        <input type="number" class="form-control" id="delivery_phoneNum" value="<?= $phone ?>" name="phoneNumber" placeholder="12">
                                        <label for="floatingInput">Phone Number</label>
                                        <small class="text-danger phone"></small>
                                    </div>
                                </div>
                                <div class="form-floating col-md-6 mb-3">
                                    <div class="form-floating ps-0 mb-3">
                                        <input type="text" class="form-control" id="delivery_postCode" value="<?= $pcode ?>" name="postalCode" placeholder="asd123">
                                        <label for="floatingInput">Postal Code</label>
                                        <small class="text-danger postal"></small>
                                    </div>
                                </div>
                                <div class="form-floating col-md-12 mb-3">
                                    <div class="form-floating ps-0 mb-3">
                                        <textarea rows="3" class="form-control" id="delivery_fullAddr" name="fullAddress" placeholder="d" style="height:100px; min-height: 57px; max-height: 100px;"><?= $fulladdr ?></textarea>
                                        <label for="floatingInput">Full Adress</label>
                                        <small class="text-danger address"></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5>Products Ordered</h5>
                            <hr>
                            <?php
                            $items = getCartItems();
                            $totalPrice = 0;
                            $groupedItems = [];
                            $itemQty = getAllItemQty();

                            // Group items by category_name
                            foreach ($items as $cItem) {
                                $categoryName = $cItem['category_name'];
                                if (!isset($groupedItems[$categoryName])) {
                                    $groupedItems[$categoryName] = [];
                                }
                                $groupedItems[$categoryName][] = $cItem;
                            } ?>
                            <div class="scrollBarCO" style="height: 450px; overflow-y: scroll;">
                                <?php
                                // Display grouped items
                                foreach ($groupedItems as $categoryName => $categoryItems) {
                                ?>
                                    <div class="card mb-3 border rounded-3">
                                        <div class="card-header bg-primary">
                                            <h5 class="card-title"><?= $categoryName ?></h5>
                                        </div>
                                        <div class="card-body bg-primary">
                                            <?php foreach ($categoryItems as $index => $cItem) {
                                                $itemTotalPrice = $cItem['product_srp'] * $cItem['product_qty'];
                                                $totalPrice += $itemTotalPrice;
                                            ?>
                                                <div class="productData row align-items-center <?= ($index < count($categoryItems) - 1) ? 'mb-0' : '' ?>">
                                                    <div class="col-md-2">
                                                        <center>
                                                            <img src="../assets/uploads/products/<?= $cItem['product_image'] ?>" alt="Product Image" width="80px">
                                                        </center>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <h5><?= $cItem['product_name'] ?></h5>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <h5 class="text-end">₱<?= number_format($itemTotalPrice, 2) ?></h5>
                                                    </div>
                                                    <div class="col-md-2 text-center">
                                                        <h5><?= $cItem['product_qty'] ?></h5>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>

                                <?php
                                }
                                ?>
                            </div>
                            <div class="card">
                                <div class="card-body bg-primary">
                                    <h5>Order Total&nbsp;(<span class="text-accent"><?= $itemQty ?>&nbsp;item</span>): <span class="text-accent">₱<?= number_format($totalPrice, 2) ?></span></h5>
                                </div>
                                <div class="card-body bg-primary">
                                    <input type="hidden" name="paymentMode" value="Cash on Delivery">
                                    <button type="submit" name="placeOrderBtn" class="btn btn-accent w-100 mb-3">COD | Place Order</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include('footer.php'); ?>
<?php include('../partials/__footer.php'); ?>