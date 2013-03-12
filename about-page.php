<?php
/**
 * Template Name: About
 * Description: The about page
 *
 * @package WordPress
 * @subpackage Bangkok
 */

get_header(); ?>

  	<div id="primary">
			<div id="content" role="main">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'page' ); ?>

					<?php comments_template( '', true ); ?>

				<?php endwhile; // end of the loop. ?>

			</div><!-- #content -->
		</div><!-- #primary -->

		<div id="secondary" class="widget-area" role="complementary">
			<aside id="map" class="widget widget_map">
				<iframe width="260" height="260" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?client=safari&amp;oe=UTF-8&amp;q=1232+W+Elizabeth+%23C-7,+Fort+Collins,+CO&amp;ie=UTF8&amp;hq=&amp;hnear=0x87694a4636cb06f7:0x97a48dd5430a417,1232+W+Elizabeth+St,+Fort+Collins,+CO+80521&amp;gl=us&amp;daddr=1232+W+Elizabeth+St,+Fort+Collins,+CO+80521&amp;t=m&amp;ll=40.575532,-105.098627&amp;spn=0.009127,0.012016&amp;z=15&amp;output=embed"></iframe><br /><a href="http://maps.google.com/maps?client=safari&amp;oe=UTF-8&amp;q=1232+W+Elizabeth+%23C-7,+Fort+Collins,+CO&amp;ie=UTF8&amp;hq=&amp;hnear=0x87694a4636cb06f7:0x97a48dd5430a417,1232+W+Elizabeth+St,+Fort+Collins,+CO+80521&amp;gl=us&amp;daddr=1232+W+Elizabeth+St,+Fort+Collins,+CO+80521&amp;t=m&amp;ll=40.575532,-105.098627&amp;spn=0.009127,0.012016&amp;z=15&amp;source=embed">View Larger Map</a>
			</aside>

			<aside id="text-2" class="widget widget_text">
				<div class="textwidget">
					<h4>Hours</h4>
					Tue - Thu:	11a - 2.30p, 4.30p - 9p<br>
					Fri - Sun:	11a - 9p<br>
					Delivery: 11a - 2p &amp; 5p - 8p<br>
					Closed on Monday<br>

					<h4>Takeout and Delivery</h4>
					970.672.8127<br>
					For orders over $18, we offer free delivery within 3 miles<br>
					of our restaurant, and $1 for each additional mile.</div>
			</aside>

		</div><!-- #secondary .widget-area -->

<?php get_footer(); ?>
