<?php
/**
 * Manage editor assets.
 */

namespace AppOrPrepend\Editor;

use AppOrPrepend;

/**
 * Hooks initialization.
 */
function init() {
	add_action( 'enqueue_block_editor_assets', __NAMESPACE__ . '\\enqueue_editor_assets' );
}

/**
 * Enqueue editor assets.
 */
function enqueue_editor_assets() {
	$asset_file = include AppOrPrepend\app_or_prep_dir() . 'build/index.asset.php';
	$deps       = array_merge( $asset_file['dependencies'], array( 'wp-element', 'wp-plugins', 'wp-element' ) );
	wp_enqueue_script(
		'apporprepend-editor',
		AppOrPrepend\app_or_prep_url() . '/build/index.js',
		$deps,
		$asset_file['version'],
		true
	);
}
