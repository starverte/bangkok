<?php
/**
 * The template for displaying Menu pages.
 *
 * @package WordPress
 * @subpackage Bangkok
 */

get_header(); ?>

		<section id="primary">
			<div id="content" role="main">

			<?php if ( have_posts() ) : ?>

				<header class="page-header">
					<h1 class="menu-title"><?php
						printf( __( 'Our Menu: %s', 'bangkok' ), '<span>' . single_term_title( '', false ) . '</span>' );
					?></h1>
					<div class="legend">
						<div class="left"><a class="menucode spicy" href="">S1</a>Spicy</div>
						<div class="right"><a class="menucode" href="">A1</a>Not Spicy</div>
					</div>

					<?php
						$term_description = term_description();
						if ( ! empty( $term_description ) )
							echo apply_filters( 'term_archive_meta', '<div class="term-archive-meta">' . $term_description . '</div>' );
					?>
				</header>

				<?php bangkok_content_nav( 'nav-above' ); ?>

				<?php /* Start the Loop */ ?>
				<?php query_posts( $query_string . '&order=ASC' ); ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php
						/* Include the Post-Format-specific template for the content.
						 * If you want to overload this in a child theme then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'content', 'menu' );
					?>

				<?php endwhile; ?>

				<?php bangkok_content_nav( 'nav-below' ); ?>

			<?php else : ?>

				<article id="post-0" class="post no-results not-found">
					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'Nothing Found', 'bangkok' ); ?></h1>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'bangkok' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->

			<?php endif; ?>

			</div><!-- #content -->
		</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>