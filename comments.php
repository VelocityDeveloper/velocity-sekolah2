<?php
/**
 * The template for displaying comments.
 *
 * @package justg
 */

defined('ABSPATH') || exit;

if (post_password_required()) {
    return;
}
?>

<div class="comments-area block-primary" id="comments">

    <?php if (have_comments()) : ?>

        <h2 class="comments-title">
            <?php
            $comments_number = get_comments_number();
            if (1 === (int) $comments_number) {
                printf(
                    esc_html_x('One thought on &ldquo;%s&rdquo;', 'comments title', 'justg'),
                    '<span>' . get_the_title() . '</span>'
                );
            } else {
                printf(
                    esc_html(
                        _nx(
                            '%1$s thought on &ldquo;%2$s&rdquo;',
                            '%1$s thoughts on &ldquo;%2$s&rdquo;',
                            $comments_number,
                            'comments title',
                            'justg'
                        )
                    ),
                    number_format_i18n($comments_number), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    '<span>' . get_the_title() . '</span>'
                );
            }
            ?>
        </h2>

        <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
            <nav class="comment-navigation" id="comment-nav-above">
                <h1 class="visually-hidden"><?php esc_html_e('Comment navigation', 'justg'); ?></h1>

                <?php if (get_previous_comments_link()) : ?>
                    <div class="nav-previous"><?php previous_comments_link(__('&larr; Older Comments', 'justg')); ?></div>
                <?php endif; ?>

                <?php if (get_next_comments_link()) : ?>
                    <div class="nav-next"><?php next_comments_link(__('Newer Comments &rarr;', 'justg')); ?></div>
                <?php endif; ?>
            </nav>
        <?php endif; ?>

        <ol class="comment-list">
            <?php
            wp_list_comments(
                [
                    'style'      => 'ol',
                    'short_ping' => true,
                ]
            );
            ?>
        </ol>

        <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
            <nav class="comment-navigation" id="comment-nav-below">
                <h1 class="visually-hidden"><?php esc_html_e('Comment navigation', 'justg'); ?></h1>

                <?php if (get_previous_comments_link()) : ?>
                    <div class="nav-previous"><?php previous_comments_link(__('&larr; Older Comments', 'justg')); ?></div>
                <?php endif; ?>

                <?php if (get_next_comments_link()) : ?>
                    <div class="nav-next"><?php next_comments_link(__('Newer Comments &rarr;', 'justg')); ?></div>
                <?php endif; ?>
            </nav>
        <?php endif; ?>

    <?php endif; ?>

    <?php comment_form(); ?>

</div>
