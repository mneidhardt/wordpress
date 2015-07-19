<?php
/**
 * @package micplugin
 * @version 0.1
 */
/*
Plugin Name: moodleplugin
Description: Plugin that enables Moodle user creation, Moodle course enrollment etc. 
Author: Michael N.
Version: 0.1
Author URI: http://headnet.dk/
*/

defined( 'ABSPATH' ) or die("Don't call us, we'll call you.");

include_once('includes/api.php');

/* Example of a filter - this just adds a text to every title: */
/*
function titlefilter($title) {
    return $title . ', or so says Rimsky Korsakov@' . date('D/F/Y H:i:s');
}

add_filter('the_title', 'titlefilter');
*/

?>
