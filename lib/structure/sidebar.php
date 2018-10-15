<?php

/**
 * Sidebar/widgetised area HTML markup structure
 *
 * @package   WindAndCloud2018
 * @since     1.0.0
 * @author    Kate Amann
 * @link      http://kateamann.com
 * @license   GNU General Public License 2.0+
 *
 */
namespace WindAndCloud2018;

add_action( 'genesis_before_content', 'genesis_seo_site_title', 1 );


add_action( 'genesis_setup', __NAMESPACE__ . '\register_sidebar_widget_areas', 15 );
function register_sidebar_widget_areas() {
	$widget_areas = array(
		array(
			'id'          => 'blog-sidebar',
			'name'        => __( 'Blog Sidebar', CHILD_THEME_NAME ),
			'description' => __( 'Blog Sidebar', CHILD_THEME_NAME ),
			'before_widget' => '<section class="widget">',
    		'after_widget' => '</section>',
		),
	);
	foreach ( $widget_areas as $widget_area ) {
		genesis_register_sidebar( $widget_area );
	}
}


add_action( 'get_header', __NAMESPACE__ . '\blog_sidebar' );
function blog_sidebar() {
	if ( is_home() || is_archive() || is_singular( 'post' ) ) {
        remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );

        add_action( 'genesis_sidebar', function() {
			genesis_widget_area ('blog-sidebar');
		} );
    }
}