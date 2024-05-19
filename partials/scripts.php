<!-- sweet js cdn start -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<!-- sweet js cdn end -->

<!-- imgZoom -->
<script>
    $('.imgBox').imgZoom({
        boxWidth: 416,
        boxHeight: 416,
        marginLeft: 5,
    });
</script>

<?php

if (isset($_SESSION['status']) && $_SESSION['status'] != '') {
?>
    <script>
        swal({
            title: "<?php echo $_SESSION['status']; ?>",
            icon: "<?php echo $_SESSION['status_code']; ?>",
            button: 'OK',
        });
    </script>
<?php
    unset($_SESSION['status']);
}
?>