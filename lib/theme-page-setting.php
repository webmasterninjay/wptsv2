<?php

// Security
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Register meta box(es).
 */
function wpts_page_setting_meta_boxes() {
    add_meta_box( 'wpts-page-setting', __( 'WPTS Page Setting', 'wptsv2' ), 'wpts_page_setting', 'page', 'normal','high' );
}
add_action( 'add_meta_boxes', 'wpts_page_setting_meta_boxes' );


function wpts_page_setting( $post ) {

  wp_nonce_field( basename( __FILE__ ), 'wpts_page_settings_meta_box_nonce' );

  $current_page_subtitle = get_post_meta( $post->ID, '_wpts_page_setting_subtitle', true );
  $current_page_fancy_title = get_post_meta( $post->ID, '_wpts_page_setting_fancy_title', true );

  if ($current_page_fancy_title == '1') {
		$current_page_fancy_title = '1';
	} else {
		$current_page_fancy_title = '0';
	}

  ?>
  <p><label for="_wpts_page_setting_subtitle"><strong><?php _e( 'Page Subtitle:', 'wptsv2' );?></strong></label><br />
  <input type="text" name="_wpts_page_setting_subtitle" value="<?php echo esc_attr($current_page_subtitle); ?>" size="50" class="widefat" /> </p>

  <p>
    <label for="_wpts_page_setting_fancy_title"><strong><?php echo __( 'Fancy Page Title?', 'wptsv2' ); ?></strong> <em>(<?php echo __( 'Text is centered with bottom border.', 'wptsv2' ); ?>)</em></label><br>
		<input type="radio" name="_wpts_page_setting_fancy_title" value="1" <?php checked( $current_page_fancy_title, '1' ); ?> /> Yes
		<input type="radio" name="_wpts_page_setting_fancy_title" value="0" <?php checked( $current_page_fancy_title, '0' ); ?> style="margin-left: 20px" /> No
  </p>
  <?php
}


function wpts_page_setting_save_data( $post_id ){
  if ( !isset( $_POST['wpts_page_settings_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['wpts_page_settings_meta_box_nonce'], basename( __FILE__ ) ) ){
		return;
	}

  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
		return;
	}

  if ( ! current_user_can( 'edit_post', $post_id ) ){
		return;
	}

  if ( isset( $_REQUEST['_wpts_page_setting_subtitle'] ) ) {
		update_post_meta( $post_id, '_wpts_page_setting_subtitle', sanitize_text_field( $_POST['_wpts_page_setting_subtitle'] ) );
	}

  if ( isset( $_REQUEST['_wpts_page_setting_fancy_title'] ) ) {
		update_post_meta( $post_id, '_wpts_page_setting_fancy_title', sanitize_text_field( $_POST['_wpts_page_setting_fancy_title'] ) );
	}
}

add_action( 'save_post', 'wpts_page_setting_save_data' );
