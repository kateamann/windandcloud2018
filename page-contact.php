<?php

/**
 * Contact page HTML markup structure
 * Template Name: Contact
 *
 * @package   WindAndCloud2018
 * @since     1.0.0
 * @author    Kate Amann
 * @link      http://kateamann.com
 * @license   GNU General Public License 2.0+
 *
 */
namespace WindAndCloud2018;


add_action( 'genesis_before_entry_content', __NAMESPACE__ . '\featured_contact_image', 1 );
function featured_contact_image() {
	
	// Display featured image above content
	genesis_image( array( 
		'size' => 'full', 
		'attr' => array ( 'class' => 'featured' ), 
	) );
}


add_action( 'genesis_entry_content', __NAMESPACE__ . '\contact_office_team', 5 );
function contact_office_team() {
	
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

		    	$job_title = get_field('job_title');

		    	?>
		    
                    <div class="small-tour-card">
                        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                        <h4>
                        	<?php the_title(); ?>
                        </h4> 
                            <?php the_post_thumbnail( 'featured-link' );?>
                            <?php if( $job_title ) {
								?>
								<div class="tour-overlay">
									<?php echo $job_title; ?>		
								</div>
								<?php
							} ?>
                        </a>
                    </div>

			<?php
			endwhile;

			wp_reset_postdata(); ?>

    	</div>
	<?php
}


add_action( 'genesis_entry_content', __NAMESPACE__ . '\contact_info_boxes', 10 );
function contact_info_boxes() {
    if ( get_field('contact_info_boxes') ) {
        if ( have_rows('contact_info_boxes') ) {

        	$i = 1;

            while ( have_rows('contact_info_boxes') ) : the_row(); ?>

                <div class="contact-info one-half<?php if( $i % 2 != 0 ) { echo ' first'; } ?>">
                    <h3><?php the_sub_field('box_heading'); ?></h3>
                    <div class="box-content"><?php the_sub_field('box_content'); ?></div>
                </div>
                <?php

                $i++;

            endwhile;
        }
    }
}

add_action( 'genesis_entry_content', __NAMESPACE__ . '\display_contact_form', 12 );
function display_contact_form() {
	echo do_shortcode( '[ninja_form id=1]' );
}

genesis();