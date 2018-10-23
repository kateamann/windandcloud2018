<?php

/**
 * Sidebar/widgetised area HTML markup structure
 *
 * @package   WindAndCloud2018
 * @since     1.0.0
 * @author    Kate Amann
 * @link      http://kateamann.com
 * @license   GNU General Public License 2.0+
 *
 */
namespace WindAndCloud2018;

add_action( 'genesis_before_content', 'genesis_seo_site_title', 1 );


add_action( 'genesis_setup', __NAMESPACE__ . '\register_sidebar_widget_areas', 15 );
function register_sidebar_widget_areas() {
	$widget_areas = array(
		array(
			'id'          => 'blog-sidebar',
			'name'        => __( 'Blog Sidebar', CHILD_THEME_NAME ),
			'description' => __( 'Blog Sidebar', CHILD_THEME_NAME ),
			'before_widget' => '<section class="widget">',
    		'after_widget' => '</section>',
		),
	);
	foreach ( $widget_areas as $widget_area ) {
		genesis_register_sidebar( $widget_area );
	}
}


add_action( 'get_header', __NAMESPACE__ . '\blog_sidebar' );
function blog_sidebar() {
	if ( is_home() || is_archive() || is_singular( 'post' ) ) {
        remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );

        add_action( 'genesis_sidebar', function() {
			genesis_widget_area ('blog-sidebar');
		} );
    }
}


add_action( 'get_header', __NAMESPACE__ . '\single_tour_sidebar' );
function single_tour_sidebar() {
	if ( is_singular( 'reisen' ) ) {
        remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );

        add_action( 'genesis_sidebar', function() {
			related_by_tag();
		} );
    }
}

function related_posts_by_tag() { 
         
    global $post;

    $count = 0;
    $postIDs = array( $post->ID );
    $related = '';
    $tags = wp_get_post_tags( $post->ID );
     
    if ( $tags ) {
         
        foreach ( $tags as $tag ) {
             
            $tagID[] = $tag->term_id;             
        }
         
        $args = array(
            'tag__in'               => $tagID,
            // 'post__not_in'          => $postIDs,
            'post_type' 			=> 'post',
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

                $related .= '<div ' . post_class() . '><h2><a href="' . get_permalink() . '" rel="bookmark" title="Permanent Link to' . get_the_title() . '">' . get_the_title() . '</a></h2></div>';
                 
                // $postIDs[] = $post->ID;

                // $count++;
            }
        }
    }

    if ( $related ) {
         
        printf( '<section class="widget featured-content featuredpost"><div class="widget-wrap"><h3 class="widgettitle widget-title">Related Posts</h3>%s</div></section>', $related );
     
    }
     
    wp_reset_query();

}

function related_by_tag() {
     
    if ( is_single ( ) ) {
         
        global $post;
 
        $count = 0;
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
             
            
            ?>
            <section class="widget featured-content featuredpost">
            	<div class="widget-wrap">
            		<h3 class="widgettitle widget-title">Related Posts</h3>
            <?php

            if ( $tag_query->have_posts() ) {
                 
                while ( $tag_query->have_posts() ) {
                     
                    $tag_query->the_post(); ?>

                    	<div <?php post_class(); ?>>
                    		<h2>
                    			<a href="" rel="bookmark" title="Permanent Link to">
                    				<?php get_the_title(); ?>
                    			</a>
                    		</h2>
                    	</div>



                    <?php
 
                    
                     
                    
                }
            }

            ?>

			    </div>
			</section>

			<?php
        }
         
        wp_reset_query();
         
    }
}


