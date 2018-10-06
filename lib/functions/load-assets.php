<?php

/**
 * Asset loader handler
 *
 * @package   WindAndCloud2018
 * @since     1.0.0
 * @author    Kate Amann
 * @link      http://kateamann.com
 * @license   GNU General Public License 2.0+
 *
 */
namespace WindAndCloud2018;

add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\enqueue_assets' );

/**
 * Enqueue Scripts and Styles.
 *
 * @since 1.0.0
 *
 * @return void
 */
function enqueue_assets() {

	wp_enqueue_style( CHILD_TEXT_DOMAIN . '-fonts', '//fonts.googleapis.com/css?family=Open+Sans:400,600,700', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'dashicons' );

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
    
	wp_enqueue_script( CHILD_TEXT_DOMAIN . '-responsive-menu', CHILD_URL . "/assets/js/responsive-menus{$suffix}.js", array( 'jquery' ), CHILD_THEME_VERSION, true );
    
    wp_localize_script(
		CHILD_TEXT_DOMAIN . '-responsive-menu',
		'genesis_responsive_menu',
		responsive_menu_settings()
	);
    
}

// Define our responsive menu settings.
function responsive_menu_settings() {

	$settings = array(
        'mainMenu'          => __( 'Menu', CHILD_TEXT_DOMAIN ),
		'menuIconClass'     => 'dashicons-before dashicons-menu',
		'subMenu'           => __( 'Submenu', CHILD_TEXT_DOMAIN ),
		'subMenuIconsClass' => 'dashicons-before dashicons-arrow-down-alt2',
		'menuClasses'       => array(
			'combine' => array(
				'.nav-primary',
				'.nav-header',
			),
			'others'  => array(),
        ),
    );

	return $settings;

}