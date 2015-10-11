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

		<?php if ( have_posts() ) : ?>

			<?php if ( is_home() && ! is_front_page() ) : ?>
				<header>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>
			<?php endif; ?>

			<?php
			// Start the loop.
            $count=0;
            $picsperrow = get_option('ptppicsperrow');
			while ( have_posts() ) : the_post();
                $postid = get_the_ID();
                $media = get_attached_media( 'image' );

                $categs = get_the_category();
                $title = '';
                if (!empty($categs)) {
                    foreach ($categs as $categ) {
                        $title .= $categ->name . ' ';
                    }
                }
                
                if (is_array($media) && sizeof($media) > 0) {
                    ++$count;
                    $tpix = get_the_post_thumbnail($postid, 'thumbnail', 'title=' . $title);
                    print('<a href="/?p=' . $postid . '">' . $tpix . '</a> ');
                    
                    if ($count % $picsperrow == 0) {
                        print '<br/>';
                    }
                }

			// End the loop.
			endwhile;

			// Previous/next page navigation.
			the_posts_pagination( array(
				'prev_text'          => __( 'Previous page' ),
				'next_text'          => __( 'Next page' ),
				'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page' ) . ' </span>',
			) );

		// If no content, include the "No posts found" template.
		else :
			get_template_part( 'content', 'none' );

		endif;
		?>

		</main><!-- .site-main -->
	</div><!-- .centro -->

<?php get_footer(); ?>
