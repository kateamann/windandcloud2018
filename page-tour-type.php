<?php

/**
 * Tour list by type page HTML markup structure
 * Template Name: Tour Type
 * 
 * @package   WindAndCloud2018
 * @since     1.0.0
 * @author    Kate Amann
 * @link      http://kateamann.com
 * @license   GNU General Public License 2.0+
 *
 */
namespace WindAndCloud2018;

add_action( 'genesis_entry_content', __NAMESPACE__ . '\display_tours_by_type', 10 );
function display_tours_by_type() {

	if ( get_field('tour_tag') ){
		$tour_tag = get_field('tour_tag');
	}

	$page_parent = wp_get_post_parent_id( $post_ID );

	if ( $page_parent == 342 ) {
		$tour_cat = 119;
	}
	if ( $page_parent == 23 ) {
		$tour_cat = 122;
	}
	
	$args = array(
		'post_type' => 'reisen',
		'cat'		=> $tour_cat,
		'tag_id'	=> $tour_tag,
		'orderby'	=> 'menu_order',
		'order'     => 'ASC',
		'posts_per_page' => -1,
	);

	$the_query = new \WP_Query( $args );?>

    <div class="tours-by-type">

	    <?php 

	    while ( $the_query->have_posts() ) : $the_query->the_post();
	    
			get_template_part('lib/views/large-tour-card'); 

		endwhile;

		wp_reset_postdata(); ?>

    </div> <?php
}

genesis();