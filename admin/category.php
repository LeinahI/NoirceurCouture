<?php include('partials/header.php');
include('../middleware/adminMW.php'); ?>

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

<div class="container">
    <div class="row"></div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h2 class="text-white">All Brand Categories
                    <a href="addCategory.php" class="btn btn-light float-end ms-2"><i class="material-icons opacity-10">post_add</i> Add Brand</a>
                </h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped" id="categTable">
                        <thead class="table-active">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Image</th>
                                <th>Visibility</th>
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
                                        <td><?= $item['category_name']; ?></td>
                                        <td>
                                            <img src="../assets/uploads/brands/<?= $item['category_image']; ?>" height="50px" alt="<?= $item['category_name']; ?>">
                                        </td>
                                        <td><?= $item['category_status'] == '0' ? "Visible" : "Hidden"; ?></td>
                                        <td>
                                            <div style="display: flex;">
                                                <a href="editCategory.php?id=<?= $item['category_id']; ?>" class="btn btn-primary mx-2">Edit</a>
                                                <form action="./models/category-auth.php" method="POST">
                                                    <input type="hidden" name="categoryID" value="<?= $item['category_id'] ?>">
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $item['category_id'] ?>">Delete</button>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="deleteModal<?= $item['category_id'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Delete Category <span><?= $item['category_id']; ?></span></h5>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Are you sure you want to delete <b><?= $item['category_name']; ?></b>?
                                                                    <br>
                                                                    All products & image associated with <b><?= $item['category_name']; ?></b> will also be deleted.
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                                                                    <input type="submit" class="btn btn-primary" name="deleteCategoryBtn" value="Delete">
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
                            } else {
                                //  echo "No records found";
                                $_SESSION['status'] = "No records found";
                                $_SESSION['status_code'] = "error";

                                // redirectSwal("No records found","error");
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