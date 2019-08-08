<?php

/**
 * Team Bio page HTML markup structure
 *
 * @package   WindAndCloud2018
 * @since     1.0.0
 * @author    Kate Amann
 * @link      http://kateamann.com
 * @license   GNU General Public License 2.0+
 *
 */
namespace WindAndCloud2018;

remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );

add_action( 'genesis_entry_header', __NAMESPACE__ . '\display_team_category', 12 );
function display_team_category() {
	$team_cat = get_field('team_category');
	$job_title = get_field('job_title');
	?>

	<h2><i class="fas <?php echo $team_cat['value']; ?>"></i>&nbsp;<?php echo $team_cat['label']; ?><?php if($job_title) { ?>&nbsp;-&nbsp;<span><?php echo $job_title; ?></span><?php } ?></h2>

	<?php
}

add_action( 'genesis_before_entry_content', __NAMESPACE__ . '\display_team_image', 1 );
function display_team_image() {
	
	// Display featured image above content
	genesis_image( array( 
		'size' => 'featured-link', 
		'attr' => array ( 'class' => 'alignright' ), 
	) );
}

add_action( 'genesis_entry_footer', __NAMESPACE__ . '\all_team_link', 5 );
function all_team_link() { ?>
	<a href="/ueber-uns/schottland-reiseleiter-team/" class="team-link" title="Unser Team">Unser Team</a>

	<?php
}


genesis();