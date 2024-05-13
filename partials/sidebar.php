<style>
    .hoverstate:hover {
        color: #bb6c54 !important;
    }
</style>

<?php
$user = getUserDetails();
$data = mysqli_fetch_array($user);
$profilePic = $data['user_profile_image'];
?>

<div class="col-md-3">
    <div class="card p-3 border rounded-3 shadow bg-main">
        <div class="row">
            <div class="card-title text-dark d-flex align-items-center">
                <div class="avatar">
                    <img src="../assets/uploads/userProfile/<?= ($profilePic) ? $profilePic : 'defaultProfile.jpg' ?>" height="48" width="48" class="rounded-circle" alt="">
                </div>
                <div class="uname ml-2">
                    <?= $_SESSION['auth_user']['user_username'] ?>
                </div>
            </div>
            <div class="card-body">
                <li class="nav-item list-unstyled mb-2">
                    <a class="nav-link hoverstate" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                        <span class="fw-bold">My Account</span>
                    </a>
                    <div class="collapse <?= in_array(basename($_SERVER['PHP_SELF']), ["myAccount.php", "myAddress.php", "myAddressAddNew.php", "myAddressEdit.php", "changePassword.php", "requestDeleteAccount.php"]) ? 'show' : ''; ?>" id="ui-basic">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item">
                                <a href="myAccount.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'myAccount.php' ? 'text-accent' : 'text-dark'; ?>">My Profile</a>
                            </li>
                            <li class="nav-item">
                                <a href="myAddress.php" class="nav-link <?= in_array(basename($_SERVER['PHP_SELF']), ["myAddress.php", "myAddressAddNew.php", "myAddressEdit.php"]) ? 'text-accent' : 'text-dark'; ?>">My Address</a>
                            </li>
                            <li class="nav-item">
                                <a href="changePassword.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'changePassword.php' ? 'text-accent' : 'text-dark'; ?>">Change Password</a>
                            </li>
                            <li class="nav-item">
                                <a href="requestDeleteAccount.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'requestDeleteAccount.php' ? 'text-accent' : 'text-dark'; ?>">Request Account Deletion</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <div class="mb-2">
                    <a href="myOrders.php" class="nav-link hoverstate text-decoration-none fw-bold <?= in_array(basename($_SERVER['PHP_SELF']), ["myOrders.php", "myOrdersToShip.php", "myOrdersToReceive.php", "myOrdersCompleted.php", "myOrdersCancelled.php"]) ? 'text-accent' : ''; ?>">My Purchase</a>
                </div>
                <div class="mb-2">
                    <a href="myNotifications.php" class="nav-link hoverstate text-decoration-none fw-bold <?= basename($_SERVER['PHP_SELF']) === 'myNotifications.php' ? 'text-accent' : ''; ?>">Notifications</a>
                </div>
            </div>
        </div>
    </div>
</div>