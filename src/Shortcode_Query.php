<?php
namespace AgriLife\MajorsDegrees;

/**
 * Static methods for often-used queries
 */

class Shortcode_Query {

	/**
	 * Queries for people with some smart defaults
	 * @param  string $type   The type taxonomy slug to filter (optional)
	 * @param  string $search The search term (optional)
	 * @return object         A WP_Query object with the results
	 */
	public static function get_posts( $post_type = 'posts', $atts = array() ) {

		// Set default arguments for every People query
		$args = array(
			'post_type'      => $post_type,
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'       => 'title',
			'order'          => 'ASC'
		);

		$tax_query = array();

		// Add a taxonomy query if needed
		if ( ! empty( $atts['departments'] ) ) {
			$tax_query[] = array(
				'taxonomy' => 'department',
				'field'    => 'slug',
				'terms'    => explode(',', $atts['departments']),
			);
		}

		if ( ! empty( $atts['degree-types'] ) ) {
			$tax_query[] = array(
				'taxonomy' => 'degree-type',
				'field'    => 'slug',
				'terms'    => explode(',', $atts['degree-types']),
			);
		}

		if ( ! empty( $atts['keywords'] ) ) {
			$tax_query[] = array(
				'taxonomy' => 'keyword',
				'field'    => 'slug',
				'terms'    => explode(',', $atts['keywords']),
			);
		}

		if( ! empty( $tax_query ) ){
			$args['tax_query'] = $tax_query;
		}

		// Add the search terms if needed
		if ( ! empty( $search ) ) {
			$args['s'] = $search;
		}

		return new WP_Query( $args );

	}

}
