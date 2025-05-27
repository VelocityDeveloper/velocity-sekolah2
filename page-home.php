<?php

/**
 * Template Name: Home Template
 *
 * Template for displaying a page just with the header and footer area and a "naked" content area in between.
 * Good for landingpages and other types of pages where you want to add a lot of custom markup.
 *
 * @package justg
 */

get_header();
$home_banner = velocitytheme_option('home_banner');
$home_foto = velocitytheme_option('home_foto');
$home_judul_sambutan = velocitytheme_option('home_judul_sambutan');
$home_isi_sambutan = velocitytheme_option('home_isi_sambutan');
$home_judul_guru = velocitytheme_option('home_judul_guru');
$home_guru = velocitytheme_option('home_guru');
$home_judul_galeri = velocitytheme_option('home_judul_galeri');
$home_galeri = velocitytheme_option('home_galeri');
?>

<div class="wrapper" id="page-wrapper">

  <?php if(!empty($home_banner)){ ?>
    <div class="velocity-home-banner">
      <img class="w-100" src="<?php echo $home_banner; ?>">
    </div>
  <?php } ?>

    <div class="container py-5">
        <div class="row text-center py-5 my-3">
          <?php if(!empty($home_foto)){ ?>
              <div class="col-md-5 me-4 mb-3 mb-md-0">
                <img src="<?php echo $home_foto; ?>">
              </div>
          <?php } ?>
            <div class="col-md text-md-start">
              <?php if(!empty($home_judul_sambutan)){ ?>
                <h2 class="fw-bold mb-md-4 mb-3"><?php echo $home_judul_sambutan; ?></h2>
              <?php } if(!empty($home_isi_sambutan)){ ?>
                <?php echo $home_isi_sambutan; ?>
              <?php } ?>
            </div>
        </div>
    </div>


<?php if(!empty($home_guru)){ ?>
<div class="bg-primary text-white py-5">
<div class="text-center py-5 my-3">
  <?php if(!empty($home_judul_guru)){ ?>
   <h2 class="fw-bold text-white mb-4"><?php echo $home_judul_guru; ?></h2>
  <?php } ?>
  <div class="velocity-swiper">
    <div class="velocity-swiper-button white-swiper-button swiper-button-next"></div>
    <div class="velocity-swiper-button white-swiper-button swiper-button-prev"></div>
    <div class="swiper home-galeri-carousel pb-5 mx-5">
      <div class="swiper-wrapper">
        <?php foreach ($home_guru as $guru) {
            echo '<div class="swiper-slide">';
              echo '<img class="mb-2" src="' . esc_url($guru['foto']) . '" alt="">';
              echo '<h3 class="fs-5 mb-2 text-white">' . esc_html($guru['nama']) . '</h3>';
              echo '<p>' . esc_html($guru['jabatan']) . '</p>';
            echo '</div>';
        } ?>
      </div>
      <div class="swiper-pagination"></div>
    </div>
  </div>
</div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    new Swiper('.home-galeri-carousel', {
        slidesPerView: 5,
        spaceBetween: 20,
        loop: true,
        navigation: {
          nextEl: '.swiper-button-next',
          prevEl: '.swiper-button-prev',
        },
        pagination: {
          el: '.swiper-pagination',
          clickable: true,
        },
        breakpoints: {
          0: { slidesPerView: 1 },
          576: { slidesPerView: 2 },
          768: { slidesPerView: 3 },
          992: { slidesPerView: 4 },
          1200: { slidesPerView: 5 }
        }
    });
  });
</script>
<?php } ?>


<?php if ( !empty($home_galeri) ) : ?>
<div class="bg-light py-5">
  <div class="text-center py-5 my-3">
    <?php if(!empty($home_judul_galeri)){ ?>
      <h2 class="fw-bold mb-4"><?php echo $home_judul_galeri; ?></h2>
    <?php } ?>

    <!-- Swiper Carousel -->
     
    <div class="velocity-swiper">
      <div class="velocity-swiper-button swiper-button-next"></div>
      <div class="velocity-swiper-button swiper-button-prev"></div>
    <div class="swiper home-galeri-swiper pb-5 mx-5">
      <div class="swiper-wrapper">
        <?php foreach ($home_galeri as $item) : ?>
          <div class="swiper-slide">
            <a href="<?php echo esc_url($item['gambar']); ?>" class="galeri-popup">
              <div class="ratio ratio-1x1">
                <img src="<?php echo esc_url($item['gambar']); ?>" class="img-fluid rounded shadow-sm" />
              </div>
            </a>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- Navigasi -->
      <div class="swiper-pagination"></div>
    </div>
    </div>

  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  // Inisialisasi Swiper
  new Swiper('.home-galeri-swiper', {
    slidesPerView: 5,
    spaceBetween: 20,
    loop: true,
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    breakpoints: {
      0: { slidesPerView: 1 },
      576: { slidesPerView: 2 },
      768: { slidesPerView: 3 },
      992: { slidesPerView: 4 },
      1200: { slidesPerView: 5 }
    }
  });

  // Inisialisasi Magnific Popup
  jQuery('.galeri-popup').magnificPopup({
    type: 'image',
    gallery: {
      enabled: true
    }
  });
});
</script>

<?php endif; ?>



</div><!-- #page-wrapper -->



<?php
get_footer();
