<?php

/**
 * Search HTML markup structure
 *
 * @package   WindAndCloud2018
 * @since     1.0.0
 * @author    Kate Amann
 * @link      http://kateamann.com
 * @license   GNU General Public License 2.0+
 *
 */
namespace WindAndCloud2018;  

//* Customize search form input button text
add_filter( 'genesis_search_button_text', __NAMESPACE__ . '\search_button_text' );
function search_button_text( $text ) {
	return esc_attr( '&#xf002;' );
}

//* Customize search form input box text
add_filter( 'genesis_search_text', __NAMESPACE__ . '\search_text' );
function search_text( $text ) {
	return esc_attr( 'Search this website...' );
}