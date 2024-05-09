<?php include('partials/header.php');
include('../middleware/sellerMW.php');
include('../models/checkSession.php');
include('models/check-seller-addr.php');
checkUserValidityAndRedirect($_SESSION['auth_user']['user_ID'] ?? null);
?>
<style>
    .card .bg-main {
        border: none;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary">
                    <h2 class="text-white">My Notifications
                    </h2>
                </div>
                <div class="card-body">
                    <?php
                    $buyerNotification = getSellerNotifications();
                    if (mysqli_num_rows($buyerNotification) == 0) {
                        // If there are no notifications
                    ?>
                        <p class="fs-1 text-center">No notifications yet</p>
                        <?php
                    } else {
                        // If there are notifications, display them
                        while ($dataid = mysqli_fetch_array($buyerNotification)) {
                            $sender = $dataid['sender_id'];
                            $profileImage = ($sender == 1) ? 'systemProfile.jpg' : 'defaultProfile.jpg';
                            $notifid = $dataid['notif_id'];
                            $header = $dataid['notif_Header'];
                            $body = $dataid['notif_Body'];
                            $notifTime = $dataid['notif_CreatedAt'];
                        ?>
                            <div class="container-fluid">
                                <a href="#" class="card shadow-dark shadow p-2 col-md-12 mb-2" data-bs-toggle="modal" data-bs-target="#notifModal<?= $notifid ?>"> <!-- Modal Trigger -->
                                    <div class=" p-1 bg-main">
                                        <div class="text-dark d-flex align-items-center justify-content-between">
                                            <div class="col-md-9 text-start">
                                                <img src="../assets/uploads/userProfile/<?php echo $profileImage ?>" alt="profile_image" height="40" width="40" class="rounded-circle object-fit-cover">
                                                <span class="ml-3"><?= $header ?></span>
                                            </div>
                                            <div class="ms-auto col-md-3 text-end">
                                                <span><?= date('m/d/Y h:i:s A', strtotime($notifTime)) ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <!-- Modal -->
                                <div class="modal fade" id="notifModal<?= $notifid ?>" tabindex="-1" aria-labelledby="notifModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content bg-main">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-6" id="notifModalLabel"><?= $header ?></h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <span><?= $body ?></span>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                                            </div>
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
</div>

<?php include('partials/footer.php'); ?>

<script>
    //Visible & hidden
    document.addEventListener("DOMContentLoaded", function() {
        var checkbox = document.getElementById("visibility_cb");
        var label = document.getElementById("visibility_label");

        checkbox.addEventListener("change", function() {
            label.textContent = checkbox.checked ? "On Vacation" : "Visible";
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        var nameInput = document.getElementById("name_input");
        var slugInput = document.getElementById("slug_input");
        var metaTitle = document.getElementById("metaTitle_input");
        var descriptionInput = document.getElementById("description_input");
        var metaDescription = document.getElementById("metaDescription_input");

        /* For slug and meta title */
        nameInput.addEventListener("input", function() {
            // Update the value of the slug input based on the name input
            slugInput.value = generateSlug(nameInput.value);
            metaTitle.value = nameInput.value;
        });

        /* for meta description */
        descriptionInput.addEventListener("input", function() {
            metaDescription.value = descriptionInput.value;
        });

        // Function to generate a slug from the given string
        function generateSlug(str) {
            // Replace spaces with dashes and convert to lowercase
            return str.trim().toLowerCase().replace(/\s+/g, '-');
        }
    });
</script>