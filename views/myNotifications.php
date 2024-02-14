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
                    <div class="container-fluid">
                        <a href="#" class="btn border border-primary col-md-12" data-bs-toggle="modal" data-bs-target="#exampleModal"> <!-- Modal Trigger -->
                            <div class="card bg-main">
                                <div class="card-body d-flex align-items-center justify-content-between gap-3">
                                    <div>
                                        <img src="../assets/uploads/userProfile/defaultProfile.jpg" alt="profile_image" height="40" width="40" class="rounded-circle object-fit-cover">
                                    </div>
                                    <div>
                                        <span>Your request for Account Deletion has been rejected.</span>
                                    </div>
                                    <div class="ms-auto">
                                        <span>Feb 14 2024 8:24 PM</span>
                                    </div>
                                </div>

                            </div>
                        </a>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-6" id="exampleModalLabel">Your request for account deletion has been rejected</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <ul>
                                            <span>1. Unfulfilled Orders or Pending Transactions.</span>
                                            <ul>• You have pending orders or transactions that have not been completed. The Seller and Noirceur Couture need to resolve these before deleting your account.</ul>
                                        </ul>
                                        <ul>
                                            <span>2. You have exceeded the account deletion limit.</span>
                                            <ul>• You can only delete an account created with the same phone number twice. If you sign up for a third time with the same phone number, you will not be able to delete this account.</ul>
                                        </ul>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="margin-top:5%;">
        <?php include('footer.php'); ?>
    </div>

    <?php include('../partials/__footer.php'); ?>