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

add_action( 'init', function(){

  if ( class_exists( 'Acf' ) ) {
    require_once(AG_MAJDEG_DIR_PATH . 'fields/majors-degrees-details.php');
  }

  $taxonomy_department = new \AgriLife\MajorsDegrees\Taxonomy(
    'Department', 'department', 'majors-and-degrees', 'agmd',
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
        'slug' => 'contact'
      )
    )
  );

  $taxonomy_degree_type = new \AgriLife\MajorsDegrees\Taxonomy(
    'Degree Type', 'degree-type', 'majors-and-degrees', 'agmd',
    array(
      'hierarchical' => false
    )
  );

  $taxonomy_keyword = new \AgriLife\MajorsDegrees\Taxonomy(
    'Keyword', 'keyword', 'majors-and-degrees', 'agmd',
    array(
      'hierarchical' => false
    )
  );

  $post_type = new \AgriLife\MajorsDegrees\PostType(
    'Majors and Degrees', 'majors-and-degrees', 'agmd', array('department', 'degree-type', 'keyword'), 'dashicons-portfolio',
    array(
      'title', 'editor', 'thumbnail', 'revisions', 'genesis-seo', 'genesis-layouts', 'genesis-scripts'
    )
  );

  $post_template = new \AgriLife\MajorsDegrees\Templates( 'majors-and-degrees', 'single-majors-degrees.php', 'archive-majors-degrees.php', 'search-majors-degrees.php' );

  $display_posts_shortcode = new \AgriLife\MajorsDegrees\PostsShortcode(
    'majors-and-degrees',
    AG_MAJDEG_TEMPLATE_PATH . '/shortcode-majors-degrees.php',
    array(
      'departments'   => '',
      'degree_types' => '',
      'keywords' => ''
    ) );

  $search_posts_shortcode = new \AgriLife\MajorsDegrees\SearchFormShortcode( 'majors-and-degrees', AG_MAJDEG_TEMPLATE_PATH . '/search-majors-degrees.php');

});
