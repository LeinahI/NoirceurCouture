<?php
if (isset($_SESSION['Errormsg'])) {
?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fa-solid fa-triangle-exclamation" style="color: #58151C;"></i>
        <?= $_SESSION['Errormsg']; ?>.
        <button id="errorCloseBtn" type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <script>
        setTimeout(function() {
            document.getElementById('errorCloseBtn').click();
        }, 5000); // 5000 milliseconds = 5 seconds
    </script>
<?php
    unset($_SESSION['Errormsg']);
} else if (isset($_SESSION['Successmsg'])) {
?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fa-solid fa-circle-check" style="color: #38761d;"></i>
        <?= $_SESSION['Successmsg']; ?>.
        <button id="successCloseBtn" type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <script>
        setTimeout(function() {
            document.getElementById('successCloseBtn').click();
        }, 5000); // 5000 milliseconds = 5 seconds
    </script>
<?php
    unset($_SESSION['Successmsg']);
}
?>