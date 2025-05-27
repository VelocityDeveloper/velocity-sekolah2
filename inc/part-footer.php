<footer class="site-footer text-center bg-primary text-white pt-2" id="colophon">
    <div class="row footer-widget container text-start mx-auto py-5">
        <?php for ($x = 1; $x <= 3; $x++) { ?>
            <?php if (is_active_sidebar('footer-widget-' . $x)) { ?>
                <div class="col-md">
                    <?php dynamic_sidebar('footer-widget-' . $x); ?>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
    <div class="site-info bg-dark py-3">
        <small>
            Copyright © <?php echo date("Y"); ?> <?php echo get_bloginfo('name'); ?>. All Rights Reserved.
        </small>
        <br>
        <small class="opacity-25" style="font-size: .7rem;">
            Design by <a class="text-light" href="https://velocitydeveloper.com" target="_blank" rel="noopener noreferrer"> Velocity Developer </a>
        </small>
    </div>
    <!-- .site-info -->
</footer>