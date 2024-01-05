<div class="col-md-3">
    <div class="card p-3 border rounded-3 shadow">
        <div class="row">
            <div class="card-title">
                My Account
            </div>
            <div class="card-body">
                <div>
                    <a href="myAccount.php" class="<?= basename($_SERVER['PHP_SELF']) === 'myAccount.php' ? 'text-primary' : 'text-dark'; ?>">My Profile</a>
                </div>
                <div>
                    <a href="myAddress.php" class="<?= basename($_SERVER['PHP_SELF']) === 'myAddress.php' ? 'text-primary' : 'text-dark'; ?>">My Address</a>
                </div>
                <div>
                    <a href="myOrders.php" class="<?= basename($_SERVER['PHP_SELF']) === 'myOrders.php' ? 'text-primary' : 'text-dark'; ?>">My Purchase</a>
                </div>
            </div>
        </div>
    </div>
</div>