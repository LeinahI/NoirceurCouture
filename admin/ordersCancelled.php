<?php include('partials/header.php');
include('../middleware/adminMW.php');

?>
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary">
                    <h2 class="text-white">Cancelled Orders
                        <a href="ordersCancelled.php" class="btn btn-light float-end ms-2"><span class="text-primary">View Cancelled</span></a>
                        <a href="ordersDeliver.php" class="btn btn-light float-end ms-2">View Delivered</a>
                        <a href="ordersShipped.php" class="btn btn-light float-end ms-2">View Shipped Out</a>
                        <a href="ordersPreparing.php" class="btn btn-light float-end ms-2">View Preparing Orders</a>
                        <a href="orders.php" class="btn btn-light float-end ms-2">View All</a>
                    </h2>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover table-striped" id="ordTable">
                        <thead>
                            <tr class="text-center">
                                <th>Order ID</th>
                                <th>Full Name</th>
                                <th>Tracking No.</th>
                                <th>Price</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $orders = getAllCancelledOrders();

                            if (mysqli_num_rows($orders) > 0) {
                                foreach ($orders as $item) {
                            ?>
                                    <tr>
                                        <td class="text-center"> <?= $item['orders_id'] ?> </td>
                                        <td class="text-center"> <?= $item['orders_full_name'] ?> </td>
                                        <td class="text-center"> <?= $item['orders_tracking_no'] ?> </td>
                                        <td class="text-end">₱<?= $item['orders_total_price'] ?> </td>
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
        });
    });
</script>

<?php include('partials/footer.php'); ?>