<?php
add_action( 'init', 'serie_init' );
/**
 * Register a serie post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function serie_init() {
	$labels = array(
		'name'               => _x( 'Series', 'post type general name', 'vine_media' ),
		'singular_name'      => _x( 'Series', 'post type singular name', 'vine_media' ),
		'menu_name'          => _x( 'Series', 'admin menu', 'vine_media' ),
		'name_admin_bar'     => _x( 'Series', 'add new on admin bar', 'vine_media' ),
		'add_new'            => _x( 'Add New', 'series', 'vine_media' ),
		'add_new_item'       => __( 'Add New Series', 'vine_media' ),
		'new_item'           => __( 'New Series', 'vine_media' ),
		'edit_item'          => __( 'Edit Series', 'vine_media' ),
		'view_item'          => __( 'View Series', 'vine_media' ),
		'all_items'          => __( 'All Series', 'vine_media' ),
		'search_items'       => __( 'Search Series', 'vine_media' ),
		'parent_item_colon'  => __( 'Parent Series:', 'vine_media' ),
		'not_found'          => __( 'No series found.', 'vine_media' ),
		'not_found_in_trash' => __( 'No series found in Trash.', 'vine_media' )
	);

	$args = array(
		'labels'             => $labels,
        'description'        => __( 'Description.', 'vine_media' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'series' ),
		'capability_type'    => 'serie',
		'has_archive'        => true,
        'show_in_rest'       => true,
        'rest_base'          => 'series',
        'menu_icon'          => 'dashicons-video-alt',
		'menu_position'      => null,
		'supports'           => array( 'title', 'thumbnail' ),
        'map_meta_cap'       => true
	);

	register_post_type( 'series', $args );
}

function series_rewrite() {
    serie_init();
    flush_rewrite_rules();
}
