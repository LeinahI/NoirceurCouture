<!-- Link Swiper's CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />

<!-- Demo styles -->
<style>
    .swiper {
        width: 100%;
        height: 100%;
    }
</style>

<!-- Swiper -->
    <div class="container">
        <div class="swiper mySwiper responsive">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <img class="slideImages img-fluid" src="../assets/slideShow/Slide0_S'YTE.jpg" />
                </div>
                <div class="swiper-slide">
                    <img class="slideImages img-fluid" src="../assets/slideShow/Slide1_GroundY.jpg" />
                </div>
                <div class="swiper-slide">
                    <img class="slideImages img-fluid" src="../assets/slideShow/Slide2_Demonia.jpg" />
                </div>
                <div class="swiper-slide">
                    <img class="slideImages img-fluid" src="../assets/slideShow/Slide3_AnthonyWang.jpg" />
                </div>
                <div class="swiper-slide">
                    <img class="slideImages img-fluid" src="../assets/slideShow/Slide4_TrippNYC.jpg" />
                </div>
                <div class="swiper-slide">
                    <img class="slideImages img-fluid" src="../assets/slideShow/Slide5_DarkSplash.jpg" />
                </div>
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