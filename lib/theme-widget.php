<?php

// Security
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
* Widget for services
* @since 12.3.0
*/
class WPTSV2_Services extends WP_Widget {

  function __construct() {
    parent::__construct(
      'wptsv2_services',
      esc_html__( 'Services', 'wptsv2' ),
      array( 'description' => esc_html__( 'Widget to display service with icon/image.', 'wptsv2' ), )
    );

    add_action('admin_enqueue_scripts', array($this, 'WPTSV2_Services_Assets'));
  }

  public function widget( $args, $instance ) {
    echo $args['before_widget'];

    if ( ! empty( $instance['image'] ) ) {
      echo '<img src="'.$instance['image'].'" class="aligncenter" title="Service" alt="'.$instance['title'] .'">';
    }

    if ( ! empty( $instance['title'] ) ) {
      echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
    }
    echo '<div class="widget-content">' . wpautop($instance['content']) . '</div>';
    echo $args['after_widget'];
  }

  public function form( $instance ) {
    $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Service', 'wptsv2' );
    $content = $instance['content'];
    $image = $instance['image'];
    ?>
    <p>
  		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'wptsv2' ); ?></label>
  		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>

    <p>
  		<label for="<?php echo esc_attr( $this->get_field_id( 'content' ) ); ?>"><?php esc_attr_e( 'Content:', 'wptsv2' ); ?></label>
  		<textarea class="widefat" rows="16" cols="20" id="<?php echo esc_attr( $this->get_field_id( 'content' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'content' ) ); ?>"><?php echo $content; ?></textarea>
		</p>

    <p>
      <label for="<?php echo $this->get_field_name( 'image' ); ?>"><?php _e( 'Image:' ); ?></label>
      <input name="<?php echo $this->get_field_name( 'image' ); ?>" id="<?php echo $this->get_field_id( 'image' ); ?>" class="widefat image_uri" type="text" size="36"  value="<?php echo esc_url( $image ); ?>" />
      <input class="upload_image_button button button-primary" type="button" value="Upload Image" />
    </p>
    <?php
  }

  public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    $instance['content'] = ( ! empty( $new_instance['content'] ) ) ? $new_instance['content'] : '';
    $instance['image'] = ( ! empty( $new_instance['image'] ) ) ? $new_instance['image'] : '';

    return $instance;
  }

  public function WPTSV2_Services_Assets() {
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    wp_enqueue_script('widget-media-upload', get_stylesheet_directory_uri() . '/js/widget-media-upload.js', array('jquery'));
    wp_enqueue_style('thickbox');
  }

}

/**
* Widget for social media
* @since 12.3.0
*/

class WPTSV2_Social extends WP_Widget {

  /**
  * Widget details
  */
  function __construct() {
    parent::__construct(
      'wptsv2_social',
      esc_html__( 'WPTS Social Media', 'wptsv2' ),
      array( 'description' => esc_html__( 'Widget to display social media.', 'wptsv2' ), )
    );
  }

  /**
  * Widget front end
  */
  public function widget( $args, $instance ) {
    echo $args['before_widget'];

    if ( ! empty( $instance['title'] ) ) {
      echo '<div class="wpts-social-title">';
      echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
      echo '</div>';
    }
    $this->wptsv2_social_front();
    echo $args['after_widget'];
  }

  /**
  * Widget backend
  */
  public function form( $instance ) {

    $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Follow Us!', 'wptsvs' );

    ?>
    <p>
  		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'wpts-affiliates' ); ?></label>
  		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
    <p><?php printf( '<em>Option for this widget can be found on <a href="%s">Genesis > WPTS Theme Settings</a> page.</em>', esc_url( home_url( '/wp-admin/admin.php?page=wpts_theme_settings' )  ) ); ?></p>
    <?php

  }

  /**
  * Widget saving/updating data
  */
  public function update( $new_instance, $old_instance ) {

    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

    return $instance;

  }

  /*
  * Widget front end data
  */
  public function wptsv2_social_front() {
    $wpts_social_fb = esc_url( genesis_get_option('wpts-fb', 'wpts-theme-settings') );
    $wpts_social_tw = esc_url( genesis_get_option('wpts-tw', 'wpts-theme-settings') );
    $wpts_social_li = esc_url( genesis_get_option('wpts-li', 'wpts-theme-settings') );
    $wpts_social_yt = esc_url( genesis_get_option('wpts-yt', 'wpts-theme-settings') );
    $wpts_social_gp = esc_url( genesis_get_option('wpts-gp', 'wpts-theme-settings') );

    if ( !empty($wpts_social_fb) || !empty($wpts_social_tw) || !empty($wpts_social_li) || !empty($wpts_social_yt) || !empty($wpts_social_gp) ) {
      echo '<div class="wpts-social-content"><ul>';

        if ( !empty($wpts_social_fb) ) :
          echo '<li><a href="'.$wpts_social_fb.'" title="Facebook" target="_blank"><span class="icon-facebook"></span></a></li>';
        endif;

        if ( !empty($wpts_social_tw) ) :
          echo '<li><a href="'.$wpts_social_tw.'" title="Twitter" target="_blank"><span class="icon-twitter"></span></a></li>';
        endif;

        if ( !empty($wpts_social_li) ) :
          echo '<li><a href="'.$wpts_social_li.'" title="Linkedin" target="_blank"><span class="icon-linkedin"></span></a></li>';
        endif;

        if ( !empty($wpts_social_yt) ) :
          echo '<li><a href="'.$wpts_social_yt.'" title="Youtube" target="_blank"><span class="icon-youtube"></span></a></li>';
        endif;

        if ( !empty($wpts_social_gp) ) :
          echo '<li><a href="'.$wpts_social_gp.'" title="Google+" target="_blank"><span class="icon-gplus"></span></a></li>';
        endif;

      echo '</ul></div>';
    }
    else {
      printf('<div class="wpts-social-content"><p><em>No data to display. Make sure you added your social media url on <a href="%s">Genesis > WPTS Theme Setting</a> page.</em></p></div>', esc_url( home_url( '/wp-admin/admin.php?page=wpts_theme_settings' )  ) );
    }
  }
}

/**
* Widget for contact
* @since 2.3.0
*/

class WPTSV2_Contact extends WP_Widget {
  /**
  * Widget details
  */
  function __construct() {
    parent::__construct(
      'wptsv2_contact',
      esc_html__( 'WPTS Contact', 'wptsv2' ),
      array( 'description' => esc_html__( 'Widget to display contact.', 'wptsv2' ), )
    );
  }

  /**
  * Widget front end
  */
  public function widget( $args, $instance ) {
    echo $args['before_widget'];

    if ( ! empty( $instance['title'] ) ) {
      echo '<div class="wpts-contact-title">';
      echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
      echo '</div>';
    }
    $this->wptsv2_contact_front();
    echo $args['after_widget'];
  }

  /**
  * Widget backend
  */
  public function form( $instance ) {

    $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Contact Us!', 'wptsv2' );

    ?>
    <p>
  		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'wpts-affiliates' ); ?></label>
  		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
    <p><?php printf( '<em>Option for this widget can be found on <a href="%s">Genesis > WPTS Theme Settings</a> page.</em>', esc_url( home_url( '/wp-admin/admin.php?page=wpts_theme_settings' )  ) ); ?></p>
    <?php

  }

  /**
  * Widget saving/updating data
  */
  public function update( $new_instance, $old_instance ) {

    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

    return $instance;

  }

  /*
  * Widget front end data
  */
  public function wptsv2_contact_front() {
    $wpts_social_phone = esc_attr( genesis_get_option('wpts-phone', 'wpts-theme-settings') );
    $wpts_social_email = esc_attr( genesis_get_option('wpts-email', 'wpts-theme-settings') );

    if ( !empty($wpts_social_phone) || !empty($wpts_social_email) ) {
      echo '<div class="wpts-contact-content">';
        if ( !empty($wpts_social_phone) ) :
          echo '<p>'.$wpts_social_phone.'</p>';
        endif;
        if ( !empty($wpts_social_email) ) :
          echo '<p>'.$wpts_social_email.'</p>';
        endif;
      echo '</div>';
    } else {
      printf('<div class="wpts-contact-content"><p><em>No data to display. Make sure you added your social media url on <a href="%s">Genesis > WPTS Theme Setting</a> page.</em></p></div>', esc_url( home_url( '/wp-admin/admin.php?page=wpts_theme_settings' )  ) );
    }
  }
}

add_action( 'widgets_init', function(){
	register_widget( 'WPTSV2_Services' );
  register_widget( 'WPTSV2_Social' );
  register_widget( 'WPTSV2_Contact' );
});
