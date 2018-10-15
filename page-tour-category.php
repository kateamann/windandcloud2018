<?php

/**
 * Tour Category page HTML markup structure
 * Template Name: Tour Category
 * 
 * @package   WindAndCloud2018
 * @since     1.0.0
 * @author    Kate Amann
 * @link      http://kateamann.com
 * @license   GNU General Public License 2.0+
 *
 */
namespace WindAndCloud2018;


add_action( 'genesis_entry_content', __NAMESPACE__ . '\display_tour_types', 10 );
function display_tour_types() {

	$postid = get_the_ID();

	if ( $postid == 342 ) {
		$tour_cat = 342;
	}
	if ( $postid == 23 ) {
		$tour_cat = 23;
	}
	
	$args = array(
		'post_type' => 'page',
		'post_parent'=> $tour_cat,
		'meta_query' => array( 
	        array(
	            'key'   => '_wp_page_template', 
	            'value' => 'page-tour-type.php'
	        )
	    ),
		'orderby'	=> 'menu_order',
		'order'     => 'ASC',
	);

	$the_query = new \WP_Query( $args );?>

    <div class="tours-by-category">

		    <?php 

		    while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
		    
		    	<!-- Meet the team sections loop -->

				<div class="small-tour-card">
					<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
						<h4><?php the_title(); ?></h4>
						<?php the_post_thumbnail( 'featured-link' );?>
					</a>
				</div>

				<?php
			endwhile;

			// Reset Second Loop Post Data
			wp_reset_postdata(); ?>

    </div> <?php
}

genesis();