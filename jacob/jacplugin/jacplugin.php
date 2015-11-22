<?php
/**
 * @package jacplugin
 * @version 0.1
 */
/*
Plugin Name: jacplugin
Plugin URI: http://meem.dk/
Description: This is not just a plugin, it is a way of life.
Author: Michael N.
Version: 0.1
Author URI: http://meem.dk/
*/

defined( 'ABSPATH' ) or die("Don't call us, we'll call you.");

/* include_once('includes/api.php'); */

/* Example of a filter - this just adds a text to every title: */
/* function titlefilter($title) {
    return $title . ', or so says Rimsky Korsakov@' . date('D/F/Y H:i:s');
}

add_filter('the_title', 'titlefilter');
*/

add_action( 'init', 'create_post_type' );
function create_post_type() {
  register_post_type( 'artikel',
    array(
      'labels' => array(
        'name' => __( 'Artikler' ),
        'singular_name' => __( 'Artikel' )
      ),
      'public' => true,
      'has_archive' => true,
    )
  );

  register_post_type( 'radio',
    array(
      'labels' => array(
        'name' => __( 'Radio' ),
        'singular_name' => __( 'Radio' )
      ),
      'public' => true,
      'has_archive' => true,
    )
  );

  register_post_type( 'bog',
    array(
      'labels' => array(
        'name' => __( 'Bøger' ),
        'singular_name' => __( 'Bog' )
      ),
      'public' => true,
      'has_archive' => true,
    )
  );

  register_post_type( 'foredrag',
    array(
      'labels' => array(
        'name' => __( 'Foredrag' ),
        'singular_name' => __( 'Foredrag' )
      ),
      'public' => true,
      'has_archive' => true,
    )
  );
}
?>
