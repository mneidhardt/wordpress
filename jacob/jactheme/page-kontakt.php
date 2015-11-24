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

/*
        $posts = get_posts(array(
                                 'numberposts' => 10,
                                 'post_type' => 'bog'));

        foreach ($posts as $post) {
            print($post->post_date . " " . $post->post_title . " --- " . $post->post_content . '<br>');
        }
*/
    while ( have_posts() ) : the_post();
        //get_template_part( 'content', 'page' );
        the_title();
        the_content();
    endwhile;

?>
</div>
<?php get_footer(); ?>
