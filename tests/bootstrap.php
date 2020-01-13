<?php
/**
 * PHPUnit bootstrap file
 *
 * @package Wp_Harvest
 */


$_tests_dir = 'vendor/wp-phpunit/wp-phpunit';
define( 'WP_TESTS_CONFIG_FILE_PATH', dirname( __FILE__ ) . '/wp-tests-config.php' );

// Give access to tests_add_filter() function.
require_once $_tests_dir . '/includes/functions.php';

/**
 * Manually load plugins/themes
 */
function _manually_load_plugin() {
	require 'app-prep-content.php';
	app_or_prepp();
}
tests_add_filter( 'muplugins_loaded', '_manually_load_plugin' );

// Start up the WP testing environment.
require $_tests_dir . '/includes/bootstrap.php';


/**
 * Sample test case.
 */
class AppOrPrependTestCase extends WP_UnitTestCase {
	protected $content_appended = 'content-appended';
	protected $post_id;
	function setUp() {
		parent::setUp();
		update_option( 'append_post', $this->content_appended );
		$this->set_permalink_structure( '/%year%/%monthnum%/%day%/%postname%/' );
	}
}
