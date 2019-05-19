<?php

/**
 * Manage all the plugin admin side
 */
class AppOrPrepp_Admin {

	public function __construct() {
		add_action( 'admin_init', array( $this, 'register_fields' ) );
	}

	public function register_fields() {
		add_settings_section(
			'apporprep_section',
			__( 'Append or Prepend Content Settings', 'apporprepp' ),
			array( $this, 'header_html' ),
			'writing'
		);

		$post_types = get_post_types( array( 'public' => true ), 'objects' );
		foreach ( $post_types as $post_type => $object ) {
			if ( 'attachment' === $post_type ) {
				continue;
			}

			add_settings_field(
				'prepend_' . $post_type,
				'<label for="prepend_' . $post_type . '">' . sprintf( _x( 'Prepend content to %s', '%s is the post type', 'apporprepp' ), $object->labels->name ) . '</label>',
				array( $this, 'prepend_html' ),
				'writing',
				'apporprep_section',
				array( 'post_type' => $post_type )
			);

			add_settings_field(
				'append_' . $post_type,
				'<label for="prepend_' . $post_type . '">' . sprintf( _x( 'Append content to %s', '%s is the post type', 'apporprepp' ), $object->labels->name ) . '</label>',
				array( $this, 'append_html' ),
				'writing',
				'apporprep_section',
				array( 'post_type' => $post_type )
			);

			add_settings_field(
				'display_in_archive_' . $post_type,
				'<label for="display_in_archive_' . $post_type . '">' . sprintf( _x( 'Display content for %s in the archive, search or author pages', '%s is the post type', 'apporprepp' ), $object->labels->name ) . '</label>',
				array( $this, 'display_in_archive' ),
				'writing',
				'apporprep_section',
				array( 'post_type' => $post_type )
			);

			add_settings_field(
				'apporprep_separator_' . $post_type,
				'',
				array( $this, 'separator' ),
				'writing',
				'apporprep_section'
			);

			register_setting(
				'writing',
				'prepend_' . $post_type,
				array( $this, 'validate' )
			);

			register_setting(
				'writing',
				'append_' . $post_type,
				array( $this, 'validate' )
			);

			register_setting(
				'writing',
				'display_in_archive_' . $post_type,
				array( $this, 'validate_display' )
			);
		}

	}

	public function header_html() {
		?>
		<p><?php _e( 'Allows you to append or prepend content to any Post Type on your site. Shortcodes allowed.', 'apporprepp' ); ?></p>
		<?php

	}

	public function separator() {
		?>
		<hr>
		<?php
	}

	/**
	 * HTML for extra settings
	 */
	public function prepend_html( $args ) {
		$post_type = $args['post_type'];
		$value     = get_option( 'prepend_' . $post_type, '' );
		wp_editor(
			$value,
			'prepend_' . $post_type,
			array(
				'quicktags'     => true,
				'media_buttons' => true,
				'textarea_rows' => 8,
				'teeny'         => true,
			)
		);
	}

	public function display_in_archive( $args ) {
		$post_type = $args['post_type'];
		$value     = get_option( 'display_in_archive_' . $post_type, true );
		?>
		<input type="checkbox" name="display_in_archive_<?php echo esc_attr( $post_type ); ?>" <?php checked( $value ); ?>>
		<?php
	}

	public function append_html( $args ) {
		$post_type = $args['post_type'];
		$value     = get_option( 'append_' . $post_type, '' );
		wp_editor(
			$value,
			'append_' . $post_type,
			array(
				'quicktags'     => true,
				'media_buttons' => true,
				'textarea_rows' => 8,
				'teeny'         => true,
			)
		);
	}

	public function validate( $value ) {
		$value = wp_kses( $value, wp_kses_allowed_html( 'post' ) );
		return $value;
	}

	public function validate_display( $value ) {
		return (bool) $value;
	}
}
