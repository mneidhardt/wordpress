<?php
/**
 * @package mailchimpplugin
 * @version 0.1
 */
/*
Plugin Name: mailchimpplugin
Description: Plugin that enables Mailchimp list signup (initially)
Author: Michael N.
Version: 0.1
Author URI: http://meem.dk/
*/

defined( 'ABSPATH' ) or die("Don't call us, we'll call you.");

include_once('includes/api.php');

// [mclists] Get the Mailchimp lists to sign up for:
function mclists_func( $atts ) {
    return file_get_contents(site_url() . '/api/mailchimp/lists/');
}
add_shortcode( 'mclists', 'mclists_func' );


/* Example of a filter - this just adds a text to every title: */
/*
function titlefilter($title) {
    return $title . ', or so says Rimsky Korsakov@' . date('D/F/Y H:i:s');
}

add_filter('the_title', 'titlefilter');
*/

?>
