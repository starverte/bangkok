<?php

add_action( 'admin_init', 'theme_options_init' );
add_action( 'admin_menu', 'theme_options_add_page' );

/**
 * Init plugin options to white list our options
 */
function theme_options_init(){
  register_setting( 'bangkok_options', 'bangkok_theme_options', 'theme_options_validate' );
}

/**
 * Load up the menu page
 */
function theme_options_add_page() {
  add_theme_page( __( 'Theme Options', 'bangkoktheme' ), __( 'Theme Options', 'bangkoktheme' ), 'edit_theme_options', 'theme_options', 'theme_options_do_page' );
}

/**
 * Create arrays for our select and radio options
 */
$select_options = array(
  '0' => array(
    'value' =>  '0',
    'label' => __( 'Zero', 'bangkoktheme' )
  ),
  '1' => array(
    'value' =>  '1',
    'label' => __( 'One', 'bangkoktheme' )
  ),
  '2' => array(
    'value' => '2',
    'label' => __( 'Two', 'bangkoktheme' )
  ),
  '3' => array(
    'value' => '3',
    'label' => __( 'Three', 'bangkoktheme' )
  ),
  '4' => array(
    'value' => '4',
    'label' => __( 'Four', 'bangkoktheme' )
  ),
  '5' => array(
    'value' => '3',
    'label' => __( 'Five', 'bangkoktheme' )
  )
);

$radio_options = array(
  'yes' => array(
    'value' => 'yes',
    'label' => __( 'Yes', 'bangkoktheme' )
  ),
  'no' => array(
    'value' => 'no',
    'label' => __( 'No', 'bangkoktheme' )
  ),
  'maybe' => array(
    'value' => 'maybe',
    'label' => __( 'Maybe', 'bangkoktheme' )
  )
);

/**
 * Create the options page
 */
function theme_options_do_page() {
  global $select_options, $radio_options;

  if ( ! isset( $_REQUEST['settings-updated'] ) )
    $_REQUEST['settings-updated'] = false;

  ?>
  <div class="wrap">
    <?php screen_icon(); echo "<h2>" . get_current_theme() . __( ' Theme Options', 'bangkoktheme' ) . "</h2>"; ?>

    <?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
    <div class="updated fade"><p><strong><?php _e( 'Options saved', 'bangkoktheme' ); ?></strong></p></div>
    <?php endif; ?>

    <form method="post" action="options.php">
      <?php settings_fields( 'bangkok_options' ); ?>
      <?php $options = get_option( 'bangkok_theme_options' ); ?>

      <table class="form-table">

        <?php
        /**
         * Asks for text to display in Search box
         */
        ?>
        <tr valign="top"><th scope="row"><?php _e( 'Text for search box', 'bangkoktheme' ); ?></th>
          <td>
            <input id="bangkok_theme_options[s_text]" class="regular-text" type="text" name="bangkok_theme_options[s_text]" value="<?php esc_attr_e( $options['s_text'] ); ?>" />
            <label class="description" for="bangkok_theme_options[s_text]"><?php _e( 'ex. Search', 'bangkoktheme' ); ?></label>
          </td>
        </tr>

        <?php
        /**
         * Asks for Facebook Profile URL
         */
        ?>
        <tr valign="top"><th scope="row"><?php _e( 'Facebook Profile', 'bangkoktheme' ); ?></th>
          <td>
            <input id="bangkok_theme_options[fb_url]" class="regular-text" type="text" name="bangkok_theme_options[fb_url]" value="<?php esc_attr_e( $options['fb_url'] ); ?>" />
            <label class="description" for="bangkok_theme_options[fb_url]"><?php _e( 'ex. http://facebook.com/starverte', 'bangkoktheme' ); ?></label>
          </td>
        </tr>

        <?php
        /**
         * Asks for Twitter Profile URL
         */
        ?>
        <tr valign="top"><th scope="row"><?php _e( 'Twitter Profile', 'bangkoktheme' ); ?></th>
          <td>
            <input id="bangkok_theme_options[twitter_url]" class="regular-text" type="text" name="bangkok_theme_options[twitter_url]" value="<?php esc_attr_e( $options['twitter_url'] ); ?>" />
            <label class="description" for="bangkok_theme_options[twitter_url]"><?php _e( 'ex. http://twitter.com/starverte', 'bangkoktheme' ); ?></label>
          </td>
        </tr>

        <?php
        /**
         * Asks for Yelp Profile URL
         */
        ?>
        <tr valign="top"><th scope="row"><?php _e( 'Yelp Profile', 'bangkoktheme' ); ?></th>
          <td>
            <input id="bangkok_theme_options[yelp_url]" class="regular-text" type="text" name="bangkok_theme_options[yelp_url]" value="<?php esc_attr_e( $options['yelp_url'] ); ?>" />
            <label class="description" for="bangkok_theme_options[yelp_url]"><?php _e( 'ex. http://mbeall.yelp.com', 'bangkoktheme' ); ?></label>
          </td>
        </tr>

        <?php
        /**
         * Footer text
         */
        ?>
        <tr valign="top"><th scope="row"><?php _e( 'Footer Text', 'bangkoktheme' ); ?></th>
          <td>
            <input id="bangkok_theme_options[footer]" class="regular-text" type="text" name="bangkok_theme_options[footer]" value="<?php esc_attr_e( $options['footer'] ); ?>" />
            <label class="description" for="bangkok_theme_options[footer]"><?php _e( 'ex. &copy 2011 Star Verte LLC', 'bangkoktheme' ); ?></label>
          </td>
        </tr>

      <p class="submit">
        <input type="submit" class="button-primary" value="<?php _e( 'Save Options', 'bangkoktheme' ); ?>" />
      </p>
    </form>
  </div>
  <?php
}

/**
 * Sanitize and validate input. Accepts an array, return a sanitized array.
 */
function theme_options_validate( $input ) {
  global $select_options, $radio_options;

  // Our checkbox value is either 0 or 1
  if ( ! isset( $input['option1'] ) )
    $input['option1'] = null;
  $input['option1'] = ( $input['option1'] == 1 ? 1 : 0 );

  // Say our text option must be safe text with no HTML tags
  $input['sometext'] = wp_filter_nohtml_kses( $input['sometext'] );

  // Our select option must actually be in our array of select options
  if ( ! array_key_exists( $input['selectinput'], $select_options ) )
    $input['selectinput'] = null;

  // Our radio option must actually be in our array of radio options
  if ( ! isset( $input['radioinput'] ) )
    $input['radioinput'] = null;
  if ( ! array_key_exists( $input['radioinput'], $radio_options ) )
    $input['radioinput'] = null;

  // Say our textarea option must be safe text with the allowed tags for posts
  $input['sometextarea'] = wp_filter_post_kses( $input['sometextarea'] );

  return $input;
}

// adapted from http://planetozh.com/blog/2009/05/handling-plugins-options-in-wordpress-28-with-register_setting/
