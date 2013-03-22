<?php
/**
 * bangkok functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook. The hook can be removed by using remove_action() or
 * remove_filter() and you can attach your own function to the hook.
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package WordPress
 * @subpackage Bangkok
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 640; /* pixels */

if ( ! function_exists( 'bangkok_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * To override bangkok_setup() in a child theme, add your own bangkok_setup to your child theme's
 * functions.php file.
 */

require_once ( get_template_directory() . '/theme-options.php' );

function bangkok_setup() {
	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on bangkok, use a find and replace
	 * to change 'bangkok' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'bangkok', get_template_directory() . '/languages' );

	$locale = get_locale();
	$locale_file = get_template_directory() . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'bangkok' ),
	) );

	/**
	 * Add support for the Aside and Gallery Post Formats
	 */
	add_theme_support( 'post-formats', array( 'aside', 'image', 'gallery' ) );
}

endif; // bangkok_setup

if ( function_exists( 'add_theme_support' ) ) { 
add_theme_support( 'post-thumbnails' );
}

/**
 * Tell WordPress to run bangkok_setup() when the 'after_setup_theme' hook is run.
 */
add_action( 'after_setup_theme', 'bangkok_setup' );

/**
 * Set a default theme color array for WP.com.
 */
$themecolors = array(
	'bg' => 'ffffff',
	'border' => 'eeeeee',
	'text' => '444444',
);

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function bangkok_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'bangkok_page_menu_args' );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function bangkok_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Sidebar 1', 'bangkok' ),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );

	register_sidebar( array(
		'name' => __( 'Sidebar 2', 'bangkok' ),
		'id' => 'sidebar-2',
		'description' => __( 'An optional second sidebar area', 'bangkok' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );
}
add_action( 'init', 'bangkok_widgets_init' );

if ( ! function_exists( 'bangkok_content_nav' ) ):
/**
 * Display navigation to next/previous pages when applicable
 *
 * @since bangkok 1.2
 */
function bangkok_content_nav( $nav_id ) {
	global $wp_query;

	?>
	<nav id="<?php echo $nav_id; ?>">
		<h1 class="assistive-text section-heading"><?php _e( 'Post navigation', 'bangkok' ); ?></h1>

	<?php if ( is_single() ) : // navigation links for single posts ?>

		<?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'bangkok' ) . '</span> %title' ); ?>
		<?php next_post_link( '<div class="nav-next">%link</div>', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'bangkok' ) . '</span>' ); ?>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

		<?php if ( get_next_posts_link() ) : ?>
		<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'bangkok' ) ); ?></div>
		<?php endif; ?>

		<?php if ( get_previous_posts_link() ) : ?>
		<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'bangkok' ) ); ?></div>
		<?php endif; ?>

	<?php endif; ?>

	</nav><!-- #<?php echo $nav_id; ?> -->
	<?php
}
endif; // bangkok_content_nav


if ( ! function_exists( 'bangkok_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own bangkok_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since bangkok 0.4
 */
function bangkok_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'bangkok' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'bangkok' ), ' ' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<footer>
				<div class="comment-author vcard">
					<?php echo get_avatar( $comment, 40 ); ?>
					<?php printf( __( '%s <span class="says">says:</span>', 'bangkok' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
				</div><!-- .comment-author .vcard -->
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em><?php _e( 'Your comment is awaiting moderation.', 'bangkok' ); ?></em>
					<br />
				<?php endif; ?>

				<div class="comment-meta commentmetadata">
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><time pubdate datetime="<?php comment_time( 'c' ); ?>">
					<?php
						/* translators: 1: date, 2: time */
						printf( __( '%1$s at %2$s', 'bangkok' ), get_comment_date(), get_comment_time() ); ?>
					</time></a>
					<?php edit_comment_link( __( '(Edit)', 'bangkok' ), ' ' );
					?>
				</div><!-- .comment-meta .commentmetadata -->
			</footer>

			<div class="comment-content"><?php comment_text(); ?></div>

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->

	<?php
			break;
	endswitch;
}
endif; // ends check for bangkok_comment()

if ( ! function_exists( 'bangkok_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 * Create your own bangkok_posted_on to override in a child theme
 *
 * @since bangkok 1.2
 */
function bangkok_posted_on() {
	printf( __( '<span class="sep">Posted on </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a><span class="byline"> <span class="sep"> by </span> <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'bangkok' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'bangkok' ), get_the_author() ) ),
		esc_html( get_the_author() )
	);
}
endif;

/**
 * Adds custom classes to the array of body classes.
 *
 * @since bangkok 1.2
 */
function bangkok_body_classes( $classes ) {
	// Adds a class of single-author to blogs with only 1 published author
	if ( ! is_multi_author() ) {
		$classes[] = 'single-author';
	}

	return $classes;
}
add_filter( 'body_class', 'bangkok_body_classes' );

/**
 * Returns true if a blog has more than 1 category
 *
 * @since bangkok 1.2
 */
function bangkok_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so bangkok_categorized_blog should return true
		return true;
	} else {
		// This blog has only 1 category so bangkok_categorized_blog should return false
		return false;
	}
}

/**
 * Flush out the transients used in bangkok_categorized_blog
 *
 * @since bangkok 1.2
 */
function bangkok_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'bangkok_category_transient_flusher' );
add_action( 'save_post', 'bangkok_category_transient_flusher' );

/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 */
function bangkok_enhanced_image_navigation( $url ) {
	global $post;

	if ( wp_attachment_is_image( $post->ID ) )
		$url = $url . '#main';

	return $url;
}
add_filter( 'attachment_link', 'bangkok_enhanced_image_navigation' );

$prefix = 'svllc_';

$meta_box = array(
    'id' => 'front-meta',
    'title' => 'Home Page',
    'page' => 'post',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array(
            'name' => 'Show on front page?',
            'id' => $prefix . 'display',
            'type' => 'checkbox'
        ),
        array(
            'name' => 'Location',
            'id' => $prefix . 'location',
            'type' => 'select',
            'options' => array('Left', 'Center', 'Right')
        )
    )
);

add_action('admin_menu', 'bangkok_add_box');

// Add meta box
function bangkok_add_box() {
    global $meta_box;

    add_meta_box($meta_box['id'], $meta_box['title'], 'bangkok_show_box', $meta_box['page'], $meta_box['context'], $meta_box['priority']);
}

// Callback function to show fields in meta box
function bangkok_show_box() {
    global $meta_box, $post;

    // Use nonce for verification
    echo '<input type="hidden" name="bangkok_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

    echo '<table class="form-table">';

    foreach ($meta_box['fields'] as $field) {
        // get current post meta data
        $meta = get_post_meta($post->ID, $field['id'], true);

        echo '<tr>',
                '<th style="width:20%"><label for="', $field['id'], '">', $field['name'], '</label></th>',
                '<td>';
        switch ($field['type']) {
            case 'checkbox':
                echo '<input type="checkbox" name="', $field['id'], '" id="', $field['id'], '"', $meta ? ' checked="checked"' : '', ' />';
                break;
            case 'select':
                echo '<select name="', $field['id'], '" id="', $field['id'], '">';
                foreach ($field['options'] as $option) {
                    echo '<option', $meta == $option ? ' selected="selected"' : '', '>', $option, '</option>';
                }
                echo '</select>';
                break;

        }
        echo     '<td>',
            '</tr>';
    }

    echo '</table>';
}

add_action('save_post', 'bangkok_save_data');

// Save data from meta box
function bangkok_save_data($post_id) {
    global $meta_box;

    // verify nonce
    if (!wp_verify_nonce($_POST['bangkok_meta_box_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    // check permissions
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    foreach ($meta_box['fields'] as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        $new = $_POST[$field['id']];

        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    }
}

// BEGIN - Custom Post Type
add_action('init', 'create_menu_types');
function create_menu_types() 
{
  $directory = get_stylesheet_directory_uri();
  $labels = array(
    'name' => _x('Menu', 'post type general name'),
    'singular_name' => _x('Menu', 'post type singular name'),
    'add_new' => _x('Add New', 'menu'),
    'add_new_item' => __('Add New Menu'),
    'edit_item' => __('Edit Menu'),
    'new_item' => __('New Menu'),
    'view_item' => __('View Menu'),
    'search_items' => __('Search Menus'),
    'not_found' =>  __('No menus found matching that criteria'),
    'not_found_in_trash' => __('No menus found in Trash. Did you check recycling?'), 
    'parent_item_colon' => '',
    'menu_name' => 'Café Menu',
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
    'menu_icon' => $directory . '/images/music.png',
    'capability_type' => 'post',
    'has_archive' => true, 
    'rewrite' => array('slug' => 'menu'),
    'hierarchical' => false,
    'menu_position' => 5,
    'supports' => array('title', 'editor', 'thumbnail')
  ); 
  register_post_type('menu',$args);
}
// END - Custom Post Type

// BEGIN - Custom Taxonomies
add_action( 'init', 'create_menu_taxonomy', 0 );
function create_menu_taxonomy()
{
/* Menu Groups */
$labels = array(	
	'name' => _x( 'Menu Group', 'custom taxonomy general name'),
	'singular_name' => _x( 'Menu Group', 'custom taxonomy singular name' ),
	'menu_name' => __( 'Menu Groups'),
	'search_items' => __( 'Search menu groups' ), 
	'popular_items' => __( 'Most popular menu groups' ), 
	'all_items' => __( 'All menu groups' ),
	'edit_item' => __( 'Edit menu group' ),
	'update_item' => __( 'Update menu group' ), 
	'add_new_item' => __( 'Add new menu group' ),
	'new_item_name' => __( 'New menu group' ), 
	'separate_items_with_commas' => __( 'Separate menu groups with commas' ),
	'add_or_remove_items' => __( 'Add or remove menu groups' ),
	'choose_from_most_used' => __( 'Choose from most used menu groups' ),
	'parent_item' => null,
    'parent_item_colon' => null,
);

register_taxonomy('menu_group','menu', array(
	'hierarchical' => true, 
	'labels' => $labels, 
	'show_ui' => true,
	'query_var' => true,
    'rewrite' => true,
));
}
add_action( 'init', 'create_options_taxonomy', 0 );
function create_options_taxonomy()
{
/* Options */
$labels = array(	
	'name' => _x( 'Options', 'custom taxonomy general name'),
	'singular_name' => _x( 'Option', 'custom taxonomy singular name' ),
	'menu_name' => __( 'Options'),
	'search_items' => __( 'Search menu options' ), 
	'popular_items' => __( 'Most popular options' ), 
	'all_items' => __( 'All menu options' ),
	'edit_item' => __( 'Edit menu option' ),
	'update_item' => __( 'Update menu option' ), 
	'add_new_item' => __( 'Add new menu option' ),
	'new_item_name' => __( 'New menu option' ), 
	'separate_items_with_commas' => __( 'Separate options with commas' ),
	'add_or_remove_items' => __( 'Add or remove menu options' ),
	'choose_from_most_used' => __( 'Choose from most used options' ),
	'parent_item' => null,
    'parent_item_colon' => null,
);

register_taxonomy('option','menu', array(
	'hierarchical' => false, 
	'labels' => $labels, 
	'show_ui' => true,
	'query_var' => true,
    'rewrite' => true,
));
}
// END - Custom Taxonomies
// BEGIN - Create custom fields
add_action("admin_menu", "my_meta_boxes");

function my_meta_boxes() {
	add_meta_box('details_meta', 'Details', 'details_meta', 'menu', 'side', 'high');
}
function hide_meta_boxes() {
	remove_meta_box( 'postcustom' , 'post' , 'normal' );
	remove_meta_box( 'postcustom' , 'page' , 'normal' ); 
}
add_action( 'admin_menu' , 'hide_meta_boxes' );

/* Menu Details */
function details_meta() {
	global $post;
	$custom = get_post_custom($post->ID);
	$price = $custom["price"] [0];
	$menucode = $custom["menucode"] [0];
	$spicy = get_post_meta( $post->ID, 'spicy', true );
?>
    <p><label>Price</label> 
	<input type="text" size="25" name="price" value="<?php echo $price; ?>" /></p>
    <p><label>Menu Code</label> 
	<input type="text" size="5" name="menucode" value="<?php echo $menucode; ?>" /></p>
    <p><label for="spicy">
			<input type="checkbox" name="spicy" id=spicy" <?php if( $spicy == true ) { ?>checked="checked"<?php } ?> />
			Spicy
		</label></p>
	<?php
}
/* Save Details */
add_action('save_post', 'save_details');


function save_details(){
  global $post;
  if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
	return $post_id;
  }

  if( defined('DOING_AJAX') && DOING_AJAX ) { //Prevents the metaboxes from being overwritten while quick editing.
	return $post_id;
  }

  if( ereg('/\edit\.php', $_SERVER['REQUEST_URI']) ) { //Detects if the save action is coming from a quick edit/batch edit.
	return $post_id;
  }
	
  // save all meta data
  update_post_meta($post->ID, 'spicy', $_POST["spicy"] );
  update_post_meta($post->ID, "price", $_POST["price"]);
  update_post_meta($post->ID, "menucode", $_POST["menucode"]);

}
// END - Custom Fields

// remove version info from head and feeds
function complete_version_removal() {
    return '';
}
add_filter('the_generator', 'complete_version_removal');

/**
 * This theme was built with PHP, Semantic HTML, CSS, love, and a bangkok.
 */
