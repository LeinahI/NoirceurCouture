<?php include('../partials/__header.php');
include('../middleware/userMW.php');
?>
<style>
    .card .bg-main {
        border: none;
    }

    .border-primary {
        border-color: #C5BEB9 !important;
    }
</style>
<div class="container mt-5">
    <?php include('../partials/sessionMessage.php') ?>
    <div class="row">
        <?php include('../partials/sidebar.php') ?>
        <div class="col-md-9">
            <div class="card border rounded-3 shadow bg-main">
                <div class="card-header">
                    <h5 class="card-title">My Notifications</h5>
                </div>
                <div class="card-body">
                    <?php
                    $buyerNotification = getBuyerNotifications();
                    while ($dataid = mysqli_fetch_array($buyerNotification)) {
                        $sender = $dataid['sender_id'];
                        $profileImage = ($sender == 1) ? 'systemProfile.jpg' : 'defaultProfile.jpg';
                        $notifid = $dataid['notif_id'];
                        $header = $dataid['notif_Header'];
                        $body = $dataid['notif_Body'];
                        $notifTime = $dataid['notif_CreatedAt'];
                    ?>
                        <div class="container-fluid">
                            <a href="#" class="btn border border-primary col-md-12 mb-2" data-bs-toggle="modal" data-bs-target="#notifModal<?= $notifid ?>"> <!-- Modal Trigger -->
                                <div class="card p-1 bg-main">
                                    <div class="d-flex align-items-center justify-content-between">
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
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div style="margin-top:5%;">
        <?php include('footer.php'); ?>
    </div>

    <?php include('../partials/__footer.php'); ?>