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
                                $state = isset($data['address_state']) ? $data['address_state'] : '';
                                $city = isset($data['address_city']) ? $data['address_city'] : '';
                                $pcode = isset($data['address_postal_code']) ? $data['address_postal_code'] : '';
                                $country = isset($data['address_country']) ? $data['address_country'] : '';
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
                                <div class=" col-md-4 mb-3">
                                    <div class="form-floating ps-0 mb-3">
                                        <input type="text" class="form-control" id="delivery_state" value="<?= $state ?>" name="state" placeholder="asd123">
                                        <label for="floatingInput">State</label>
                                        <small class="text-danger state"></small>
                                    </div>
                                </div>
                                <div class=" col-md-4 mb-3">
                                    <div class="form-floating ps-0 mb-3">
                                        <input type="text" class="form-control" id="delivery_city" value="<?= $city ?>" name="city" placeholder="asd123">
                                        <label for="floatingInput">City</label>
                                        <small class="text-danger city"></small>
                                    </div>
                                </div>
                                <div class=" col-md-4 mb-3">
                                    <div class="form-floating ps-0 mb-3">
                                        <input type="text" class="form-control" id="delivery_postCode" value="<?= $pcode ?>" name="postalCode" placeholder="asd123">
                                        <label for="floatingInput">Postal Code</label>
                                        <small class="text-danger postal"></small>
                                    </div>
                                </div>
                                <div class="form-floating col-md-12 mb-3">
                                    <div class="form-floating ps-0 mb-3">
                                        <select class="form-select" id="delivery_country" name="country">
                                            <?php include('../partials/country-options.php') ?>
                                        </select>
                                        <label for="floatingInput">Country</label>
                                        <small class="text-danger country"></small>
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
<?php include('footer.php'); ?>
<?php include('../partials/__footer.php'); ?>

<!--------------------------
PAYPAL Integration
This Code helps with integration: https://stackoverflow.com/questions/56414640/paypal-checkout-javascript-with-smart-payment-buttons-create-order-problem
--------------------------->
<script src="https://www.paypal.com/sdk/js?client-id=AVe3Db1QSdssjRZm8rLrGrd6eWNPiBPsU-ax8oQU2BfXO1UANt6WPddNUjHAsMwQpS375AHeSRrrCMEq&currency=PHP&disable-funding=card"></script>
<script>
    /* Prevent user to write letter or symbols in phone number */
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

    //!!!!!!!!!!!!!!!!!
    //!Save Inputs Start
    //!!!!!!!!!!!!!!!!!
    //Save fname_input text
    $(document).ready(function() {
        var del_fname = $('#delivery_fname');
        var del_emailAddr = $('#delivery_emailAddr');
        var del_phoneNum = $('#delivery_phoneNum');
        var del_state = $('#delivery_state');
        var del_city = $('#delivery_city');
        var del_postCode = $('#delivery_postCode');
        var del_country = $('#delivery_country');
        var del_fullAddr = $('#delivery_fullAddr');

        //?fname
        var savedFnameInput = sessionStorage.getItem('fullName');
        if (savedFnameInput) {
            del_fname.val(savedFnameInput);
        }
        del_fname.on('input', function() {
            sessionStorage.setItem('fullName', del_fname.val());
        });

        //?email
        var savedEmailInput = sessionStorage.getItem('emailAddress');
        if (savedEmailInput) {
            del_emailAddr.val(savedEmailInput);
        }
        del_emailAddr.on('input', function() {
            sessionStorage.setItem('emailAddress', del_emailAddr.val());
        });

        //?phone
        var savedPhoneInput = sessionStorage.getItem('phoneNumber');
        if (savedPhoneInput) {
            del_phoneNum.val(savedPhoneInput);
        }
        del_phoneNum.on('input', function() {
            sessionStorage.setItem('phoneNumber', del_phoneNum.val());
        });

        // Retrieve and set the input text on page load
        var savedLoginInput = sessionStorage.getItem('state');
        if (savedLoginInput) {
            loginInput.val(savedLoginInput);
        }

        // Save input text on every change
        loginInput.on('input', function() {
            sessionStorage.setItem('state', loginInput.val());
        });

        // Retrieve and set the input text on page load
        var savedLoginInput = sessionStorage.getItem('city');
        if (savedLoginInput) {
            loginInput.val(savedLoginInput);
        }

        // Save input text on every change
        loginInput.on('input', function() {
            sessionStorage.setItem('city', loginInput.val());
        });

        // Retrieve and set the input text on page load
        var savedLoginInput = sessionStorage.getItem('postalCode');
        if (savedLoginInput) {
            loginInput.val(savedLoginInput);
        }

        // Save input text on every change
        loginInput.on('input', function() {
            sessionStorage.setItem('postalCode', loginInput.val());
        });

        // Retrieve and set the input text on page load
        var savedLoginInput = sessionStorage.getItem('country');
        if (savedLoginInput) {
            loginInput.val(savedLoginInput);
        }

        // Save input text on every change
        loginInput.on('input', function() {
            sessionStorage.setItem('country', loginInput.val());
        });

        // Retrieve and set the input text on page load
        var savedLoginInput = sessionStorage.getItem('fullAddress');
        if (savedLoginInput) {
            loginInput.val(savedLoginInput);
        }

        // Save input text on every change
        loginInput.on('input', function() {
            sessionStorage.setItem('fullAddress', loginInput.val());
        });
    });

    //!!!!!!!!!!!!!!!!!
    //!Save Inputs end
    //!!!!!!!!!!!!!!!!!

    /* display selected country */
    var selectedCountry = "<?php echo $country; ?>";
    // Set the selected attribute based on the PHP variable
    document.getElementById("delivery_country").value = selectedCountry;

    /* Cash on Delivery */
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
        var state = $('#delivery_state').val();
        var city = $('#delivery_city').val();
        var country = $('#delivery_country').val();
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

        if (state.length === 0) {
            $(".state").text("*This field is required");
            isValid = false;
        }

        if (city.length === 0) {
            $(".city").text("*This field is required");
            isValid = false;
        }

        if (country.length === 0) {
            $(".country").text("*This field is required");
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
                    shipping: {
                        method: "United States Postal Service",
                        address: {
                            name: {
                                full_name: $('#delivery_fname').val(),
                            },
                            address_line_1: $('#delivery_fullAddr').val(),
                            /* Full address */

                            admin_area_2: $('#delivery_city').val(),
                            /* City */

                            admin_area_1: $('#delivery_state').val(),
                            /* State */

                            postal_code: $('#delivery_postCode').val(),
                            /* Zipcode */

                            country_code: $('#delivery_country').val() /* Country */
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
                var postalCode = $('#delivery_postCode').val();
                var state = $('#delivery_state').val();
                var city = $('#delivery_city').val();
                var country = $('#delivery_country').val();
                var fullAddr = $('#delivery_fullAddr').val();

                var data = {
                    'fullName': fname,
                    'emailAddress': email,
                    'phoneNumber': phoneNum,
                    'postalCode': postalCode,
                    'state': state,
                    'city': city,
                    'country': country,
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