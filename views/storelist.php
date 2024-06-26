<!-- also calledCategories.php -->
<?php include('../partials/__header.php');
include(__DIR__ . '/../models/checkSession.php');
checkUserValidityAndRedirect($_SESSION['auth_user']['user_ID'] ?? null);
?>

<style>
    .icon {
        width: 90px;
        height: 90px;
        padding: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

<div class="py-3 bg-main">
    <div class="container">
        <h6 class="text-dark">
            <a href="index.php" class="text-dark">Home</a> /
            <a href="storelist.php" class="text-dark">Collections</a>
        </h6>
    </div>
</div>

<div class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Our Collections</h1>
                <hr>
                <div class="row">

                    <?php
                    $categories = getAllActive("categories");

                    if (mysqli_num_rows($categories) > 0) {
                        foreach ($categories as $item) {
                    ?>
                            <div class="col-md-6 mb-3">
                                <a href="store.php?category=<?= $item['category_slug'] ?>" class="text-decoration-none">
                                    <div class="card border-0">
                                        <div class="card-body bg-tertiary col-md-12">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="d-flex align-items-center">
                                                        <div class="icon rounded-circle">
                                                            <img src="../assets/uploads/brands/<?= $item['category_image'] ?>" alt="Store Image" class="object-fit-cover rounded-circle" width="90" height="90">
                                                        </div>
                                                        <div class="ms-3 c-details">
                                                            <h4 class="store_name"><?= $item['category_name'] ?></h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
    </div>
</div>

<div style="margin-top:2.9%;">
    <?php include('footer.php'); ?>
</div>

<?php include('../partials/__footer.php'); ?>