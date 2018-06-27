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
	protected $js = array();

	public function __construct( $posttype, $template, $atts = array(), $js = array() ) {

		$this->post_type = $posttype;
		$this->template = $template;
		$this->atts = $atts;
		$this->name .= str_replace('-', '_', $this->post_type);

		add_shortcode( $this->name, array( $this, 'search_form_shortcode' ) );

		if( !empty($js) ){
			$this->js = $js;
			add_action( 'wp_enqueue_scripts', array( $this, 'register_all_js' ) );
		}

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

	public function register_all_js(){

		if(is_array($this->js[0])){
			foreach ($this->js as $key => $item) {
				$this->register_js($item);
			}
		} else {
			$this->register_js($this->js);
		}

	}

	public function register_js($item){

		$deps = array_key_exists('deps', $item) ? $item['deps'] : array();
		$ver = array_key_exists('ver', $item) ? $item['ver'] : false;
		$in_footer = array_key_exists('in_footer', $item) ? $item['in_footer'] : false;

		wp_register_script( $item['handle'], $item['src'], $deps, $ver, $in_footer );

	}

}
