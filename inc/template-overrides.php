<?php

if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('velocitychild_get_fallback_image_url')) {
    function velocitychild_get_fallback_image_url()
    {
        return get_stylesheet_directory_uri() . '/img/no-image.webp';
    }
}

if (!function_exists('velocitychild_get_bootstrap_icon_svg')) {
    function velocitychild_get_bootstrap_icon_svg($icon)
    {
        $icons = [
            'chevron-left' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true" focusable="false"><path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0"/></svg>',
            'chevron-right' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true" focusable="false"><path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708"/></svg>',
        ];

        return isset($icons[$icon]) ? $icons[$icon] : '';
    }
}

if (!function_exists('velocitychild_normalize_image_url')) {
    function velocitychild_normalize_image_url($url)
    {
        $resolved_url = function_exists('velocitychild_resolve_image_value_to_url')
            ? velocitychild_resolve_image_value_to_url($url, 'full')
            : (is_string($url) ? trim($url) : '');

        return $resolved_url !== '' ? esc_url($resolved_url) : esc_url(velocitychild_get_fallback_image_url());
    }
}

if (!function_exists('velocitychild_get_post_thumbnail_html')) {
    function velocitychild_get_post_thumbnail_html($post_id, $size = 'medium', $ratio = '4x3', $args = [])
    {
        $post_id = absint($post_id);
        if (!$post_id) {
            return '';
        }

        $args = wp_parse_args(
            $args,
            [
                'link'          => true,
                'ratio_class'   => 'ratio ratio-' . sanitize_html_class($ratio),
                'wrapper_class' => 'bg-light overflow-hidden mb-2 mb-md-0',
                'image_class'   => 'velocity-thumb-image',
                'loading'       => 'lazy',
            ]
        );

        if (has_post_thumbnail($post_id)) {
            $image_html = get_the_post_thumbnail(
                $post_id,
                $size,
                [
                    'class'   => trim('w-100 h-100 ' . $args['image_class']),
                    'loading' => $args['loading'],
                ]
            );
        } else {
            $image_html = sprintf(
                '<img src="%1$s" alt="%2$s" class="%3$s" loading="%4$s">',
                esc_url(velocitychild_get_fallback_image_url()),
                esc_attr(get_the_title($post_id)),
                esc_attr(trim('w-100 h-100 ' . $args['image_class'])),
                esc_attr($args['loading'])
            );
        }

        $thumbnail = sprintf(
            '<div class="%1$s %2$s">%3$s</div>',
            esc_attr($args['ratio_class']),
            esc_attr($args['wrapper_class']),
            $image_html
        );

        if (!$args['link']) {
            return $thumbnail;
        }

        return sprintf(
            '<a href="%1$s" class="d-block text-reset">%2$s</a>',
            esc_url(get_permalink($post_id)),
            $thumbnail
        );
    }
}

if (!function_exists('velocitychild_parse_guru_items')) {
    function velocitychild_parse_guru_items($raw_value)
    {
        $items = [];

        if (is_array($raw_value)) {
            foreach ($raw_value as $item) {
                if (!is_array($item)) {
                    continue;
                }

                $nama = sanitize_text_field(isset($item['nama']) ? $item['nama'] : '');
                $jabatan = sanitize_text_field(isset($item['jabatan']) ? $item['jabatan'] : '');
                $foto_raw = isset($item['foto']) ? $item['foto'] : '';
                $foto_url = function_exists('velocitychild_resolve_image_value_to_url')
                    ? velocitychild_resolve_image_value_to_url($foto_raw, 'large')
                    : trim((string) $foto_raw);

                if ($nama === '' && $jabatan === '' && $foto_url === '') {
                    continue;
                }

                $items[] = [
                    'foto'    => $foto_url !== '' ? esc_url($foto_url) : esc_url(velocitychild_get_fallback_image_url()),
                    'nama'    => $nama,
                    'jabatan' => $jabatan,
                ];
            }

            return $items;
        }

        $lines = preg_split('/\r\n|\r|\n/', (string) $raw_value);
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '') {
                continue;
            }

            $parts = array_map('trim', explode('|', $line));
            $parts = array_pad($parts, 3, '');
            $nama = sanitize_text_field($parts[0]);
            $jabatan = sanitize_text_field($parts[1]);
            $foto_raw = trim($parts[2]);

            if ($nama === '' && $jabatan === '' && $foto_raw === '') {
                continue;
            }

            $items[] = [
                'nama'    => $nama,
                'jabatan' => $jabatan,
                'foto'    => $foto_raw !== '' ? esc_url($foto_raw) : esc_url(velocitychild_get_fallback_image_url()),
            ];
        }

        return $items;
    }
}

if (!function_exists('velocitychild_parse_gallery_items')) {
    function velocitychild_parse_gallery_items($raw_value)
    {
        $items = [];

        if (is_array($raw_value)) {
            foreach ($raw_value as $item) {
                if (!is_array($item) || empty($item['gambar'])) {
                    continue;
                }

                $gambar_url = function_exists('velocitychild_resolve_image_value_to_url')
                    ? velocitychild_resolve_image_value_to_url($item['gambar'], 'large')
                    : trim((string) $item['gambar']);

                if ($gambar_url === '') {
                    continue;
                }

                $items[] = [
                    'gambar' => esc_url($gambar_url),
                ];
            }

            return $items;
        }

        $lines = preg_split('/\r\n|\r|\n/', (string) $raw_value);
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '') {
                continue;
            }

            $items[] = [
                'gambar' => esc_url($line),
            ];
        }

        return $items;
    }
}

if (!function_exists('justg_entry_footer')) {
    function justg_entry_footer()
    {
        if ('post' === get_post_type()) {
            $categories_list = get_the_category_list(esc_html__(', ', 'justg'));
            if ($categories_list && justg_categorized_blog()) {
                printf('<span class="cat-links">' . esc_html__('Posted in %s', 'justg') . '</span>', $categories_list); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            }

            $tags_list = get_the_tag_list('', esc_html__(', ', 'justg'));
            if ($tags_list) {
                printf('<span class="tags-links">' . esc_html__('Tagged %s', 'justg') . '</span>', $tags_list); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            }
        }

        if (!is_single() && !post_password_required() && (comments_open() || get_comments_number())) {
            echo '<span class="comments-link">';
            comments_popup_link(esc_html__('Leave a comment', 'justg'), esc_html__('1 Comment', 'justg'), esc_html__('% Comments', 'justg'));
            echo '</span>';
        }

        edit_post_link(
            sprintf(
                esc_html__('Edit %s', 'justg'),
                the_title('<span class="visually-hidden">"', '"</span>', false)
            ),
            '<span class="edit-link">',
            '</span>'
        );
    }
}

if (!function_exists('justg_pagination')) {
    function justg_pagination($args = [], $class = 'pagination')
    {
        if (!isset($args['total']) && $GLOBALS['wp_query']->max_num_pages <= 1) {
            return;
        }

        $args = wp_parse_args(
            $args,
            [
                'mid_size'           => 2,
                'prev_next'          => true,
                'prev_text'          => velocitychild_get_bootstrap_icon_svg('chevron-left'),
                'next_text'          => velocitychild_get_bootstrap_icon_svg('chevron-right'),
                'type'               => 'array',
                'current'            => max(1, get_query_var('paged')),
                'screen_reader_text' => __('Posts navigation', 'justg'),
            ]
        );

        $links = paginate_links($args);
        if (!$links) {
            return;
        }
        ?>
        <nav aria-labelledby="posts-nav-label">
            <h2 id="posts-nav-label" class="visually-hidden"><?php echo esc_html($args['screen_reader_text']); ?></h2>
            <ul class="<?php echo esc_attr($class); ?>">
                <?php foreach ($links as $link) : ?>
                    <li class="page-item <?php echo strpos($link, 'current') ? 'active' : ''; ?>">
                        <?php echo str_replace('page-numbers', 'page-link', $link); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>
        <?php
    }
}

if (!function_exists('justg_post_nav')) {
    function justg_post_nav()
    {
        $previous = is_attachment() ? get_post(get_post()->post_parent) : get_adjacent_post(false, '', true);
        $next     = get_adjacent_post(false, '', false);

        if (!$next && !$previous) {
            return;
        }
        ?>
        <nav class="container navigation post-navigation block-primary">
            <h2 class="visually-hidden"><?php esc_html_e('Post navigation', 'justg'); ?></h2>
            <div class="d-flex nav-links justify-content-between gap-3">
                <?php if (get_previous_post_link()) : ?>
                    <?php previous_post_link('<span class="nav-previous">%link</span>', velocitychild_get_bootstrap_icon_svg('chevron-left') . '<span class="ms-1">%title</span>'); ?>
                <?php endif; ?>
                <?php if (get_next_post_link()) : ?>
                    <?php next_post_link('<span class="nav-next ms-auto">%link</span>', '<span class="me-1">%title</span>' . velocitychild_get_bootstrap_icon_svg('chevron-right')); ?>
                <?php endif; ?>
            </div>
        </nav>
        <?php
    }
}
