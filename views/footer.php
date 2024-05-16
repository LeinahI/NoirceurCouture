<!-- Footer -->
<footer class="text-left text-lg-start bg-secondary text-muted">
    <!-- Copyright -->
    <div class="border-bottom border-secondary">
        <div class="container py-1">
            <div class="text-start text-white">
                © 2023&nbsp;Noirceur Couture
            </div>
        </div>
    </div>
    <!-- Copyright -->
    <hr>
    <!-- Section: Links  -->
    <section class="">
        <div class="container text-center text-md-start mt-5">
            <!-- Grid row -->
            <div class="row mt-3">
                <!-- Grid column -->
                <?php
                $categories = getAllActive("categories");

                if (mysqli_num_rows($categories) > 0) {
                ?>
                    <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4 text-start">
                        <?php
                        foreach ($categories as $item) {
                        ?>
                            <div class="col-md-12 mb-3">
                                <a class="text-white" href="store.php?category=<?= $item['category_slug'] ?>">
                                    <h6><?= $item['category_name'] ?></h6>
                                </a>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                <?php
                }
                ?>

                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-md-3 mx-auto mb-md-0 mb-4 text-white text-start">
                    <div class="col-md-12">
                        <p>Emilio Aguinaldo Hwy, Crossing Silang East, Tagaytay, 4120 Cavite</p>
                        <p>nctr@proton.mail</p>
                    </div>
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-md-6 mx-auto mb-4 text-white text-start">
                    <!-- Links -->
                    <h6 class="text-uppercase fw-bold mb-4 ">Be One of us</h6>
                    <div class="col-md-12">
                        <p>Unleash your eccentric creation through NoirceurCouture</p>
                    </div>
                </div>
                <!-- Grid column -->
            </div>
            <!-- Grid row -->
        </div>
    </section>
    <!-- Section: Links  -->
</footer>
<!-- Footer -->