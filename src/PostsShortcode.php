<?php
namespace AgriLife\MajorsDegrees;

/**
 * Creates the shortcode to list posts. Can be filtered by taxonomy
 */

class PostsShortcode {

	protected $post_type;
	protected $template;
	protected $atts;
	protected $name = 'display_';

	public function __construct( $posttype, $template, $atts = array() ) {

		$this->post_type = $posttype;
		$this->template = $template;
		$this->atts = $atts;
		$this->name .= str_replace('-', '_', $this->post_type);

		add_shortcode( $this->name, array( $this, 'display_posts_shortcode' ) );

	}

	/**
	 * Renders the shortcode
	 * @param  string $atts The shortcode attributes
	 * @return string       The shortcode output
	 */
	public function display_posts_shortcode( $atts ) {


		extract( shortcode_atts( $this->atts, $atts ));

		$posts = Shortcode_Query::get_posts( $this->post_type, $atts );

		ob_start();

		require $this->template;

		$output = ob_get_contents();
		ob_clean();

		return $output;

	}

}
