<?php

/**
 * Calendar Page HTML markup structure
 * Template Name: Calendar
 * 
 * @package   WindAndCloud2018
 * @since     1.0.0
 * @author    Kate Amann
 * @link      http://kateamann.com
 * @license   GNU General Public License 2.0+
 *
 */
namespace WindAndCloud2018;


add_action( 'genesis_entry_content', __NAMESPACE__ . '\group_travel_calendar', 10 );
function group_travel_calendar() {
	
	$args = array(
		'post_type' 		=> 'reisen',
		'post_status' 		=> 'publish',
		'posts_per_page' 	=> -1,
		'meta_key'			=> 'start_date',
		'orderby'			=> 'meta_value',
		'order'				=> 'ASC'
	);
	
	setlocale(LC_ALL, 'de_DE');
	
	$the_query = new \WP_Query($args);
	
	if($the_query->have_posts())
	{
		$month = -1;
	
		while($the_query->have_posts()) : $the_query->the_post(); global $post; ?>
		
		<?php
			$newMonth 	= intval(substr(get_field('start_date'), 5, 2));
			$time		= strtotime(get_field('start_date'));

			$categories	= get_field('category');

			if(get_post_type($categories[0]->ID) == 'individualreisen')
				continue;

			if($month !== $newMonth)
			{
				if($month !== -1)
				{
					// end section
					?>
					</tbody></table></div></section>
					<?php
				}
				
				// start section
				?>
				<section class="content-wrapper calendar">
		      	  <h3><?php echo strftime("%B %Y", $time); ?></h3>
		      	  
		      	  <div class="table-wrapper"><table><thead><tr><td>Datum</td><td>Name der Tour</td><td>Tour Kategorie</td><td></td></tr></thead><tbody>
				<?php
			}
			
			$month 		= $newMonth;

			// row
			?>

  	  		<tr onclick="location.href='<?php the_permalink(); ?>'">
  	  			<td><?php echo date('d.m.y', strtotime(get_field('start_date'))) . ' - ' . date('d.m.y', strtotime(get_field('end_date'))) ?></td>
  	  			<td><?php the_title(); ?></td>
  	  			<td><?php echo $categories[0]->post_title; ?></td>
  	  			<td></td>
  	  		</tr>

		<?php endwhile;
		
		// end section
		?>
		</tbody></table></div></section>
		<?php
	}
	
	wp_reset_postdata();
}



genesis();