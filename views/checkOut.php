<?php include('../partials/__header.php');
include('../middleware/userMW.php');
include('../models/dbcon.php');
include('../models/dataEncryption.php');

$cartCheck = checkItemExists();
if (mysqli_num_rows($cartCheck) < 1) {
    redirectSwal("myCart.php", "Your cart is empty", "error");
}

?>

<style>
    .border-accent {
        border-color: #bb6c54 !important;
    }
</style>

<div class="py-3 bg-main">
    <div class="container">
        <h6>
            <a href="index.php" class="text-dark">Home</a> /
            <a href="myCart.php" class="text-dark">Cart</a> /
            <a href="checkOut.php" class="text-dark">Check out</a>
        </h6>
    </div>
</div>

<div class="mt-5 mb-5">
    <div class="container">
        <?php include('../partials/sessionMessage.php') ?>

        <div class="card border-0">
            <div class="card-body bg-tertiary rounded-3">
                <?php
                $user = getDefaultUserAddress($_SESSION['auth_user']['user_ID']);
                $data = mysqli_fetch_array($user);
                $isDefault = isset($data['address_isDefault']);
                $fname = isset($data['address_fullName']) ? $data['address_fullName'] : '';
                $fname = isset($data['address_fullName']) ? $data['address_fullName'] : '';
                $email = isset($data['address_email']) ? $data['address_email'] : '';
                $regionCode = isset($data['address_region']) ? $data['address_region'] : '';
                $provinceCode = isset($data['address_province']) ? $data['address_province'] : '';
                $cityCode = isset($data['address_city']) ? $data['address_city'] : '';
                $barangayCode = isset($data['address_barangay']) ? $data['address_barangay'] : '';
                $phone = isset($data['address_phone']) ? $data['address_phone'] : '';
                $fulladdr = isset($data['address_fullAddress']) ? $data['address_fullAddress'] : '';

                $decryptedfullAddr = decryptData($fulladdr);

                // Load region data
                $regionData = json_decode(file_get_contents("../assets/js/ph-json/region.json"), true);
                // Load province data
                $provinceData = json_decode(file_get_contents("../assets/js/ph-json/province.json"), true);
                // Load city data
                $cityData = json_decode(file_get_contents("../assets/js/ph-json/city.json"), true);
                // Load barangay data
                $barangayData = json_decode(file_get_contents("../assets/js/ph-json/barangay.json"), true);
                //!Fetch region name based on region code
                $regionName = "";
                $regionUrl = "../assets/js/ph-json/region.json";
                /* $regionData = json_decode(file_get_contents($regionUrl), true); //!Fetch the RegionData */

                //!loop through regionData & find regionName corresponding to region code
                foreach ($regionData as $RegD) {
                    if ($RegD['region_code'] == $regionCode) {
                        $regionName = $RegD['region_name'];
                        break;
                    }
                }

                //+Fetch Province name based on Province code
                $provinceName = "";
                $provinceUrl = "../assets/js/ph-json/province.json";
                /* $provinceData = json_decode(file_get_contents($provinceUrl), true); //+Fetch the provinceData */

                //+loop through provinceData & find provinceName corresponding to region code
                foreach ($provinceData as $ProvD) {
                    if ($ProvD['province_code'] == $provinceCode) {
                        $provinceName = $ProvD['province_name'];
                        break;
                    }
                }

                //?Fetch Province name based on Province code
                $cityName = "";
                $cityUrl = "../assets/js/ph-json/city.json";
                /* $cityData = json_decode(file_get_contents($cityUrl), true); //+Fetch the ProvinceData */

                //?loop through ProvinceData & find provinceName corresponding to region code
                foreach ($cityData as $CtyD) {
                    if ($CtyD['city_code'] == $cityCode) {
                        $cityName = $CtyD['city_name'];
                        break;
                    }
                }

                //*Fetch Barangay name based on Barangay code
                $barangayName = "";
                $barangayUrl = "../assets/js/ph-json/barangay.json";
                /* $barangayData = json_decode(file_get_contents($barangayUrl), true); //+Fetch the barangayData */

                //*loop through barangayData & find barangayName corresponding to region code
                foreach ($barangayData as $BrgyD) {
                    if ($BrgyD['brgy_code'] == $barangayCode) {
                        $barangayName = $BrgyD['brgy_name'];
                        break;
                    }
                }
                ?>

                <?php

                if (empty($data)) {
                ?>
                    <!-- Modal Initialize on load -->
                    <div class="modal" id="modalNoAddressYet" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content bg-main">
                                <div class="modal-body">
                                    <h3 class="modal-title" id="exampleModalLabel">New Address</h3>
                                    <p>To place order, please add your delivery address</p>
                                    <hr>
                                    <div class="row">
                                        <form action="../models/authcode.php" method="POST">
                                            <input type="hidden" name="userID" value="<?= $_SESSION['auth_user']['user_ID'] ?>">
                                            <input type="hidden" name="checkoutPage" value="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

                                            <div class="row">
                                                <!-- Fname and Lname start -->
                                                <div class="form-floating col-md-12 mb-3">
                                                    <input type="text" class="form-control" id="user_fname" name="fullName" required placeholder="name" autocomplete="off">
                                                    <label for="floatingInput" class="ms-2">Full Name</label>
                                                </div>
                                                <!-- Fname and Lname end -->
                                            </div>

                                            <div class="row">
                                                <!-- Email and Number start -->
                                                <div class="form-floating col-md-6 mb-3">
                                                    <input type="email" class="form-control" id="user_email" name="email" required placeholder="name@example.com" autocomplete="off">
                                                    <label for="floatingInput" class="ms-2">Email address</label>
                                                </div>

                                                <div class="form-floating col-md-6 mb-3">
                                                    <input type="number" class="form-control" id="user_email" name="phoneNumber" required placeholder="09" onkeypress="inpNum(event)">
                                                    <label for="floatingInput" class="ms-2">Phone Number</label>
                                                </div>
                                                <!-- Email and Number end -->
                                            </div>

                                            <div class="row">
                                                <!--//! Select Region Province City Barangay -->
                                                <div class="form-floating mb-3">
                                                    <select name="region" class="form-select form-control form-control-md" id="region" required></select> <!-- Region -->
                                                    <label for="floatingInput" class="ms-2">Region</label>
                                                </div>

                                                <div class="form-floating col-md-4 mb-3">
                                                    <select name="province" class="form-control form-control-md" id="province" required></select> <!-- Province -->
                                                    <label for="floatingInput" class="ms-2">Province</label>
                                                </div>
                                                <div class="form-floating col-md-4 mb-3">
                                                    <select name="city" class="form-control form-control-md" id="city" required></select> <!-- City -->
                                                    <label for="floatingInput" class="ms-2">City / Municipality</label>
                                                </div>
                                                <div class="form-floating col-md-4 mb-3">
                                                    <select name="barangay" class="form-control form-control-md" id="barangay" required></select> <!-- Barangay -->
                                                    <label for="floatingInput" class="ms-2">Barangay</label>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <!--Addr start -->
                                                <div class="form-floating col-md-12 mb-3">
                                                    <div class="form-floating ps-0 ">
                                                        <textarea rows="3" class="form-control" id="delivery_fullAddr" name="fullAddress" required placeholder="d" style="height:100px; min-height: 57px; max-height: 100px;"></textarea>
                                                        <label for="floatingInput">Address</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <!-- Set Default Address -->
                                                <div class="ms-4 mb-3 user-select-none">
                                                    <input class="form-check-input" type="checkbox" name="defaultAddr" id="reverseCheck1">
                                                    <label class="form-check-label" for="reverseCheck1">
                                                        Set as Default Address
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="btn-group col-md-12">
                                                    <a href="myCart.php" type="button" class="col-md-6 btn btn-primary">Cancel</a>
                                                    <button name="userAddAddrBtn" type="submit" class="col-md-6 btn btn-accent">Add New Address</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>

                <form action="../models/placeOrder.php" method="POST">
                    <div class="row">
                        <!-- Modal -->
                        <div class="modal fade" id="changeAddressModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="changeAddressLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content bg-main">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="changeAddressLabel">My Address</h1>
                                    </div>
                                    <div class="modal-body">
                                        <?php
                                        $userAddressResult = getUserAddress($_SESSION['auth_user']['user_ID']); // Pass userid to fetch addresses for specific user
                                        while ($datas = mysqli_fetch_array($userAddressResult)) {
                                            $addressid = $datas['address_id'];
                                            $Default = $datas['address_isDefault'];
                                            $firstname = $datas['address_fullName'];
                                            $addremail = $datas['address_email'];
                                            $phoneNumber = $datas['address_phone'];
                                            $fullAddress = $datas['address_fullAddress'];
                                            $regCode = isset($datas['address_region']) ? $datas['address_region'] : '';
                                            $provCode = isset($datas['address_province']) ? $datas['address_province'] : '';
                                            $ctyCode = isset($datas['address_city']) ? $datas['address_city'] : '';
                                            $brgyCode = isset($datas['address_barangay']) ? $datas['address_barangay'] : '';

                                            //!Fetch region name based on region code
                                            $regName = "";
                                            /* $regionData = json_decode(file_get_contents($regionUrl), true); //!Fetch the RegionData */
                                            //!loop through regionData & find regionName corresponding to region code
                                            foreach ($regionData as $RegD) {
                                                if ($RegD['region_code'] == $regCode) {
                                                    $regName = $RegD['region_name'];
                                                    break;
                                                }
                                            }
                                            //+Fetch Province name based on Province code
                                            $provName = "";
                                            /* $provinceData = json_decode(file_get_contents($provinceUrl), true); //+Fetch the provinceData */
                                            //+loop through provinceData & find provinceName corresponding to region code
                                            foreach ($provinceData as $ProvD) {
                                                if ($ProvD['province_code'] == $provCode) {
                                                    $provName = $ProvD['province_name'];
                                                    break;
                                                }
                                            }
                                            //?Fetch Province name based on Province code
                                            $ctyName = "";
                                            /* $cityData = json_decode(file_get_contents($cityUrl), true); //+Fetch the ProvinceData */
                                            //?loop through ProvinceData & find provinceName corresponding to region code
                                            foreach ($cityData as $CtyD) {
                                                if ($CtyD['city_code'] == $ctyCode) {
                                                    $ctyName = $CtyD['city_name'];
                                                    break;
                                                }
                                            }
                                            //*Fetch Barangay name based on Barangay code
                                            $brgyName = "";
                                            /* $barangayData = json_decode(file_get_contents($barangayUrl), true); //+Fetch the barangayData */
                                            //*loop through barangayData & find barangayName corresponding to region code
                                            foreach ($barangayData as $BrgyD) {
                                                if ($BrgyD['brgy_code'] == $brgyCode) {
                                                    $brgyName = $BrgyD['brgy_name'];
                                                    break;
                                                }
                                            }
                                        ?>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="<?php echo $addressid; ?>" <?= ($Default == 1) ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="<?= $addressid ?>">
                                                    <span class="fw-bold change_fn"><?php echo $firstname; ?></span> |
                                                    <span class="change_phone"><?php echo $phoneNumber; ?></span> |
                                                    <span class="change_email"><?php echo $addremail; ?></span><br>
                                                    <span class="change_address"><?= $decryptedfullAddr ?></span>,
                                                    <span class="change_brgyn"><?php echo $brgyName; ?></span>,
                                                    <span class="change_cityn"><?php echo $ctyName; ?></span>,
                                                    <span class="change_provn"><?php echo $provName; ?></span>,
                                                    <span class="change_regn"><?php echo $regName; ?></span>

                                                    <input readonly type="hidden" class="code_brgy" value="<?= $brgyCode ?>">
                                                    <input readonly type="hidden" class="code_city" value="<?= $ctyCode ?>">
                                                    <input readonly type="hidden" class="code_prov" value="<?= $provCode ?>">
                                                    <input readonly type="hidden" class="code_reg" value="<?= $regCode ?>">
                                                    <input readonly type="hidden" class="change_defaultAddr" value="<?= $Default ?>">
                                                    <?php
                                                    if ($Default == 1) {
                                                    ?>
                                                        <div style="margin-top: 5px;">
                                                            <span class="text-accent border border-accent p-1">Default</span>
                                                        </div>
                                                    <?php
                                                    }
                                                    ?>
                                                </label>
                                            </div>
                                            <hr>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="button" class="btn btn-accent btn-main" data-bs-dismiss="modal">Confirm</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal end -->

                        <!-- Order Address Details -->
                        <div class="col-md-12">
                            <div class="mb-4">
                                <span class="fs-5">Delivery Address
                                    <span class="float-end">
                                        <a href="myCart.php" class="btn btn-tertiary">
                                            Go back
                                        </a>
                                    </span>
                                </span>
                            </div>
                            <hr>
                            <?php if (empty($data)) { ?>

                            <?php } else { ?>
                                <div class="row">
                                    <!-- Your existing code for address details -->
                                    <!-- Fname -->
                                    <div class="col-md-3 mb-3" style="padding-left: 30px;">
                                        <span class="fw-bold" id="delivery_fname"><?php echo $fname; ?></span> <br>
                                        <span class="fw-bold" id="delivery_phoneNum"><?php echo $phone; ?></span> |
                                        <span id="delivery_emailAddr"><?php echo $email; ?></span>

                                        <!--//! input hidden that going to give to server side -->
                                        <input type="hidden" id="hidden_fname" name="fullName" value="<?php echo $fname; ?>">
                                        <input type="hidden" id="hidden_phone" name="phoneNumber" value="<?php echo $phone; ?>">
                                        <input type="hidden" id="hidden_email" name="emailAddress" value="<?php echo $email; ?>">
                                    </div>
                                    <!-- State City Country -->
                                    <div class="col-md-7 mb-3">
                                        <span id="delivery_fullAddr"><?php echo $decryptedfullAddr; ?></span>,
                                        <span id="barangay_text"><?php echo $barangayName; ?></span>,
                                        <span id="city_text"><?php echo $cityName; ?></span>,
                                        <span id="province_text"><?php echo $provinceName; ?></span>,
                                        <span id="region_text"><?php echo $regionName; ?></span>

                                        <!--//! input hidden that going to give to server side -->
                                        <input readonly type="hidden" id="hidden_fulladdr" name="fullAddress" value="<?php echo $decryptedfullAddr; ?>">
                                        <input readonly type="hidden" class="hidden_barangay_code" id="barangay_code" name="barangay" value="<?php echo $barangayCode; ?>">
                                        <input readonly type="hidden" class="hidden_city_code" id="city_code" name="city" value="<?php echo $cityCode; ?>">
                                        <input readonly type="hidden" class="hidden_province_code" id="province_code" name="province" value="<?php echo $provinceCode; ?>">
                                        <input readonly type="hidden" class="hidden_region_code" id="region_code" name="region" value="<?php echo $regionCode; ?>">
                                    </div>

                                    <div class="col-md-1 text-center">
                                        <input readonly type="hidden" id="hidden_default" value="<?php echo $isDefault ?>">
                                        <span id="addr_isdefault" class="border-0 btn-main rounded-3 p-1">Default</span>
                                    </div>

                                    <div class="col-md-1 mb-3 text-center">
                                        <!-- Modal Trigger -->
                                        <a href="#" class="text-dark-4" data-bs-toggle="modal" data-bs-target="#changeAddressModal">Change</a>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <!-- Products -->
                        <div class="col-md-12">
                            <div class="px-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5>Products Ordered</h5>
                                    </div>
                                    <div class="col-md-2 pl-2 d-flex">
                                        <h6>Unit Price</h6>
                                    </div>
                                    <div class="col-md-2 pl-0 d-flex justify-content-center">
                                        <h6>Quantity</h6>
                                    </div>
                                    <div class="col-md-2 text-end">
                                        <h6>Total Price</h6>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <?php
                            $items = getCartItems();
                            $totalPrice = 0;
                            $groupedItems = [];
                            $itemQty = getAllItemQty();

                            if (mysqli_fetch_array($items) == 0) {
                                redirectSwal("myCart.php", "Your cart is empty", "error");
                            }

                            // Group items by category_name
                            foreach ($items as $cItem) {
                                $categoryName = $cItem['category_name'];
                                $onVacation = $cItem['category_onVacation'];
                                if (!isset($groupedItems[$categoryName])) {
                                    $groupedItems[$categoryName] = [];
                                }
                                $groupedItems[$categoryName][] = $cItem;
                            } ?>
                            <div class="scrollBarCO" style="height: <?= count($groupedItems) > 1 ? '450px' : 'auto'; ?>; overflow-y: scroll; scrollbar-width: none;">
                                <?php
                                // Display grouped items
                                foreach ($groupedItems as $categoryName => $categoryItems) {
                                ?>
                                    <div class="card mb-3 border-0 rounded-3">
                                        <div class="card-header bg-main">
                                            <h5 class="card-title">
                                                <?= $categoryName ?>
                                                <span class="fs-6 fw-bold">
                                                    <?php
                                                    if ($onVacation) {
                                                        echo "(Currently on vacation)";
                                                    }
                                                    ?>
                                                </span>
                                            </h5>
                                        </div>
                                        <div class="card-body bg-main rounded-3">
                                            <?php foreach ($categoryItems as $index => $cItem) {
                                                $itemTotalPrice = $cItem['product_srp'] * $cItem['product_qty'];
                                                $totalPrice += $itemTotalPrice;
                                            ?>
                                                <div class="productData row align-items-center <?= ($index < count($categoryItems) - 1) ? 'mb-2' : '' ?>">
                                                    <div class="col-md-2">
                                                        <center>
                                                            <img src="../assets/uploads/products/<?= $cItem['product_image'] ?>" alt="Product Image" width="80px">
                                                        </center>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <h5><?= $cItem['product_name'] ?></h5>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <h5 class="text-end">
                                                            <?php
                                                            if ($cItem['product_original_price'] > $cItem['product_srp']) {
                                                            ?>
                                                                <span class="fs-6 text-secondary text-decoration-line-through">₱<?= number_format($cItem['product_original_price'], 2) ?></span>
                                                                &nbsp;
                                                                ₱<?= number_format($cItem['product_srp'], 2) ?>
                                                                <br>
                                                                <span class="text-accent fs-6">
                                                                    Discount <?= $cItem['product_discount'] ?>%
                                                                </span>
                                                            <?php
                                                            } else {
                                                            ?>

                                                                ₱<?= number_format($cItem['product_srp'], 2) ?>

                                                            <?php
                                                            }
                                                            ?>
                                                        </h5>
                                                    </div>
                                                    <!-- Product Qty -->
                                                    <div class="col-md-2 text-center">
                                                        <h5 class="text-end"><?= $cItem['product_qty'] ?></h5>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <h5 class="text-end">₱<?= number_format($itemTotalPrice, 2) ?></h5>
                                                    </div>

                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>

                                <?php
                                }
                                ?>
                            </div>
                            <div class="card  border-0">
                                <div class="card-body bg-main text-end rounded-top">
                                    <h5>Order Total&nbsp;(<span class="text-accent"><?= $itemQty ?>&nbsp;item</span>): <span class="text-accent">₱<?= number_format($totalPrice, 2) ?></span></h5>
                                </div>
                                <div class="card-body bg-main rounded-bottom">
                                    <input type="hidden" name="paymentMode" value="Cash on Delivery">
                                    <input type="hidden" name="paymentID" value="" id="paymentIDInput">

                                    <?php
                                    if (!empty($data)) {
                                    ?>
                                        <button type="submit" name="placeOrderBtn" class="btn btn-main w-100 mb-3">COD | Place Order</button>
                                        <div id="paypal-button-container"></div>
                                    <?php
                                    }
                                    if ($onVacation == 1) {
                                        redirectSwal("myCart.php", "Seller is on vacation", "error");
                                    }
                                    ?>

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
    /* Run this if no address yet */
    window.onload = () => {
        $('#modalNoAddressYet').modal('show');
    }

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

    document.addEventListener("DOMContentLoaded", function() {
        // Add event listener to the Confirm button
        document.querySelector(".btn-confirm").addEventListener("click", function() {
            // Find the checked radio button inside the modal
            var checkedRadio = document.querySelector('input[name="flexRadioDefault"]:checked');
            if (checkedRadio) {
                // Extract data associated with the checked radio button
                var fullName = checkedRadio.parentElement.querySelector('.change_fn').textContent.trim();
                var phoneNumber = checkedRadio.parentElement.querySelector('.change_phone').textContent.trim();
                var emailAddress = checkedRadio.parentElement.querySelector('.change_email').textContent.trim();
                var fullAddress = checkedRadio.parentElement.querySelector('.change_address').textContent.trim();
                var barangayName = checkedRadio.parentElement.querySelector('.change_brgyn').textContent.trim(); // This line should correctly fetch the barangay name
                var cityName = checkedRadio.parentElement.querySelector('.change_cityn').textContent.trim();
                var provinceName = checkedRadio.parentElement.querySelector('.change_provn').textContent.trim();
                var regionName = checkedRadio.parentElement.querySelector('.change_regn').textContent.trim();

                var brgyCode = checkedRadio.parentElement.querySelector('.code_brgy').value.trim();
                var ctyCode = checkedRadio.parentElement.querySelector('.code_city').value.trim();
                var provCode = checkedRadio.parentElement.querySelector('.code_prov').value.trim();
                var regCode = checkedRadio.parentElement.querySelector('.code_reg').value.trim();

                var defaultAddr = checkedRadio.parentElement.querySelector('.change_defaultAddr').value.trim();

                // Populate the delivery address fields with the selected address details
                document.getElementById("delivery_fname").textContent = fullName;
                document.getElementById("delivery_phoneNum").textContent = phoneNumber;
                document.getElementById("delivery_emailAddr").textContent = emailAddress;
                document.getElementById("delivery_fullAddr").textContent = fullAddress;
                document.getElementById("barangay_text").textContent = barangayName;
                document.getElementById("city_text").textContent = cityName;
                document.getElementById("province_text").textContent = provinceName;
                document.getElementById("region_text").textContent = regionName;

                //Popilate the hidden delivery address input fields with the selected address
                document.getElementById("hidden_fname").value = fullName;
                document.getElementById("hidden_phone").value = phoneNumber;
                document.getElementById("hidden_email").value = emailAddress;
                document.getElementById("hidden_fulladdr").value = fullAddress;

                document.getElementById("hidden_default").value = defaultAddr;

                // Hide addr_isdefault span if hidden_default value is 0
                var addrIsDefault = document.getElementById("addr_isdefault");
                if (addrIsDefault && defaultAddr === "0") {
                    addrIsDefault.setAttribute("hidden", "");
                } else {
                    addrIsDefault.removeAttribute("hidden");
                }

                var hiddenBarangayCodes = document.getElementsByClassName("hidden_barangay_code");
                for (var i = 0; i < hiddenBarangayCodes.length; i++) {
                    hiddenBarangayCodes[i].value = brgyCode;
                }
                var hiddenCityCodes = document.getElementsByClassName("hidden_city_code");
                for (var i = 0; i < hiddenCityCodes.length; i++) {
                    hiddenCityCodes[i].value = ctyCode;
                }
                var hiddenProvinceCodes = document.getElementsByClassName("hidden_province_code");
                for (var i = 0; i < hiddenProvinceCodes.length; i++) {
                    hiddenProvinceCodes[i].value = provCode;
                }
                var hiddenRegionCodes = document.getElementsByClassName("hidden_region_code");
                for (var i = 0; i < hiddenRegionCodes.length; i++) {
                    hiddenRegionCodes[i].value = regCode;
                }
            }
        });
    });

    paypal.Buttons({
        style: {
            disableMaxWidth: true
        },
        createOrder: function(data, actions) {
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
                                full_name: $('#delivery_fname').text(),
                            },
                            address_line_1: $('#delivery_fullAddr').text(),
                            /* Full address */

                            admin_area_2: $('#city_text').text(),
                            /* City */

                            admin_area_1: $('#region_text').text(),
                            /* State */

                            postal_code: $('#province_text').text(),
                            /* Zipcode */

                            country_code: 'PH' /* Country */
                        }
                    }
                }]
            });
        },
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(orderData) {
                console.log('Capture Result', orderData, JSON.stringify(orderData, null, 2));

                console.log(orderData)
                const transaction = orderData.purchase_units[0].payments.captures[0];
                /* alert(`Transaction ${transaction.status}: ${transaction.id}\n\nSee console for available details`); */

                var fname = $('#delivery_fname').text();
                var email = $('#delivery_emailAddr').text();
                var phoneNum = $('#delivery_phoneNum').text();
                var region = $('#region_code').val();
                var province = $('#province_code').val();
                var city = $('#city_code').val();
                var barangay = $('#barangay_code').val();
                var fullAddr = $('#delivery_fullAddr').text();

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