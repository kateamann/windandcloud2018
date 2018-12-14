<div class="small-tour-card">
    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
        <h4><?php the_title(); ?></h4>
        <?php if ( has_post_thumbnail() ) {
                the_post_thumbnail( 'featured-link' );
            } else { ?>
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/small-card-placeholder.png" alt="<?php the_title(); ?>" />
            <?php } ?>
        <div class="tour-overlay"><?php 
            if(get_field('discount_price')) { ?>
                ab <span class="original"><?php the_field('price'); ?> €</span><span class="discount"><?php the_field('discount_price'); ?> €</span> <?php
            } 
            else { ?>
                ab <?php the_field('price'); ?> € <?php
            } ?>
        </div>
    </a>
</div>