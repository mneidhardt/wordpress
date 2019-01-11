<?php
/**
Template Name: Full-width layout
Template Post Type: artikler
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

    $posts = get_posts(array(
        'numberposts' => 10,
        'post_type' => 'radio'));

    foreach ($posts as $post) {
        print('<div class="itementry">');
        print('<div class="itementrytitle">' .
              $post->post_title . ' ' .
              get_the_date('', $post) .
              '</div>');
        print('<div class="itementrytext">' .
              apply_filters( 'the_content', $post->post_content ) .
              '</div>');
        /*  . ': ' . $post->post_content); */
        print('</div>');

    }

?>
</div>
<?php get_footer(); ?>
