<?php include('../partials/__header.php');

include('../middleware/userMW.php');
?>
<div class="py-3 bg-main">
    <div class="container">
        <h6>
            <a href="index.php" class="text-dark">Home</a> /
            <a href="myLikes.php" class="text-dark">Wish List</a>
        </h6>
    </div>
</div>

<div id="mylikes">
    <div class="container">
        <div class="row">
            <div>
                <h1 class="text-center mb-3">Wish List</h1>
            </div>
            <div class="text-center hidden" id="noLikedItems">
                <p>There are no items in your Wish List.</p>
            </div>
            <div class="col-12 row">
                <?php
                $items = getLikesItems();

                if (mysqli_num_rows($items) > 0) {
                    foreach ($items as $cItem) {
                        if (strlen($cItem['product_name']) > 27) {
                            $cItem['product_name'] = substr($cItem['product_name'], 0, 24) . '...';
                        }
                ?>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-6 mb-3 d-flex align-items-stretch">
                            <div class="card border-0 bg-tertiary" id="likedCard">
                                <div class="card-body">
                                    <a href="productView.php?product=<?= $cItem['product_slug'] ?>" class="card-link text-dark">
                                        <img src="../assets/uploads/products/<?= $cItem['product_image'] ?>" alt="Product Image" class="w-100">
                                        <p class="card-title"><?= $cItem['product_name'] ?></p>
                                    </a>
                                    <p class="fs-6 text-dark">₱<?= number_format($cItem['product_srp'], 2) ?></p>
                                    <div class="">
                                        <button class="btn btn-main" id="deleteItemLike" value="<?= $cItem['lid'] ?>"><i class="bi bi-trash"></i></button>
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

<div style="margin-top:20%;">
    <?php include('footer.php'); ?>
</div>

<?php include('../partials/__footer.php'); ?>