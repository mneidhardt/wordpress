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

    while ( have_posts() ) : the_post();
        //get_template_part( 'content', 'page' );
        // the_title();
        the_content();
    endwhile;

?>
</div>
<?php get_footer(); ?>
