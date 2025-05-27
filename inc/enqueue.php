<?php

/**
 * Enqueue child theme styles and scripts.
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Load the parent style.css file
 *
 * @link http://codex.wordpress.org/Child_Themes
 */
if (!function_exists('justg_child_enqueue_parent_style')) {
    function justg_child_enqueue_parent_style()
    {
        $theme = wp_get_theme();
        $parenthandle = 'parent-style';

        // Jika plugin tidak me-load CSS
        if (
            !wp_style_is('magnific-popup-styles', 'enqueued') &&
            !wp_style_is('magnific-popup-styles', 'registered')
        ) {
            wp_enqueue_style(
                'velocity-sekolah2-magnific-popup-styles',
                'https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.0.0/magnific-popup.min.css',
                [],
                '1.0.0'
            );
        }

        // Jika plugin tidak me-load JS
        if (
            !wp_script_is('magnific-popup-script', 'enqueued') &&
            !wp_script_is('magnific-popup-script', 'registered')
        ) {
            wp_enqueue_script(
                'velocity-sekolah2-magnific-popup-script',
                'https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.0.0/jquery.magnific-popup.min.js',
                ['jquery'],
                '1.0.0',
                true
            );
        }

        // Tambahkan Swiper hanya di page-home.php
        if (is_page_template('page-home.php')) {
            wp_enqueue_style('velocity-swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css');
            wp_enqueue_script('velocity-swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', [], null, true);
        }

        wp_enqueue_style('velocity-google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap', false);
        wp_enqueue_style($parenthandle, get_template_directory_uri() . '/style.css', [], $theme->parent()->get('Version'));
        wp_enqueue_style('custom-style', get_stylesheet_directory_uri() . '/css/custom.css', [], $theme->parent()->get('Version'));
        wp_enqueue_style('child-style', get_stylesheet_uri(), [$parenthandle], $theme->get('Version'));

        wp_enqueue_script(
            'justg-custom-scripts',
            get_stylesheet_directory_uri() . '/js/custom.js',
            [],
            $theme->parent()->get('Version') . '.' . filemtime(get_stylesheet_directory() . '/js/custom.js'),
            true
        );
    }

    add_action('wp_enqueue_scripts', 'justg_child_enqueue_parent_style',99);
}
