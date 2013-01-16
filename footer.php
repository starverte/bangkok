<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package WordPress
 * @subpackage Bangkok
 */
?>

<?php
	$options = get_option('bangkok_theme_options');
?>

	</div><!-- #main -->

	<footer id="colophon" role="contentinfo">
		<div id="site-generator">
			<?php do_action( 'bangkok_credits' ); ?>
			<p><?php echo $options['footer']; ?></p>
			<p>&copy 2011 Theme developed by <a href="http://starverte.com">Star Verte LLC</a>.</p>
			<p><a href="http://openmenu.com>Menu powered by OpenMenu.</a></p>
			<p><a href="<?php echo esc_url( __( 'http://wordpress.org/', 'bangkok' ) ); ?>" title="<?php esc_attr_e( 'Semantic Personal Publishing Platform', 'bangkok' ); ?>" rel="generator"><?php printf( __( 'Proudly powered by %s', 'bangkok' ), 'WordPress' ); ?></a></p>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>