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

	global $wpdb;

	$ranges = $wpdb->get_results('SELECT * FROM wp_ftcalendar_events ORDER BY start_datetime ASC', ARRAY_A);

	setlocale(LC_ALL, 'de_DE');

	$month = -1;

	foreach($ranges as $range) {
		$startDate 	= $range['start_datetime'];
		$endDate 	= $range['end_datetime'];

		$tourID = $range['post_parent'];
		$post = get_post( $tourID, ARRAY_A );

		$title = $post['post_title'];
		$tour_tags = get_the_tags( $tourID );

		$newMonth 	= intval(substr($startDate, 5, 2));
		$time		= strtotime($startDate);

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
		  	  
		  	  <div class="table-wrapper"><table><thead><tr><td>Datum</td><td>Name der Tour</td><td class="tour-tag">Tour Kategorie</td><td></td></tr></thead><tbody>
			<?php
		}

		$month 		= $newMonth;

		// row
		?>
			<tr onclick="location.href='<?php the_permalink( $tourID ); ?>'">
				<td><?php echo date('d.m.y', strtotime($startDate)) . ' - ' . date('d.m.y', strtotime($endDate)) ?></td>
				<td><?php echo $title; ?></td>
				<td class="tour-tag"><?php echo $tour_tags[0]->name; ?></td>
				<td><i class="fas fa-caret-right"></i></td>
			</tr>

		<?php
	}

	?>
	</tbody></table></div></section>

	<?php 
	      	  
}







genesis();