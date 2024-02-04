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
            <div class="card-body bg-main rounded-3">
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
                                $fname = isset($data['address_fullName']) ? $data['address_fullName'] : '';
                                $email = isset($data['address_email']) ? $data['address_email'] : '';
                                $regionCode = isset($data['address_region']) ? $data['address_region'] : '';
                                $provinceCode = isset($data['address_province']) ? $data['address_province'] : '';
                                $cityCode = isset($data['address_city']) ? $data['address_city'] : '';
                                $barangayCode = isset($data['address_barangay']) ? $data['address_barangay'] : '';
                                $phone = isset($data['address_phone']) ? $data['address_phone'] : '';
                                $fulladdr = isset($data['address_fullAddress']) ? $data['address_fullAddress'] : '';

                                ?>
                                <!-- Fname -->
                                <div class=" col-md-12 mb-3">
                                    <div class="form-floating ps-0 mb-3">
                                        <input type="text" class="form-control" id="delivery_fname" value="<?= $fname ?>" name="fullName" placeholder="nasd">
                                        <label for="floatingInput">Full Name</label>
                                        <small class="text-danger fname"></small>
                                    </div>
                                </div>
                                <!-- Email & number -->
                                <div class=" col-md-6 mb-3">
                                    <div class="form-floating ps-0 mb-3">
                                        <input type="email" class="form-control" id="delivery_emailAddr" value="<?= $email ?>" name="emailAddress" placeholder="asd@g.co">
                                        <label for="floatingInput">Email Address</label>
                                        <small class="text-danger email"></small>
                                    </div>
                                </div>
                                <div class=" col-md-6 mb-3">
                                    <div class="form-floating ps-0 mb-3">
                                        <input type="number" class="form-control" id="delivery_phoneNum" value="<?= $phone ?>" name="phoneNumber" placeholder="09" onkeypress="inpNum(event)">
                                        <label for="floatingInput">Phone Number</label>
                                        <small class="text-danger phone"></small>
                                    </div>
                                </div>
                                <!-- State City Country -->
                                <div class="form-floating col-md-12 mb-3">
                                    <div class="form-floating ps-0 mb-3">
                                        <select name="region" class="form-select form-control form-control-md" id="region" required></select>
                                        <input type="hidden" class="form-control form-control-md" name="region_text" id="region-text" required>
                                        <label for="floatingInput">Region</label>
                                        <small class="text-danger region"></small>
                                    </div>
                                </div>
                                <div class=" col-md-4 mb-3">
                                    <div class="form-floating ps-0 mb-3">
                                        <select name="province" class="form-control form-control-md" id="province" required></select>
                                        <input type="hidden" class="form-control form-control-md" name="province_text" id="province-text" required> <!-- Province -->
                                        <label for="floatingInput">Province</label>
                                        <small class="text-danger province"></small>
                                    </div>
                                </div>
                                <div class=" col-md-4 mb-3">
                                    <div class="form-floating ps-0 mb-3">
                                        <select name="city" class="form-control form-control-md" id="city" required></select>
                                        <input type="hidden" class="form-control form-control-md" name="city_text" id="city-text" required> <!-- City -->
                                        <label for="floatingInput">City / Municipality</label>
                                        <small class="text-danger city"></small>
                                    </div>
                                </div>
                                <div class=" col-md-4 mb-3">
                                    <div class="form-floating ps-0 mb-3">
                                        <select name="barangay" class="form-control form-control-md" id="barangay" required></select>
                                        <input type="hidden" class="form-control form-control-md" name="barangay_text" id="barangay-text" required> <!-- Barangay -->
                                        <label for="floatingInput">Barangay</label>
                                        <small class="text-danger barangay"></small>
                                    </div>
                                </div>

                                <!-- Address -->
                                <div class="form-floating col-md-12 mb-3">
                                    <div class="form-floating ps-0 mb-3">
                                        <textarea rows="3" class="form-control" id="delivery_fullAddr" name="fullAddress" placeholder="d" style="height:100px; min-height: 57px; max-height: 100px;"><?= $fulladdr ?></textarea>
                                        <label for="floatingInput">Address</label>
                                        <small class="text-danger address"></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div>
                                <span class="fs-5">Products Ordered
                                    <a href="myCart.php" class="btn btn-primary float-end">Back</a>
                                </span>

                            </div>
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
                            <div class="scrollBarCO overflow-y-auto" style="height: 450px;">
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
                                                    <!--  -->
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
<?php
include('footer.php');
include('../assets/js/ph-address-selector.php');
include('../partials/__footer.php');
?>

<!--------------------------
//+PAYPAL Integration
//+This Code helps with integration: https://stackoverflow.com/questions/56414640/paypal-checkout-javascript-with-smart-payment-buttons-create-order-problem
--------------------------->
<script src="https://www.paypal.com/sdk/js?client-id=AVe3Db1QSdssjRZm8rLrGrd6eWNPiBPsU-ax8oQU2BfXO1UANt6WPddNUjHAsMwQpS375AHeSRrrCMEq&currency=PHP&disable-funding=card"></script>
<script>
    /*//! Prevent user to write letter or symbols in phone number */
    function inpNum(e) {
        e = e || window.event;
        var charCode = (typeof e.which == "undefined") ? e.keyCode : e.which;
        var charStr = String.fromCharCode(charCode);

        // Allow only numeric characters
        if (!charStr.match(/^[0-9]+$/)) {
            e.preventDefault();
        }

        // Allow a maximum of 11 digits
        var inputValue = e.target.value || '';
        var numericValue = inputValue.replace(/[^0-9]/g, '');

        if (numericValue.length == 11) {
            e.preventDefault();
        }

        // Apply Philippine phone number format (optional)
        if (numericValue.length === 1 && numericValue !== '0') {
            // Add '0' at the beginning if the first digit is not '0'
            e.target.value = '0' + numericValue;
        } else if (numericValue.length >= 2 && !numericValue.startsWith('09')) {
            // Ensure it starts with '09'
            e.target.value = '09' + numericValue.substring(2);
        }
    }

    /*//! Cash on Delivery */
    var rn = Math.floor(Math.random() * (9999999 - 10000 + 1)) + 1000;
    // Extract the last 4 digits of the phone number
    var phoneNum = $('#delivery_phoneNum').val();
    var last4Digits = phoneNum.slice(-4);
    var paymentID = "COD" + rn + last4Digits;
    document.getElementById("paymentIDInput").value = paymentID;

    

    /*//! Delivery Address validate function */
    function validateForm() {
        var isValid = true;

        // Get the values
        var fname = $('#delivery_fname').val();
        var email = $('#delivery_emailAddr').val();
        var phoneNum = $('#delivery_phoneNum').val();
        var region = $('#region').val();
        var province = $('#province').val();
        var city = $('#city').val();
        var barangay = $('#barangay').val();
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
        } else if (!phoneNum.match(/^09\d{9}$/)) {
            $(".phone").text("*Invalid Philippine phone number format");
            isValid = false;
        }

        if (region.length === 0) {
            $(".region").text("*This field is required");
            isValid = false;
        }

        if (province.length === 0) {
            $(".province").text("*This field is required");
            isValid = false;
        }

        if (city.length === 0) {
            $(".city").text("*This field is required");
            isValid = false;
        }

        if (barangay.length === 0) {
            $(".barangay").text("*This field is required");
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
                    shipping: {
                        method: "United States Postal Service",
                        address: {
                            name: {
                                full_name: $('#delivery_fname').val(),
                            },
                            address_line_1: $('#delivery_fullAddr').val(),
                            /* Full address */

                            admin_area_2: $('#city-text').val(), 
                            /* City */

                            admin_area_1: $('#region-text').val(),
                            /* State */

                            postal_code: $('#province-text').val(),
                            /* Zipcode */

                            country_code: 'PH' /* Country */
                        }
                    }
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
                var region = $('#region').val();
                var province = $('#province').val();
                var city = $('#city').val();
                var barangay = $('#barangay').val();
                var fullAddr = $('#delivery_fullAddr').val();

                var data = {
                    'fullName': fname,
                    'emailAddress': email,
                    'phoneNumber': phoneNum,
                    'region': region,
                    'province': province,
                    'city': city,
                    'barangay': barangay,
                    /* 'country': "PH", */
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