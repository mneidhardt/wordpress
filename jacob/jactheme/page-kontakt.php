<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage jactheme
 */

get_header();
?>
<div id="main">
<?php

    $postarray = get_posts(array(
                             'numberposts' => 1,
                             'post_type' => 'kontakt'));

    if (is_array($postarray) && sizeof($postarray) == 1) {
        $post = $postarray[0];
        print($post->post_content . '<br>');
    } else {
        error_log("Expected a post with type 'kontakt', containing data to display.");
    }

?>
</div>
<?php get_footer(); ?>
