
<div class="card border-0 rounded-3 bg-tertiary mb-3">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12 text-center px-0">
                <a href="myOrders.php" class="m-2 btn col-xl-2 col-md-3 col-3 <?= basename($_SERVER['PHP_SELF']) === 'myOrders.php' ? 'btn-main' : 'btn-tertiary'; ?>  w-100">All</a>
                <a href="myOrdersToShip.php" class="m-2 btn col-xl-2 col-md-3 col-3 <?= basename($_SERVER['PHP_SELF']) === 'myOrdersToShip.php' ? 'btn-main' : 'btn-tertiary'; ?>  w-100">To Ship</a>
                <a href="myOrdersToReceive.php" class="m-2 btn col-xl-2 col-md-3 col-3 <?= basename($_SERVER['PHP_SELF']) === 'myOrdersToReceive.php' ? 'btn-main' : 'btn-tertiary'; ?>  w-100">To Receive</a>
                <a href="myOrdersCompleted.php" class="m-2 btn col-xl-2 col-md-3 col-3 <?= basename($_SERVER['PHP_SELF']) === 'myOrdersCompleted.php' ? 'btn-main' : 'btn-tertiary'; ?> w-100">Completed</a>
                <a href="myOrdersCancelled.php" class="m-2 btn col-xl-2 col-md-3 col-3 <?= basename($_SERVER['PHP_SELF']) === 'myOrdersCancelled.php' ? 'btn-main' : 'btn-tertiary'; ?>  w-100">Cancelled</a>
            </div>
        </div>
    </div>
</div>