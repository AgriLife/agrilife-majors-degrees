<?php
namespace AgriLife\MajorsDegrees;

/**
 * Creates the shortcode to list posts. Can be filtered by taxonomy
 */

class SearchFormShortcode {

	protected $post_type;
	protected $template;
	protected $atts;
	protected $name = 'search_form_';

	public function __construct( $posttype, $template, $atts = array() ) {

		$this->post_type = $posttype;
		$this->template = $template;
		$this->atts = $atts;
		$this->name .= str_replace('-', '_', $this->post_type);

		add_shortcode( $this->name, array( $this, 'search_form_shortcode' ) );

	}

	/**
	 * Renders the shortcode
	 * @param  string $atts The shortcode attributes
	 * @return string       The shortcode output
	 */
	public function search_form_shortcode( $atts ) {


		extract( shortcode_atts( $this->atts, $atts ));

		$post_type = $this->post_type;

		ob_start();

		require $this->template;

		$output = ob_get_contents();
		ob_clean();

		return $output;

	}

}
