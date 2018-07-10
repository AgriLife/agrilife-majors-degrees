<?php
/**
 * Plugin Name: AgriLife Majors and Degrees Plugin
 * Plugin URI: https://github.com/AgriLife/agrilife-majors-degrees
 * Description: Majors and Degrees Post Type Plugin
 * Version: 1.0.0
 * Author: Zach Watkins
 * Author URI: http://github.com/ZachWatkins
 * Author Email: zachary.watkins@ag.tamu.edu
 * License: GPL2+
 */

require 'vendor/autoload.php';

define( 'AG_MAJDEG_DIRNAME', 'agrilife-majors-degrees' );
define( 'AG_MAJDEG_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'AG_MAJDEG_DIR_FILE', __FILE__ );
define( 'AG_MAJDEG_DIR_URL', plugin_dir_url( __FILE__ ) );
define( 'AG_MAJDEG_TEMPLATE_PATH', AG_MAJDEG_DIR_PATH . 'view' );

add_image_size( 'majors-and-degrees-header-max', 2220, 680, array( 'center', 'top' ) );
add_image_size( 'majors-and-degrees-header-large', 1110, 340, array( 'center', 'top' ) );
add_image_size( 'majors-and-degrees-header-medium', 720, 220, array( 'center', 'top' ) );

add_action( 'init', function(){

  $post_type_slug = 'majors-and-degrees';
  $namespace = 'agmjd';

  if ( class_exists( 'Acf' ) ) {
    require_once(AG_MAJDEG_DIR_PATH . 'fields/majors-degrees-details.php');
  }

  // Add taxonomies
  $taxonomy_department = new \AgriLife\MajorsDegrees\Taxonomy(
    'Department', 'department', $post_type_slug, $namespace,
    array(
      'hierarchical' => false
    ),
    array(
      array(
        'name' => 'Ranking',
        'slug' => 'ranking',
        'type' => 'full'
      ),
      array(
        'name' => 'Contact Info',
        'slug' => 'contact',
        'type' => 'link'
      ),
      array(
        'name' => 'Department Page',
        'slug' => 'department-page',
        'type' => 'link'
      )
    ),
    AG_MAJDEG_TEMPLATE_PATH . '/archive-taxonomy.php'
  );

  $taxonomy_degree_type = new \AgriLife\MajorsDegrees\Taxonomy(
    'Degree Type', 'degree-type', $post_type_slug, $namespace,
    array(
      'hierarchical' => false
    ),
    array(),
    AG_MAJDEG_TEMPLATE_PATH . '/archive-taxonomy.php'
  );

  $taxonomy_keyword = new \AgriLife\MajorsDegrees\Taxonomy(
    'Keyword', 'keyword', $post_type_slug, $namespace,
    array(
      'hierarchical' => false
    ),
    array(),
    AG_MAJDEG_TEMPLATE_PATH . '/archive-taxonomy.php'
  );

  // Add custom post type
  $post_type = new \AgriLife\MajorsDegrees\PostType(
    'Majors and Degrees', $post_type_slug, $namespace, array('department', 'degree-type', 'keyword'), 'dashicons-portfolio',
    array(
      'title', 'editor', 'thumbnail', 'revisions', 'genesis-seo', 'genesis-layouts', 'genesis-scripts'
    )
  );

  // Add custom post type templates
  $post_template = new \AgriLife\MajorsDegrees\Templates( $post_type_slug, 'single-majors-degrees.php', 'archive-majors-degrees.php', 'search-majors-degrees.php' );

  // Add custom post type list shortcode
  $display_posts_shortcode = new \AgriLife\MajorsDegrees\PostsShortcode(
    $post_type_slug,
    AG_MAJDEG_TEMPLATE_PATH . '/shortcode-posts.php',
    array(
      'departments' => array(
        'default' => '',
        'taxonomy' => 'department',
        'field' => 'slug'
      ),
      'degree_types' => array(
        'default' => '',
        'taxonomy' => 'degree-type',
        'field' => 'slug'
      ),
      'keywords' => array(
        'default' => '',
        'taxonomy' => 'keyword',
        'field' => 'slug'
      )
    )
  );

  // Add custom post type search shortcode
  $search_posts_shortcode = new \AgriLife\MajorsDegrees\SearchFormShortcode(
    $post_type_slug,
    AG_MAJDEG_TEMPLATE_PATH . '/shortcode-search-form.php',
    array(),
    array(
      'handle' => 'majors-degrees-search',
      'src' => AG_MAJDEG_DIR_URL . 'js/search-form.js',
      'deps' => array('jquery-ui-autocomplete'),
      'ver' => filemtime(AG_MAJDEG_DIR_PATH . 'js/search-form.js'),
      'in_footer' => true
    )
  );

});
