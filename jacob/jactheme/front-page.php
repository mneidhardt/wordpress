<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * e.g., it puts together the home page when no home.php file exists.
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 *
 * @package WordPress
 * @subpackage ptptheme
 */

get_header();

?>
<div id="main">
<?php

    $postarray = get_posts(array(
                             'numberposts' => 1,
                             'post_type' => 'forside'));

    if (is_array($postarray) && sizeof($postarray) == 1) {
        $post = $postarray[0];
        print($post->post_content . '<br>');
    } else {
        error_log("Expected a post with type 'forside', containing data to display.");
    }

?>
</div>
</body>
</html>
