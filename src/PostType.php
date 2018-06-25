<?php
namespace AgriLife\MajorsDegrees;

/**
 * Builds and registers a custom post type
 */

class PostType {

  /**
   * Dequeues global styles
   * @since 1.1.0
   * @string $name
   * @array $taxonomy
   * @string $tag
   * @string $icon
   * @array $supports
   * @return void
   */
	public function __construct( $name, $slug, $tag, $taxonomies = array( 'category', 'post_tag' ), $icon = 'dashicons-portfolio', $supports = array( 'title' ) ) {

		$singular = $name;
		$plural = $name . 's';

		// Backend labels
		$labels = array(
			'name' => __( $plural, $tag ),
			'singular_name' => __( $plural, $tag ),
			'add_new' => __( 'Add New', $tag ),
			'add_new_item' => __( 'Add New ' . $singular, $tag ),
			'edit_item' => __( 'Edit ' . $singular, $tag ),
			'new_item' => __( 'New ' . $singular, $tag ),
			'view_item' => __( 'View ' . $singular, $tag ),
			'search_items' => __( 'Search ' . $plural, $tag ),
			'not_found' => __( 'No ' . $plural . ' Found', $tag ),
			'not_found_in_trash' => __( 'No ' . $plural . ' found in trash', $tag ),
			'parent_item_colon' => '',
			'menu_name' => __( $plural, $tag ),
		);

		// Post type arguments
		$args = array(
			'labels' => $labels,
			'public' => true,
			'show_ui' => true,
			'rewrite' => array(
				'with_front' => false,
				'slug' => $slug
			),
			'supports' => $supports,
			'has_archive' => true,
			'menu_icon' => $icon,
			'publicly_queryable' => true,
			'taxonomies' => $taxonomies
		);

		// Register the Reports post type
		register_post_type( $slug, $args );

	}

}
