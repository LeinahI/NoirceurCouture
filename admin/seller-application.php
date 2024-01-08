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
                    <h2 class="text-white">Seller Application</h2>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover table-striped" id="ordTable">
                        <thead>
                            <tr class="text-center">
                                <th>User ID</th>
                                <th>Full Name</th>
                                <th>Business Type</th>
                                <th>Confirmation</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $seller = GetAllSellerApplication();
                            /* echo $roleName; */

                            if (mysqli_num_rows($seller) > 0) {
                                foreach ($seller as $item) {
                            ?>
                                    <tr>
                                        <td class="text-start"> <?= $item['seller_user_ID'] ?> </td>
                                        <td class="text-start"> <?= $item['user_firstName'] ?>&nbsp;<?= $item['user_lastName'] ?> </td>
                                        <td class="text-start"><?= $item['seller_seller_type'] ?> </td>
                                        <td class="text-center">
                                            <form action="models/seller-application-auth.php" method="POST" class="text-start">
                                                <input type="hidden" name="sellerUserID" value="<?= $item['seller_user_ID'] ?>">
                                                <!-- Button for Accept -->
                                                <button type="submit" name="processSellerApplication" value="accept" class="btn btn-primary">Accept</button>

                                                <!-- Button for Reject -->
                                                <button type="submit" name="processSellerApplication" value="reject" class="btn btn-primary">Reject</button>
                                            </form>
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