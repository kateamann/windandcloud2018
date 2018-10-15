<?php

/**
 * Footer HTML markup structure
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
 * Unregister footer callbacks.
 *
 * @since 1.0.0
 *
 * @return void
 */
function unregister_footer_callbacks() {
	remove_action('genesis_footer', 'genesis_do_footer');
}


add_action( 'genesis_setup', __NAMESPACE__ . '\register_footer_widget_areas', 15 );
/**
 * Register Footer widget areas
 *
 * @since  1.0.0
 *
 * @return void
 */
function register_footer_widget_areas() {
	$widget_areas = array(
		array(
			'id'          => 'footer-left',
			'name'        => __( 'Footer Left', CHILD_THEME_NAME ),
			'description' => __( 'This is the footer left area', CHILD_THEME_NAME ),
			'before_widget' => '<div class="footerleft widget">',
    		'after_widget' => '</div>',
		),
		array(
			'id'          => 'footer-right',
			'name'        => __( 'Footer Right', CHILD_THEME_NAME ),
			'description' => __( 'This is the footer right area', CHILD_THEME_NAME ),
			'before_widget' => '<div class="footerright widget">',
    		'after_widget' => '</div>',
		),
	);
	foreach ( $widget_areas as $widget_area ) {
		genesis_register_sidebar( $widget_area );
	}
}


add_action('genesis_footer', __NAMESPACE__ . '\add_custom_footer');

//Add the New Footer
function add_custom_footer() {
    genesis_widget_area ('footer-left',array(
        'before' => '<div class="leftfoot one-half first">',
        'after' => '</div>',));
    genesis_widget_area ('footer-right',	array(
        'before' => '<div class="rightfoot one-half">',
        'after' => '</div>',));
}