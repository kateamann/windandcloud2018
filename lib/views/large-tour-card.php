<section class="large-tour-card">

	<h3><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
			<?php the_title(); ?>
			<span class="price">
					<?php 
		        if(get_field('discount_price')) { ?>
		            <span class="original"><?php the_field('price'); ?> €</span><span class="discount"><?php the_field('discount_price'); ?> €</span> <?php
		        } 
		        else { ?>
		            <?php the_field('price'); ?> €<?php
		        } ?>
			</span>
		</a>
	</h3>

	<div class="tour-teaser">
    	<a class="entry-image-link" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
		 	<?php the_post_thumbnail( 'featured-image' );?>
		</a>

		<div class="tour-info">
			<?php //the_excerpt(); ?>
			<span>Highlights</span>
			<ul>
				<li>Fahrt mit dem berühmten Jacobite Dampfzug</li>
				<li>Die Metropolen Edinburgh und Glasgow</li>
				<li>Die „Insel des Nebels“ -  Isle of Skye</li>
				<li>Einsamkeit der grandiosen Highlands</li>
				<li>Bahnfahrten entlang berühmter Filmkulissen</li>
			</ul>
			<div class="more-link">
				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="button">Zu den Reisedetails</a>
			</div>
	    </div>
	</div>
</section>