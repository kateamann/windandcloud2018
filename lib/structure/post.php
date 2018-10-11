<?php

/**
 * Post HTML markup structure
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
 * Unregister post callbacks.
 *
 * @since 1.0.0
 *
 * @return void
 */
function unregister_post_callbacks() {

}            

add_filter( 'genesis_author_box_gravatar_size', __NAMESPACE__ . '\setup_author_box_gravatar_size' );

/**
* Modify size of the Gravatar in the author box.
*
* @since 1.0.0
*
* @param  $size
* 
* @return int
*/
function setup_author_box_gravatar_size( $size ) {
	return 90;
}



//* Customize the entry meta in the entry header
add_filter( 'genesis_post_info', __NAMESPACE__ . '\post_info_filter' );
function post_info_filter($post_info) {
	$post_info = '[post_date]';
	return $post_info;
}


add_action( 'genesis_before_entry_content', __NAMESPACE__ . '\display_featured_image' );
function display_featured_image() {
	if ( ! is_singular( array( 'post', 'page' ) ) ) {
		return;
	}
	if ( ! has_post_thumbnail() ) {
		return;
	}
	// Display featured image above content
	echo '<div class="singular-featured-image">';
		genesis_image( array( 'size' => 'featured-image' ) );
	echo '</div>';
}



//* Add featured post widget area to blog home
//add_action( 'genesis_setup', __NAMESPACE__ . '\register_home_widget_areas', 15 );
function register_home_widget_areas() {
	$widget_areas = array(
		array(
			'id'          => 'blog-featured',
			'name'        => __( 'Blog Featured Post', CHILD_THEME_NAME ),
			'description' => __( 'Blog Featured Post', CHILD_THEME_NAME ),
			'before_widget' => '<div class="blog-featured">',
    		'after_widget' => '</div>',
		),
	);
	foreach ( $widget_areas as $widget_area ) {
		genesis_register_sidebar( $widget_area );
	}
}

//add_action( 'get_header', __NAMESPACE__ . '\blog_featured_post' );
function blog_featured_post() {
	if ( is_home() ) {
		add_action( 'genesis_before_while', function() {
			genesis_widget_area ('blog-featured',array(
		        'before' => '<div class="widget">',
		        'after' => '</div>',));
		} );
	}
}



//* Change appearance of posts in archives and blog home
add_action ( 'genesis_before_loop', __NAMESPACE__ . '\archive_listing_layout' );
function archive_listing_layout() {
	if ( is_home() || is_archive() || is_search() ) {
		remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
		remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
		remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
		remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );
		remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
		remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
		add_action( 'genesis_before_entry', 'genesis_do_post_title' );
		add_action( 'genesis_before_entry_content', 'genesis_do_post_image', 1 );
		if ( ! is_post_type_archive( 'team-bios' ) ) {
			add_action( 'genesis_entry_content', 'genesis_post_info', 8 );
		}
	}
}


//* Modify the Genesis content limit read more link
add_filter( 'get_the_content_more_link', __NAMESPACE__ . '\change_read_more_link' );
function change_read_more_link() {
	return '... ';
}

add_action( 'genesis_entry_content', __NAMESPACE__ . '\read_more_button', 12 );
function read_more_button() {
    // if this is a singular page, abort.
    if ( is_singular() ) {
        return;
    }

    printf( '<a href="%s" class="more-link button">%s</a>', get_permalink(), esc_html__( 'Read more' ) );
}