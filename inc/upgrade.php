<?php
/**
 * Upgrades routines.
 */

namespace AppOrPrepend\Admin;

use AppOrPrepend;
use AppOrPrepend\Content;
use AppOrPrepend\Meta;

const VERSION_OPTION = 'app_or_prep_version';

/**
 * Upgrade plugin database (just maybe)
 */
function maybe_upgrade() {
	$stored_version = get_option( VERSION_OPTION, '1.0' );
	update_option( VERSION_OPTION, AppOrPrepend\PLUGIN_VERSION );
	if ( version_compare( $stored_version, AppOrPrepend\PLUGIN_VERSION ) < 0 ) {
		$post_types = Content\get_allowed_post_types();
		foreach ( $post_types as $post_type ) {
			if ( 'attachment' === $post_type ) {
				continue;
			}

			$display_in_single  = get_option( 'display_in_single_' . $post_type );
			$display_in_archive = get_option( 'display_in_archive_' . $post_type );

			$append = get_option( 'append_' . $post_type );
			if ( ! empty( $append ) ) {
				$post_id = wp_insert_post(
					[
						'post_type'    => AppOrPrepend\PostType\POST_TYPE,
						'post_content' => $append,
						'post_status'  => 'publish',
					]
				);

				if ( ! is_wp_error( $post_id ) ) {
					update_post_meta( $post_id, Meta\SHOW_IN_ARCHIVE_META, (bool) $display_in_archive );
					update_post_meta( $post_id, Meta\SHOW_IN_SINGLE_META, (bool) $display_in_single );
					update_post_meta( $post_id, Meta\ACTION_META, 'append' );
					update_post_meta( $post_id, Meta\POST_TYPE_META, $post_type );
				}
			}

			$prepend = get_option( 'prepend_' . $post_type );
			if ( ! empty( $prepend ) ) {
				$post_id = wp_insert_post(
					[
						'post_type'    => AppOrPrepend\PostType\POST_TYPE,
						'post_content' => $prepend,
						'post_status'  => 'publish',
					]
				);

				if ( ! is_wp_error( $post_id ) ) {
					update_post_meta( $post_id, Meta\SHOW_IN_ARCHIVE_META, (bool) $display_in_archive );
					update_post_meta( $post_id, Meta\SHOW_IN_SINGLE_META, (bool) $display_in_single );
					update_post_meta( $post_id, Meta\ACTION_META, 'prepend' );
					update_post_meta( $post_id, Meta\POST_TYPE_META, $post_type );
				}
			}

			delete_option( 'display_in_archive_' . $post_type );
			delete_option( 'display_in_single_' . $post_type );
			delete_option( 'prepend_' . $post_type );
			delete_option( 'append_' . $post_type );
		}
	}
}
