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
    Min nye bog udkommer 26. november 2015 - <a href="http://forlagetcolumbus.dk/produkt/europas-svaere-faellesskab/produkt/vis/" target="_blank">mere info.</a>
    <img src="/wp-content/uploads/2015/11/Omslag_Europas_med-billede-800x563.png" title="Bogomslag" class="imgnofloat">

</div>
<?php
/*
    $postarray = get_posts(array(
                             'numberposts' => 1,
                             'post_type' => 'forside'));

    if (is_array($postarray) && sizeof($postarray) == 1) {
        $post = $postarray[0];
        print($post->post_content . '<br>');
    } else {
        print("Hey ho...");
    }

*/


?>
</body>
</html>
