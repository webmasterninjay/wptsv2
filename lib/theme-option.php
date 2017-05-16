<?php

// Security
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

// define theme setting field
define('wpts_theme_setting_field','wpts-theme-settings');

// start
class wpts_theme_settings extends Genesis_Admin_Boxes {

  // setup page details
  function __construct() {

    $page_id = 'wpts_theme_settings';

    $menu_ops = array(
      'submenu' => array(
        'parent_slug' => 'genesis',
        'page_title'  => 'WPTS Theme Settings',
        'menu_title'  => 'WPTS Theme Settings',
      )
    );

    $page_ops = array(
      'screen_icon' => 'options-general',
      'save_button_text'  => 'Save Settings',
      'reset_button_text' => 'Reset Settings',
      'save_notice_text'  => 'Your Settings has been saved.',
      'reset_notice_text' => 'Your Settings has been reset.'
    );

    $settings_field = 'wpts-theme-settings';

    $default_settings = array(
      'wpts-fb' => '',
      'wpts-tw' => '',
      'wpts-li' => '',
      'wpts-yt' => '',
      'wpts-gp' => '',
      'wpts-email' => '',
      'wpts-phone' => ''
    );

    $this->create( $page_id, $menu_ops, $page_ops, $settings_field, $default_settings );

    add_action( 'genesis_settings_sanitizer_init', array( $this, 'sanitization_filters' ) );
  }

  // Sanitize
  function sanitization_filters() {
    genesis_add_option_filter( 'safe_html', $this->settings_field, array(
      'wpts-fb',
      'wpts-tw',
      'wpts-li',
      'wpts-yt',
      'wpts-gp',
      'wpts-email',
      'wpts-phone'
    ) );
  }

  // help tab
  function help() {
    $screen = get_current_screen();
    $screen->add_help_tab( array(
      'id' => 'wpts-theme-help',
      'title' => 'WPTS Theme Help',
      'content' => '<p>'.__('Fill up the form and submit.','wptsv2').'</p>',
    ) );
  }

  // metabox
  function metaboxes() {
    add_meta_box('social_metabox', 'Social Media Options', array( $this, 'social_metabox' ), $this->pagehook, 'main', 'high');
    add_meta_box('theme_metabox', 'Theme Options', array( $this, 'theme_metabox' ), $this->pagehook, 'main', 'high');
  }

  //  metabox form
  function social_metabox() { ?>

		<p><?php _e( 'Facebook URL:', 'wptsv2' );?><br />
		<input type="text" name="<?php echo wpts_theme_setting_field; ?>[wpts-fb]" value="<?php echo esc_url( genesis_get_option('wpts-fb', 'wpts-theme-settings') ); ?>" size="50" class="widefat" /> </p>

		<p><?php _e( 'Twitter URL:', 'wptsv2' );?><br />
		<input type="text" name="<?php echo wpts_theme_setting_field; ?>[wpts-tw]" value="<?php echo esc_url( genesis_get_option('wpts-tw', 'wpts-theme-settings') ); ?>" size="50" class="widefat" /> </p>

    <p><?php _e( 'Linkedin URL:', 'wptsv2' );?><br />
		<input type="text" name="<?php echo wpts_theme_setting_field; ?>[wpts-li]" value="<?php echo esc_url( genesis_get_option('wpts-li', 'wpts-theme-settings') ); ?>" size="50" class="widefat" /> </p>

    <p><?php _e( 'Youtube URL:', 'wptsv2' );?><br />
		<input type="text" name="<?php echo wpts_theme_setting_field; ?>[wpts-yt]" value="<?php echo esc_url( genesis_get_option('wpts-yt', 'wpts-theme-settings') ); ?>" size="50" class="widefat" /> </p>

    <p><?php _e( 'Google+ URL:', 'wptsv2' );?><br />
		<input type="text" name="<?php echo wpts_theme_setting_field; ?>[wpts-gp]" value="<?php echo esc_url( genesis_get_option('wpts-gp', 'wpts-theme-settings') ); ?>" size="50" class="widefat" /> </p>

	<?php }

  function theme_metabox() { ?>

		<p><?php _e( 'Phone Number:', 'wptsv2' );?><br />
		<input type="text" name="<?php echo wpts_theme_setting_field; ?>[wpts-phone]" value="<?php echo esc_attr( genesis_get_option('wpts-phone', 'wpts-theme-settings') ); ?>" size="50" class="widefat" /> </p>

		<p><?php _e( 'Email Address:', 'wptsv2' );?><br />
		<input type="text" name="<?php echo wpts_theme_setting_field; ?>[wpts-email]" value="<?php echo esc_attr( genesis_get_option('wpts-email', 'wpts-theme-settings') ); ?>" size="50" class="widefat" /> </p>

	<?php }
}

// register genesis menu
function wpts_child_theme_settings() {
	global $_child_theme_settings;
	$_child_theme_settings = new wpts_theme_settings;
}
add_action( 'genesis_admin_menu', 'wpts_child_theme_settings' );
