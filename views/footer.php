<!-- Footer -->
<footer class="text-center text-lg-start bg-secondary text-muted">
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
                    <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                        <!-- Links -->
                        <h6 class="text-uppercase fw-bold mb-4 text-white">
                            Collections
                        </h6>
                        <?php
                        foreach ($categories as $item) {
                        ?>
                            <div class="col-md-12 mb-3">
                                <a class="text-white" href="store.php?category=<?= $item['category_slug'] ?>">
                                    <h6></h6><?= $item['category_name'] ?></h6>
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
                <div class="col-md-3  mx-auto mb-md-0 mb-4 text-white">
                    <!-- Links -->
                    <h6 class="text-uppercase fw-bold mb-4 ">Contact</h6>
                    <p>Emilio Aguinaldo Hwy, Crossing Silang East, Tagaytay, 4120 Cavite</p>
                    <p>nctr@proton.mail</p>
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
    <div class="text-center p-4 text-white">
        © <?= date('Y') ?>
        <a class="text-white fw-bold" href="index.php">Noirceur Couture.</a>
        All rights reserved.
    </div>
    <!-- Copyright -->
</footer>
<!-- Footer -->