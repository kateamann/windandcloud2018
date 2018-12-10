<section class="large-tour-card">

	<h3><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
			<?php the_title(); ?>
			<span class="price">
				ab <?php the_field('price'); ?> €
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
		        <h5 class="trip-subline"><?php echo $subline; ?></h5>
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