<div class="col-md-3">
    <div class="card p-3 border rounded-3 shadow bg-main">
        <div class="row">
            <div class="card-title text-dark">
                My Account
            </div>
            <div class="card-body">
                <div>
                    <a href="myAccount.php" class="<?= basename($_SERVER['PHP_SELF']) === 'myAccount.php' ? 'text-accent' : 'text-dark'; ?>">My Profile</a>
                </div>
                <div>
                    <a href="myAddress.php" class="<?= basename($_SERVER['PHP_SELF']) === 'myAddress.php' ? 'text-accent' : 'text-dark'; ?>">My Address</a>
                </div>
                <div>
                    <a href="myOrders.php" class="<?= basename($_SERVER['PHP_SELF']) === 'myOrders.php' ? 'text-accent' : 'text-dark'; ?>">My Purchase</a>
                </div>
                <div>
                    <a href="requestDeleteAccount.php"  class="<?= basename($_SERVER['PHP_SELF']) === 'requestDeleteAccount.php' ? 'text-accent' : 'text-dark'; ?>">Request Account Deletion</a>
                    <!--
                        Reference https://help.shopee.com.my/portal/article/78582-[My-Account]-How-do-I-delete-my-Shopee-account%3F
                     -->
                    

                </div>
            </div>
        </div>
    </div>
</div>