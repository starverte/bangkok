<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Bangkok
 */

get_header(); ?>

		<div id="primary">
			<div id="content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php bangkok_content_nav( 'nav-above' ); ?>

				<?php get_template_part( 'content', 'menu' ); ?>

				<?php bangkok_content_nav( 'nav-below' ); ?>

				<?php comments_template( '', true ); ?>

			<?php endwhile; // end of the loop. ?>

			</div><!-- #content -->
		</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>