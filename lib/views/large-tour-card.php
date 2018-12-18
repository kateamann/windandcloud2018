<section class="large-tour-card">

	<h3><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
			<span class="tour-title"><?php the_title(); ?></span>
			<span class="price">
				<?php 
		        if(get_field('discount_price')) { ?>
		            ab <span class="original"><?php the_field('price'); ?> €</span><span class="discount"><?php the_field('discount_price'); ?> €</span> <?php
		        } 
		        else { ?>
		            ab <?php the_field('price'); ?> €<?php
		        } ?>
			</span>
		</a>
	</h3>

	<div class="tour-teaser">
    	<a class="entry-image-link" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
		 	<?php the_post_thumbnail( 'featured-image' );?>
		</a>

		<div class="tour-info">
			<?php 
			$subline = get_field('subline');

		    if( $subline ) { ?>
		        <h4 class="trip-subline"><?php echo $subline; ?></h4>
		    <?php 
		    }

			the_excerpt(); 
			?>
			<div class="more-link">
				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="button">Zu den Reisedetails</a>
			</div>
	    </div>
	</div>
</section>