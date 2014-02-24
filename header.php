<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package Bangkok
 */
?><!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<meta name="google-site-verification" content="3AO_zI0q_DqvScRHNHGhPo65Imcbkcp7xoKJnBqL3oI" />
<title><?php
  /*
   * Print the <title> tag based on what is being viewed.
   */
  global $page, $paged;

  wp_title( '|', true, 'right' );

  // Add the blog name.
  bloginfo( 'name' );

  // Add the blog description for the home/front page.
  $site_description = get_bloginfo( 'description', 'display' );
  if ( $site_description && ( is_home() || is_front_page() ) )
    echo " | $site_description";

  // Add a page number if necessary:
  if ( $paged >= 2 || $page >= 2 )
    echo ' | ' . sprintf( __( 'Page %s', 'bangkok' ), max( $paged, $page ) );

  ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <?php
    $options = get_option('bangkok_theme_options');
  ?>  

<div id="page" class="hfeed">

  <header id="branding" role="banner">
    <div id="social-icons">



      <a class="facebook" href="<?php echo $options['fb_url']; ?>"><img class="facebook" src="<?php echo get_template_directory_uri(); ?>/images/facebook.png" /></a>
      <a class="twitter" href="<?php echo $options['twitter_url']; ?>"><img class="twitter" src="<?php echo get_template_directory_uri(); ?>/images/twitter.png" /></a>
      <a class="yelp" href="<?php echo $options['yelp_url']; ?>"><img class="yelp" src="<?php echo get_template_directory_uri(); ?>/images/yelp.png" /></a>
    </div>

    <hgroup>
      <h1 id="site-title"><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
      <h2 id="site-description"><?php bloginfo( 'description' ); ?></h2>
      <img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" class="logo" />
      <?php get_search_form(); ?>
    </hgroup>

    <div class="address">1232 W Elizabeth #C-7, Fort Collins, CO | 970.672.8127 | info@cafedebangkok.net</div>

    <nav id="access" role="navigation">
      <h1 class="assistive-text section-heading"><?php _e( 'Main menu', 'bangkok' ); ?></h1>
      <div class="skip-link screen-reader-text"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'bangkok' ); ?>"><?php _e( 'Skip to content', 'bangkok' ); ?></a></div>

      <?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
    </nav><!-- #access -->
  

  </header><!-- #branding -->

  <div id="main">