<?php

/**
 * Setup the child theme
 *
 * @package   WindAndCloud2018
 * @since     1.0.0
 * @author    Kate Amann
 * @link      http://kateamann.com
 * @license   GNU General Public License 2.0+
 *
 */
namespace WindAndCloud2018;

add_action( 'genesis_setup', __NAMESPACE__ . '\setup_child_theme', 15 );

/**
 * Setup child theme
 *
 * @since  1.0.0
 * 
 * @return void
 */
function setup_child_theme() {

    // Set Localization
    load_child_theme_textdomain( CHILD_TEXT_DOMAIN, CHILD_THEME_DIR . '/languages' );

    unregister_genesis_callbacks();
    
    add_theme_supports();
    add_new_image_sizes();  
}

/**
 * Unregister Genesis callbacks - because child theme loads before Genesis.
 *
 * @since 1.0.0
 *
 * @return void
 */
function unregister_genesis_callbacks() {
    unregister_menu_callbacks();
    unregister_header_callbacks();
    unregister_footer_callbacks();
    //add each of the unregister structure callbacks here
}

/**
 * Adds theme supports to the site
 *
 * @since 1.0.0
 *
 * @return void
 */
function add_theme_supports() {
    $config = array(
        'html5' => array( 
            'caption', 
            'comment-form', 
            'comment-list', 
            'gallery', 
            'search-form' 
        ),
        'genesis-accessibility' => array( 
            '404-page', 
            'drop-down-menu', 
            'headings', 
            'rems', 
            'search-form', 
            'skip-links' 
        ),
        'genesis-responsive-viewport' => null,
        'custom-header' => array(
            'width'           => 600,
            'height'          => 160,
            'header-selector' => '.site-title a',
            'header-text'     => false,
            'flex-height'     => true,
        ),
        'custom-background' => null,
        'genesis-after-entry-widget-area' => null,
        'genesis-footer-widgets' => null,
        'genesis-menus'=> array( 
            'primary' => __( 'Main Menu', CHILD_TEXT_DOMAIN ), 
            'secondary' => __( 'Footer Menu', CHILD_TEXT_DOMAIN ) 
        ),
    );
    
    foreach( $config as $feature => $args ) {
       add_theme_support( $feature, $args ); 
    }
    
}


/**
 * Adds new image sizes to the site
 *
 * @since 1.0.0
 *
 * @return void
 */
function add_new_image_sizes() {
    $config = array(
        'featured-image' =>  array(
            'width' => 900, 
            'height' => 600, 
            'crop' => TRUE,
        ),
        'featured-link' =>  array(
            'width' => 450, 
            'height' => 300, 
            'crop' => TRUE,
        ),
        'featured-thumb' =>  array(
            'width' => 150, 
            'height' => 100, 
            'crop' => TRUE,
        ),
    );
    
    foreach( $config as $name => $args ) {
        $crop = array_key_exists( 'crop', $args ) ? $args['crop'] : false;
        add_image_size( $name, $args['width'], $args['height'], $crop );
    }
}


add_filter( 'genesis_theme_settings_defaults', __NAMESPACE__ . '\set_theme_settings_defaults' );

/**
 * Sets theme setting defaults
 *
 * @since 1.0.0
 *
 * @param array $defaults
 *
 * @return array
 */
function set_theme_settings_defaults( array $defaults ) {
    $config = get_theme_settings_defaults();
    $defaults = wp_parse_args( $config, $defaults );
    
    return $defaults;
}


add_action( 'after_switch_theme', __NAMESPACE__ . '\update_theme_settings_defaults' );

/**
 * Updates theme setting defaults
 *
 * @since 1.0.0
 *
 * @return void
 */
function update_theme_settings_defaults() {
    
    $config = get_theme_settings_defaults();

	if ( function_exists( 'genesis_update_settings' ) ) {

		genesis_update_settings( $config );

	}

	update_option( 'posts_per_page', $config['blog_cat_num'] );
    
}

add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_sidebar_content' );


/**
 * Get the theme settings defaults
 *
 * @since 1.0.0
 *
 * @return array
 */
function get_theme_settings_defaults() { 
    return array(
			'blog_cat_num'              => 5,
			'content_archive'           => 'full',
			'content_archive_limit'     => 0,
			'content_archive_thumbnail' => 0,
			'posts_nav'                 => 'numeric',
			'site_layout'               => 'sidebar-content',
		);
}

/**
 * Move Yoast to the Bottom
 */
function yoasttobottom() {
  return 'low';
}
add_filter( 'wpseo_metabox_prio', 'yoasttobottom');