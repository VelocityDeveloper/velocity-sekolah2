<nav id="main-navi" class="navbar shadow navbar-expand-md d-block navbar-light pb-0 px-0 border border-light border-bottom-0 pt-0" aria-labelledby="main-nav-label">

    <h2 id="main-nav-label" class="screen-reader-text">
        <?php esc_html_e('Main Navigation', 'justg'); ?>
    </h2>

    <div class="menu-header position-relative rounded-top py-2 px-3" style="background: var(--bs-primary);">

        <button class="btn btn-sm btn-link text-light text-start d-flex d-md-none w-100" type="button" data-bs-toggle="offcanvas" data-bs-target="#navbarNavOffcanvas" aria-controls="navbarNavOffcanvas" aria-expanded="false" aria-label="<?php esc_attr_e('Toggle navigation', 'justg'); ?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
            </svg>
            <small>Menu</small>
        </button>

        <div class="offcanvas offcanvas-start" tabindex="-1" id="navbarNavOffcanvas">

            <div class="offcanvas-header justify-content-end">
                <button type="button" class="btn-close btn-close-dark text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div><!-- .offcancas-header -->

            <!-- The WordPress Menu goes here -->
            <?php
            wp_nav_menu(
                array(
                    'theme_location'  => 'primary',
                    'container_class' => 'offcanvas-body',
                    'container_id'    => '',
                    'menu_class'      => 'navbar-nav navbar-light justify-content-start flex-md-wrap flex-grow-1',
                    'fallback_cb'     => '',
                    'menu_id'         => 'primary-menu',
                    'depth'           => 4,
                    'walker'          => new justg_WP_Bootstrap_Navwalker(),
                )
            );
            ?>
        </div><!-- .offcanvas -->

    </div>

    <?php $bannerheader = velocitytheme_option('image_bannerheader', ''); ?>
    <div class="part_bannerheader">
        <?php if ($bannerheader) : ?>
            <img class="img-fluid w-100" src="<?php echo $bannerheader; ?>" alt="Banner Header" loading="lazy">
        <?php else : ?>
            <div class="px-3 py-0 bg-primary text-white">
                <div class="row align-items-center text-center text-md-start">
                    <div class="col-md-3 p-2">
                        <?php echo the_custom_logo(); ?>
                    </div>
                    <div class="col-md-9 col-xl-8">
                        <h3 class="text-white">
                            <?php echo get_bloginfo('name'); ?>
                        </h3>
                        <span class="part_taglineheader">
                            <?php echo get_option('blogdescription'); ?>
                        </span>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

</nav><!-- .site-navigation -->