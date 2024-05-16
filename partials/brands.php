<div class="container">
    <div class="col-md-8 mx-auto">
        <div class="row">
            <?php
            $categories = getAllActive("categories");

            if (mysqli_num_rows($categories) > 0) {
                foreach ($categories as $item) {
            ?>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-6 gy-4 text-center">
                        <a href="store.php?category=<?= $item['category_slug'] ?>">
                            <img class="w-100" height="90" width="160" src="../assets/uploads/brands/<?= $item['category_image'] ?>">
                        </a>
                    </div>
                <?php
                }
            } else {
                ?>

                <p class="text-center fs-1 fw-bold text-accent">
                    No Stores available yet
                </p>
            <?php
            }
            ?>
        </div>
    </div>
</div>