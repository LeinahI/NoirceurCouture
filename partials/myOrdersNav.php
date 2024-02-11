<div class="card border rounded-3 shadow bg-main mb-3">
    <div class="card-body">
        <div class="col-md-12 text-center px-0">
            <a href="myOrders.php" class="btn <?= basename($_SERVER['PHP_SELF']) === 'myOrders.php' ? 'btn-accent' : 'btn-primary'; ?> col-md-2 w-100">All</a>
            <a href="myOrdersToShip.php" class="btn <?= basename($_SERVER['PHP_SELF']) === 'myOrdersToShip.php' ? 'btn-accent' : 'btn-primary'; ?> col-md-2 w-100">To Ship</a>
            <a href="myOrdersToReceive.php" class="btn <?= basename($_SERVER['PHP_SELF']) === 'myOrdersToReceive.php' ? 'btn-accent' : 'btn-primary'; ?> col-md-2 w-100">To Receive</a>
            <a href="myOrdersCompleted.php" class="btn <?= basename($_SERVER['PHP_SELF']) === 'myOrdersCompleted.php' ? 'btn-accent' : 'btn-primary'; ?> col-md-2 w-100">Completed</a>
            <a href="myOrdersCancelled.php" class="btn <?= basename($_SERVER['PHP_SELF']) === 'myOrdersCancelled.php' ? 'btn-accent' : 'btn-primary'; ?> col-md-2 w-100">Cancelled</a>
        </div>
    </div>
</div>