<?php include('../partials/__header.php');

include('../middleware/userMW.php');
?>
<div class="py-3 bg-primary">
    <div class="container">
        <h6>
            <a href="#" class="text-dark">Home /</a>
            <a href="#" class="text-dark">Likes</a>
        </h6>
    </div>
</div>

<div id="mylikes">
    <div class="mt-5">
        <div class="container">
            <div class="col-md-12">
                <div class="row">
                    <?php
                    $items = getLikesItems();

                    if (mysqli_num_rows($items) > 0) {
                        foreach ($items as $cItem) {
                            if (strlen($cItem['product_name']) > 15) {
                                $cItem['product_name'] = substr($cItem['product_name'], 0, 15) . '...';
                            }
                    ?>
                            <div class="card mx-2 mb-3" style="width: 18rem;">
                                <a href="productView.php?product=<?= $cItem['product_slug'] ?>">
                                    <img src="../assets/uploads/products/<?= $cItem['product_image'] ?>" alt="Product Image" class="w-100">
                                </a>
                                <div class="card-body">
                                    <a href="productView.php?product=<?= $cItem['product_slug'] ?>" class="text-dark">
                                        <h5 class="card-title"><?= $cItem['product_name'] ?></h5>
                                    </a>

                                    <h6><b>₱<?= number_format($cItem['product_srp'], 2) ?></b></h6>
                                    <button class="btn btn-danger deleteItemLike" value="<?= $cItem['lid'] ?>"><i class="fa-solid fa-trash" style="color: #ffffff;"></i></button>
                                </div>
                            </div>
                        <?php
                        }
                    } else {
                        ?>
                        <div class="text-center">
                            <h1>You don't have any likes yet</h1>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div style="margin-top:20%;">
    <?php include('footer.php'); ?>
</div>

<?php include('../partials/__footer.php'); ?>