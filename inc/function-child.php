<?php

/**
 * Fuction yang digunakan di theme ini.
 */
if (!defined('ABSPATH')) {
    exit;
}

add_action('after_setup_theme', 'velocitychild_theme_setup', 20);
add_action('customize_controls_enqueue_scripts', 'velocitychild_customize_control_assets');

function velocitychild_theme_setup()
{
    remove_action('justg_header', 'justg_header_menu');
    remove_action('justg_do_footer', 'justg_the_footer_open');
    remove_action('justg_do_footer', 'justg_the_footer_content');
    remove_action('justg_do_footer', 'justg_the_footer_close');
    remove_theme_support('widgets-block-editor');
}

if (!function_exists('velocitychild_sanitize_image_url')) {
    function velocitychild_sanitize_image_url($value)
    {
        return $value ? esc_url_raw($value) : '';
    }
}

if (!function_exists('velocitychild_sanitize_editor_content')) {
    function velocitychild_sanitize_editor_content($value)
    {
        return wp_kses_post((string) $value);
    }
}

if (!function_exists('velocitychild_customize_control_assets')) {
    function velocitychild_customize_control_assets()
    {
        $theme   = wp_get_theme();
        $version = $theme ? $theme->get('Version') : '1.0.0';

        wp_enqueue_media();

        if (function_exists('wp_enqueue_editor')) {
            wp_enqueue_editor();
        }

        $editor_js_path    = get_stylesheet_directory() . '/js/customizer-editor.js';
        $repeater_css_path = get_stylesheet_directory() . '/css/customizer-repeater.css';
        $repeater_js_path  = get_stylesheet_directory() . '/js/customizer-repeater.js';

        $editor_js_ver    = file_exists($editor_js_path) ? filemtime($editor_js_path) : $version;
        $repeater_css_ver = file_exists($repeater_css_path) ? filemtime($repeater_css_path) : $version;
        $repeater_js_ver  = file_exists($repeater_js_path) ? filemtime($repeater_js_path) : $version;

        wp_enqueue_script(
            'velocitychild-customizer-editor',
            get_stylesheet_directory_uri() . '/js/customizer-editor.js',
            ['jquery', 'customize-controls', 'editor'],
            $editor_js_ver,
            true
        );
        wp_enqueue_style(
            'velocitychild-customizer-repeater',
            get_stylesheet_directory_uri() . '/css/customizer-repeater.css',
            [],
            $repeater_css_ver
        );
        wp_enqueue_script(
            'velocitychild-customizer-repeater',
            get_stylesheet_directory_uri() . '/js/customizer-repeater.js',
            ['jquery', 'customize-controls', 'media-editor', 'media-views', 'editor'],
            $repeater_js_ver,
            true
        );
    }
}

if (!function_exists('velocitychild_decode_repeater_value')) {
    function velocitychild_decode_repeater_value($value)
    {
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $value = $decoded;
            } else {
                $value = [];
            }
        }

        return is_array($value) ? $value : [];
    }
}

if (!function_exists('velocitychild_resolve_image_value_to_url')) {
    function velocitychild_resolve_image_value_to_url($value, $size = 'full')
    {
        if (is_numeric($value)) {
            $image_id = absint($value);
            if ($image_id > 0) {
                $image_url = wp_get_attachment_image_url($image_id, $size);
                if ($image_url) {
                    return $image_url;
                }
            }
        }

        $image_url = esc_url_raw((string) $value);
        return $image_url ?: '';
    }
}

if (!function_exists('velocitychild_get_home_guru_repeater_fields')) {
    function velocitychild_get_home_guru_repeater_fields()
    {
        return [
            'foto' => [
                'type'        => 'image',
                'label'       => __('Foto', 'justg'),
                'description' => __('Pilih foto guru.', 'justg'),
                'default'     => '',
            ],
            'nama' => [
                'type'    => 'text',
                'label'   => __('Nama', 'justg'),
                'default' => '',
            ],
            'jabatan' => [
                'type'    => 'text',
                'label'   => __('Jabatan', 'justg'),
                'default' => '',
            ],
        ];
    }
}

if (!function_exists('velocitychild_get_legacy_home_guru_items')) {
    function velocitychild_get_legacy_home_guru_items()
    {
        $value = velocitytheme_option('home_guru', []);

        if (is_string($value)) {
            $items = [];
            $lines = preg_split('/\r\n|\r|\n/', $value);
            foreach ($lines as $line) {
                $line = trim($line);
                if ($line === '') {
                    continue;
                }

                $parts = array_map('trim', explode('|', $line));
                $parts = array_pad($parts, 3, '');
                $items[] = [
                    'nama'    => $parts[0],
                    'jabatan' => $parts[1],
                    'foto'    => $parts[2],
                ];
            }

            $value = $items;
        }

        return velocitychild_sanitize_home_guru_repeater($value);
    }
}

if (!function_exists('velocitychild_sanitize_home_guru_repeater')) {
    function velocitychild_sanitize_home_guru_repeater($value)
    {
        $items = velocitychild_decode_repeater_value($value);
        $clean = [];

        foreach ($items as $item) {
            if (!is_array($item)) {
                continue;
            }

            $foto_raw = isset($item['foto']) ? $item['foto'] : '';
            $foto     = '';
            if (is_numeric($foto_raw) && absint($foto_raw) > 0) {
                $foto = absint($foto_raw);
            } elseif (!empty($foto_raw)) {
                $foto = esc_url_raw((string) $foto_raw);
            }

            $nama    = isset($item['nama']) ? sanitize_text_field((string) $item['nama']) : '';
            $jabatan = isset($item['jabatan']) ? sanitize_text_field((string) $item['jabatan']) : '';

            if (empty($foto) && $nama === '' && $jabatan === '') {
                continue;
            }

            $clean[] = [
                'foto'    => $foto,
                'nama'    => $nama,
                'jabatan' => $jabatan,
            ];
        }

        return $clean;
    }
}

if (!function_exists('velocitychild_get_home_galeri_repeater_fields')) {
    function velocitychild_get_home_galeri_repeater_fields()
    {
        return [
            'gambar' => [
                'type'        => 'image',
                'label'       => __('Gambar Galeri', 'justg'),
                'description' => __('Pilih gambar galeri.', 'justg'),
                'default'     => '',
            ],
        ];
    }
}

if (!function_exists('velocitychild_get_legacy_home_galeri_items')) {
    function velocitychild_get_legacy_home_galeri_items()
    {
        $value = velocitytheme_option('home_galeri', []);

        if (is_string($value)) {
            $items = [];
            $lines = preg_split('/\r\n|\r|\n/', $value);
            foreach ($lines as $line) {
                $line = trim($line);
                if ($line === '') {
                    continue;
                }

                $items[] = [
                    'gambar' => $line,
                ];
            }

            $value = $items;
        }

        return velocitychild_sanitize_home_galeri_repeater($value);
    }
}

if (!function_exists('velocitychild_sanitize_home_galeri_repeater')) {
    function velocitychild_sanitize_home_galeri_repeater($value)
    {
        $items = velocitychild_decode_repeater_value($value);
        $clean = [];

        foreach ($items as $item) {
            if (!is_array($item)) {
                continue;
            }

            $gambar_raw = isset($item['gambar']) ? $item['gambar'] : '';
            $gambar     = '';
            if (is_numeric($gambar_raw) && absint($gambar_raw) > 0) {
                $gambar = absint($gambar_raw);
            } elseif (!empty($gambar_raw)) {
                $gambar = esc_url_raw((string) $gambar_raw);
            }

            if (empty($gambar)) {
                continue;
            }

            $clean[] = [
                'gambar' => $gambar,
            ];
        }

        return $clean;
    }
}

if (class_exists('WP_Customize_Control') && !class_exists('VelocityChild_Customize_Editor_Control')) {
    class VelocityChild_Customize_Editor_Control extends WP_Customize_Control
    {
        public $type = 'velocitychild_editor';

        public function render_content()
        {
            $editor_id = sanitize_html_class('velocitychild_editor_' . $this->id);
            ?>
            <label>
                <?php if (!empty($this->label)) : ?>
                    <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                <?php endif; ?>
                <?php if (!empty($this->description)) : ?>
                    <span class="description customize-control-description"><?php echo esc_html($this->description); ?></span>
                <?php endif; ?>
                <textarea id="<?php echo esc_attr($editor_id); ?>" class="widefat velocitychild-editor-field" rows="8" <?php $this->link(); ?>><?php echo esc_textarea($this->value()); ?></textarea>
            </label>
            <?php
        }
    }
}

if (!class_exists('Velocitychild_Repeater_Control') && class_exists('WP_Customize_Control')) {
    class Velocitychild_Repeater_Control extends WP_Customize_Control
    {
        public $type = 'velocity_repeater';
        public $fields = [];
        public $item_label = '';
        public $add_button_label = '';

        public function __construct($manager, $id, $args = [], $options = [])
        {
            if (isset($args['fields'])) {
                $this->fields = (array) $args['fields'];
                unset($args['fields']);
            }
            if (isset($args['item_label'])) {
                $this->item_label = (string) $args['item_label'];
                unset($args['item_label']);
            }
            if (isset($args['add_button_label'])) {
                $this->add_button_label = (string) $args['add_button_label'];
                unset($args['add_button_label']);
            }

            parent::__construct($manager, $id, $args);
        }

        protected function render_content()
        {
            if (empty($this->fields)) {
                return;
            }

            $value = velocitychild_decode_repeater_value($this->value());
            $encoded_value = wp_json_encode($value);
            if (empty($encoded_value)) {
                $encoded_value = '[]';
            }
            ?>
            <div class="velocity-repeater-control">
                <?php if (!empty($this->label)) : ?>
                    <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                <?php endif; ?>
                <?php if (!empty($this->description)) : ?>
                    <p class="description"><?php echo wp_kses_post($this->description); ?></p>
                <?php endif; ?>
                <div class="velocity-repeater" data-fields="<?php echo esc_attr(wp_json_encode($this->fields)); ?>" data-default-label="<?php echo esc_attr($this->item_label ? $this->item_label : __('Item', 'justg')); ?>">
                    <input type="hidden" class="velocity-repeater-store" <?php $this->link(); ?> value="<?php echo esc_attr($encoded_value); ?>">
                    <div class="velocity-repeater-items">
                        <?php if (!empty($value)) { foreach ($value as $item) { echo $this->get_single_item_markup($item); } } ?>
                    </div>
                    <button type="button" class="button button-primary velocity-repeater-add"><?php echo esc_html($this->add_button_label ? $this->add_button_label : __('Tambah Item', 'justg')); ?></button>
                    <script type="text/html" class="velocity-repeater-template"><?php echo $this->get_single_item_markup([]); ?></script>
                </div>
            </div>
            <?php
        }

        private function get_single_item_markup($item_values = [])
        {
            ob_start();
            $summary = $this->item_label ? $this->item_label : __('Item', 'justg');
            ?>
            <div class="velocity-repeater-item">
                <button type="button" class="velocity-repeater-toggle" aria-expanded="true">
                    <span class="velocity-repeater-item-label"><?php echo esc_html($summary); ?></span>
                    <span class="velocity-repeater-toggle-icon" aria-hidden="true"></span>
                </button>
                <div class="velocity-repeater-item-body">
                    <?php foreach ($this->fields as $field_key => $field) :
                        $field_type    = isset($field['type']) ? $field['type'] : 'text';
                        $field_label   = isset($field['label']) ? $field['label'] : '';
                        $field_default = isset($field['default']) ? $field['default'] : '';
                        $field_desc    = isset($field['description']) ? $field['description'] : '';
                        $field_value   = isset($item_values[$field_key]) ? $item_values[$field_key] : $field_default;

                        if ('image' === $field_type) :
                            $image_value = (string) $field_value;
                            $image_id    = absint($field_value);
                            $image_url   = '';
                            if ($image_id > 0) {
                                $image_url = wp_get_attachment_image_url($image_id, 'medium_large');
                            } elseif (filter_var($image_value, FILTER_VALIDATE_URL)) {
                                $image_url = $image_value;
                            }
                            ?>
                            <div class="velocity-repeater-field">
                                <span class="velocity-repeater-field-label"><?php echo esc_html($field_label); ?></span>
                                <div class="velocity-repeater-image-field">
                                    <input type="hidden" data-field="<?php echo esc_attr($field_key); ?>" data-default="<?php echo esc_attr($field_default); ?>" value="<?php echo esc_attr($image_value); ?>">
                                    <div class="velocity-repeater-image-preview<?php echo $image_url ? ' has-image' : ''; ?>"><?php if ($image_url) : ?><img src="<?php echo esc_url($image_url); ?>" alt=""><?php endif; ?></div>
                                    <div class="velocity-repeater-image-actions"><button type="button" class="button velocity-repeater-media-select"><?php esc_html_e('Pilih Gambar', 'justg'); ?></button><button type="button" class="button-link button-link-delete velocity-repeater-media-remove"><?php esc_html_e('Hapus', 'justg'); ?></button></div>
                                </div>
                                <?php if (!empty($field_desc)) : ?><span class="description customize-control-description"><?php echo wp_kses_post($field_desc); ?></span><?php endif; ?>
                            </div>
                        <?php elseif ('editor' === $field_type) : ?>
                            <label class="velocity-repeater-field"><span class="velocity-repeater-field-label"><?php echo esc_html($field_label); ?></span><textarea class="velocity-repeater-editor" rows="6" data-field="<?php echo esc_attr($field_key); ?>" data-default="<?php echo esc_attr($field_default); ?>"><?php echo esc_textarea((string) $field_value); ?></textarea><?php if (!empty($field_desc)) : ?><span class="description customize-control-description"><?php echo wp_kses_post($field_desc); ?></span><?php endif; ?></label>
                        <?php elseif ('textarea' === $field_type) : ?>
                            <label class="velocity-repeater-field"><span class="velocity-repeater-field-label"><?php echo esc_html($field_label); ?></span><textarea data-field="<?php echo esc_attr($field_key); ?>" data-default="<?php echo esc_attr($field_default); ?>"><?php echo esc_textarea((string) $field_value); ?></textarea><?php if (!empty($field_desc)) : ?><span class="description customize-control-description"><?php echo wp_kses_post($field_desc); ?></span><?php endif; ?></label>
                        <?php else : ?>
                            <label class="velocity-repeater-field"><span class="velocity-repeater-field-label"><?php echo esc_html($field_label); ?></span><input type="<?php echo esc_attr($field_type); ?>" data-field="<?php echo esc_attr($field_key); ?>" data-default="<?php echo esc_attr($field_default); ?>" value="<?php echo esc_attr((string) $field_value); ?>"><?php if (!empty($field_desc)) : ?><span class="description customize-control-description"><?php echo wp_kses_post($field_desc); ?></span><?php endif; ?></label>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <div class="velocity-repeater-actions"><button type="button" class="button velocity-repeater-clone"><?php esc_html_e('Clone', 'justg'); ?></button><button type="button" class="button button-secondary velocity-repeater-remove"><?php esc_html_e('Hapus', 'justg'); ?></button></div>
                </div>
            </div>
            <?php
            return ob_get_clean();
        }
    }
}

add_action('customize_register', 'velocitychild_customize_register', 30);

function velocitychild_customize_register(WP_Customize_Manager $wp_customize)
{
    $text_theme = 'justg';

    $wp_customize->add_panel(
        'velocity_child_panel',
        [
            'priority'    => 30,
            'title'       => esc_html__('Velocity Theme', $text_theme),
            'description' => '',
        ]
    );

    $wp_customize->add_section(
        'section_header_kontak',
        [
            'title'    => esc_html__('Kontak Header', $text_theme),
            'panel'    => 'velocity_child_panel',
            'priority' => 20,
        ]
    );

    $wp_customize->add_setting(
        'kontak_telepon',
        [
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ]
    );
    $wp_customize->add_control(
        'kontak_telepon',
        [
            'label'   => esc_html__('Nomor Telepon', $text_theme),
            'section' => 'section_header_kontak',
            'type'    => 'text',
        ]
    );

    $wp_customize->add_setting(
        'kontak_whatsapp',
        [
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ]
    );
    $wp_customize->add_control(
        'kontak_whatsapp',
        [
            'label'   => esc_html__('Nomor WhatsApp', $text_theme),
            'section' => 'section_header_kontak',
            'type'    => 'text',
        ]
    );

    $wp_customize->add_setting(
        'kontak_email',
        [
            'default'           => '',
            'sanitize_callback' => 'sanitize_email',
        ]
    );
    $wp_customize->add_control(
        'kontak_email',
        [
            'label'   => esc_html__('Email', $text_theme),
            'section' => 'section_header_kontak',
            'type'    => 'email',
        ]
    );

    $wp_customize->add_section(
        'section_home_banner',
        [
            'panel'    => 'velocity_child_panel',
            'title'    => esc_html__('Halaman Depan - Gambar Utama', $text_theme),
            'priority' => 30,
        ]
    );

    $wp_customize->add_setting(
        'home_banner',
        [
            'default'           => '',
            'sanitize_callback' => 'velocitychild_sanitize_image_url',
        ]
    );
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'home_banner',
            [
                'label'   => esc_html__('Gambar Utama', $text_theme),
                'section' => 'section_home_banner',
            ]
        )
    );

    $wp_customize->add_section(
        'section_home_sambutan',
        [
            'panel'    => 'velocity_child_panel',
            'title'    => esc_html__('Halaman Depan - Sambutan', $text_theme),
            'priority' => 40,
        ]
    );

    $wp_customize->add_setting(
        'home_foto',
        [
            'default'           => '',
            'sanitize_callback' => 'velocitychild_sanitize_image_url',
        ]
    );
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'home_foto',
            [
                'label'   => esc_html__('Foto', $text_theme),
                'section' => 'section_home_sambutan',
            ]
        )
    );

    $wp_customize->add_setting(
        'home_judul_sambutan',
        [
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ]
    );
    $wp_customize->add_control(
        'home_judul_sambutan',
        [
            'label'   => esc_html__('Judul Sambutan', $text_theme),
            'section' => 'section_home_sambutan',
            'type'    => 'text',
        ]
    );

    $wp_customize->add_setting(
        'home_isi_sambutan',
        [
            'default'           => '',
            'sanitize_callback' => 'velocitychild_sanitize_editor_content',
        ]
    );
    $wp_customize->add_control(
        new VelocityChild_Customize_Editor_Control(
            $wp_customize,
            'home_isi_sambutan',
            [
                'label'       => esc_html__('Isi Sambutan', $text_theme),
                'section'     => 'section_home_sambutan',
            ]
        )
    );

    $wp_customize->add_section(
        'section_home_guru',
        [
            'panel'    => 'velocity_child_panel',
            'title'    => esc_html__('Halaman Depan - Daftar Guru', $text_theme),
            'priority' => 50,
        ]
    );

    $wp_customize->add_setting(
        'home_judul_guru',
        [
            'default'           => 'Daftar Guru',
            'sanitize_callback' => 'sanitize_text_field',
        ]
    );
    $wp_customize->add_control(
        'home_judul_guru',
        [
            'label'   => esc_html__('Judul', $text_theme),
            'section' => 'section_home_guru',
            'type'    => 'text',
        ]
    );

    $wp_customize->add_setting(
        'home_guru',
        [
            'default'           => velocitychild_get_legacy_home_guru_items(),
            'sanitize_callback' => 'velocitychild_sanitize_home_guru_repeater',
        ]
    );
    $wp_customize->add_control(
        new Velocitychild_Repeater_Control(
            $wp_customize,
            'home_guru',
            [
                'label'            => esc_html__('Daftar Guru', $text_theme),
                'section'          => 'section_home_guru',
                'fields'           => velocitychild_get_home_guru_repeater_fields(),
                'item_label'       => esc_html__('Guru', $text_theme),
                'add_button_label' => esc_html__('Tambah Guru', $text_theme),
            ]
        )
    );

    $wp_customize->add_section(
        'section_home_galeri',
        [
            'panel'    => 'velocity_child_panel',
            'title'    => esc_html__('Halaman Depan - Galeri Foto', $text_theme),
            'priority' => 60,
        ]
    );

    $wp_customize->add_setting(
        'home_judul_galeri',
        [
            'default'           => 'Galeri Foto',
            'sanitize_callback' => 'sanitize_text_field',
        ]
    );
    $wp_customize->add_control(
        'home_judul_galeri',
        [
            'label'   => esc_html__('Judul', $text_theme),
            'section' => 'section_home_galeri',
            'type'    => 'text',
        ]
    );

    $wp_customize->add_setting(
        'home_galeri',
        [
            'default'           => velocitychild_get_legacy_home_galeri_items(),
            'sanitize_callback' => 'velocitychild_sanitize_home_galeri_repeater',
        ]
    );
    $wp_customize->add_control(
        new Velocitychild_Repeater_Control(
            $wp_customize,
            'home_galeri',
            [
                'label'            => esc_html__('Galeri Foto', $text_theme),
                'section'          => 'section_home_galeri',
                'fields'           => velocitychild_get_home_galeri_repeater_fields(),
                'item_label'       => esc_html__('Foto', $text_theme),
                'add_button_label' => esc_html__('Tambah Foto', $text_theme),
            ]
        )
    );

    $wp_customize->remove_section('header_image');
}

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

add_action('justg_header', 'justg_header_berita');
function justg_header_berita()
{
    require_once get_stylesheet_directory() . '/inc/part-header.php';
}

add_action('justg_do_footer', 'justg_footer_berita');
function justg_footer_berita()
{
    require_once get_stylesheet_directory() . '/inc/part-footer.php';
}

add_action('widgets_init', 'justg_widgets_init', 20);
if (!function_exists('justg_widgets_init')) {
    function justg_widgets_init()
    {
        register_sidebar(
            [
                'name'         => __('Main Sidebar', 'justg'),
                'id'           => 'main-sidebar',
                'description'  => __('Main sidebar widget area', 'justg'),
                'before_widget'=> '<aside id="%1$s" class="widget %2$s">',
                'after_widget' => '</aside>',
                'before_title' => '<h6 class="widget-title"><span>',
                'after_title'  => '</span></h6>',
                'show_in_rest' => false,
            ]
        );

        register_sidebar(
            [
                'name'         => __('Footer Widget Area 1', 'justg'),
                'id'           => 'footer-widget-1',
                'description'  => __('', 'justg'),
                'before_widget'=> '<aside id="%1$s" class="mb-4 widget %2$s">',
                'after_widget' => '</aside>',
                'before_title' => '<h6 class="widget-title"><span>',
                'after_title'  => '</span></h6>',
            ]
        );

        register_sidebar(
            [
                'name'         => __('Footer Widget Area 2', 'justg'),
                'id'           => 'footer-widget-2',
                'description'  => __('', 'justg'),
                'before_widget'=> '<aside id="%1$s" class="mb-4 widget %2$s">',
                'after_widget' => '</aside>',
                'before_title' => '<h6 class="widget-title"><span>',
                'after_title'  => '</span></h6>',
            ]
        );

        register_sidebar(
            [
                'name'         => __('Footer Widget Area 3', 'justg'),
                'id'           => 'footer-widget-3',
                'description'  => __('', 'justg'),
                'before_widget'=> '<aside id="%1$s" class="mb-4 widget %2$s">',
                'after_widget' => '</aside>',
                'before_title' => '<h6 class="widget-title"><span>',
                'after_title'  => '</span></h6>',
            ]
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

function custom_excerpt_length($length)
{
    return 40;
}
add_filter('excerpt_length', 'custom_excerpt_length');
