<?php
/**
 * Manage metadata registration and validation.
 */

namespace AppOrPrepend\Meta;

use AppOrPrepend\PostType;

const ACTION_META          = 'apporprep_action';
const POST_TYPE_META       = 'apporprep_post_type';
const SHOW_IN_ARCHIVE_META = 'apporprep_show_in_archive';
const SHOW_IN_SINGLE_META  = 'apporprep_show_in_single';

/**
 * Plugin initialization.
 */
function init() {
	add_action( 'init', __NAMESPACE__ . '\\register_meta' );
}

/**
 * Register meta fields.
 */
function register_meta() {
	register_post_meta(
		PostType\POST_TYPE,
		ACTION_META,
		array(
			'show_in_rest'      => true,
			'single'            => true,
			'type'              => 'string',
			'sanitize_callback' => __NAMESPACE__ . '\\sanitize_action',
			'default'           => '',
		)
	);

	register_post_meta(
		PostType\POST_TYPE,
		POST_TYPE_META,
		array(
			'show_in_rest'      => true,
			'single'            => true,
			'type'              => 'string',
			'sanitize_callback' => __NAMESPACE__ . '\\sanitize_post_type',
			'default'           => '',
		)
	);

	register_post_meta(
		PostType\POST_TYPE,
		SHOW_IN_ARCHIVE_META,
		array(
			'show_in_rest'      => true,
			'single'            => true,
			'type'              => 'boolean',
			'sanitize_callback' => 'rest_sanitize_boolean',
			'default'           => false,
		)
	);

	register_post_meta(
		PostType\POST_TYPE,
		SHOW_IN_SINGLE_META,
		array(
			'show_in_rest'      => true,
			'single'            => true,
			'type'              => 'boolean',
			'sanitize_callback' => 'rest_sanitize_boolean',
			'default'           => true,
		)
	);
}

/**
 * Sanitize the action meta value.
 *
 * @param mixed $value Action value to sanitize.
 *
 * @return string
 */
function sanitize_action( $value ): string {
	if ( ! in_array( $value, array( 'append', 'prepend' ), true ) ) {
		return '';
	}
	return $value;
}

/**
 * Sanitize the post type meta value.
 *
 * @param mixed $value Post type to be sanitized.
 *
 * @return mixed|string
 */
function sanitize_post_type( $value ) {
	$types = array_filter(
		get_post_types( array( 'show_in_rest' => true ), 'objects' ),
		function( $post_type ) {
			return ( is_post_type_viewable( $post_type ) && 'attachment' !== $post_type->name );
		}
	);

	return in_array( $value, wp_list_pluck( $types, 'name' ), true ) ? $value : '';
}

/**
 * Get a list of metadata for the append or prepend post type.
 *
 * @param int $post_id Post ID.
 *
 * @return array
 */
function get_post_apporprepend_meta( int $post_id ): array {
	return array(
		SHOW_IN_ARCHIVE_META => (bool) get_post_meta( $post_id, SHOW_IN_ARCHIVE_META, true ),
		SHOW_IN_SINGLE_META  => (bool) get_post_meta( $post_id, SHOW_IN_SINGLE_META, true ),
		ACTION_META          => get_post_meta( $post_id, ACTION_META, true ),
		POST_TYPE_META       => get_post_meta( $post_id, POST_TYPE_META, true ),
	);
}
