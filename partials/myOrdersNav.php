<div class="card border-0 rounded-3 bg-tertiary mb-3">
    <div class="card-body">
        <div class="col-md-12 text-center px-0">
            <a href="myOrders.php" class="btn <?= basename($_SERVER['PHP_SELF']) === 'myOrders.php' ? 'btn-main' : 'btn-tertiary'; ?> col-md-2 w-100">All</a>
            <a href="myOrdersToShip.php" class="btn <?= basename($_SERVER['PHP_SELF']) === 'myOrdersToShip.php' ? 'btn-main' : 'btn-tertiary'; ?> col-md-2 w-100">To Ship</a>
            <a href="myOrdersToReceive.php" class="btn <?= basename($_SERVER['PHP_SELF']) === 'myOrdersToReceive.php' ? 'btn-main' : 'btn-tertiary'; ?> col-md-2 w-100">To Receive</a>
            <a href="myOrdersCompleted.php" class="btn <?= basename($_SERVER['PHP_SELF']) === 'myOrdersCompleted.php' ? 'btn-main' : 'btn-tertiary'; ?> col-md-2 w-100">Completed</a>
            <a href="myOrdersCancelled.php" class="btn <?= basename($_SERVER['PHP_SELF']) === 'myOrdersCancelled.php' ? 'btn-main' : 'btn-tertiary'; ?> col-md-2 w-100">Cancelled</a>
        </div>
    </div>
</div>