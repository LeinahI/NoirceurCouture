<?php include('includes/header.php');
?>
<?php
if (isset($_SESSION['Errormsg'])) {
?>
    <div class="container mt-3 position-absolute start-50 translate-middle-x z-2">
        <div class="row">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-triangle-exclamation" style="color: #58151C;"></i>
                <?= $_SESSION['Errormsg']; ?>.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>
<?php
    unset($_SESSION['Errormsg']);
}
?>
<?php include('includes/slider.php'); ?>
<div class="mt-3 mb-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h4 class="text-center">Trending Products</h4>
                <hr>
                <div class="row">
                    <div class="main-content">
                        <div class="owl-carousel">
                            <?php
                            $popularProducts = getAllPopular();

                            if (mysqli_num_rows($popularProducts) > 0) {
                                foreach ($popularProducts as $item) {
                                    $product_name = $item['product_name'];
                                    if (strlen($product_name) > 15) {
                                        $product_name = substr($product_name, 0, 20) . '...';
                                    }
                            ?>
                                    <div class="item">
                                        <a href="productView.php?product=<?= $item['product_slug'] ?>" class="card-link">
                                            <div class="card " style="height: 100%;">
                                                <div class="card-body d-flex flex-column justify-content-between" style="height: 100%;">
                                                    <div>
                                                        <img src="uploads/products/<?= $item['product_image'] ?>" alt="Product Image" class="w-100">
                                                        <h6><?= $product_name; ?></h6>
                                                        <h6 class="text-center fw-bold">₱<?= number_format($item['product_srp'], 2) ?></h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                            <?php
                                }
                            }
                            ?>
                        </div>
                        <div class="owl-theme">
                            <div class="owl-controls">
                                <div class="custom-nav owl-nav"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mb-5">
    <div class="container">
        <div class="position-absolute z-2" style="translate: 800px 300px;">
            <div class="card" style="width: 24rem;">
                <div class="card-body">
                    <h5 class="card-title text-center fw-bold">Welcome to the Noirceur</h5>
                    <p class="card-text text-center">Noirceur Couture is the go-to place for individuals who seek avant-garde and other subculture wear from well-known brands. <br>
                        As a trusted distributor, we bring you an extensive collection of curated pieces from top fashion brands around the world. <br>
                        From chic clothing to accessories, Noirceur Couture caters to diverse tastes, providing a seamless shopping experience for those looking for quality and exclusivity.</p>
                    <center>
                        <a href="brands.php" class="btn btn-primary">Shop Now</a>
                    </center>
                </div>
            </div>
        </div>
        <img class="img-fluid" src="assets/slideShow/nctr.jpg" />
    </div>
</div>

<?php include('ftr.php'); ?>

<?php include('includes/footer.php'); ?>
<script>
    $('.main-content .owl-carousel').owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        navText: [
            '<i class="fa fa-angle-left" aria-hidden="true"></i>',
            '<i class="fa fa-angle-right" aria-hidden="true"></i>'
        ],
        navContainer: '.main-content .custom-nav',
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 3
            },
            1000: {
                items: 5
            }
        }
    });
</script>