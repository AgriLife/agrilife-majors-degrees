<?php
namespace AgriLife\MajorsDegrees;

/**
 * Builds and registers a custom taxonomy
 */

class Taxonomy {

	/**
	 * Builds and registers the custom taxonomy
	 */
	public function __construct($name, $slug, $post_slug, $tag, $user_args = array()) {

		$singular = $name;
		$plural = $name . 's';

		// Taxonomy labels
		$labels = array(
			'name' => __( $plural, $tag ),
			'singular_name' => __( $singular, $tag ),
			'search_items' => __( 'Search ' . $plural, $tag ),
			'all_items' => __( 'All ' . $plural, $tag ),
			'parent_item' => __( 'Parent ' . $singular, $tag ),
			'parent_item_colon' => __( 'Parent ' . $singular . ':', $tag ),
			'edit_item' => __( 'Edit ' . $singular, $tag ),
			'update_item' => __( 'Update ' . $singular, $tag ),
			'add_new_item' => __( 'Add New ' . $singular, $tag ),
			'new_item_name' => __( 'New ' . $singular . ' Name', $tag ),
			'menu_name' => __( $plural, $tag ),
		);

		// Taxonomy arguments
		$args = array_merge(
			array(
				'labels' => $labels,
				'hierarchical' => true,
				'show_ui' => true,
				'show_admin_column' => true,
				'rewrite' => array( 'slug' )
			),
			$user_args
		);

		// Register the Type taxonomy
		register_taxonomy( $slug, $post_slug, $args );

	}

}
