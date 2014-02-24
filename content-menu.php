<?php
/**
 * @package Bangkok
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <?php global $post;
  $custom = get_post_custom($post->ID);
  $price = $custom["price"] [0];
  $menucode = $custom["menucode"] [0];
  $spicy = get_post_meta( $post->ID, 'spicy', true ); ?>
  <header class="entry-header">
     <?php if ( get_post_meta($post->ID, 'spicy', true) ) : ?>
      <a class="menucode spicy" href="#"><?php echo $menucode; ?></a>
      <a href="#"><h1 class="entry-title spicy"><?php the_title(); ?></h1></a><div class="price">$<?php echo $price; ?></div>
    <?php else: ?>
      <a class="menucode" href="#"><?php echo $menucode; ?></a>
      <a href="#"><h1 class="entry-title"><?php the_title(); ?></h1></a><div class="price">$<?php echo $price; ?></div>
    <?php endif; ?>

    <div class="entry-meta">
      <?php bangkok_posted_on(); ?>
    </div><!-- .entry-meta -->
  </header><!-- .entry-header -->

  <div class="entry-content">
    <?php the_content(); ?>
    <?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'bangkok' ), 'after' => '</div>' ) ); ?>
  </div><!-- .entry-content -->

  <footer class="entry-meta">
     <?php
    $terms = get_the_terms( $post->ID, 'option' );
            
    if ( $terms && ! is_wp_error( $terms ) ) : 

      $option_links = array();

      foreach ( $terms as $term ) {
        $option_links[] = $term->name;
      }
      
      $choice_of = join( ", ", $option_links );
            
    ?>

    <p class="choices">
      Choice of: <?php echo strrev(preg_replace('/ ,/',' ro ,', strrev($choice_of),1)); ?>
    </p>

    <?php endif; ?>
    <?php edit_post_link( __( 'Edit', 'bangkok' ), '<span class="edit-link">', '</span>' ); ?>
  </footer><!-- .entry-meta -->
</article><!-- #post-<?php the_ID(); ?> -->