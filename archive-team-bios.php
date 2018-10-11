<?php

/**
 * Team page HTML markup structure
 *
 * @package   WindAndCloud2018
 * @since     1.0.0
 * @author    Kate Amann
 * @link      http://kateamann.com
 * @license   GNU General Public License 2.0+
 *
 */
namespace WindAndCloud2018;



//* Show full text
add_filter( 'genesis_pre_get_option_content_archive_limit', __NAMESPACE__ . '\team_archive_content_limit' );
function team_archive_content_limit() {
		return 0;
}


genesis();