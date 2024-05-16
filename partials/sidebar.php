<style>
    .hoverstate {
        color: var(--text-dark-4);
    }

    .hoverstate:hover {
        color: var(--text-dark) !important;
    }

    @media (max-width: 768px) {
        .sidebar {
            margin-bottom: 15px;
        }
    }
</style>

<?php
$user = getUserDetails();
$data = mysqli_fetch_array($user);
$profilePic = $data['user_profile_image'];
?>

<div class="col-md-3 sidebar">
    <div class="card p-3 border-0 rounded-3 bg-tertiary">
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
                        <span class="<?= in_array(basename($_SERVER['PHP_SELF']), ["myAccount.php", "changePhoneNumber.php", "changeEmailAddress.php", "myAddress.php", "myAddressAddNew.php", "myAddressEdit.php", "changePassword.php", "requestDeleteAccount.php"]) ? 'text-decoration-underline' : ''; ?>">My Account</span>
                    </a>
                    <div class="collapse <?= in_array(basename($_SERVER['PHP_SELF']), ["myAccount.php", "changePhoneNumber.php", "changeEmailAddress.php", "myAddress.php", "myAddressAddNew.php", "myAddressEdit.php", "changePassword.php", "requestDeleteAccount.php"]) ? 'show' : ''; ?>" id="ui-basic">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item">
                                <a href="myAccount.php" class="hoverstate nav-link <?= in_array(basename($_SERVER['PHP_SELF']), ["myAccount.php", "changePhoneNumber.php", "changeEmailAddress.php"]) ? 'text-dark text-decoration-underline' : 'text-dark-4'; ?>">My Profile</a>
                            </li>
                            <li class="nav-item">
                                <a href="myAddress.php" class="hoverstate nav-link <?= in_array(basename($_SERVER['PHP_SELF']), ["myAddress.php", "myAddressAddNew.php", "myAddressEdit.php"]) ? 'text-dark text-decoration-underline' : 'text-dark-4'; ?>">My Address</a>
                            </li>
                            <li class="nav-item">
                                <a href="changePassword.php" class="hoverstate nav-link <?= basename($_SERVER['PHP_SELF']) === 'changePassword.php' ? 'text-dark text-decoration-underline' : 'text-dark-4'; ?>">Change Password</a>
                            </li>
                            <li class="nav-item">
                                <a href="requestDeleteAccount.php" class="hoverstate nav-link <?= basename($_SERVER['PHP_SELF']) === 'requestDeleteAccount.php' ? 'text-dark text-decoration-underline' : 'text-dark-4'; ?>">Request Account Deletion</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <div class="mb-2">
                    <a href="myOrders.php" class="hoverstate <?= in_array(basename($_SERVER['PHP_SELF']), ["myOrders.php", "myOrdersToShip.php", "myOrdersToReceive.php", "myOrdersCompleted.php", "myOrdersCancelled.php"]) ? 'text-dark text-decoration-underline' : ''; ?>">My Purchase</a>
                </div>
                <div class="mb-2">
                    <a href="myNotifications.php" class="hoverstate <?= basename($_SERVER['PHP_SELF']) === 'myNotifications.php' ? 'text-dark text-decoration-underline' : ''; ?>">Notifications</a>
                </div>
            </div>
        </div>
    </div>
</div>