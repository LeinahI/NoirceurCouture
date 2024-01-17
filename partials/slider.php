<!-- Link Swiper's CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />

<!-- Demo styles -->
<style>
    .swiper {
        position: relative;
        width: 1296px;
        height: 729px;
    }

    @media (max-width: 1399px) {
        .swiper {
             width: 1116px;
            height: 627.067px;
        }
    }

    @media (max-width: 1199px) {
        .swiper {
             width: 936px;
            height: 529.1px;
        }
    }

    @media (max-width: 991px) {
        .swiper {
             width: 696px;
            height: 391.033px;
        }
    }

    @media (max-width: 767px) {
        .swiper {
             width: 516px;
            height: 289.867px;
        }
    }
</style>

<!-- Swiper -->
<div class="container">
    <div class="swiper mySwiper responsive">
        <div class="swiper-wrapper">
            <?php
            require_once '../models/slideShowFunction.php';
            $slideshowImages = getSlideShow();

            if (count($slideshowImages) > 0) {
                foreach ($slideshowImages as $item) {
            ?>
                    <div class="swiper-slide">
                        <img class="slideImages h-100 w-100 img-fluid border border-top-0" src="../assets/uploads/slideshow/<?= $item['ss_image'] ?>" />
                    </div>
            <?php
                }
            } else {
                // Handle case where there are no slideshow images
                /* echo 'No slideshow images available.'; */
            }
            ?>
        </div>
    </div>
</div>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

<!-- Initialize Swiper -->
<script>
    document.querySelector('.slideImages').setAttribute('draggable', false);

    var swiper = new Swiper(".mySwiper", {
        spaceBetween: 30,
        effect: "fade",
        loop: "true",
        allowTouchMove: false,
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
    });
</script>