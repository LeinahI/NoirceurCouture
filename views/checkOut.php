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
                                        <small class="text-danger fname"></small>
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
                                    <input type="hidden" name="paymentID" value="" id="paymentIDInput">

                                    <button type="submit" name="placeOrderBtn" class="btn btn-accent w-100 mb-3">COD | Place Order</button>
                                    <div id="paypal-button-container"></div>
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

<!--------------------------
PAYPAL Integration
This Code helps with integration: https://stackoverflow.com/questions/56414640/paypal-checkout-javascript-with-smart-payment-buttons-create-order-problem
--------------------------->
<script src="https://www.paypal.com/sdk/js?client-id=AVe3Db1QSdssjRZm8rLrGrd6eWNPiBPsU-ax8oQU2BfXO1UANt6WPddNUjHAsMwQpS375AHeSRrrCMEq&currency=PHP&disable-funding=card"></script>
<script>
    /* COD */
    var rn = Math.floor(Math.random() * (9999999 - 10000 + 1)) + 1000;
    // Extract the last 4 digits of the phone number
    var phoneNum = $('#delivery_phoneNum').val();
    var postalCode = $('#delivery_postCode').val();
    var last4Digits = phoneNum.slice(-4);
    var last4text = postalCode.slice(-4);
    var paymentID = "COD" + rn + last4Digits + last4text;
    document.getElementById("paymentIDInput").value = paymentID;

    /* Delivery Addr validate function */
    function validateForm() {
        var isValid = true;

        // Get the values
        var fname = $('#delivery_fname').val();
        var email = $('#delivery_emailAddr').val();
        var phoneNum = $('#delivery_phoneNum').val();
        var postalCode = $('#delivery_postCode').val();
        var fullAddr = $('#delivery_fullAddr').val();

        // Check each variable
        if (fname.length === 0) {
            $(".fname").text("This field is required");
            isValid = false;
        }

        if (email.length === 0) {
            $(".email").text("*This field is required");
            isValid = false;
        }

        if (phoneNum.length === 0) {
            $(".phone").text("*This field is required");
            isValid = false;
        }

        if (postalCode.length === 0) {
            $(".postal").text("*This field is required");
            isValid = false;
        }

        if (fullAddr.length === 0) {
            $(".address").text("*This field is required");
            isValid = false;
        }
        return isValid;
    }

    paypal.Buttons({
        createOrder: function(data, actions) {
            if (!validateForm()) {
                return false;
            }
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        currency_code: 'PHP',
                        value: '<?= $totalPrice ?>',
                        breakdown: {
                            item_total: {
                                unit_amount: <?= $itemQty ?>,
                                currency_code: 'PHP',
                                value: '<?= $totalPrice ?>',
                            }
                        }
                    },
                }]
            });
        },
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(orderData) {
                /* console.log('Capture Result', orderData, JSON.stringify(orderData, null, 2)); */

                console.log(orderData)
                const transaction = orderData.purchase_units[0].payments.captures[0];
                /* alert(`Transaction ${transaction.status}: ${transaction.id}\n\nSee console for available details`); */

                var fname = $('#delivery_fname').val();
                var email = $('#delivery_emailAddr').val();
                var phoneNum = $('#delivery_phoneNum').val();
                var postalCode = $('#delivery_postCode').val();
                var fullAddr = $('#delivery_fullAddr').val();

                var data = {
                    'fullName': fname,
                    'emailAddress': email,
                    'phoneNumber': phoneNum,
                    'postalCode': postalCode,
                    'fullAddress': fullAddr,
                    'paymentMode': "Paypal",
                    'paymentID': transaction.id,
                    'placeOrderBtn': true,
                };

                $.ajax({
                    method: "POST",
                    url: "../models/placeOrder.php",
                    data: data,
                    success: function(response) {
                        // Show SweetAlert on the current page
                        swal({
                            title: "Order Placed Successfully",
                            icon: "success",
                            button: "OK",
                        }).then(() => {
                            // Redirect to myOrders.php after user clicks OK
                            window.location.href = "myOrders.php";
                        });
                    }
                });

            });
        }
    }).render('#paypal-button-container');
</script>