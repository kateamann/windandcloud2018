<div class="small-tour-card">
    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
        <h4><?php the_title(); ?></h4>
        <?php the_post_thumbnail( 'featured-link' );?>
        <div class="tour-overlay">ab <?php the_field('price'); ?> €
        </div>
    </a>
</div>