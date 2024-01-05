<?php include('../partials/__header.php');

include('../middleware/userMW.php');/* Authenticate.php */
?>
<div>
    <div class="mt-5" style="margin-bottom: 10%;">
        <div class="container">
            <div class="row">
                <?php include('../partials/sidebar.php') ?>
                <div class="col-md-9">
                    <div class="card p-3 border rounded-3 shadow">
                        <div class="card-header">
                            <h5 class="card-title">My Purchase</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-hover table-striped shadow">
                                <thead>
                                    <tr class="text-center">
                                        <!-- <th>ID</th> -->
                                        <th class="text-start">Tracking No.</th>
                                        <th class="text-start">Price</th>
                                        <th class="text-start">Date</th>
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
                                                <!-- <td class="text-center"> <?php /* $item['orders_id'] */ ?> </td> -->
                                                <td class="text-start"> <?= $item['orders_tracking_no'] ?> </td>
                                                <td class="text-start">₱<?= $item['orders_total_price'] ?> </td>
                                                <td class="text-start"> <?= date('F d, Y h:i:s A', strtotime($item['orders_createdAt'])) ?> </td>
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
        </div>
    </div>

    <div>
        <?php include('footer.php'); ?>
    </div>
</div>

<?php include('../partials/__footer.php'); ?>