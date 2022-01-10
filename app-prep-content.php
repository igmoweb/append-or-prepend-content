<?php
/**
 * Plugin Name: Append or Prepend Content
 * Description: Add content before or after every post, page or Custom Post Type
 * Plugin URI: https://wordpress.org/plugins/append-or-prepend-content
 * Version: %%version%%
 * Author: igmoweb
 * Author URI: http://igmoweb.com
 * Text Domain: apporprepp
 * Domain path: /languages
 * License: GPLv2 or later (license.txt)
 */

namespace AppOrPrepend;

use AppOrPrepend\PostType;
use AppOrPrepend\Meta;
use AppOrPrepend\Editor;
use AppOrPrepend\Content;

/**
 * Plugin initialization.
 */
function init() {
	include_once plugin_dir_path( __FILE__ ) . '/inc/content.php';
	include_once plugin_dir_path( __FILE__ ) . '/inc/meta.php';
	include_once plugin_dir_path( __FILE__ ) . '/inc/post-type.php';
	include_once plugin_dir_path( __FILE__ ) . '/inc/editor.php';

	add_action( 'plugins_loaded', __NAMESPACE__ . '\\load_text_domain', 50 );

	Content\init();
	Meta\init();
	PostType\init();
	Editor\init();
}

/**
 * Load the plugin text domain
 */
function load_text_domain() {
	load_plugin_textdomain( 'apporprepp', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
}

/**
 * Retrieve the plugin URL.
 *
 * @return string
 */
function app_or_prep_url(): string {
	return plugin_dir_url( __FILE__ );
}

/**
 * Retrieve the plugin absolute path.
 *
 * @return string
 */
function app_or_prep_dir(): string {
	return plugin_dir_path( __FILE__ );
}

init();
