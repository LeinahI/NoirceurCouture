<?php
$currentFilename = basename($_SERVER['PHP_SELF']);
?>
<style>
    @media (max-width: 991px) {
        #offcanvasNavbar2 {
            width: 25% !important;
        }
    }

    @media (max-width: 767px) {
        #offcanvasNavbar2 {
            width: 30% !important;
        }
    }
    @media (max-width: 576px) {
        #offcanvasNavbar2 {
            width: 40% !important;
        }
    }
</style>
<nav class="navbar navbar-expand-lg bg-primary" aria-label="Offcanvas navbar large">
    <div class="container">
        <a href="../views/index.php" class="navbar-brand">
            <img src="../assets/images/logo/NoirceurCouture_BK.png" height="30" alt="Logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar2" aria-controls="offcanvasNavbar2">
            <i class="fa-solid fa-bars"></i>
        </button>
        <div class="offcanvas offcanvas-end bg-primary" tabindex="-1" id="offcanvasNavbar2" aria-labelledby="offcanvasNavbar2Label">
            <div class="offcanvas-header">
                <a href="../views/index.php" class="navbar-brand">
                    <img src="../assets/images/logo/NoirceurCouture_BK.png" height="30" alt="Logo">
                </a>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    <li class="nav-item" <?php if (in_array($currentFilename, ['storelist.php', 'verifyAccount.php', 'verifyEmailFinal.php', "reset.php", "resetPassword.php"])) echo 'hidden'; ?>>
                        <a class="nav-link text-brown" href="../views/storelist.php">Collections</a>
                    </li>
                    <!-- myCart start -->
                    <li class="nav-item" <?php if (in_array($currentFilename, ['myCart.php', 'verifyAccount.php', 'verifyEmailFinal.php', "reset.php", "resetPassword.php"])) echo 'hidden'; ?>>
                        <!-- user cart qty -->
                        <a class="nav-link" href="../views/myCart.php"><i class="fa-solid fa-cart-shopping text-accent"></i>&nbsp;<span class="text-brown d-inline d-lg-none">Cart</span>
                            <?php if (isset($_SESSION['auth'])) {
                                $cartQty = getCartQty();
                            ?>
                                <span class="itemCartQty text-accent"><?php echo $cartQty; ?></span>
                            <?php } else { ?>
                                <span class="itemCartQty text-accent"></span>
                            <?php } ?>
                        </a>
                    </li>
                    <!-- myCart end -->

                    <!-- Wish List start -->
                    <li class="nav-item" <?php if (in_array($currentFilename, ['myLikes.php', 'verifyAccount.php', 'verifyEmailFinal.php', "reset.php", "resetPassword.php"])) echo 'hidden'; ?>>
                        <!-- user cart qty -->
                        <a class="nav-link" href="../views/myLikes.php"><i class="fa-solid fa-heart text-accent"></i>&nbsp;<span class="text-brown d-inline d-lg-none">Likes</span>
                            <?php if (isset($_SESSION['auth'])) {
                                $cartQty = getLikesQty();
                            ?>
                                <span class="itemCartQty text-accent"><?php echo $cartQty; ?></span>
                            <?php } else { ?>
                                <span class="itemCartQty text-accent"></span>
                            <?php } ?>
                        </a>
                    </li>
                    <!-- Wish List end -->

                    <?php
                    if (isset($_SESSION['auth'])) {
                        $user = getUserDetails();
                        $data = mysqli_fetch_array($user);
                        $profilePic = $data['user_profile_image'];
                    ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-brown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="../assets/uploads/userProfile/<?= ($profilePic) ? $profilePic : 'defaultProfile.jpg' ?>" height="20" width="20" class="rounded-circle" alt="">
                                <?= $_SESSION['auth_user']['user_username'] ?>
                            </a>
                            <ul class="dropdown-menu bg-primary">
                                <li><a class="dropdown-item text-brown" href="myOrders.php">My Purchase</a></li>
                                <li><a class="dropdown-item text-brown" href="myAccount.php">My Account</a></li>
                                <li><a class="dropdown-item text-brown" href="../models/logout.php">Log Out</a></li>
                            </ul>
                        </li>
                    <?php
                    } else {
                    ?>
                        <li class="nav-item" <?php if (in_array($currentFilename, ['verifyAccount.php', 'verifyEmailFinal.php', "reset.php", "resetPassword.php"])) echo 'hidden'; ?>>
                            <a class="nav-link text-brown" href="../seller/seller-registration.php">Start Selling</a>
                        </li>
                        <li class="nav-item" <?php if (in_array($currentFilename, ['verifyAccount.php', 'verifyEmailFinal.php', "reset.php", "resetPassword.php"])) echo 'hidden'; ?>>
                            <a class="nav-link text-brown" href="../views/register.php">Register</a>
                        </li>
                        <li class="nav-item" <?php if (in_array($currentFilename, ['verifyAccount.php', 'verifyEmailFinal.php', "reset.php", "resetPassword.php"])) echo 'hidden'; ?>>
                            <a class="nav-link text-brown" href="../views/login.php">Log in</a>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</nav>

<!-- <script>
    // Event delegation for dropdown
    $('body').on('click', '.nav-link.dropdown-toggle', function(e) {
        e.preventDefault();
        $(this).next('.dropdown-menu').toggle();
    });

    // Event delegation for dropdown items
    $('body').on('click', '.dropdown-menu a', function(e) {
        e.preventDefault();
        var href = $(this).attr('href');
        window.location.href = href; // Redirect to the selected link
    });
</script> -->