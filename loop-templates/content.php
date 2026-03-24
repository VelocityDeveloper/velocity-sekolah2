<?php

/**
 * Post rendering content according to caller of get_template_part
 *
 * @package justg
 */

defined('ABSPATH') || exit;
?>

<article <?php post_class('block-primary mb-4'); ?> id="post-<?php the_ID(); ?>">

    <header class="entry-header">
        <?php
        the_title(
            sprintf('<h2 class="content-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())),
            '</a></h2>'
        );
        ?>
    </header>

    <div class="entry-content">
        <div class="row">
            <div class="col-md-4 pe-md-0">
                <?php echo velocitychild_get_post_thumbnail_html(get_the_ID(), 'medium', '4x3'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            </div>
            <div class="col-md-8">
                <?php the_excerpt(); ?>

                <?php if ('post' === get_post_type()) : ?>
                    <div class="entry-meta">
                        <small><?php justg_posted_on(); ?></small>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

</article>
