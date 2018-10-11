<?php

/**
 * Tour page HTML markup structure
 *
 * @package   WindAndCloud2018
 * @since     1.0.0
 * @author    Kate Amann
 * @link      http://kateamann.com
 * @license   GNU General Public License 2.0+
 *
 */
namespace WindAndCloud2018;


add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\enqueue_tab_script' );
function enqueue_tab_script() {
    
	wp_enqueue_script( CHILD_TEXT_DOMAIN . '-tab-accordions', CHILD_URL . "/assets/js/tab-accordions.js", array( 'jquery' ), CHILD_THEME_VERSION, true );
}


remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );

add_action( 'genesis_before_entry_content', __NAMESPACE__ . '\display_featured_tour_image' );
function display_featured_tour_image() {
	if ( ! has_post_thumbnail() ) {
		return;
	}
	// Display featured image above content
	echo '<div class="singular-featured-image">';
		genesis_image( array( 'size' => 'featured-image' ) );
	echo '</div>';
}






add_action( 'genesis_entry_content', __NAMESPACE__ . '\tour_tabs', 10 );
function tour_tabs() { 
	?>
	<div class="tour-info">

	    <div class="tab-nav">
		    <ul class="tour-tabs">
		        <li class="active" rel="tab1">Programm</a></li>
		        <li rel="tab2">Leistungen</a></li>
		        <li rel="tab3">Termine & Preise</a></li>
		        <li rel="tab4">Bewertungene</a></li>
		    </ul>
		</div>

	    <div class="tab-content-container">
	 
		    <h3 class="d_active tab_drawer_heading" rel="tab1">Programm</h3>
			<div id="tab1" class="tab_content">
			<h2>Programm</h2>
			<?php if( get_field('time_tab') ){
					the_field('time_tab');
				} ?>
			</div>
			<!-- #tab1 -->

			<h3 class="tab_drawer_heading" rel="tab2">Leistunge</h3>
			<div id="tab2" class="tab_content">
			<h2>Leistunge</h2>
			<?php if( get_field('services_tab') ){
					the_field('services_tab');
				} ?>
			</div>
			<!-- #tab2 -->

			<h3 class="tab_drawer_heading" rel="tab3">Termine & Preise</h3>
			<div id="tab3" class="tab_content">
			<h2>Termine & Preise</h2>
			<?php
				if( get_field('dates_tab') ){
					the_field('dates_tab');
				}
				if( get_field('prices_tab') ){
					the_field('prices_tab');
				}
			?>
			</div>
			<!-- #tab3 -->

			<h3 class="tab_drawer_heading" rel="tab4">Bewertungene</h3>
			<div id="tab4" class="tab_content">
			<h2>Bewertungene</h2>
			<?php if( get_field('ratings_tab') ){
					the_field('ratings_tab');
				} ?>
			</div>
			<!-- #tab4 --> 

		</div>

	</div> 

<?php }


add_action( 'genesis_entry_content', __NAMESPACE__ . '\tour_programme', 11 );
function tour_programme() {
	if( get_field('programme') ) {
		$programme = get_field('programme'); ?>

		<a class="download-programme" href="<?php echo wp_get_attachment_url($programme['id']); ?>">Download Programm</a>

	<?php }
}


genesis();