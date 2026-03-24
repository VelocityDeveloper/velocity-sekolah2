<?php

/**
 * Template Name: Home Template
 *
 * @package justg
 */

get_header();

$home_banner = velocitychild_normalize_image_url(velocitytheme_option('home_banner'));
$home_foto = velocitychild_normalize_image_url(velocitytheme_option('home_foto'));
$home_judul_sambutan = velocitytheme_option('home_judul_sambutan');
$home_isi_sambutan = velocitytheme_option('home_isi_sambutan');
$home_judul_guru = velocitytheme_option('home_judul_guru');
$home_guru = velocitychild_parse_guru_items(velocitytheme_option('home_guru'));
$home_judul_galeri = velocitytheme_option('home_judul_galeri');
$home_galeri = velocitychild_parse_gallery_items(velocitytheme_option('home_galeri'));
?>

<div class="wrapper" id="page-wrapper">

    <?php if (!empty(velocitytheme_option('home_banner'))) : ?>
        <div class="overflow-hidden">
            <img class="w-100" src="<?php echo esc_url($home_banner); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>">
        </div>
    <?php endif; ?>

    <div class="container py-5">
        <div class="row text-center py-5 my-3 align-items-center">
            <?php if (!empty(velocitytheme_option('home_foto'))) : ?>
                <div class="col-md-5 me-4 mb-3 mb-md-0">
                    <img src="<?php echo esc_url($home_foto); ?>" alt="<?php echo esc_attr($home_judul_sambutan ?: get_bloginfo('name')); ?>" class="img-fluid rounded shadow-sm">
                </div>
            <?php endif; ?>
            <div class="col-md text-md-start">
                <?php if (!empty($home_judul_sambutan)) : ?>
                    <h2 class="fw-bold mb-md-4 mb-3"><?php echo esc_html($home_judul_sambutan); ?></h2>
                <?php endif; ?>
                <?php if (!empty($home_isi_sambutan)) : ?>
                    <?php echo wp_kses_post(wpautop($home_isi_sambutan)); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php if (!empty($home_guru)) : ?>
        <div class="bg-primary text-white py-5">
            <div class="text-center py-5 my-3">
                <?php if (!empty($home_judul_guru)) : ?>
                    <h2 class="fw-bold text-white mb-4"><?php echo esc_html($home_judul_guru); ?></h2>
                <?php endif; ?>
                <div class="velocity-swiper">
                    <div class="velocity-swiper-button white-swiper-button swiper-button-next home-guru-swiper-next"></div>
                    <div class="velocity-swiper-button white-swiper-button swiper-button-prev home-guru-swiper-prev"></div>
                    <div class="swiper home-galeri-carousel pb-5 mx-5">
                        <div class="swiper-wrapper">
                            <?php foreach ($home_guru as $guru) : ?>
                                <div class="swiper-slide">
                                    <div class="ratio ratio-1x1 mb-2 overflow-hidden rounded-circle bg-white bg-opacity-10 mx-auto" style="max-width: 180px;">
                                        <img class="velocity-thumb-image" src="<?php echo esc_url($guru['foto']); ?>" alt="<?php echo esc_attr($guru['nama']); ?>" loading="lazy">
                                    </div>
                                    <?php if (!empty($guru['nama'])) : ?>
                                        <h3 class="fs-5 mb-2 text-white"><?php echo esc_html($guru['nama']); ?></h3>
                                    <?php endif; ?>
                                    <?php if (!empty($guru['jabatan'])) : ?>
                                        <p class="mb-0"><?php echo esc_html($guru['jabatan']); ?></p>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="swiper-pagination home-guru-swiper-pagination"></div>
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
                    nextEl: '.home-guru-swiper-next',
                    prevEl: '.home-guru-swiper-prev',
                },
                pagination: {
                    el: '.home-guru-swiper-pagination',
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
    <?php endif; ?>

    <?php if (!empty($home_galeri)) : ?>
        <div class="bg-light py-5">
            <div class="text-center py-5 my-3">
                <?php if (!empty($home_judul_galeri)) : ?>
                    <h2 class="fw-bold mb-4"><?php echo esc_html($home_judul_galeri); ?></h2>
                <?php endif; ?>

                <div class="velocity-swiper">
                    <div class="velocity-swiper-button swiper-button-next home-galeri-swiper-next"></div>
                    <div class="velocity-swiper-button swiper-button-prev home-galeri-swiper-prev"></div>
                    <div class="swiper home-galeri-swiper pb-5 mx-5">
                        <div class="swiper-wrapper">
                            <?php foreach ($home_galeri as $item) : ?>
                                <div class="swiper-slide">
                                    <a href="<?php echo esc_url($item['gambar']); ?>" class="galeri-popup d-block">
                                        <div class="ratio ratio-1x1 overflow-hidden rounded shadow-sm bg-white">
                                            <img src="<?php echo esc_url($item['gambar']); ?>" class="velocity-thumb-image" alt="Galeri" loading="lazy">
                                        </div>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="swiper-pagination home-galeri-swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </div>

        <script>
        document.addEventListener('DOMContentLoaded', function () {
            new Swiper('.home-galeri-swiper', {
                slidesPerView: 5,
                spaceBetween: 20,
                loop: true,
                navigation: {
                    nextEl: '.home-galeri-swiper-next',
                    prevEl: '.home-galeri-swiper-prev',
                },
                pagination: {
                    el: '.home-galeri-swiper-pagination',
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

            jQuery('.galeri-popup').magnificPopup({
                type: 'image',
                gallery: {
                    enabled: true
                }
            });
        });
        </script>
    <?php endif; ?>

</div>

<?php
get_footer();
