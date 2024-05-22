<!-- sweet js cdn start -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<!-- sweet js cdn end -->

<!-- imgZoom -->
<script>
    // Check if the viewport width is less than or equal to 767px
    const mediaQuery = window.matchMedia('(min-width: 768px)');

    // Function to handle the media query change
    function handleMediaQueryChange(event) {
        if (event.matches) {
            $('.imgBox').imgZoom({
                boxWidth: 350,
                boxHeight: 400,
                marginLeft: 2,
            });
        } 
    }

    // Add event listener for media query change
    mediaQuery.addEventListener('change', handleMediaQueryChange);

    // Call the function initially to set the initial styles
    handleMediaQueryChange(mediaQuery);
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