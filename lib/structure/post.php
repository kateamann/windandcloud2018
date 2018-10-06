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



//* Change appearance of posts in archives and blog home

add_action ( 'genesis_before_loop', __NAMESPACE__ . '\archive_listing_layout' );

function archive_listing_layout() {
	if ( ! is_singular( array( 'post', 'page' ) ) ) {
		remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
		remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
		add_action( 'genesis_before_entry', 'genesis_do_post_title' );
		add_action( 'genesis_entry_content', 'genesis_post_info', 8 );
		remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
	}
}