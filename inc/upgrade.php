<?php
/**
 * Upgrades routines.
 */

namespace AppOrPrepend\Admin;

use AppOrPrepend;

const VERSION_OPTION = 'app_or_prep_version';

/**
 * Upgrade plugin database (just maybe)
 */
function maybe_upgrade() {
	$stored_version = get_option( VERSION_OPTION, '1.0' );

	if ( version_compare( $stored_version, AppOrPrepend\PLUGIN_VERSION ) < 0 ) {
		$post_types = get_post_types( array( 'public' => true ), 'objects' );
		foreach ( $post_types as $post_type ) {

			$display_in_single  = get_option( 'display_in_single_' . $post_type->name );
			$display_in_archive = get_option( 'display_in_archive_' . $post_type->name );
			var_dump( $display_in_single );
			var_dump( $display_in_archive );

			$append  = get_option( 'append_' . $post_type->name );
			$prepend = get_option( 'prepend_' . $post_type->name );
			var_dump( $append );
			var_dump( $prepend );
		}
		die();
	}
}
