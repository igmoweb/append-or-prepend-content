<?php
/**
 * Manage post types registration and
 */

namespace AppOrPrepend\PostType;

use AppOrPrepend\Meta;

const POST_TYPE = 'append_or_prepend';

/**
 * Hooks initialization.
 */
function init() {
	add_action( 'init', __NAMESPACE__ . '\\register' );
	add_filter( 'the_title', __NAMESPACE__ . '\\parse_post_title', 10, 2 );
}

/**
 * Register Company taxonomy
 */
function register() {
	register_post_type(
		POST_TYPE,
		array(
			'description'         => 'Allow appending or prepending content for any post type',
			'labels'              => array(
				'name'               => _x( 'Append or Prepend Content', 'post type general name', 'apporprepp' ),
				'singular_name'      => _x( 'Append or Prepend Content', 'post type singular name', 'apporprepp' ),
				'menu_name'          => _x( 'Append Content', 'admin menu', 'apporprepp' ),
				'name_admin_bar'     => _x( 'Append or Prepend Content', 'add new post-type on admin bar', 'apporprepp' ),
				'add_new'            => _x( 'Add New', 'post_type', 'apporprepp' ),
				'add_new_item'       => __( 'Add New Append or Prepend Content', 'apporprepp' ),
				'edit_item'          => __( 'Edit Append or Prepend Content', 'apporprepp' ),
				'new_item'           => __( 'New Append or Prepend Content', 'apporprepp' ),
				'view_item'          => __( 'View Append or Prepend Content', 'apporprepp' ),
				'search_items'       => __( 'Search Append or Prepend Content', 'apporprepp' ),
				'not_found'          => __( 'No posts found.', 'apporprepp' ),
				'not_found_in_trash' => __( 'No posts found in Trash.', 'apporprepp' ),
				'parent_item_colon'  => __( 'Parent Append or Prepend Content:', 'apporprepp' ),
				'all_items'          => __( 'All Append or Prepend Contents', 'apporprepp' ),
			),
			'public'              => false,
			'hierarchical'        => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => false,
			'show_in_admin_bar'   => false,
			'menu_position'       => null,
			'menu_icon'           => null,
			'capability_type'     => 'post',
			'supports'            => array( 'editor', 'custom-fields' ),
			'taxonomies'          => array(),
			'has_archive'         => false,
			'query_var'           => false,
			'can_export'          => true,
			'show_in_rest'        => true,
		)
	);
}

/**
 * Parse the post title based on the Append or Prepend options selected in the editor.
 *
 * @param string  $title Post title.
 * @param integer $post_id Post ID.
 */
function parse_post_title( string $title, int $post_id ): string {
	if ( get_post_type( $post_id ) !== POST_TYPE ) {
		return $title;
	}

	$action         = Meta\get_post_apporprepend_meta( $post_id )[ Meta\ACTION_META ];
	$post_type_meta = Meta\get_post_apporprepend_meta( $post_id )[ Meta\POST_TYPE_META ];

	if ( ! $post_type_meta || ! $action ) {
		return '⚠️ No action or post type selected!';
	}

	return "$action for $post_type_meta";
}
