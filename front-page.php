<?php

/**
 * Front Page HTML markup structure
 *
 * @package   WindAndCloud2018
 * @since     1.0.0
 * @author    Kate Amann
 * @link      http://kateamann.com
 * @license   GNU General Public License 2.0+
 *
 */
namespace WindAndCloud2018;

add_action( 'genesis_before_entry_content', __NAMESPACE__ . '\display_home_tour_blocks', 5 );
function display_home_tour_blocks() { ?>

	<div class="tours-by-category">

	<?php

	$post_objects = get_field('tour_type_blocks');

	if( $post_objects ) {
	    foreach( $post_objects as $post_object): 
	    	$parent = wp_get_post_parent_id($post_object->ID);
	    	$tour_tag = get_field('tour_tag', $post_object->ID);
			$tour_term = get_term( $tour_tag );
	    	?>

	        <div class="small-tour-card">
				<a href="<?php echo get_permalink($post_object->ID); ?>" title="<?php echo get_the_title($post_object->ID); ?>">
					<h4><?php echo $tour_term->name; ?></h4>
					<?php echo get_the_post_thumbnail( $post_object->ID, 'featured-link' ); ?>
				</a>
			</div><?php 
		endforeach;
	} ?>

	</div> <?php
}


add_action( 'genesis_after_entry_content', __NAMESPACE__ . '\featured_tour_home', 12 );
function featured_tour_home() {
    global $post;

    $post_object = get_field('featured_tour');

    if( $post_object ): 

        // override $post
        $post = $post_object;
        setup_postdata( $post ); 

        ?>

        <div class="home-featured-tour">
        	<h2>Reiseangebote</h2>
        	<?php get_template_part('lib/views/large-tour-card'); ?>
		</div>

        <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
    <?php endif;
}

genesis();