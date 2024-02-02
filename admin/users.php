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
                                <th>Ban Status</th>
                                <th>Action</th>
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
                                    $banStat = $item['user_isBan'];

                                    if ($userRole == 0) {
                                        $roleName = 'Buyer';
                                    } elseif ($userRole == 1) {
                                        $roleName = 'Admin';
                                    } elseif ($userRole == 2) {
                                        $roleName = 'Seller';
                                    } else {
                                        $roleName = 'Unknown'; // Handle any other values if necessary
                                    }

                                    if ($banStat == 0) {
                                        $banStatus = 'No';
                                    } elseif ($banStat == 1) {
                                        $banStatus = 'Yes';
                                    }

                            ?>
                                    <tr>
                                        <td class="text-start"> <?= $item['user_ID'] ?> </td>
                                        <td class="text-start"> <?= $item['user_firstName'] ?> </td>
                                        <td class="text-start"> <?= $item['user_lastName'] ?> </td>
                                        <td class="text-start"><?= $item['user_username'] ?> </td>
                                        <td class="text-start"><?= $roleName ?> </td>
                                        <td class="text-start"><?php
                                                                if ($userRole == 1) {
                                                                    echo "";
                                                                } else if ($userRole != 1) {
                                                                    echo $banStatus;
                                                                }
                                                                ?> </td>
                                        <td>
                                            <div class="d-flex">
                                                <a href="viewUsers.php?id=<?= $item['user_ID']; ?>" class="btn btn-primary mx-2">View</a>

                                                <?php
                                                if ($userRole != 1 && $banStat != 1) {
                                                ?>
                                                    <form action="./models/user-auth.php" method="POST">
                                                        <input type="hidden" name="userID" value="<?= $item['user_ID'] ?>">
                                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $item['user_ID'] ?>">Ban</button>
                                                        <!-- Modal -->
                                                        <div class="modal fade" id="deleteModal<?= $item['user_ID'] ?>" data-bs-keyboard="true" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">Ban <span><?= $item['user_username']; ?></span></h5>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p class="text-wrap fs-5">
                                                                            Are you sure you want to permanently Ban <b><?= $item['user_username']; ?></b>?
                                                                        </p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                                                                        <input type="submit" class="btn btn-primary" name="banUserBtn" value="Confirm Ban">
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
                            <!-- Modal -->
                            <div class="modal fade" id="banModal" tabindex="-1" aria-labelledby="banModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="banModalLabel">Are you sure to ban <?= $item['user_ID'] ?>?</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            ...
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
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