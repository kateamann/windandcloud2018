<?php

/**
 * Tour page HTML markup structure
 *
 * @package   WindAndCloud2018
 * @since     1.0.0
 * @author    Kate Amann
 * @link      http://kateamann.com
 * @license   GNU General Public License 2.0+
 *
 */
namespace WindAndCloud2018;


add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\enqueue_tab_script' );
function enqueue_tab_script() {
    
	wp_enqueue_script( CHILD_TEXT_DOMAIN . '-tab-accordions', CHILD_URL . "/assets/js/tab-accordions.js", array( 'jquery' ), CHILD_THEME_VERSION, true );
}


remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
add_action( 'genesis_entry_header', __NAMESPACE__ . '\display_booking_button' );

remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
add_action( 'genesis_entry_footer', __NAMESPACE__ . '\display_tour_programme_download', 11 );
add_action( 'genesis_entry_footer', __NAMESPACE__ . '\display_booking_button', 12 );



function display_booking_button() { 
	if( get_field('book_url') ){
		?>
	<a href="<?php the_field('book_url'); ?>" class="button book-tour" title="Kaufen Sie eine Tour">Jetzt buchen</a>
	<?php			
	}
}

function display_tour_programme_download() {
	if( get_field('programme') ) {
		$programme = get_field('programme'); ?>

		<a href="<?php echo wp_get_attachment_url($programme['id']); ?>" class="download-programme">Download Programm</a>

	<?php }
}



add_action( 'genesis_before_entry_content', __NAMESPACE__ . '\display_featured_tour_image' );
function display_featured_tour_image() {
	if ( ! has_post_thumbnail() ) {
		return;
	}
	// Display featured image above content
	echo '<div class="singular-featured-image">';
		genesis_image( array( 'size' => 'featured-image' ) );
	echo '</div>';
}






add_action( 'genesis_entry_content', __NAMESPACE__ . '\tour_tabs', 10 );
function tour_tabs() { 
	?>
	<div class="tour-info">

	    <div class="tab-nav">
		    <ul class="tour-tabs">
		        <li class="active" rel="tab1">Programm</a></li>
		        <li rel="tab2">Leistungen</a></li>
		        <li rel="tab3">Termine & Preise</a></li>
		        <li rel="tab4">Bewertungene</a></li>
		    </ul>
		</div>

	    <div class="tab-content-container">
	 
		    <h3 class="d_active tab_drawer_heading" rel="tab1">Programm</h3>
			<div id="tab1" class="tab_content">
			<h2 class="tab-heading">Programm</h2>
			<?php if( get_field('time_tab') ){
					the_field('time_tab');
				} ?>
			</div>
			<!-- #tab1 -->

			<h3 class="tab_drawer_heading" rel="tab2">Leistunge</h3>
			<div id="tab2" class="tab_content">
			<h2 class="tab-heading">Leistunge</h2>
			<?php  if( get_field('dates_tab') ){
					the_field('dates_tab');
				}
				if( get_field('services_tab') ){
					the_field('services_tab');
				}?>
			</div>
			<!-- #tab2 -->

			<h3 class="tab_drawer_heading" rel="tab3">Termine & Preise</h3>
			<div id="tab3" class="tab_content">
			<h2 class="tab-heading">Termine & Preise</h2>
			<?php
				if( get_field('prices_tab') ){
					the_field('prices_tab');
				}
				if( get_field('subscriber_tab') ){
					the_field('subscriber_tab');
				}
			?>
			</div>
			<!-- #tab3 -->

			<h3 class="tab_drawer_heading" rel="tab4">Bewertungene</h3>
			<div id="tab4" class="tab_content">
			<h2 class="tab-heading">Bewertungene</h2>
			<?php if( get_field('ratings_tab') ){
					the_field('ratings_tab');
				} ?>
			</div>
			<!-- #tab4 --> 

		</div>

	</div> 

<?php 
}



add_action( 'genesis_after_entry', __NAMESPACE__ . '\related_tours' );
/**
 * Outputs related posts with thumbnail
 * 
 * @author Nick the Geek
 * @url https://designsbynickthegeek.com/tutorials/related-posts-genesis
 * @global object $post 
 */
function related_tours() {
     
    if ( is_single ( ) ) {
         
        global $post;
 
        $count = 0;
        $postIDs = array( $post->ID );
        $related = '';
        // $tags = wp_get_post_tags( $post->ID );
        $cats = wp_get_object_terms( $id, 'category' );
         
        // if ( $tags ) {
             
        //     foreach ( $tags as $tag ) {
                 
        //         $tagID[] = $tag->term_id;
                 
        //     }
             
        //     $args = array(
        //         'tag__in'               => $tagID,
        //         'post__not_in'          => $postIDs,
        //         'showposts'             => 5,
        //         'ignore_sticky_posts'   => 1,
        //         'tax_query'             => array(
        //             array(
        //                                 'taxonomy'  => 'post_format',
        //                                 'field'     => 'slug',
        //                                 'terms'     => array( 
        //                                     'post-format-link', 
        //                                     'post-format-status', 
        //                                     'post-format-aside', 
        //                                     'post-format-quote'
        //                                     ),
        //                                 'operator'  => 'NOT IN'
        //             )
        //         )
        //     );
 
        //     $tag_query = new \WP_Query( $args );
             
        //     if ( $tag_query->have_posts() ) {
                 
        //         while ( $tag_query->have_posts() ) {
                     
        //             $tag_query->the_post();
 
        //             $img = genesis_get_image() ? genesis_get_image( array( 'size' => 'related' ) ) : '<img src="' . get_bloginfo( 'stylesheet_directory' ) . '/images/related.png" alt="' . get_the_title() . '" />';
 
        //             $related .= '<li><a href="' . get_permalink() . '" rel="bookmark" title="Permanent Link to' . get_the_title() . '">' . $img . get_the_title() . '</a></li>';
                     
        //             $postIDs[] = $post->ID;
 
        //             $count++;
        //         }
        //     }
        // }
 
        if ( $count <= 2 ) {
             
            $catIDs = array( );
 
            foreach ( $cats as $cat ) {
                 
                if ( 3 == $cat )
                    continue;
                $catIDs[] = $cat;
                 
            }
             
            $showposts = 3 - $count;
 
            $args = array(
                'category__in'          => $catIDs,
                'post__not_in'          => $postIDs,
                'showposts'             => $showposts,
                'post_type' 			=> 'reisen',
                'ignore_sticky_posts'   => 1,
                'orderby'               => 'rand',
                'tax_query'             => array(
                                    array(
                                        'taxonomy'  => 'post_format',
                                        'field'     => 'slug',
                                        'terms'     => array( 
                                            'post-format-link', 
                                            'post-format-status', 
                                            'post-format-aside', 
                                            'post-format-quote' ),
                                        'operator' => 'NOT IN'
                                    )
                )
            );
 
            $cat_query = new \WP_Query( $args );
             
            if ( $cat_query->have_posts() ) {
                 
                while ( $cat_query->have_posts() ) {
                     
                    $cat_query->the_post();
 
                    $img = genesis_get_image() ? genesis_get_image( array( 'size' => 'featured-link' ) ) : '<img src="' . get_bloginfo( 'stylesheet_directory' ) . '/images/related.png" alt="' . get_the_title() . '" />';
 
                    $related .= '<div class="small-tour-card"><a href="' . get_permalink() . '" rel="bookmark" title="Permanent Link to' . get_the_title() . '"><h4>' . get_the_title() . '</h4>' . $img . '</a></div>';
                }
            }
        }
 
        if ( $related ) {
             
            printf( '<div class="related-posts"><h3 class="related-title">You might also like</h3><div class="related-list">%s</div></div>', $related );
         
        }
         
        wp_reset_query();
         
    }
}


genesis();