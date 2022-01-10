<?php
/**
 * Manage admin options/menus.
 */

namespace AppOrPrepend\Admin;

use const AppOrPrepend\PostType\POST_TYPE;

/**
 * Inititialize hooks.
 */
function init() {
	add_action( 'admin_init', __NAMESPACE__ . '\\register_fields' );
}

/**
 * Register settings fields
 */
function register_fields() {
	add_settings_section(
		'apporprep_section',
		__( 'Append or Prepend Content', 'apporprepp' ),
		__NAMESPACE__ . '\\render_option',
		'writing'
	);
}

/**
 * Render the writing option.
 */
function render_option() {
	$view_link = admin_url( 'edit.php?post_type=' . POST_TYPE );
	$new_link  = admin_url( 'post-new.php?post_type=' . POST_TYPE );
	?>
	<table class="form-table" role="presentation">
		<tbody>
		<tr>
			<th scope="row">
				<?php esc_html_e( 'View current appended/prepended content', 'apporprepp' ); ?>
			</th>
			<td>
				<a class="button" href="<?php echo esc_url( $view_link ); ?>" style="margin-right:10px;">
					<?php esc_html_e( 'View', 'apporprepp' ); ?>
				</a>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<?php esc_html_e( 'Add new content to append/prepend', 'apporprepp' ); ?>
			</th>
			<td>
				<a class="button" href="<?php echo esc_url( $new_link ); ?>" style="margin-right:10px;">
					<?php esc_html_e( 'Add new', 'apporprepp' ); ?>
				</a>
			</td>
		</tr>
		</tbody>
	</table>
	<?php
}
