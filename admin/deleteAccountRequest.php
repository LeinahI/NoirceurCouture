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
                    <h2 class="text-white">Delete Account Requests</h2>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover table-striped" id="ordTable">
                        <thead>
                            <tr class="text-center">
                                <th>User ID</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Reason</th>
                                <th>Details</th>
                                <th>Confirmation</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $delAcc = GetAllDeletedAccReq();

                            if (mysqli_num_rows($delAcc) > 0) {
                                foreach ($delAcc as $item) {

                                    $role = $item['ud_role'];
                            ?>
                                    <tr>
                                        <td class="text-start"> <?= $item['ud_user_ID'] ?> </td>
                                        <td class="text-start"> <?= $item['ud_username'] ?></td>
                                        <td class="text-start"> <?php if ($role == 0) {
                                                                    echo "Buyer";
                                                                } else if ($role == 2) {
                                                                    echo "Seller";
                                                                } ?></td>
                                        <td class="text-start"> <?= $item['ud_reason'] ?> </td>
                                        <td class="text-start"> <?= $item['ud_details'] ?> </td>
                                        <td class="text-center">
                                            <form action="models/user-account-deletion.php" method="POST" class="text-start">
                                                <input type="hidden" name="deletedUserID" value="<?= $item['ud_user_ID'] ?>">
                                                <!-- Button for Accept -->
                                                <button type="submit" name="processAccDeletion" value="accept" class="btn btn-primary">Accept</button>

                                                <!-- Button for Reject -->
                                                <button type="submit" name="processAccDeletion" value="reject" class="btn btn-primary">Reject</button>
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