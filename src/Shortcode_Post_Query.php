<?php
namespace AgriLife\MajorsDegrees;

/**
 * Static methods for often-used queries
 * @package AgriLife Majors and Degrees
 * @since 1.0.0
 */
class Shortcode_Post_Query {

	/**
	 * Queries for people with some smart defaults
	 * @param	 string $type	  The type taxonomy slug to filter (optional)
	 * @param	 string $search The search term (optional)
	 * @return object				  A WP_Query object with the results
	 */
	public static function get_posts( $post_type = 'posts', $atts = array(), $taxonomy = array() ) {

		// Set default arguments for every People query
		$args = array(
			'post_type'			 => $post_type,
			'post_status'		 => 'any',
			'posts_per_page' => -1,
			'orderby'			   => 'title',
			'order'					 => 'ASC'
		);

		if( !empty( $atts ) && !empty( $taxonomy ) ){

			$args['tax_query'] = array();

			foreach ($taxonomy as $key => $value) {

				if( array_key_exists( $key, $atts ) ){

					$args['tax_query'][] = array(
						'taxonomy' => $value['taxonomy'],
						'field'    => $value['field'],
						'terms'    => explode( ',', $atts[$key] )
					);

				}

			}

		}

		return new \WP_Query( $args );

	}

}
