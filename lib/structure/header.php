<?php

/**
 * Header HTML markup structure
 *
 * @package   WindAndCloud2018
 * @since     1.0.0
 * @author    Kate Amann
 * @link      http://kateamann.com
 * @license   GNU General Public License 2.0+
 *
 */
namespace WindAndCloud2018;

/**
 * Unregister header callbacks.
 *
 * @since 1.0.0
 *
 * @return void
 */
function unregister_header_callbacks() {
	remove_action( 'genesis_site_title', 'genesis_seo_site_title' );
	remove_action( 'genesis_site_description', 'genesis_seo_site_description' );
}

add_action( 'genesis_before_content', __NAMESPACE__ . '\logo_and_nav_in_sidebar', 1 );


function logo_and_nav_in_sidebar() {
	?>
	<div class="logo-nav">
		<?php genesis_seo_site_title(); ?>
		<?php genesis_do_nav(); ?>
	</div>
	<?php
}