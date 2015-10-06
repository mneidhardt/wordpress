<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package WordPress
 * @subpackage ptptheme
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

single!?!?!!
		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();

			/*
			 * Include the post format-specific template for the content. If you want to
			 * use this in a child theme, then include a file called called content-___.php
			 * (where ___ is the post format) and that will be used instead.
			 */
			// get_template_part( 'content', get_post_format() );
            // print('<h2>' . the_title() . '</h2>' . the_content());
            /*$media = get_attached_media( 'image' );
            foreach ($media as $image) {
                print('<img src="' . $image->guid . '">');
            }
            */

   //$attdata = get_attached_media('image', $post-ID);
   //print('ATTMEDIA: ' . print_r($attdata, true) . '<br>');

   $args = array(
   'post_type' => 'attachment',
   'numberposts' => -1,
   'post_status' => null,
   'post_parent' => $post->ID
  );

  $attachments = get_posts( $args );
     if ( $attachments ) {
        foreach ( $attachments as $attachment ) {
           echo '<li>';
           echo wp_get_attachment_image( $attachment->ID, 'full' );
           echo '<p>';
           echo apply_filters( 'the_title', $attachment->post_title );
           echo '</p></li>';
          }
     } else {
         print('No attachments... args=' . print_r($args, true));
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
