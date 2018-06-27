<?php
namespace AgriLife\MajorsDegrees;

/**
 * Creates the shortcode to list posts. Can be filtered by taxonomy
 */

class PostsShortcode {

	protected $post_type;
	protected $template;
	protected $atts;
	protected $taxonomy;
	protected $name = 'display_';

	public function __construct( $posttype, $template, $atts = array() ) {

		$this->post_type = $posttype;
		$this->template = $template;
		$this->name .= str_replace('-', '_', $this->post_type);

		if( !empty( $atts ) ){
			$this->taxonomy = $atts;
			$this->atts = array();
			foreach ($atts as $key => $value) {
				$this->atts[$key] = '';
			}
		}

		add_shortcode( $this->name, array( $this, 'display_posts_shortcode' ) );

	}

	/**
	 * Renders the shortcode
	 * @param  string $atts The shortcode attributes
	 * @return string       The shortcode output
	 */
	public function display_posts_shortcode( $atts ) {

		extract( shortcode_atts( $this->atts, $atts ));

		$posts = Post_Query::get_posts( $this->post_type, $atts, $this->taxonomy );

		ob_start();

		require $this->template;

		$output = ob_get_contents();
		ob_clean();

		return $output;

	}

}
