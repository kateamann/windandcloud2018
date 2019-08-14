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

//* Remove the edit link
add_filter ( 'genesis_edit_post_link' , '__return_false' );

//* Customize the entry meta in the entry header
add_filter( 'genesis_post_info', __NAMESPACE__ . '\post_info_filter' );
function post_info_filter($post_info) {
	$post_info = '[post_date]';
	return $post_info;
}


add_action( 'genesis_before_entry_content', __NAMESPACE__ . '\display_featured_image' );
function display_featured_image() {
	if ( ! is_singular( array( 'page' ) ) ) {
		return;
	}
    if ( is_page_template() ) {
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

add_filter( 'tiled_gallery_content_width', __NAMESPACE__ . '\custom_jetpack_gallery_width' );
function custom_jetpack_gallery_width($width){
    $tiled_gallery_content_width = $width;
    $width = 880;
    return $width;
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
        add_action( 'genesis_entry_content', 'genesis_post_meta', 8 );
	}
}




//* Customize the post meta function
add_filter( 'genesis_post_meta', __NAMESPACE__ . '\post_meta_filter' );
function post_meta_filter($post_meta) {
    if ( !is_page() ) {
        $post_meta = '[post_categories before="Kategorien: "]';
        return $post_meta;
    }
}

//* Modify the Genesis content limit read more link
add_filter( 'get_the_content_more_link', __NAMESPACE__ . '\change_read_more_link' );
function change_read_more_link() {
	return '... ';
}

add_action( 'genesis_entry_content', __NAMESPACE__ . '\read_more_button', 12 );
function read_more_button() {
    if ( is_singular() ) {
        return;
    }

    printf( '<a href="%s" class="more-link button">%s</a>', get_permalink(), esc_html__( 'Read more' ) );
}

//* Customize the next page link
add_filter ( 'genesis_next_link_text' , __NAMESPACE__ . '\custom_next_page_link' );
function custom_next_page_link ( $text ) {
    return 'nächste Seite &#x000BB;';
}

//* Customize the previous page link
add_filter ( 'genesis_prev_link_text' , __NAMESPACE__ . '\custom_previous_page_link' );
function custom_previous_page_link ( $text ) {
    return '&#x000AB; vorherige Seite';
}

//* Content boxes on pages
add_action( 'genesis_entry_content', __NAMESPACE__ . '\add_content_boxes', 12 );
function add_content_boxes() {
    if ( is_page() && is_singular() ) {
        if ( get_field('content_boxes') ) {
            if ( have_rows('content_boxes') ) {
                while ( have_rows('content_boxes') ) : the_row(); ?>
                    <section class="content-box">
                        <h3><?php the_sub_field('box_heading'); ?></h3>
                        <div class="box-content"><?php the_sub_field('box_content'); ?></div>
                    </section>
                    <?php
                endwhile;
            }
        }
    }
}

add_action( 'genesis_after_entry', __NAMESPACE__ . '\blog_post_related_tours' );
//* Outputs related tours by tag
function blog_post_related_tours() {
     
    if ( is_singular ( 'post' ) ) {
         
        global $post;
 
        //$count = 0;
        $postIDs = array( $post->ID );
        $related = '';
        $tags = wp_get_post_tags( $post->ID );

        if ( $tags ) {
             
            foreach ( $tags as $tag ) {
                $tagID[] = $tag->term_id;   
            }
             
            $args = array(
                'tag__in'               => $tagID,
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
             
            if ( $tag_query->have_posts() ) { ?>

                <div class="related-posts">
                    <h3 class="related-title">Das könnte Sie auch interessieren:</h3>
                    <div class="related-list"> <?php
                 
                    while ( $tag_query->have_posts() ) {
                         
                        $tag_query->the_post(); 
                            
                            get_template_part('lib/views/small-tour-card-loop');
                                                         
                        $postIDs[] = $post->ID;
     
                        //$count++;
                    } ?>

                    </div>
                </div> <?php
            }
        }
        wp_reset_query();  
    }
}