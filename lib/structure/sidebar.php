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
        array(
            'id'          => 'blog-home-sidebar',
            'name'        => __( 'Blog Home Sidebar', CHILD_THEME_NAME ),
            'description' => __( 'Blog Home Sidebar', CHILD_THEME_NAME ),
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
	if ( is_home() ) {
        remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );

        add_action( 'genesis_sidebar', function() {
			genesis_widget_area ('blog-home-sidebar');
		} );
    }
    if ( is_archive() || is_singular( 'post' ) ) {
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



function related_by_tag() {
     
    if ( is_single ( ) ) {
         
        global $post;
 
        $tags = wp_get_post_tags( $post->ID );
         
        if ( $tags ) {
             
            foreach ( $tags as $tag ) {
                 
                $tagID[] = $tag->term_id;
                 
            }
             
            $args = array(
                'tag__in'               => $tagID,
                'post_type'             => 'post',
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

                ?>
                <section class="widget featured-content featuredpost">
                    <div class="widget-wrap">
                        <h3 class="widgettitle widget-title">Related Posts</h3>
                <?php
                 
                while ( $tag_query->have_posts() ) {
                     
                    $tag_query->the_post(); ?>

                        <div <?php post_class(); ?>>
                            <h2>
                                <a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to<?php the_title_attribute(); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h2>
                            <?php genesis_post_info(); ?>
                        </div>

                    <?php
                    
                }

                ?>

                </div>
            </section>

            <?php
            }
        }
         
        wp_reset_query();
         
    }
}



add_action( 'genesis_sidebar', __NAMESPACE__ . '\newsletter_button', 2 );
function newsletter_button() { ?>
    <section class="newsletter widget">
        <div class="createsend-button" data-listid="i/27/967/E23/427E004FF3A4670C"></div>
        <script type="text/javascript">
            (function () { 
                var e = document.createElement('script'); e.type = 'text/javascript'; e.async = true; e.src = ('https:' == document.location.protocol ? 'https' : 'http') + '://btn.createsend1.com/js/sb.min.js?v=3'; e.className = 'createsend-script'; var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(e, s); 
            })();
        </script>
    </section>
    <?php
}


add_action( 'genesis_sidebar', __NAMESPACE__ . '\featured_tour_in_sidebar', 3 );
function featured_tour_in_sidebar() {
    if( !is_front_page() ) {

        global $post;

        $post_object = get_field('featured_tour');

        if( $post_object ): 

            // override $post
            $post = $post_object;
            setup_postdata( $post ); 

            ?>

            <section class="widget featured-content featuredpost">
                <div class="widget-wrap">
                    <h3 class="widgettitle widget-title">Featured Tour</h3>
                    <div class="small-tour-card">
                        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                        <h4><?php the_title(); ?></h4> 
                             <?php the_post_thumbnail( 'featured-link' );?>
                        <div class="tour-overlay">
                            <?php 
                            if(get_field('discount_price')) { ?>
                                <span class="original">€<?php the_field('price'); ?></span><span class="discount">ab €<?php the_field('discount_price'); ?></span> <?php
                            } 
                            else { ?>
                                ab €<?php the_field('price');
                            } ?>
                        </div>
                        </a>
                    </div>
                </div>
            </section>

            <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
        <?php endif;

    }
}





