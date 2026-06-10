<?php
/**
 * Sidebar Template
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

if ( ! is_active_sidebar( 'sidebar-main' ) ) {
	return;
}
?>

<aside id="secondary" class="developer-starter-pro-sidebar" role="complementary">
	<?php dynamic_sidebar( 'sidebar-main' ); ?>
</aside>
