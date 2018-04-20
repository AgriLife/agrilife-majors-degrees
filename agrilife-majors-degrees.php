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

  $custom_post_type = new \AgriLife\MajorsDegrees\PostType(
  	'Majors and Degrees', array(), 'dashicons-portfolio',
  	array(
  		'title', 'genesis-seo', 'genesis-layouts', 'genesis-scripts'
  	)
  );

  $custom_post_type = new \AgriLife\MajorsDegrees\Templates( 'majors-and-degrees', 'single-majors-degrees.php', 'archive-majors-degrees.php' );

});
