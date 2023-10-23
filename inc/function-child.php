<?php

/**
 * Fuction yang digunakan di theme ini.
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

add_action('after_setup_theme', 'velocitychild_theme_setup', 9);

function velocitychild_theme_setup()
{

    // Load justg_child_enqueue_parent_style after theme setup
    add_action('wp_enqueue_scripts', 'justg_child_enqueue_parent_style', 20);

    if (class_exists('Kirki')) :

        Kirki::add_panel('panel_sekolah', [
            'priority'    => 10,
            'title'       => esc_html__('Sekolah', 'justg'),
            'description' => esc_html__('', 'justg'),
        ]);
        ///Section Color
        Kirki::add_section('section_colorsekolah', [
            'panel'    => 'panel_sekolah',
            'title'    => __('Warna', 'justg'),
            'priority' => 10,
        ]);
        Kirki::add_field('justg_config', [
            'type'        => 'color',
            'settings'    => 'color_theme',
            'label'       => __('Warna Tema', 'kirki'),
            'description' => esc_html__('', 'kirki'),
            'section'     => 'section_colorsekolah',
            'default'     => '#345AAA',
            'transport'   => 'auto',
            'output'      => [
                [
                    'element'   => ':root',
                    'property'  => '--color-theme',
                ],
                [
                    'element'   => ':root',
                    'property'  => '--bs-primary',
                ],
                [
                    'element'   => '.border-color-theme',
                    'property'  => '--bs-border-color',
                ],
                [
                    'element'   => '#primary-menu .dropdown-menu',
                    'property'  => '--bs-dropdown-link-active-bg',
                ]
            ],
        ]);
        Kirki::add_field('justg_config', [
            'type'        => 'color',
            'settings'    => 'color_theme2',
            'label'       => __('Warna Tema 2', 'kirki'),
            'description' => esc_html__('', 'kirki'),
            'section'     => 'section_colorsekolah',
            'default'     => '#46a32d',
            'transport'   => 'auto',
            'output'      => [
                [
                    'element'   => ':root',
                    'property'  => '--color-theme-2',
                ],
                [
                    'element'   => ':root',
                    'property'  => '--bs-secondary',
                ]
            ],
        ]);
        Kirki::add_field('justg_config', [
            'type'        => 'background',
            'settings'    => 'background_themewebsite',
            'label'       => __('Background Website', 'kirki'),
            'description' => esc_html__('', 'kirki'),
            'section'     => 'section_colorsekolah',
            'default'     => [
                'background-color'      => 'rgb(235, 235, 235)',
                'background-image'      => get_stylesheet_directory_uri() . '/images/wall.webp',
                'background-repeat'     => 'repeat',
                'background-position'   => 'center center',
                'background-size'       => 'auto',
                'background-attachment' => 'fixed',
            ],
            'transport'   => 'auto',
            'output'      => [
                [
                    'element'   => ':root[data-bs-theme=light] body',
                ],
                [
                    'element'   => 'body',
                ],
            ],
        ]);

        ///Section Header
        Kirki::add_section('section_headersekolah', [
            'panel'    => 'panel_sekolah',
            'title'    => __('Header', 'justg'),
            'priority' => 10,
        ]);
        Kirki::add_field('justg_config', [
            'type'        => 'image',
            'settings'    => 'image_bannerheader',
            'label'       => esc_html__('Banner Header', 'kirki'),
            'description' => esc_html__('Upload banner 960x240', 'kirki'),
            'section'     => 'section_headersekolah',
            'default'     => '',
            'partial_refresh'    => [
                'partial_bannerheader' => [
                    'selector'        => '.part_bannerheader',
                    'render_callback' => '__return_false'
                ]
            ],
        ]);

    endif;

    //remove action from Parent Theme
    remove_action('justg_header', 'justg_header_menu');
    remove_action('justg_do_footer', 'justg_the_footer_open');
    remove_action('justg_do_footer', 'justg_the_footer_content');
    remove_action('justg_do_footer', 'justg_the_footer_close');
    remove_theme_support('widgets-block-editor');
}

///remove breadcrumbs
add_action('wp_head', function () {
    if (!is_single()) {
        remove_action('justg_before_title', 'justg_breadcrumb');
    }
});

if (!function_exists('justg_header_open')) {
    function justg_header_open()
    {
        echo '<header id="wrapper-header">';
        echo '<div id="wrapper-navbar" class="container px-2 px-md-0" itemscope itemtype="http://schema.org/WebSite">';
    }
}
if (!function_exists('justg_header_close')) {
    function justg_header_close()
    {
        echo '</div>';
        echo '</header>';
    }
}


///add action builder part
add_action('justg_header', 'justg_header_berita');
function justg_header_berita()
{
    require_once(get_stylesheet_directory() . '/inc/part-header.php');
}
add_action('justg_do_footer', 'justg_footer_berita');
function justg_footer_berita()
{
    require_once(get_stylesheet_directory() . '/inc/part-footer.php');
}
add_action('justg_before_wrapper_content', 'justg_before_wrapper_content');
function justg_before_wrapper_content()
{
    echo '<div class="px-2">';
    echo '<div class="card rounded-0 border-light border-top-0 border-bottom-0 shadow px-0 px-md-2 container">';
}
add_action('justg_after_wrapper_content', 'justg_after_wrapper_content');
function justg_after_wrapper_content()
{
    echo '</div>';
    echo '</div>';
}


//register widget
add_action('widgets_init', 'justg_widgets_init', 20);
if (!function_exists('justg_widgets_init')) {
    function justg_widgets_init()
    {
        register_sidebar(
            array(
                'name'          => __('Main Sidebar', 'justg'),
                'id'            => 'main-sidebar',
                'description'   => __('Main sidebar widget area', 'justg'),
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget'  => '</div></aside>',
                'before_title'  => '<h3 class="widget-title"><span>',
                'after_title'   => '</span></h3><div class="p-2">',
                'show_in_rest'   => false,
            )
        );
    }
}

add_action('wp_footer', 'justg_wp_footer');
function justg_wp_footer()
{
    $bgimg = velocitytheme_option('background_themewebsite', '');
?>
    <?php if (empty($bgimg) || $bgimg && empty($bgimg['background-image'])) : ?>
        <style>
            :root[data-bs-theme=light] body {
                background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/images/wall.webp);
                background-color: #FFF8EB;
                background-repeat: repeat;
                background-position: center;
                background-attachment: fixed;
                background-size: auto;
            }
        </style>
    <?php endif; ?>
<?php
}
