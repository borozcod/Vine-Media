<?php
/**
 * Include and setup custom metaboxes and fields. (make sure you copy this file to outside the CMB2 directory)
 *
 * Be sure to replace all instances of 'vine_media_' with your project's prefix.
 * http://nacin.com/2010/05/11/in-wordpress-prefix-everything/
 *
 * @category YourThemeOrPlugin
 * @package  Demo_CMB2
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/CMB2/CMB2
 */

/**
 * Get the bootstrap! If using the plugin from wordpress.org, REMOVE THIS!
 */

if ( file_exists( dirname( __FILE__ ) . '/cmb2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/cmb2/init.php';
} elseif ( file_exists( dirname( __FILE__ ) . '/CMB2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/CMB2/init.php';
}

/**
 * Conditionally displays a metabox when used as a callback in the 'show_on_cb' cmb2_box parameter
 *
 * @param  CMB2 $cmb CMB2 object.
 *
 * @return bool      True if metabox should show
 */
function vine_media_show_if_front_page( $cmb ) {
	// Don't show this metabox if it's not the front page template.
	if ( get_option( 'page_on_front' ) !== $cmb->object_id ) {
		return false;
	}
	return true;
}

/**
 * Conditionally displays a field when used as a callback in the 'show_on_cb' field parameter
 *
 * @param  CMB2_Field $field Field object.
 *
 * @return bool              True if metabox should show
 */
function vine_media_hide_if_no_cats( $field ) {
	// Don't show this field if not in the cats category.
	if ( ! has_tag( 'cats', $field->object_id ) ) {
		return false;
	}
	return true;
}

/**
 * Manually render a field.
 *
 * @param  array      $field_args Array of field arguments.
 * @param  CMB2_Field $field      The field object.
 */
function vine_media_render_row_cb( $field_args, $field ) {
	$classes     = $field->row_classes();
	$id          = $field->args( 'id' );
	$label       = $field->args( 'name' );
	$name        = $field->args( '_name' );
	$value       = $field->escaped_value();
	$description = $field->args( 'description' );
	?>
	<div class="custom-field-row <?php echo esc_attr( $classes ); ?>">
		<p><label for="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $label ); ?></label></p>
		<p><input id="<?php echo esc_attr( $id ); ?>" type="text" name="<?php echo esc_attr( $name ); ?>" value="<?php echo $value; ?>"/></p>
		<p class="description"><?php echo esc_html( $description ); ?></p>
	</div>
	<?php
}

/**
 * Manually render a field column display.
 *
 * @param  array      $field_args Array of field arguments.
 * @param  CMB2_Field $field      The field object.
 */
function vine_media_display_text_small_column( $field_args, $field ) {
	?>
	<div class="custom-column-display <?php echo esc_attr( $field->row_classes() ); ?>">
		<p><?php echo $field->escaped_value(); ?></p>
		<p class="description"><?php echo esc_html( $field->args( 'description' ) ); ?></p>
	</div>
	<?php
}

/**
 * Conditionally displays a message if the $post_id is 2
 *
 * @param  array      $field_args Array of field parameters.
 * @param  CMB2_Field $field      Field object.
 */
function vine_media_before_row_if_2( $field_args, $field ) {
	if ( 2 == $field->object_id ) {
		echo '<p>Testing <b>"before_row"</b> parameter (on $post_id 2)</p>';
	} else {
		echo '<p>Testing <b>"before_row"</b> parameter (<b>NOT</b> on $post_id 2)</p>';
	}
}

add_action( 'cmb2_admin_init', 'vine_media_register_theme_options_metabox' );
/**
 * Hook in and register a metabox to handle a theme options page and adds a menu item.
 */
function vine_media_register_theme_options_metabox() {

	/**
	 * Registers options page menu item and form.
	 */
	$cmb_options = new_cmb2_box( array(
		'id'           => 'vine_media_theme_options_page',
		'title'        => esc_html__( 'Series Metrics', 'cmb2' ),
		'object_types' => array( 'options-page' ),

		/*
		 * The following parameters are specific to the options-page box
		 * Several of these parameters are passed along to add_menu_page()/add_submenu_page().
		 */

		'option_key'      => 'vine_media_theme_options', // The option key and admin menu page slug.
		'icon_url'        => 'dashicons-chart-area', // Menu icon. Only applicable if 'parent_slug' is left empty.
		// 'menu_title'      => esc_html__( 'Options', 'cmb2' ), // Falls back to 'title' (above).
		// 'parent_slug'     => 'themes.php', // Make options page a submenu item of the themes menu.
		// 'capability'      => 'manage_options', // Cap required to view options-page.
		// 'position'        => 1, // Menu position. Only applicable if 'parent_slug' is left empty.
		// 'admin_menu_hook' => 'network_admin_menu', // 'network_admin_menu' to add network-level options page.
		// 'display_cb'      => false, // Override the options-page form output (CMB2_Hookup::options_page_output()).
		// 'save_button'     => esc_html__( 'Save Theme Options', 'cmb2' ), // The text for the options-page save button. Defaults to 'Save'.
		// 'disable_settings_errors' => true, // On settings pages (not options-general.php sub-pages), allows disabling.
		// 'message_cb'      => 'vine_media_options_page_message_callback',
	) );

	/**
	 * Options fields ids only need
	 * to be unique within this box.
	 * Prefix is not needed.
	 */
	$cmb_options->add_field( array(
		'name'    => esc_html__( 'Site Background Color', 'cmb2' ),
		'desc'    => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'      => 'bg_color',
		'type'    => 'colorpicker',
		'default' => '#ffffff',
	) );

}

/**
 * Callback to define the optionss-saved message.
 *
 * @param CMB2  $cmb The CMB2 object.
 * @param array $args {
 *     An array of message arguments
 *
 *     @type bool   $is_options_page Whether current page is this options page.
 *     @type bool   $should_notify   Whether options were saved and we should be notified.
 *     @type bool   $is_updated      Whether options were updated with save (or stayed the same).
 *     @type string $setting         For add_settings_error(), Slug title of the setting to which
 *                                   this error applies.
 *     @type string $code            For add_settings_error(), Slug-name to identify the error.
 *                                   Used as part of 'id' attribute in HTML output.
 *     @type string $message         For add_settings_error(), The formatted message text to display
 *                                   to the user (will be shown inside styled `<div>` and `<p>` tags).
 *                                   Will be 'Settings updated.' if $is_updated is true, else 'Nothing to update.'
 *     @type string $type            For add_settings_error(), Message type, controls HTML class.
 *                                   Accepts 'error', 'updated', '', 'notice-warning', etc.
 *                                   Will be 'updated' if $is_updated is true, else 'notice-warning'.
 * }
 */
function vine_media_options_page_message_callback( $cmb, $args ) {
	if ( ! empty( $args['should_notify'] ) ) {

		if ( $args['is_updated'] ) {

			// Modify the updated message.
			$args['message'] = sprintf( esc_html__( '%s &mdash; Updated!', 'cmb2' ), $cmb->prop( 'title' ) );
		}

		add_settings_error( $args['setting'], $args['code'], $args['message'], $args['type'] );
	}
}

/**
 * Only show this box in the CMB2 REST API if the user is logged in.
 *
 * @param  bool                 $is_allowed     Whether this box and its fields are allowed to be viewed.
 * @param  CMB2_REST_Controller $cmb_controller The controller object.
 *                                              CMB2 object available via `$cmb_controller->rest_box->cmb`.
 *
 * @return bool                 Whether this box and its fields are allowed to be viewed.
 */
function vine_media_limit_rest_view_to_logged_in_users( $is_allowed, $cmb_controller ) {
	if ( ! is_user_logged_in() ) {
		$is_allowed = false;
	}

	return $is_allowed;
}

add_action( 'cmb2_init', 'vine_media_register_rest_api_box' );
/**
 * Hook in and add a box to be available in the CMB2 REST API. Can only happen on the 'cmb2_init' hook.
 * More info: https://github.com/CMB2/CMB2/wiki/REST-API
 */
function vine_media_register_rest_api_box() {
	$prefix = 'vine_media_rest_';

	$cmb_rest = new_cmb2_box( array(
		'id'            => 'sermons_metabox',
		'title'         => esc_html__( 'Sermons', 'vine_media' ),
		'object_types'  => array( 'serie' ), // Post type
		'show_in_rest' => WP_REST_Server::ALLMETHODS, // WP_REST_Server::READABLE|WP_REST_Server::EDITABLE, // Determines which HTTP methods the box is visible in.
		// Optional callback to limit box visibility.
		// See: https://github.com/CMB2/CMB2/wiki/REST-API#permissions
		// 'get_box_permissions_check_cb' => 'vine_media_limit_rest_view_to_logged_in_users',
	) );

	$group_field_id = $cmb_rest->add_field( array(
		'id'          => 'sermons',
		'type'        => 'group',
		'description' => esc_html__( 'Add sermons for this series', 'vine_media' ),
		'options'     => array(
			'group_title'   => esc_html__( 'Entry {#}', 'vine_media' ), // {#} gets replaced by row number
			'add_button'    => esc_html__( 'Add Another Sermon', 'vine_media' ),
			'remove_button' => esc_html__( 'Remove Sermon', 'vine_media' ),
			'sortable'      => true,
			// 'closed'     => true, // true to have the groups closed by default
		),
	) );

	$cmb_rest->add_group_field( $group_field_id, array(
		'name'       => esc_html__( 'Sermon Title', 'vine_media' ),
		'id'         => 'sermon_title',
		'type'       => 'text',
		'show_in_rest' => WP_REST_Server::EDITABLE,// WP_REST_Server::ALLMETHODS|WP_REST_Server::READABLE, // Determines which HTTP methods the field is visible in. Will override the cmb2_box 'show_in_rest' param.
		// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
	) );

	$cmb_rest->add_group_field( $group_field_id, array(
		'name'       => esc_html__( 'Sermon Video', 'vine_media' ),
		'id'         => 'sermon_video_link',
		'type'       => 'text',
		'show_in_rest' => WP_REST_Server::EDITABLE,// WP_REST_Server::ALLMETHODS|WP_REST_Server::READABLE, // Determines which HTTP methods the field is visible in. Will override the cmb2_box 'show_in_rest' param.
		// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
	) );

	$cmb_rest->add_group_field( $group_field_id, array(
		'name' => esc_html__( 'Sermon Thumbnail', 'vine_media' ),
		'id'   => 'sermon_thumbnail',
		'type' => 'file',
	) );

	$cmb_rest->add_group_field(  $group_field_id, array(
		'name'             => esc_html__( 'Select Speaker', 'vine_media' ),
		'desc'             => esc_html__( 'field description (optional)', 'vine_media' ),
		'id'               => 'sermon_speaker',
		'type'             => 'select',
		'show_option_none' => true,
		'options'          => array(
			'standard' => esc_html__( 'Speaker 1', 'vine_media' ),
			'custom'   => esc_html__( 'Speaker 2', 'vine_media' ),
			'none'     => esc_html__( 'Speaker 3', 'vine_media' ),
		),
	) );

	$cmb_rest->add_group_field(  $group_field_id, array(
		'name'             => esc_html__( 'Select Location', 'vine_media' ),
		'desc'             => esc_html__( 'field description (optional)', 'vine_media' ),
		'id'               => 'sermon_location',
		'type'             => 'select',
		'show_option_none' => true,
		'options'          => array(
			'standard' => esc_html__( 'Speaker 1', 'vine_media' ),
			'custom'   => esc_html__( 'Speaker 2', 'vine_media' ),
			'none'     => esc_html__( 'Speaker 3', 'vine_media' ),
		),
	) );
}
