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
                                                <input type="hidden" name="deletedUserRole" value="<?= $role ?>">
                                                <!-- Button for Accept -->
                                                <button type="submit" name="processAccDeletion" value="accept" class="btn btn-primary">Accept</button>
                                            </form>
                                            <!-- Button for Reject -->
                                            <!-- Button trigger modal -->
                                            <form action="models/user-account-deletion.php" method="POST" class="text-start">
                                                <input type="hidden" name="rejectedUserID" value="<?= $item['ud_user_ID'] ?>">
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#rejectModal<?= $item['ud_user_ID'] ?>">
                                                    Reject
                                                </button>
                                                <!-- Modal -->
                                                <div class="modal fade" id="rejectModal<?= $item['ud_user_ID'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Select Rejection Reason for <?= $item['ud_username'] ?></h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <input type="hidden" name="rejectedUserID" value="<?= $item['ud_user_ID'] ?>">
                                                                <input type="hidden" name="senderID" value="<?= $_SESSION['auth_user']['user_ID']; ?>">

                                                                <!--//+ Reason1 -->
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="rejectReason" id="reason1" value="reason1" required>
                                                                    <label class="form-check-label fs-6" for="reason1">Unfulfilled Orders or Pending Transactions</label>
                                                                </div>
                                                                <input type="hidden" name="reasonHeader1" value="Unfulfilled Orders or Pending Transactions">
                                                                <input type="hidden" name="reasonBody1" value="You have pending orders or transactions that have not been completed. The Seller and Noirceur Couture need to resolve these before deleting your account.">

                                                                <!--//+ Reason2 -->
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="rejectReason" id="reason2" value="reason2" required>
                                                                    <label class="form-check-label fs-6" for="reason2">You have exceeded the account deletion limit</label>
                                                                </div>
                                                                <input type="hidden" name="reasonHeader2" value="You have exceeded the account deletion limit">
                                                                <input type="hidden" name="reasonBody2" value="You can only delete an account created with the same phone number twice. If you sign up for a third time with the same phone number, you will not be able to delete this account.">
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" name="processAccRejection" value="reject" class="btn btn-primary">Confirm reject</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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