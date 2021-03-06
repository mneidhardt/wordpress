<?php
/**
 * Twenty Fifteen functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @subpackage jactheme
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Twenty Fifteen 1.0
 */


if ( ! isset( $content_width ) ) {
	$content_width = 660;
}

add_theme_support( 'post-thumbnails' );

function set_featured_image($postid) {

    // If this is just a revision, don't send the email.
    if ( wp_is_post_revision( $postid ) )
        return;

    $media = get_attached_media( 'image' );

    if (is_array($media) && sizeof($media) > 0) {
        reset($media);
         // I always use the first attached image as featured image (i.e. thumbnail):
        set_post_thumbnail($postid, key($media));
    }
}
add_action( 'save_post', 'set_featured_image' );

function enqueue_mystyle() {
    wp_enqueue_style( 'jacstyle', get_stylesheet_uri());
}

add_action('wp_enqueue_scripts', 'enqueue_mystyle');
include_once('jacsettings.php');
