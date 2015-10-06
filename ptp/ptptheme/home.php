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

get_header(); ?>

  <div class="main"></div>
  <div class="centro">
		<main id="main" class="site-main" role="main">

        <?php

        $args = array( 'posts_per_page' => 50, 'orderby' => 'date', 'order' => 'ASC');
        $posts = get_posts($args);
        $count=0;
        $picsperrow = get_option('ptppicsperrow');

        foreach ($posts as $post ) {
            setup_postdata( $post );
            ++$count;
            $postid = get_the_ID();

            $tpix = get_the_post_thumbnail($postid, 'thumbnail');
            print('<a href="/?p=' . $postid . '">' . $tpix . '</a>&nbsp;');

            if ($count % $picsperrow == 0) {
                print '<br/>';
            }
        }
        wp_reset_postdata();

		// Previous/next page navigation.
		/*
        the_posts_pagination( array(
			'prev_text'          => __( 'Previous page' ),
			'next_text'          => __( 'Next page' ),
			'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page' ) . ' </span>',
		) );
        */

		?>

		</main><!-- .site-main -->
	</div><!-- .centro -->

<?php get_footer(); ?>
