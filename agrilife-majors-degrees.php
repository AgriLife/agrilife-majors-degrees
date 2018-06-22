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

  function sm_register_query_vars( $vars ) {
      $vars[] = 'taxonomy';
      return $vars;
  }
  add_filter( 'query_vars', 'sm_register_query_vars' );

  function Search_with_in_a_tax( &$query ) {
    if ( is_search() && isset($query->query['taxonomy'])) {
      // This is a search results query on a search page
      $tax_query = array(
        // array(
        //   'taxonomy' => 'keyword',
        //   'terms' => 'test',
        //   'field' => 'term_id',
        // ),
        // array(
        //   'taxonomy' => 'keyword',
        //   'terms' => 'test',
        //   'field' => 'name',
        // ),
        // array(
        //   'taxonomy' => 'keyword',
        //   'terms' => 'test',
        //   'field' => 'term_taxonomy_id',
        // ),
        array(
          'taxonomy' => 'keyword',
          'terms' => array('test'),
          'field' => 'slug',
        )
      );

       //turn it into a WP_Tax_Query object
      $tax_query = new WP_Tax_Query($tax_query);
      $tax_query->primary_table = 'wp_posts';
      $tax_query->primary_id_column = 'ID';
      // $query->set('tax_query', $tax_query);
      // $query->set('s', '');
      // $query->set('tax_query', array(
      //   array(
      //     'taxonomy' => 'keyword',
      //     'field' => 'slug',
      //     'terms' => 'test'
      //   )
      // ) );
      echo '<pre>';
      print_r($query);
      echo '</pre>';
    }
  }
  add_action('pre_get_posts', 'Search_with_in_a_tax', 1);
  // add_action('parse_query', function($query){
  //   if ( is_search() && isset($query->query['taxonomy'])) {
  //     // This is a search results query on a search page
  //     $tax_query = array(
  //       // array(
  //       //   'taxonomy' => 'keyword',
  //       //   'terms' => 'test',
  //       //   'field' => 'term_id',
  //       // ),
  //       // array(
  //       //   'taxonomy' => 'keyword',
  //       //   'terms' => 'test',
  //       //   'field' => 'name',
  //       // ),
  //       // array(
  //       //   'taxonomy' => 'keyword',
  //       //   'terms' => 'test',
  //       //   'field' => 'term_taxonomy_id',
  //       // ),
  //       array(
  //         'taxonomy' => 'keyword',
  //         'terms' => array('test'),
  //         'field' => 'slug',
  //       )
  //     );

  //      //turn it into a WP_Tax_Query object
  //     $tax_query = new WP_Tax_Query($tax_query);
  //     $tax_query->primary_table = 'wp_posts';
  //     $tax_query->primary_id_column = 'ID';
  //     $query->tax_query = $tax_query;
  //     $query->set('s', '');
  //     echo '<pre>';
  //     print_r($query);
  //     echo '</pre>';
  //   }
  // });

});
