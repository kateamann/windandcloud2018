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

	// gets start and end dates with post id from ACF repeater
	$rows = $wpdb->get_results( 
        "
        SELECT 
			A.post_id, 
			A.meta_value as startdate, 
			B.meta_value as enddate
		FROM wac_n06_postmeta as A 
		JOIN wac_n06_postmeta as B on A.post_id 
			WHERE A.post_id = B.post_id 
			AND A.meta_value > CURDATE()
			AND A.meta_key LIKE 'tour_dates_%_tour_start' AND B.meta_key LIKE 'tour_dates_%_tour_end'
		    AND SUBSTRING(B.meta_key,12,5) = SUBSTRING(A.meta_key,12,5)
        "
    );

	setlocale(LC_ALL, 'de_DE');

	$month = -1;

	$order = array();

	// populate order
	foreach( $rows as $i => $row ) {
		$order[ $i ] = $row->startdate;
	}

	// multisort
	array_multisort( $order, SORT_ASC, $rows );

	// Loop through the returned rows
	foreach( $rows as $row) {

		if ( get_post_status ( $row->post_id ) == 'publish' ) {
	    

			$startdate = $row->startdate;
			$enddate = $row->enddate;
			$post_id = $row->post_id;
			$tour_name = get_the_title($post_id);
			$tour_tags = get_the_tags($post_id);

			$newMonth 	= intval(substr($startdate, 4, 2));
			$time		= strtotime($startdate);

			if($month !== $newMonth) {
				if($month !== -1) {
					// end section
					?>
					</tbody></table></div></section>
					<?php
				}
				
				// start section
				?>
				<section class="content-wrapper calendar">
			  	  <h3><?php echo strftime("%B %Y", $time); ?></h3>
			  	  
			  	  <div class="table-wrapper">
			  	  	<table>
			  	  		<thead><tr><td class="date">Datum</td><td class="tour-name">Name der Tour</td><td class="tour-tag">Tour Kategorie</td><td class="arrow"></td></tr></thead>
			  	  		<tbody>
				<?php
			}

			$month = $newMonth;

			// row
				?>
					<tr onclick="location.href='<?php the_permalink( $post_id ); ?>'">
						<td class="date"><?php echo date('d.m.y', strtotime($startdate)) . ' - ' . date('d.m.y', strtotime($enddate)) ?></td>
						<td class="tour-name"><?php echo $tour_name; ?></td>
						<td class="tour-tag">
							<?php
							if($tour_tags) {
								foreach($tour_tags as $tour_tag) :  
									echo $tour_tag->name . '&nbsp;'; 
						      	endforeach;
							}
							 
					      	?>
					    </td>
						<td class="arrow"><i class="fas fa-caret-right"></i></td>
					</tr>

					<?php
				
		}
	}

	?>
	</tbody></table></div></section>

	<?php 
    	  
}

genesis();