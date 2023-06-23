<?php include('includes/header.php');

include('middleware/userMW.php');/* Authenticate.php */
?>
<div>
    <div class="py-3 bg-primary">
        <div class="container">
            <h6 class="text-white">
                <a href="#" class="text-white">Home /</a>
                <a href="#" class="text-white">My Orders</a>
            </h6>
        </div>
    </div>
    <div class="mt-5" style="margin-bottom: 10%;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>My Orders</h2>
                    <table class="table table-bordered table-hover table-striped shadow">
                        <thead>
                            <tr class="text-center">
                                <th>ID</th>
                                <th>Tracking No.</th>
                                <th>Price</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $orders = getOrders();

                            if (mysqli_num_rows($orders) > 0) {
                                foreach ($orders as $item) {
                            ?>
                                    <tr>
                                        <td class="text-center"> <?= $item['orders_id'] ?> </td>
                                        <td class="text-center"> <?= $item['orders_tracking_no'] ?> </td>
                                        <td class="text-end">₱<?= $item['orders_total_price'] ?> </td>
                                        <td class="text-center"> <?= date('F d, Y h:i:s A', strtotime($item['orders_createdAt'])) ?> </td>
                                        <td class="text-center"><a href="viewOrderDetails.php?trck=<?= $item['orders_tracking_no'] ?>" class="btn btn-primary">View Details</a></td>
                                    </tr>
                                <?php
                                }
                            } else {
                                ?>
                                <h1 class="text-center">You haven't ordered yet.</h1>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <div>
        <?php include('ftr.php'); ?>
    </div>
</div>

<?php include('includes/footer.php'); ?>