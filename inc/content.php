<?php
/**
 * Manage content appending/prepending.
 */

namespace AppOrPrepend\Content;

use AppOrPrepend\PostType;
use AppOrPrepend\Meta;

/**
 * Hooks initialization.
 */
function init() {
	if ( is_admin() ) {
		return;
	}

	add_filter( 'the_content', __NAMESPACE__ . '\\add_content' );
}

/**
 * List of allowed post types to append/prepend content.
 *
 * @return array
 */
function get_allowed_post_types(): array {
	$types = array_filter(
		get_post_types( array( 'public' => true ), 'objects' ),
		function( $post_type ) {
			return ( is_post_type_viewable( $post_type ) && 'attachment' !== $post_type->name );
		}
	);

	return wp_list_pluck( $types, 'name' );
}

/**
 * Display content before or after
 *
 * @param mixed $content The post content.
 *
 * @return mixed
 */
function add_content( $content ) {

	if ( ! apply_filters( 'app_or_prepend.display_content', true ) ) {
		return $content;
	}

	$post      = get_post();
	$post_type = get_post_type( $post );

	$all_app_or_prepend_posts = get_posts(
		[
			'posts_per_page' => - 1,
			'post_type'      => PostType\POST_TYPE,
		]
	);

	$is_archive = is_archive() || is_search() || is_home();
	$is_single  = is_singular( $post_type );

	foreach ( $all_app_or_prepend_posts as $app_or_prep_post ) {
		$meta           = Meta\get_post_apporprepend_meta( $app_or_prep_post->ID );
		$post_type_meta = $meta[ Meta\POST_TYPE_META ];

		if ( $post_type_meta === $post_type ) {

			if ( $is_archive && ! $meta[ Meta\SHOW_IN_ARCHIVE_META ] ) {
				continue;
			}

			if ( $is_single && ! $meta[ Meta\SHOW_IN_SINGLE_META ] ) {
				continue;
			}

			$action = $meta[ Meta\ACTION_META ];

			setup_postdata( $app_or_prep_post->ID );

			ob_start();
			add_filter( 'app_or_prepend.display_content', '__return_false' );
			the_content();
			add_filter( 'app_or_prepend.display_content', '__return_true' );
			$extra_content = ob_get_clean();

			wp_reset_postdata();

			$content = $action === 'prepend' ? $extra_content . $content : $content . $extra_content;
		}
	}

	return $content;
}
