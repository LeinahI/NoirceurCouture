<?php include('partials/header.php');
include('../middleware/adminMW.php'); ?>

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

<div class="container">
    <div class="row"></div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h2 class="text-white">All Stores
                    <!-- <a href="addCategory.php" class="btn btn-light float-end ms-2"><i class="material-icons opacity-10">post_add</i> Add Store</a> -->
                </h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped" id="categTable">
                        <thead class="table-active">
                            <tr>
                                <th>store ID</th>
                                <th>user ID</th>
                                <th>Name</th>
                                <th>Image</th>
                                <th>Store Visibility</th>
                                <th>Ban Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $category = getAll("categories");

                            if (mysqli_num_rows($category) > 0) {

                                foreach ($category as $item) {
                                    $banStat = $item['category_isBan'];
                                    if ($banStat == 0) {
                                        $banStatus = 'No';
                                    } elseif ($banStat == 1) {
                                        $banStatus = 'Yes';
                                    }
                            ?>
                                    <tr>
                                        <td><?= $item['category_id']; ?></td>
                                        <td><?= $item['category_user_ID']; ?></td>
                                        <td><?= $item['category_name']; ?></td>
                                        <td>
                                            <img src="../assets/uploads/brands/<?= $item['category_image']; ?>" height="50px" alt="<?= $item['category_name']; ?>">
                                        </td>
                                        <td><?= $item['category_onVacation'] == '0' ? "Visible" : "On Vacation"; ?></td><!-- Visibility store -->
                                        <td><?= $banStatus; ?></td>
                                        <td>
                                            <div style="display: flex;">
                                                <a href="viewCategory.php?id=<?= $item['category_id']; ?>" class="btn btn-primary mx-2">View</a>
                                                <?php
                                                if ($banStat != 1) {
                                                ?>
                                                    <form action="./models/category-auth.php" method="POST">
                                                        <input type="hidden" name="categID" value="<?= $item['category_id'] ?>">
                                                        <input type="hidden" name="categUserID" value="<?= $item['category_user_ID'] ?>">
                                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $item['category_id'] ?>">Ban</button>
                                                        <!-- Modal -->
                                                        <div class="modal fade" id="deleteModal<?= $item['category_id'] ?>" data-bs-keyboard="true" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">Ban <span><?= $item['category_name']; ?></span></h5>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p class="text-wrap fs-5">
                                                                            Are you sure you want to permanently Ban <b><?= $item['category_name']; ?></b>?
                                                                        </p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                                                                        <input type="submit" class="btn btn-primary" name="banCategoryBtn" value="Confirm Ban">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>

                                                <?php
                                                } elseif ($banStat == 1) {
                                                ?>
                                                    <form action="./models/category-auth.php" method="POST">
                                                        <input type="hidden" name="categID" value="<?= $item['category_id'] ?>">
                                                        <input type="hidden" name="categUserID" value="<?= $item['category_user_ID'] ?>">
                                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $item['category_id'] ?>">Unban</button>
                                                        <!-- Modal -->
                                                        <div class="modal fade" id="deleteModal<?= $item['category_id'] ?>" data-bs-keyboard="true" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">Unban <span><?= $item['category_name']; ?></span></h5>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p class="text-wrap fs-5">
                                                                            Are you sure you want to revert ban <b><?= $item['category_name']; ?></b>?
                                                                        </p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                                                                        <input type="submit" class="btn btn-primary" name="revertBanCategoryBtn" value="Revert Ban">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                <?php
                                                } ?>
                                            </div>
                                        </td>

                                    </tr>

                </div>
                </td>
                </tr>
        <?php
                                }
                            } else {
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
<script src="../assets/js/jquery.min.js"></script>
<!--jquery cdn end-->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#categTable').DataTable({
            "bProcessing": true,
            pageLength: 0,
            lengthMenu: [
                [4, -1],
                [4, "All"]
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