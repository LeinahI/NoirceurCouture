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
                    <h2 class="text-white">All Users</h2>
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
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $users = getAllUsers();



                            /* echo $roleName; */

                            if (mysqli_num_rows($users) > 0) {
                                foreach ($users as $item) {
                                    /* Define Role */
                                    $userRole = $item['user_role'];

                                    if ($userRole == 0) {
                                        $roleName = 'Buyer';
                                    } elseif ($userRole == 1) {
                                        $roleName = 'Admin';
                                    } elseif ($userRole == 2) {
                                        $roleName = 'Seller';
                                    } else {
                                        $roleName = 'Unknown'; // Handle any other values if necessary
                                    }
                            ?>
                                    <tr>
                                        <td class="text-start"> <?= $item['user_ID'] ?> </td>
                                        <td class="text-start"> <?= $item['user_firstName'] ?> </td>
                                        <td class="text-start"> <?= $item['user_lastName'] ?> </td>
                                        <td class="text-start"><?= $item['user_username'] ?> </td>
                                        <td class="text-start"><?= $roleName ?> </td>
                                        <td class="text-center">
                                            <div class="d-flex">
                                                <a href="editusers.php?id=<?= $item['user_ID']; ?>" class="btn btn-primary mx-2">Edit</a>
                                                <form action="models/user-auth.php" method="POST">
                                                    <input type="hidden" name="user_ID" value="<?= $item['user_ID'] ?>">
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $item['user_ID'] ?>">Delete</button>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="deleteModal<?= $item['user_ID'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Delete User <span><?= $item['user_ID']; ?></span></h5>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Are you sure you want to delete <b><?= $item['user_firstName']; ?></b>?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                                                                    <input type="submit" class="btn btn-primary" name="deleteUserBtn" value="Delete">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
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