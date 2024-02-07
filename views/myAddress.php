<?php
include('../partials/__header.php');
include('../middleware/userMW.php');
?>

<style>
    .border-accent {
        border-color: #bb6c54 !important;
    }
</style>

<div class="container mt-5">
    <?php
    if (isset($_SESSION['Errormsg'])) {
    ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-triangle-exclamation" style="color: #58151C;"></i>
            <?= $_SESSION['Errormsg']; ?>.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php
        /* Alert popup will show here */
        unset($_SESSION['Errormsg']);
    }
    ?>
    <div class="row">
        <?php include('../partials/sidebar.php') ?>
        <div class="col-md-9">
            <div>
                <div class="card border rounded-3 shadow bg-main">
                    <div class="card-header">
                        <h5 class="card-title ">
                            <span>My Addresses</span>
                            <span class="float-end">
                                <a href="myAddresAddNew.php" class="btn btn-primary">
                                    Add New Address
                                </a>
                            </span>
                        </h5>
                    </div>
                    <?php
                    // Fetch user details
                    $useridResult = getUserDetails();
                    while ($dataid = mysqli_fetch_array($useridResult)) {
                        $userid = $dataid['user_ID'];

                        // Fetch user addresses based on user ID
                        $userAddressResult = getUserAddress(); // Pass userid to fetch addresses for specific user
                        while ($data = mysqli_fetch_array($userAddressResult)) {
                            $addrid = $data['address_id'];
                            $fname = $data['address_fullName'];
                            $email = $data['address_email'];
                            $regionCode = $data['address_region'];
                            $provinceCode = $data['address_province'];
                            $cityCode = $data['address_city'];
                            $barangayCode = $data['address_barangay'];
                            $phone = $data['address_phone'];
                            $fulladdr = $data['address_fullAddress'];

                            //!Fetch region name based on region code
                            $regionName = "";
                            $regionUrl = "../assets/js/ph-json/region.json";
                            $regionData = json_decode(file_get_contents($regionUrl), true); //!Fetch the RegionData

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
                            $provinceData = json_decode(file_get_contents($provinceUrl), true); //+Fetch the provinceData

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
                            $cityData = json_decode(file_get_contents($cityUrl), true); //+Fetch the ProvinceData

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
                            $barangayData = json_decode(file_get_contents($barangayUrl), true); //+Fetch the barangayData

                            //*loop through barangayData & find barangayName corresponding to region code
                            foreach ($barangayData as $BrgyD) {
                                if ($BrgyD['brgy_code'] == $barangayCode) {
                                    $barangayName = $BrgyD['brgy_name'];
                                    break;
                                }
                            }

                    ?>

                            <div class="card-body">
                                <!-- Display user addresses in cards -->
                                <div class="card bg-main">
                                    <div class="row card-body col-md-12 ">
                                        <div class="col-md-10">
                                            <input type="hidden" name="addrID" value="<?= $addrid ?>">
                                            <div id="namePhoneEmail">
                                                <span class="fw-bold"><?= $fname ?></span> |
                                                <span class="fw-normal"><?= $phone ?></span> |
                                                <span class="fw-normal"><?= $email ?></span>
                                            </div>
                                            <div id="fullAddress">
                                                <span><?= $fulladdr ?></span>
                                            </div>
                                            <div id="location">
                                                <span><?= $barangayName ?></span>,
                                                <span><?= $cityName ?></span>,<br>
                                                <span><?= $provinceName ?></span>,
                                                <span><?= $regionName ?></span>
                                            </div>
                                            <div id="isDefault" class="mt-2">
                                                <span class="text-accent border border-accent p-1">Default</span>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <span class="float-end mb-2">
                                                <a href="#">Edit</a>
                                                <a href="#">Delete</a>
                                            </span>
                                            <button class="btn btn-accent float-end">Set as Default</button>
                                        </div>
                                    </div>
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
</div>

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

        if (numericValue.length >= 11) {
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
</script>

<div style="margin-top:5%;">
    <?php include('footer.php'); ?>
</div>

<?php
include('../assets/js/ph-address-selector.php');
include('../partials/__footer.php');
?>