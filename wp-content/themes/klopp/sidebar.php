<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package klopp
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}

if ( klopp_load_sidebar() ) : ?>
<div id="secondary" class="widget-area <?php do_action('klopp_secondary-width') ?>" role="complementary">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</div><!-- #secondary -->
<?php endif; ?>
