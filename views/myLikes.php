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
        <div class="col-md-12">
            <h1 class="text-center mb-3">Wish List</h1>
            <div class="row">
                <?php
                $items = getLikesItems();

                if (mysqli_num_rows($items) > 0) {
                    foreach ($items as $cItem) {
                        if (strlen($cItem['product_name']) > 27) {
                            $cItem['product_name'] = substr($cItem['product_name'], 0, 24) . '...';
                        }
                ?>
                        <div class="card border-0" style="width: 18rem;" id="likedCard">
                            <div class="card-body bg-tertiary rounded">
                                <a href="productView.php?product=<?= $cItem['product_slug'] ?>" class="text-dark">
                                    <img src="../assets/uploads/products/<?= $cItem['product_image'] ?>" alt="Product Image" class="w-100">
                                    <h5 class="card-title"><?= $cItem['product_name'] ?></h5>
                                </a>

                                <h6><b>₱<?= number_format($cItem['product_srp'], 2) ?></b></h6>
                                <button class="btn btn-danger" id="deleteItemLike" value="<?= $cItem['lid'] ?>"><i class="fa-solid fa-trash" style="color: #ffffff;"></i></button>
                            </div>
                        </div>
                <?php
                    }
                }
                ?>
                <div class="text-center hidden" id="noLikedItems">
                    <p>There are no items in your Wish List.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div style="margin-top:20%;">
    <?php include('footer.php'); ?>
</div>

<?php include('../partials/__footer.php'); ?>