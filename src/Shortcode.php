<?php
namespace AgriLife\MajorsDegrees;

/**
 * Creates the shortcode to list posts. Can be filtered by taxonomy
 */

class Shortcode {

	public function __construct() {

		add_shortcode( 'majors_and_degrees', array( $this, 'create_shortcode' ) );

	}

	/**
	 * Renders the shortcode
	 * @param  string $atts The shortcode attributes
	 * @return string       The shortcode output
	 */
	public function create_shortcode( $atts ) {

		extract( shortcode_atts( array(
				'departments'   => '',
				'degree-types' => '',
				'keywords' => ''
			),
			$atts ));

		$posts = Shortcode_Query::get_posts( 'majors-and-degrees', $atts );

		require AG_MAJDEG_PLUGIN_DIR_PATH . '/views/shortcode-majors-degrees.php';

		$output = ob_get_contents();
		ob_clean();

		return $output;

	}

}
