<?php
namespace AgriLife\MajorsDegrees;

/**
 * Builds and registers a custom taxonomy
 */

class Taxonomy {

	protected $slug;
	protected $meta_boxes = array();
	protected $template;

	/**
	 * Builds and registers the custom taxonomy
	 */
	public function __construct($name, $slug, $post_slug, $tag, $user_args = array(), $meta = array(), $template = '') {

		$this->slug = $slug;

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

		// Create taxonomy custom fields
		if( !empty($meta) ){
			if( !is_array($meta[0]) ){
				$this->add_meta_box($meta);
				$this->meta_boxes[] = $meta;
			} else {
				foreach ($meta as $key => $value) {
					$this->add_meta_box($value);
					$this->meta_boxes[] = $value;
				}
			}
		}

		// Add custom template for post taxonomies
		if( !empty( $template ) ){
			$this->template = $template;
			add_filter( 'template_include', array( $this, 'custom_template' ) );
		}

	}

	/*
		Add a meta box to the taxonomy
		$name - string
		$slug - string
		$type - string: full (default), input

		Partial credit: https://pippinsplugins.com/adding-custom-meta-fields-to-taxonomies/
	*/
	public function add_meta_box( $meta ){
		$this->meta_name = $meta['name'];
		$this->meta_slug = $meta['slug'];

  	add_action( "{$this->slug}_edit_form_fields", array($this, 'taxonomy_edit_meta_field'), 10, 2 );
	  add_action( "edited_{$this->slug}", array($this, 'save_taxonomy_custom_meta'), 10, 2 );
	}

  // Edit term page
  public function taxonomy_edit_meta_field($term) {

    // put the term ID into a variable
    $t_id = $term->term_id;

    foreach ($this->meta_boxes as $key => $meta) {
	    // retrieve the existing value(s) for this meta field. This returns an array
	    $slug = $meta['slug'];
	    $term_meta = get_option( "taxonomy_{$t_id}_{$slug}" );

	    ?><tr class="form-field term-<?php echo $slug; ?>-wrap">
        <th scope="row" valign="top"><label for="term_meta_<?php echo $slug; ?>"><?php _e( $meta['name'], 'mjd' ); ?></label></th>
        <td>
          <?php

          $value = $term_meta ? $term_meta : '';

          switch ($meta['type']) {
          	case 'full':
          		wp_editor( $value, 'term_meta_' . $slug, array(
          			'textarea_name' => 'term_meta_' . $slug,
          			'wpautop' => false
          		) );
          		break;

          	case 'link':
          		?><input type="url" name="term_meta_<?php echo $slug; ?>" id="term_meta_<?php echo $slug; ?>" value="<?php echo $value; ?>" placeholder="https://example.com" pattern="http[s]?://.*"><?php
          		break;

          	default:
          		?><input type="text" name="term_meta_<?php echo $slug; ?>" id="term_meta_<?php echo $slug; ?>" value="<?php echo $value; ?>"><?php
          		break;
          }

          ?>
          <p class="description"><?php _e( 'Enter a value for this field','mjd' ); ?></p>
        </td>
	  	</tr><?php
    }
  }

  // Save extra taxonomy fields callback function.
  public function save_taxonomy_custom_meta( $term_id ) {

  	foreach ($this->meta_boxes as $key => $meta) {
  		$slug = $meta['slug'];
	    if ( isset( $_POST['term_meta_' . $slug] ) ) {
	      $t_id = $term_id;
	      $value = $_POST['term_meta_' . $slug];
	      // Save the option array.
	      update_option( "taxonomy_{$t_id}_{$slug}", $value );
	    }

  	}

  }

  public function custom_template( $template ){

  	if( is_tax('keyword') ){

  		return $this->template;

  	}

  	return $template;
  }

}
