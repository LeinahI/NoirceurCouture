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
                    <h2 class="text-white">Deleted Users</h2>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover table-striped" id="ordTable">
                        <thead>
                            <tr class="text-center">
                                <th>User ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>username</th>
                                <th>Role</th>
                                <th>Delete Reason</th>
                                <th>Reason Details</th>
                                <th>Date Deleted</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $users = getAllDeletedUsers();
                            /* echo $roleName; */
                            if (mysqli_num_rows($users) > 0) {
                                foreach ($users as $item) {
                                    /* Define Role */
                                    $userRole = $item['ud_role'];

                                    if ($userRole == 0) {
                                        $roleName = 'Buyer';
                                    } elseif ($userRole == 2) {
                                        $roleName = 'Seller';
                                    } else {
                                        $roleName = 'Unknown'; // Handle any other values if necessary
                                    }
                            ?>
                                    <tr>
                                        <td class="text-start"> <?= $item['ud_user_ID'] ?> </td>
                                        <td class="text-start"> <?= $item['ud_firstName'] ?> </td>
                                        <td class="text-start"> <?= $item['ud_lastName'] ?> </td>
                                        <td class="text-start"><?= $item['ud_username'] ?> </td>
                                        <td class="text-start"><?= $roleName ?> </td>
                                        <td class="text-start"><?= $item['ud_reason'] ?> </td>
                                        <td class="text-start"><?= $item['ud_details'] ?> </td>
                                        <td class="text-start"><?= date('m/d/Y h:i:s A', strtotime($item['ud_reqCreatedAt']))  ?> </td>
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