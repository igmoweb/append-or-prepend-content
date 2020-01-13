<?php

class Test_Append_Or_Prepend_Archives extends AppOrPrependTestCase {

	function setUp() {
		global $id, $post;
		parent::setUp();
		set_current_screen( 'front' );
		$this->post_id = self::factory()->post->create();
		$this->go_to( '/search/test/' );
		$id = $post = $this->post_id;
		setup_postdata( $this->post_id );
	}

	function tearDown() {
		parent::tearDown();
		wp_reset_postdata();
	}

	/**
	 * Archives: ON
	 * Single: ON
	 */
	function test_content_is_appended_in_archives() {
		update_option( 'display_in_archive_post', 1 );
		update_option( 'display_in_single_post', 1 );
		$this->assertContains( $this->content_appended, apply_filters( 'the_content', '' ) );
	}

	/**
	 * Archives: ON
	 * Single: OFF
	 */
	function test_content_is_appended_in_archives_2() {
		update_option( 'display_in_archive_post', 1 );
		update_option( 'display_in_single_post', 0 );
		$this->assertContains( $this->content_appended, apply_filters( 'the_content', '' ) );
	}

	/**
	 * Archives: OFF
	 * Single: ON
	 */
	function test_content_is_NOT_appended_in_archives() {
		update_option( 'display_in_archive_post', 0 );
		update_option( 'display_in_single_post', 1 );
		$this->assertNotContains( $this->content_appended, apply_filters( 'the_content', '' ) );
	}

	/**
	 * Archives: OFF
	 * Single: OFF
	 */
	function test_content_is_NOT_appended_in_archives_2() {
		update_option( 'display_in_archive_post', 0 );
		update_option( 'display_in_single_post', 0 );
		$this->assertNotContains( $this->content_appended, apply_filters( 'the_content', '' ) );
	}
}
