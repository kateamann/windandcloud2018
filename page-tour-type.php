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
	);

	$the_query = new \WP_Query( $args );?>

    <div class="tours-by-type">

		    <?php 

		    while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
		    
		    	<!-- Meet the team sections loop -->

				<section class="large-tour-card">

					<h3><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>

						
					</h3>

					<h4 class="price">
						<?php 
			            if(get_field('discount_price')) { ?>
			                <span class="original">€<?php the_field('price'); ?></span><span class="discount">ab €<?php the_field('discount_price'); ?></span> <?php
			            } 
			            else { ?>
			                ab €<?php the_field('price');
			            } ?>
					</h4>

					<div class="tour-teaser">
				    	<a class="entry-image-link" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
						 	<?php the_post_thumbnail( 'featured-link' );?>
						</a>

						<div class="tour-info">
							<?php the_excerpt(); ?>
							<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="more-link button">Find out more</a>
					    </div>
					</div>
				</section>

				<?php
			endwhile;

			// Reset Second Loop Post Data
			wp_reset_postdata(); ?>

    </div> <?php
}


genesis();