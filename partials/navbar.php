<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow"> <!--  sticky-top -->
    <div class="container">
        <a href="index.php" class="navbar-brand">
            <img src="../assets/images/logo/NoirceurCouture_WT.png" height="30" alt="LOGO">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item" <?php if (basename($_SERVER['PHP_SELF']) === 'brands.php') echo 'hidden'; ?>>
                    <a class="nav-link" href="brands.php">Collections</a>
                </li>
                <!-- myCart start -->
                <li class="nav-item" <?php if (basename($_SERVER['PHP_SELF']) === 'myCart.php') echo 'hidden'; ?>>
                    <!-- user cart qty -->
                    <a class="nav-link" href="myCart.php"><i class="fa-solid fa-cart-shopping" style="color: #ffffff;"></i>&nbsp;
                        <?php if (isset($_SESSION['auth'])) {
                            $cartQty = getCartQty();
                        ?>
                            <span class="itemCartQty"><?php echo $cartQty; ?></span>
                        <?php } else { ?>
                            <span class="itemCartQty"></span>
                        <?php } ?>
                    </a>
                </li>
                <!-- myCart end -->

                <!-- Wish List start -->
                <li class="nav-item" <?php if (basename($_SERVER['PHP_SELF']) === 'myLikes.php') echo 'hidden'; ?>>
                    <!-- user cart qty -->
                    <a class="nav-link" href="myLikes.php"><i class="fa-solid fa-heart" style="color: #ffffff;"></i></i>&nbsp;
                        <?php if (isset($_SESSION['auth'])) {
                            $cartQty = getLikesQty();
                        ?>
                            <span class="itemCartQty"><?php echo $cartQty; ?></span>
                        <?php } else { ?>
                            <span class="itemCartQty"></span>
                        <?php } ?>
                    </a>
                </li>
                <!-- Wish List end -->

                <?php
                if (isset($_SESSION['auth'])) {
                ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?= $_SESSION['auth_user']['user_username'] ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="myOrders.php">My Purchase</a></li>
                            <li><a class="dropdown-item" href="myAccount.php">My Account</a></li>
                            <li><a class="dropdown-item" href="logout.php">Log Out</a></li>
                        </ul>
                    </li>
                <?php
                } else {
                ?>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Log in</a>
                    </li>
                <?php
                }
                ?>
            </ul>
        </div>
    </div>
</nav>