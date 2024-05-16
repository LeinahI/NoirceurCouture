<?php include('../partials/__header.php');

include(__DIR__ . '/../models/checkSession.php');
checkUserValidityAndRedirect($_SESSION['auth_user']['user_ID'] ?? null);
?>

<div class="container mt-3 position-absolute start-50 translate-middle-x z-2">
    <?php include('../partials/sessionMessage.php') ?>
</div>

<?php
$categories = getAllActive("categories");
if (mysqli_num_rows($categories) > 0) {
?>
    <p class="fs-6 my-4 text-center">Brands</p>
<?php
    include('../partials/brands.php');
}
$popular = getAllPopular();
if (mysqli_num_rows($popular) > 0) {
    include('../partials/recommendedItems.php');
}
?>

<style>
    @media (max-width: 1399px) {
        .text-display {
            display: none;
        }
    }
</style>


<div class="my-5">
    <div class="container">
        <div class="position-absolute z-2 text-display" style="translate: 800px 300px;">
            <div class="card" style="width: 24rem;">
                <div class="card-body bg-main">
                    <h5 class="card-title text-center fw-bold">Welcome to the Noirceur</h5>
                    <p class="card-text text-center">Noirceur Couture is the go-to place for individuals who seek avant-garde and other subculture wear from well-known brands. <br>
                        As a trusted distributor, we bring you an extensive collection of curated pieces from top fashion brands around the world. <br>
                        From chic clothing to accessories, Noirceur Couture caters to diverse tastes, providing a seamless shopping experience for those looking for quality and exclusivity.</p>
                    <center>
                        <a href="storelist.php" class="btn btn-primary">Shop Now</a>
                    </center>
                </div>
            </div>
        </div>
        <img class="img-fluid" src="../assets/images/index/nctr.jpg" />
    </div>
</div>
<?php
include('footer.php');
include('../partials/__footer.php');
?>