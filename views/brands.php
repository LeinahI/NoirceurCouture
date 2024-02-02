<!-- also calledCategories.php -->
<?php include('../partials/__header.php');
include(__DIR__ . '/../models/checkSession.php');
checkUserValidityAndRedirect($_SESSION['auth_user']['user_ID'] ?? null);
?>

<style>
    .img-fixed-height {
        height: 200px;
        width: auto;
        object-fit: cover;
    }
</style>

<div class="py-3 bg-primary">
    <div class="container">
        <h6 class="text-dark">Home / Collections / </h6>
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
                            <div class="col-md-4 mb-3">
                                <a href="products.php?category=<?= $item['category_slug'] ?>">
                                    <div class="card shadow">
                                        <div class="card-body bg-primary">
                                            <img src="../assets/uploads/brands/<?= $item['category_image'] ?>" alt="Brand Image" class="w-100 img-fixed-height">
                                            <h4><?= $item['category_name'] ?></h4>
                                        </div>
                                    </div>
                                </a>
                            </div>
                    <?php
                        }
                    } else {
                        echo "No data available";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>

<?php include('../partials/__footer.php'); ?>