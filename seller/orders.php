<?php include('partials/header.php');
include('../middleware/sellerMW.php');
?>
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary">
                    <h2 class="text-white">All Orders
                        <a href="ordersCancelled.php" class="btn btn-light float-end ms-2">View Cancelled</a>
                        <a href="ordersDeliver.php" class="btn btn-light float-end ms-2">View Delivered</a>
                        <a href="ordersShipped.php" class="btn btn-light float-end ms-2">View Shipped Out</a>
                        <a href="ordersPreparing.php" class="btn btn-light float-end ms-2">View Preparing Orders</a>
                        <a href="orders.php" class="btn btn-light float-end ms-2"><span class="text-primary">View All</span></a>
                    </h2>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover table-striped" id="ordTable">
                        <thead>
                            <tr class="text-center">
                                <th>Order ID</th>
                                <th>Full Name</th>
                                <th>Tracking No.</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $orders = getAllOrdersbyStore($_SESSION['auth_user']['user_ID']);

                            if (mysqli_num_rows($orders) > 0) {
                                foreach ($orders as $item) {
                            ?>
                                    <tr>
                                        <td class="text-center"> <?= $item['orders_id'] ?> </td>
                                        <td class="text-center"> <?= $item['orders_full_name'] ?> </td>
                                        <td class="text-center"> <?= $item['orders_tracking_no'] ?> </td>
                                        <td class="text-center"> <?= date('F d, Y h:i:s A', strtotime($item['orders_createdAt'])) ?> </td>
                                        <td class="text-center">
                                            <a href="viewOrderDetails.php?trck=<?= $item['orders_tracking_no'] ?>" class="btn btn-primary">View Details</a>
                                        </td>
                                    </tr>
                            <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!--jquery cdn start-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<!--jquery cdn end-->

<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#ordTable').DataTable({
            "bProcessing": true,
            stateSave: true,
            pageLength: 0,
            lengthMenu: [
                [5, -1],
                [5, "All"]
            ],
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records"
            },
            order: [
                [0, 'desc'] // Assuming the first column (index 0) contains timestamps or dates
            ]
        });
    });
</script>

<?php include('partials/footer.php'); ?>