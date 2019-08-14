<?php

/**
 * Team page HTML markup structure
 * Template Name: Team
 *
 * @package   WindAndCloud2018
 * @since     1.0.0
 * @author    Kate Amann
 * @link      http://kateamann.com
 * @license   GNU General Public License 2.0+
 *
 */
namespace WindAndCloud2018;

add_action( 'genesis_entry_content', __NAMESPACE__ . '\office_team_links', 15 );
function office_team_links() {
	
	$args = array(
		'post_type' => 'team-bios',
		'meta_key'		=> 'team_category',
		'meta_value'	=> 'buro',
		'orderby'	=> 'menu_order',
		'order'     => 'ASC',
		'posts_per_page' => -1,
	);

	$the_query = new \WP_Query( $args );?>

    
    	<div class="team-members">
    		<h2>Unser Büro Team</h2>

		    <?php 

		    while ( $the_query->have_posts() ) : $the_query->the_post(); 
		    	?>
		    
                    <div class="small-tour-card">
                        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                        <h4>
                        	<?php the_title(); ?>
                        </h4> 
                             <?php the_post_thumbnail( 'featured-link' );?>
                        </a>
                    </div>

			<?php
			endwhile;

			wp_reset_postdata(); ?>

    	</div>
	<?php
}

add_action( 'genesis_entry_content', __NAMESPACE__ . '\guide_team_links', 15 );
function guide_team_links() {
	
	$args = array(
		'post_type' => 'team-bios',
		'meta_key'		=> 'team_category',
		'meta_value'	=> array('reiseleiterin', 'reiseleiter'),
		'orderby'	=> 'menu_order',
		'order'     => 'ASC',
		'posts_per_page' => -1,
	);

	$the_query = new \WP_Query( $args );?>

    
    	<div class="team-members">
    		<h2>Unsere Reiseleiter*innen</h2>

		    <?php 

		    while ( $the_query->have_posts() ) : $the_query->the_post(); 
		    	?>
		    
                    <div class="small-tour-card">
                        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                        <h4>
                        	<?php the_title(); ?>
                        </h4> 
                             <?php the_post_thumbnail( 'featured-link' );?>
                        </a>
                    </div>

			<?php
			endwhile;

			wp_reset_postdata(); ?>

    	</div>
	<?php
}

genesis();