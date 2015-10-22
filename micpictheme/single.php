<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package WordPress
 * @subpackage micpictheme

      NB: All the stuff related to the carousel should only be printed if there are multiple images!
 */

get_header(); ?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();
            $args = array(
            'post_type' => 'attachment',
            'numberposts' => -1,
            'post_status' => null,
            'post_parent' => $post->ID
            );

            $attachments = get_posts( $args );
            if ( $attachments ) {

                /* I expect the content of all posts to be ID,ID,
                   i.e. the ID of the previous post followed by a comma and
                   the ID of the next post, so users can browse through
                   all images. The first has no previous, and the last has no next, though.
                   See ptpsettings.php, where this content is added.
                */
                $cnt = explode(',', get_the_content());
                $navi = '';

                if (sizeof($cnt) == 2) {
                    $navi = "<a href='/?p=$cnt[0]'>&lt;&lt;</a> " . 
                            " <a href='/?p=$cnt[1]'>&gt;&gt;</a>";
                } 

                $catg = get_the_category($post->ID);

                print($navi . '<table border=0><tr>');
                foreach ( $attachments as $attachment ) {
                    print('<td>' . $catg[0]->name . '<br>' .
                          wp_get_attachment_image( $attachment->ID, 'full' ) . '</td>');
                }
                print('</tr></table>');
            }
            
			// If comments are open or we have at least one comment, load up the comment template.
			//if ( comments_open() || get_comments_number() ) :
			//	comments_template();
			//endif;

			// Previous/next post navigation.
			the_post_navigation( array(
				'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Next' ) . '</span> ' .
					'<span class="screen-reader-text">' . __( 'Next post:' ) . '</span> ' .
					'<span class="post-title">%title</span>',
				'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Previous' ) . '</span> ' .
					'<span class="screen-reader-text">' . __( 'Previous post:' ) . '</span> ' .
					'<span class="post-title">%title</span>',
			) );

		// End the loop.
		endwhile;
		?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>
