<!-- sweet js cdn start -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<!-- sweet js cdn end -->

<!-- Owl Carousel -->
<script>
    $('.owl-one .owl-carousel').owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        navText: [
            '<i class="fa fa-angle-left" aria-hidden="true"></i>',
            '<i class="fa fa-angle-right" aria-hidden="true"></i>'
        ],
        navContainer: '.owl-one .custom-nav',
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 3
            },
            1000: {
                items: 5
            }
        }
    });

    $('.owl-two .owl-carousel').owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        navText: [
            '<i class="fa fa-angle-left" aria-hidden="true"></i>',
            '<i class="fa fa-angle-right" aria-hidden="true"></i>'
        ],
        navContainer: '.owl-two .custom-nav',
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 3
            },
            1000: {
                items: 5
            }
        }
    });
</script>

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