<!-- Footer -->
<footer class="text-center text-lg-start bg-dark text-muted">
    <hr>
    <!-- Section: Links  -->
    <section class="">
        <div class="container text-center text-md-start mt-5">
            <!-- Grid row -->
            <div class="row mt-3">
                <!-- Grid column -->
                <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4 text-light">
                    <!-- Links -->
                    <h6 class="text-uppercase fw-bold mb-4">
                        Collections
                    </h6>
                    <?php
                    $categories = getAllActive("categories");

                    if (mysqli_num_rows($categories) > 0) {
                        foreach ($categories as $item) {
                    ?>
                            <div class="col-md-12 mb-3">
                                <a class="text-white" href="products.php?category=<?= $item['category_slug'] ?>">
                                    <h6></h6><?= $item['category_name'] ?></h6>
                                </a>
                            </div>
                    <?php
                        }
                    } else {
                        echo "No data available";
                    }
                    ?>
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-md-3  mx-auto mb-md-0 mb-4 text-light">
                    <!-- Links -->
                    <h6 class="text-uppercase fw-bold mb-4">Contact</h6>
                    <p><i class="fas fa-home me-3"></i>Emilio Aguinaldo Hwy, Crossing Silang East, Tagaytay, 4120 Cavite</p>
                    <p>
                        <i class="fas fa-envelope me-3"></i>
                        nctr@proton.mail
                    </p>
                    <p><i class="fas fa-phone me-3"></i> 09193554999</p>
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-md-6  mx-auto mb-4">
                    <!-- Links -->
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d967.3423122401905!2d120.96095992851185!3d14.114369299759414!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33bd77610323083d%3A0x1fd18cb1bcbc6319!2sHillcrest%20Plaza!5e0!3m2!1sen!2sph!4v1687276603531!5m2!1sen!2sph" class="w-100 h-100" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
                <!-- Grid column -->
            </div>
            <!-- Grid row -->
        </div>
    </section>
    <!-- Section: Links  -->

    <!-- Copyright -->
    <div class="text-center p-4 text-light">
        © <?= date('Y') ?>
        <a class="text-reset fw-bold" href="index.php">Noirceur Couture.</a>
        All rights reserved.
    </div>
    <!-- Copyright -->
</footer>
<!-- Footer -->