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


add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\enqueue_tour_scripts' );
function enqueue_tour_scripts() {
    
	wp_enqueue_style( 'flexslider-styles', CHILD_URL . "/assets/css/flexslider.css", array(), CHILD_THEME_VERSION );
    wp_enqueue_script( 'flexslider', CHILD_URL . "/assets/js/jquery.flexslider-min.js", array( 'jquery' ), CHILD_THEME_VERSION, true );
    wp_enqueue_script( 'flexslider-init', CHILD_URL . "/assets/js/flexslider-init.js", array( 'flexslider' ), CHILD_THEME_VERSION, true );
    wp_enqueue_script( CHILD_TEXT_DOMAIN . '-tab-accordions', CHILD_URL . "/assets/js/tab-accordions.js", array( 'jquery' ), CHILD_THEME_VERSION, true );
}


remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
add_action( 'genesis_entry_header', __NAMESPACE__ . '\display_subline', 12 );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
add_action( 'genesis_entry_footer', __NAMESPACE__ . '\display_tour_programme_download', 11 );
add_action( 'genesis_entry_footer', __NAMESPACE__ . '\display_booking_button', 12 );



function display_subline() { 
    $subline = get_field('subline');

    if( $subline ) { ?>

        <h5 class="trip-subline"><?php echo $subline; ?></h5>

    <?php 
    }
}


function display_booking_button() { 
	if( get_field('book_url') ){
		?>
	<a href="<?php the_field('book_url'); ?>" class="button book-tour" title="Kaufen Sie eine Tour">Jetzt buchen</a>
	<?php			
	}
}


function display_tour_programme_download() {
        $programme = get_field('programme');

        if( $programme ) { ?>

            <a href="<?php echo $programme['url']; ?>" class="download-programme"><i class="fas fa-file-pdf"></i> Download Programm</a>

            <?php 
        }
}

function upcoming_tour_dates() {
    if( get_field('tour_dates') ) {
        if( have_rows('tour_dates') ) {
            $have_date = false;
            $today = date('Ymd');

            echo '<h3>Termine</h3>';
            while ( have_rows('tour_dates') ) : the_row();

                $the_date = get_sub_field( 'tour_start', false );
                if( $the_date > $today ) {
                    $have_date = true;
                        ?>

                    <span class="tour-start"><?php the_sub_field('tour_start'); ?></span> - 
                    <span class="tour-end"><?php the_sub_field('tour_end'); ?></span>
                    <?php
                    if( get_sub_field('tour_label')) { ?>
                        <span class="tour-label"> &nbsp; <?php the_sub_field('tour_label'); ?></span>
                        <?php
                    } ?>

                    <br />
                    <?php
                }
            endwhile;

            if( !$have_date ) { ?>
                <span class="no-tours">No tours</span>
                <?php
            }
        }
    }

    if( get_field('date_information') ) { ?>

        <h3>Termine</h3>
        <span class="date-info"><?php the_field('date_information'); ?></span>

        <?php
    }
}


function display_prices() { ?>

    <h3>Preise</h3>
    <span class="price">
        <?php 
        if( get_field('discount_price') ) { ?>
            <span class="discount"><span class="original"><?php the_field('price'); ?>€</span> <?php the_field('discount_price'); ?>€ pro Person</span><?php
        } 
        else { ?>
            <?php the_field('price'); ?>€ pro Person<?php
        } ?>
    <br /></span>
    <?php

    if( get_field('pro_person_b_b') ) { ?>
       <span class="price-type"><?php the_field('pro_person_b_b'); ?>€ pro Person in B&B-Pensionen</span><br />
        <?php
    }

    if( get_field('pro_person_hotels') ) { ?>
       <span class="price-type"><?php the_field('pro_person_hotels'); ?>€ pro Person in Hotels</span><br />
        <?php
    }

    if( get_field('einzelzimmer_zuschlag') ) { ?>
       <span class="price-type"><?php the_field('einzelzimmer_zuschlag'); ?>€ Einzelzimmer-Zuschlag</span><br />
        <?php
    }

    if( get_field('august_zuschlag') ) { ?>
       <span class="price-type"><?php the_field('august_zuschlag'); ?>€ August-Zuschlag</span><br />
        <?php
    }

    if( get_field('zuschlag_fur_einzelreisende') ) { ?>
       <span class="price-type"><?php the_field('zuschlag_fur_einzelreisende'); ?>€ Zuschlag für Einzelreisende</span><br />
        <?php
    }

    if( have_rows('additional_prices') ) {
        
        while ( have_rows('additional_prices') ) : the_row(); ?>

            <span class="price-type"><?php the_sub_field( 'amount' ); ?>€ <?php the_sub_field( 'label' ); ?></span><br />

            <?php
        endwhile;
    }
}

 
add_action( 'genesis_before_entry_content', __NAMESPACE__ . '\tour_info_box', 4 );
function tour_info_box() { ?>

    <div class="info-box">

        <div class="info">
            <?php display_booking_button(); ?>
        
            <div class="price">
                <?php 
                if( get_field('discount_price') ) { ?>
                    <span class="discount">ab €<?php the_field('discount_price'); ?></span><span class="original">€<?php the_field('price'); ?></span> <?php
                } 
                else { ?>
                    ab €<?php the_field('price');
                } ?>
            </div>
            <?php upcoming_tour_dates(); ?>
        </div>

        <?php display_map(); ?>
    </div>

<?php
}



add_action( 'genesis_entry_content', __NAMESPACE__ . '\insert_gallery', 10 );
function insert_gallery() { ?>
    <div class="tour-images">
        <?php display_gallery(); ?>
    </div>

<?php
}



function display_gallery() {
    $images = get_field('tour_gallery');

    if( $images ){ ?>
    <div class="tour-gallery">
        <div id="slider" class="flexslider">
            <ul class="slides">
                <?php foreach( $images as $image ): ?>
                    <li>
                        <img src="<?php echo $image['sizes']['featured-image']; ?>" alt="<?php echo $image['alt']; ?>" />
                        
                            <?php if( $image['caption'] ) { ?>
                                <div class="flexcaption">
                                    <p><?php echo $image['caption']; ?></p>
                                </div>
                            <?php
                            } ?>
                            
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div id="carousel" class="flexslider">
            <ul class="slides">
                <?php foreach( $images as $image ): ?>
                    <li>
                        <img src="<?php echo $image['sizes']['featured-thumb']; ?>" alt="<?php echo $image['alt']; ?>" />
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <?php }
}


function display_map() { 
    $map_image = get_field('map_image');
    $map_display = $map_image['sizes'][ 'medium' ];

    if( !empty($map_image) ) { ?>
        <div class="tour-map">
            <img src="<?php echo $map_display; ?>" alt="<?php echo $map_image['alt']; ?>" />
        </div>

    <?php 
    }
}

function display_page_content($path) {
    $post = get_page_by_path($path);
    $content = apply_filters('the_content', $post->post_content);
    echo $content;
}



function display_tour_feedback() {
    if( have_rows('tour_feedback') ) { ?>

    <?php while( have_rows('tour_feedback') ): the_row(); 

        $customer_name = get_sub_field('customer_name');
        $feedback_date = get_sub_field('feedback_date');
        $comment = get_sub_field('customer_comment');

        $rating = get_sub_field('customer_rating');
        $rating_stars = "";

        // img tags for each whole star
        for( $i=0; $i<$rating; $i++ ){
            $rating_stars .= '<i class="fas fa-star"></i>';
        }

        ?>
        <div class="feedback">

        <h4><?php echo $customer_name; ?><span class="feedback-date"> am <?php echo $feedback_date; ?></span></h4>
            <?php if( $rating ) { ?>
                <h5>
                    <?php print $rating_stars; ?>
                </h5>
                <?php
            } 
            echo $comment; ?>
        </div>

    <?php endwhile; ?>

<?php }
}




add_action( 'genesis_after_entry_content', __NAMESPACE__ . '\tour_tabs', 6 );
function tour_tabs() { 
	?>
	<div class="tour-info">

	    <div class="tab-nav">
		    <ul class="tour-tabs">
		        <li class="active" rel="tab1">Programm</a></li>
		        <li rel="tab2">Leistungen</a></li>
		        <li rel="tab3">Termine & Preise</a></li>
		        <li rel="tab4">Bewertungen</a></li>
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

			<h3 class="tab_drawer_heading" rel="tab2">Leistungen</h3>
			<div id="tab2" class="tab_content">
			<h2 class="tab-heading">Leistungen</h2>
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
                <div class="tab-section"><?php upcoming_tour_dates(); ?></div>
                <div class="tab-section"><?php display_prices(); ?></div>
                <div class="tab-section"><?php display_page_content('buchung'); ?></div>
			</div>
			<!-- #tab3 -->

			<h3 class="tab_drawer_heading" rel="tab4">Bewertungen</h3>
			<div id="tab4" class="tab_content">
			<h2 class="tab-heading">Bewertungen</h2>
                <?php display_tour_feedback();?>
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
        $tags = wp_get_post_tags( $post->ID );
        $cats = get_the_category();
        $cat = $cats[0]->term_id;
         
        if ( $tags ) {
             
            foreach ( $tags as $tag ) {
                 
                $tagID[] = $tag->term_id;
                 
            }
             
            $args = array(
                'tag__in'               => $tagID,
                'cat'         		 	=> $cat,
                'post__not_in'          => $postIDs,
                'post_type' 			=> 'reisen',
                'showposts'             => 3,
                'ignore_sticky_posts'   => 1,
                'tax_query'             => array(
                    array(
                                        'taxonomy'  => 'post_format',
                                        'field'     => 'slug',
                                        'terms'     => array( 
                                            'post-format-link', 
                                            'post-format-status', 
                                            'post-format-aside', 
                                            'post-format-quote'
                                            ),
                                        'operator'  => 'NOT IN'
                    )
                )
            );
 
            $tag_query = new \WP_Query( $args );
             
            if ( $tag_query->have_posts() ) {
                 
                while ( $tag_query->have_posts() ) {
                     
                    $tag_query->the_post();
 
                    $img = genesis_get_image() ? genesis_get_image( array( 'size' => 'featured-link' ) ) : '<img src="' . get_bloginfo( 'stylesheet_directory' ) . '/images/related.png" alt="' . get_the_title() . '" />';
                         
                    if(get_field('discount_price')) { 
                        $price = '<span class="original">€' . get_field('price') . '</span><span class="discount">ab €' . get_field('discount_price') . '</span>';
                    } 
                    else {
                        $price = 'ab €' . get_field('price');
                    }
 
                    $related .= '<div class="small-tour-card"><a href="' . get_permalink() . '" rel="bookmark" title="Permanent Link to' . get_the_title() . '"><h4>' . get_the_title() . '</h4>' . $img . '<div class="tour-overlay">' . $price . '</div></a></div>';
                     
                    $postIDs[] = $post->ID;
 
                    $count++;
                }
            }
        }
 
        // if ( $count <= 2 ) {
             
        //     $catIDs = array( );
 
        //     foreach ( $cats as $cat ) {
                 
        //         if ( 3 == $cat )
        //             continue;
        //         $catIDs[] = $cat;
                 
        //     }
             
        //     $showposts = 3 - $count;
 
        //     $args = array(
        //         'category__in'          => $catIDs,
        //         'post__not_in'          => $postIDs,
        //         'showposts'             => $showposts,
        //         'post_type' 			=> 'reisen',
        //         'ignore_sticky_posts'   => 1,
        //         'orderby'               => 'rand',
        //         'tax_query'             => array(
        //                             array(
        //                                 'taxonomy'  => 'post_format',
        //                                 'field'     => 'slug',
        //                                 'terms'     => array( 
        //                                     'post-format-link', 
        //                                     'post-format-status', 
        //                                     'post-format-aside', 
        //                                     'post-format-quote' ),
        //                                 'operator' => 'NOT IN'
        //                             )
        //         )
        //     );
 
        //     $cat_query = new \WP_Query( $args );
             
        //     if ( $cat_query->have_posts() ) {
                 
        //         while ( $cat_query->have_posts() ) {
                     
        //             $cat_query->the_post();
 
        //             $img = genesis_get_image() ? genesis_get_image( array( 'size' => 'featured-link' ) ) : '<img src="' . get_bloginfo( 'stylesheet_directory' ) . '/images/related.png" alt="' . get_the_title() . '" />';
 
        //             $related .= '<div class="small-tour-card"><a href="' . get_permalink() . '" rel="bookmark" title="Permanent Link to' . get_the_title() . '"><h4>' . get_the_title() . '</h4>' . $img . '</a></div>';
        //         }
        //     }
        // }
 
        if ( $related ) {
             
            printf( '<div class="related-posts"><h3 class="related-title">You might also like</h3><div class="related-list">%s</div></div>', $related );
         
        }
         
        wp_reset_query();
         
    }
}

genesis();