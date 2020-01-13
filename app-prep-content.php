<?php // phpcs:ignore WordPress.Files.FileName.InvalidClassFileName

/**
 * Plugin Name: Append or Prepend Content
 * Description: Add content before or after every post, page or Custom Post Type
 * Plugin URI: https://wordpress.org/plugins/app-prep-content
 * Version: %%version%%
 * Author: igmoweb
 * Author URI: http://igmoweb.com
 * Text Domain: apporprepp
 * Domain path: /languages
 * License: GPLv2 or later (license.txt)
 */
class AppOrPrepp {

	/**
	 * Plugin instance.
	 *
	 * @var AppOrPrepp
	 */
	private static $instance;

	/**
	 * Get a single instance of the plugin.
	 *
	 * @return AppOrPrepp
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * AppOrPrepp constructor.
	 */
	public function __construct() {
		if ( is_admin() ) {
			include_once plugin_dir_path( __FILE__ ) . '/class-apporprepp-admin.php';
			new AppOrPrepp_Admin();
		}

		add_filter( 'the_content', [ $this, 'the_content' ] );

		add_action( 'plugins_loaded', [ $this, 'load_text_domain' ], 50 );
	}

	/**
	 * Load the plugin text domain
	 */
	public function load_text_domain() {
		load_plugin_textdomain( 'apporprepp', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
	}

	/**
	 * Display content before or after
	 *
	 * @param string $content The post content.
	 *
	 * @return string
	 */
	public function the_content( $content ) {
		$post      = get_post();
		$post_type = get_post_type( $post );

		if ( is_archive() || is_search() ) {
			$display_in_archive = absint( get_option( 'display_in_archive_' . $post_type, 1 ) );
			if ( ! $display_in_archive ) {
				return $content;
			}
		}

		$display_in_single = absint( get_option( 'display_in_single_' . $post_type, 1 ) );
		if ( is_singular( $post_type ) && ! $display_in_single ) {
			return $content;
		}

		if ( ! apply_filters( 'app_or_prepend.display_content', true ) ) {
			return $content;
		}

		$prepend = get_option( 'prepend_' . $post_type, '' );
		$append  = get_option( 'append_' . $post_type, '' );

		if ( $prepend ) {
			$content = wpautop( $prepend ) . $content;
		}

		if ( $append ) {
			$content = $content . wpautop( $append );
		}

		return $content;
	}
}

add_action( 'plugins_loaded', 'app_or_prepp' );
/**
 * Return the plugin instance
 *
 * @return AppOrPrepp
 */
function app_or_prepp() {
	return AppOrPrepp::get_instance();
}
