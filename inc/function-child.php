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

        $text_theme = 'justg';

        Kirki::add_panel('panel_velocity', [
            'priority'    => 10,
            'title'       => esc_html__('Velocity Theme', $text_theme),
            'description' => esc_html__('', $text_theme),
        ]);
        ///Section Color
        Kirki::add_section('section_colorsekolah', [
            'panel'    => 'panel_velocity',
            'title'    => __('Warna Tema', $text_theme),
            'priority' => 10,
        ]);
        Kirki::add_field('justg_config', [
            'type'        => 'color',
            'settings'    => 'color_theme',
            'label'       => __('Warna Tema', $text_theme),
            'description' => esc_html__('', $text_theme),
            'section'     => 'section_colorsekolah',
            'default'     => '#00601f',
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
                ]
            ],
        ]);
        Kirki::add_field('justg_config', [
            'type'        => 'color',
            'settings'    => 'color_theme2',
            'label'       => __('Warna Tema 2', $text_theme),
            'description' => esc_html__('', $text_theme),
            'section'     => 'section_colorsekolah',
            'default'     => '#ffcc36',
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


        // SECTION: Kontak Header
        Kirki::add_section('section_header_kontak', [
            'title'       => esc_html__('Kontak Header', $text_theme),
            'panel'       => 'panel_velocity',
            'priority'    => 20,
        ]);

        // Field: Nomor Telepon
        Kirki::add_field('justg_config', [
            'type'        => 'text',
            'settings'    => 'kontak_telepon',
            'label'       => esc_html__('Nomor Telepon', $text_theme),
            'section'     => 'section_header_kontak',
            'default'     => '',
            'priority'    => 10,
        ]);

        // Field: Nomor WhatsApp
        Kirki::add_field('justg_config', [
            'type'        => 'text',
            'settings'    => 'kontak_whatsapp',
            'label'       => esc_html__('Nomor WhatsApp', $text_theme),
            'section'     => 'section_header_kontak',
            'default'     => '',
            'priority'    => 20,
        ]);

        // Field: Email
        Kirki::add_field('justg_config', [
            'type'        => 'text',
            'settings'    => 'kontak_email',
            'label'       => esc_html__('Email', $text_theme),
            'section'     => 'section_header_kontak',
            'default'     => '',
            'priority'    => 30,
        ]);



        /**
         * SECTION 1: Banner
         */
        Kirki::add_section('section_home_banner', [
            'panel'    => 'panel_velocity',
            'title'    => esc_html__('Halaman Depan - Banner', $text_theme),
            'priority' => 20,
        ]);

        Kirki::add_field('justg_config', [
            'type'        => 'image',
            'settings'    => 'home_banner',
            'label'       => esc_html__('Gambar Banner', $text_theme),
            'section'     => 'section_home_banner',
            'default'     => '',
        ]);

        /**
         * SECTION 2: Sambutan 
         */
        Kirki::add_section('section_home_sambutan', [
            'panel'    => 'panel_velocity',
            'title'    => esc_html__('Halaman Depan - Sambutan', $text_theme),
            'priority' => 30,
        ]);

        Kirki::add_field('justg_config', [
            'type'     => 'image',
            'settings' => 'home_foto',
            'label'    => esc_html__('Foto', $text_theme),
            'section'  => 'section_home_sambutan',
        ]);

        Kirki::add_field('justg_config', [
            'type'     => 'text',
            'settings' => 'home_judul_sambutan',
            'label'    => esc_html__('Judul Sambutan', $text_theme),
            'section'  => 'section_home_sambutan',
        ]);

        Kirki::add_field('justg_config', [
            'type'     => 'editor',
            'settings' => 'home_isi_sambutan',
            'label'    => esc_html__('Isi Sambutan', $text_theme),
            'section'  => 'section_home_sambutan',
            'default'  => '',
        ]);

        /**
         * SECTION 3: Daftar Guru
         */
        Kirki::add_section('section_home_guru', [
            'panel'    => 'panel_velocity',
            'title'    => esc_html__('Halaman Depan - Daftar Guru', $text_theme),
            'priority' => 40,
        ]);

        Kirki::add_field('justg_config', [
            'type'     => 'text',
            'settings' => 'home_judul_guru',
            'label'    => esc_html__('Judul', $text_theme),
            'section'  => 'section_home_guru',
            'default'  => 'Daftar Guru',
        ]);

        Kirki::add_field('justg_config', [
            'type'     => 'repeater',
            'settings' => 'home_guru',
            'label'    => esc_html__('Daftar Guru', $text_theme),
            'section'  => 'section_home_guru',
			'row_label'   => [
				'type'  => 'text',
				'value' => __('Guru', 'justg'),
			],
            'fields'   => [
                'foto' => [
                    'type'  => 'image',
                    'label' => esc_html__('Foto', $text_theme),
                ],
                'nama' => [
                    'type'  => 'text',
                    'label' => esc_html__('Nama', $text_theme),
                ],
                'jabatan' => [
                    'type'  => 'text',
                    'label' => esc_html__('Jabatan', $text_theme),
                ],
            ],
            'default' => [],
        ]);

        /**
         * SECTION 4: Galeri Foto
         */
        Kirki::add_section('section_home_galeri', [
            'panel'    => 'panel_velocity',
            'title'    => esc_html__('Halaman Depan - Galeri Foto', $text_theme),
            'priority' => 50,
        ]);

        Kirki::add_field('justg_config', [
            'type'     => 'text',
            'settings' => 'home_judul_galeri',
            'label'    => esc_html__('Judul', $text_theme),
            'section'  => 'section_home_galeri',
            'default'  => 'Galeri Foto',
        ]);

        Kirki::add_field('justg_config', [
            'type'     => 'repeater',
            'settings' => 'home_galeri',
            'label'    => esc_html__('Galeri Foto', $text_theme),
            'section'  => 'section_home_galeri',
			'row_label'   => [
				'type'  => 'text',
				'value' => __('Foto', 'justg'),
			],
            'fields'   => [
                'gambar' => [
                    'type'  => 'image',
                    'label' => esc_html__('Gambar Galeri', $text_theme),
                ],
            ],
            'default' => [],
        ]);


        // remove panel in customizer 
        Kirki::remove_panel('global_panel');
        Kirki::remove_panel('panel_footer');
        Kirki::remove_panel('panel_antispam');
        Kirki::remove_control('display_header_text');
        Kirki::remove_section('header_image');
        Kirki::remove_section('header_section');

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
        echo '<header class="bg-white shadow shadow-sm" id="wrapper-header" itemscope itemtype="http://schema.org/WebSite">';
    }
}
if (!function_exists('justg_header_close')) {
    function justg_header_close()
    {
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
				'after_widget'  => '</aside>',
				'before_title'  => '<h6 class="widget-title"><span>',
				'after_title'   => '</span></h6>',
				'show_in_rest'   => false,
			)
		);
		// Register footer widget area
		register_sidebar(
			array(
				'name'          => __( 'Footer Widget Area 1', 'justg' ),
				'id'            => 'footer-widget-1',
				'description'   => __( '', 'justg' ),
				'before_widget' => '<aside id="%1$s" class="mb-4 widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h6 class="widget-title"><span>',
				'after_title'   => '</span></h6>',
			)
		);
		register_sidebar(
			array(
				'name'          => __( 'Footer Widget Area 2', 'justg' ),
				'id'            => 'footer-widget-2',
				'description'   => __( '', 'justg' ),
				'before_widget' => '<aside id="%1$s" class="mb-4 widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h6 class="widget-title"><span>',
				'after_title'   => '</span></h6>',
			)
		);
		register_sidebar(
			array(
				'name'          => __( 'Footer Widget Area 3', 'justg' ),
				'id'            => 'footer-widget-3',
				'description'   => __( '', 'justg' ),
				'before_widget' => '<aside id="%1$s" class="mb-4 widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h6 class="widget-title"><span>',
				'after_title'   => '</span></h6>',
			)
		);
	}
}


if (!function_exists('justg_right_sidebar_check')) {
	function justg_right_sidebar_check()
	{
		if (is_singular('fl-builder-template')) {
			return;
		}
		if (!is_active_sidebar('main-sidebar')) {
			return;
		}
		echo '<div class="right-sidebar widget-area ps-md-2 col-sm-12 col-md-3 order-3" id="right-sidebar" role="complementary">';
		do_action('justg_before_main_sidebar');
		dynamic_sidebar('main-sidebar');
		do_action('justg_after_main_sidebar');
		echo '</div>';
	}
}

function custom_excerpt_length($length) {
    return 40;
}
add_filter('excerpt_length', 'custom_excerpt_length');
