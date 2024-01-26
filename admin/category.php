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
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $category = getAll("categories");

                            if (mysqli_num_rows($category) > 0) {

                                foreach ($category as $item) {
                            ?>
                                    <tr>
                                        <td><?= $item['category_id']; ?></td>
                                        <td><?= $item['category_user_ID']; ?></td>
                                        <td><?= $item['category_name']; ?></td>
                                        <td>
                                            <img src="../assets/uploads/brands/<?= $item['category_image']; ?>" height="50px" alt="<?= $item['category_name']; ?>">
                                        </td>
                                        <td><?= $item['category_status'] == '0' ? "Visible" : "Hidden"; ?></td><!-- Visibility store -->
                                        <td>
                                            <div style="display: flex;">
                                                <a href="editCategory.php?id=<?= $item['category_id']; ?>" class="btn btn-primary mx-2">View</a>
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