<?php include('partials/header.php');
include('../middleware/adminMW.php'); ?>

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

<div class="container">
    <div class="row"></div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h2 class="text-white">Modify Slideshow
                    <a href="addImage.php" class="btn btn-light float-end ms-2"><i class="material-icons opacity-10">add_to_photos</i> Add Image</a>
                </h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped" id="prodTable">
                        <thead class="table-active">
                            <tr>
                                <th>ID</th>
                                <th>image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $img = getAll("slideshow");

                            if (mysqli_num_rows($img) > 0) {

                                foreach ($img as $item) {
                            ?>
                                    <tr>
                                        <td><?= $item['ss_id']; ?></td>

                                        <td><img src="../assets/uploads/slideshow/<?= $item['ss_image']; ?>" height="100px" class="w-40 border" alt="slideshow image"></td>
                                        <td>
                                            <div style="display: flex;">
                                                <a href="editImage.php?id=<?= $item['ss_id']; ?>" class="btn btn-primary mx-2">Edit</a>
                                                <form action="models/slide-show-auth.php" method="POST">
                                                    <input type="hidden" name="ssID" value="<?= $item['ss_id'] ?>">
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $item['ss_id'] ?>">Delete</button>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="deleteModal<?= $item['ss_id'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Delete Product <span><?= $item['ss_id']; ?></span></h5>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Are you sure you want to delete this image?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                                                                    <input type="submit" class="btn btn-primary" name="deleteSlideshowBtn" value="Delete">
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<!--jquery cdn end-->

<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#prodTable').DataTable({
            "bProcessing": true,
            stateSave: true,
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