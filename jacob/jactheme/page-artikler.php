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

    $posts = get_posts(array(
        'numberposts' => 10,
        'post_type' => 'artikel'));

    $count==0;

    foreach ($posts as $post) {
        /*
        $categs = get_the_category();
        $title = '';
        if (!empty($categs)) {
            foreach ($categs as $categ) {
                $title .= $categ->name . ' ';
            }
        }
        */

        if ($count++ % 2 == 0) {
            $class = '"imgfloatright"';
        } else {
            $class = '"imgfloatleft"';
        }

        print("<div class=$class>");
        /* 
        $media = get_attached_media( 'image', $post->ID );

        if (is_array($media) && sizeof($media) > 0) {

            $tpix = get_the_post_thumbnail($post->ID, 'thumbnail', 'title=""');
            print('<a href="/?p=' . $postid . '">' . $tpix . '</a> ');
        }
        */
        print($post->post_content);
        print('</div>');

    }

?>
</div>
<?php get_footer(); ?>
