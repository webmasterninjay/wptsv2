<?php
// Start the engine.
include_once( get_template_directory() . '/lib/init.php' );

// Setup Theme.
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );
include_once( get_stylesheet_directory() . '/lib/theme-widget.php' );
include_once( get_stylesheet_directory() . '/lib/theme-option.php' );
include_once( get_stylesheet_directory() . '/lib/theme-page-setting.php' );

// Set Localization (do not remove).
add_action( 'after_setup_theme', 'wptsv2_localization_setup' );
function wptsv2_localization_setup(){
	load_child_theme_textdomain( 'wptsv2', get_stylesheet_directory() . '/languages' );
}

// Add the helper functions.
include_once( get_stylesheet_directory() . '/lib/helper-functions.php' );

// Add Image upload and Color select to WordPress Theme Customizer.
require_once( get_stylesheet_directory() . '/lib/customize.php' );

// Include Customizer CSS.
include_once( get_stylesheet_directory() . '/lib/output.php' );

// Add WooCommerce support.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-setup.php' );

// Add the required WooCommerce styles and Customizer CSS.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-output.php' );

// Add the Genesis Connect WooCommerce notice.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-notice.php' );

// Child theme (do not remove).
define( 'CHILD_THEME_NAME', 'WebPagesThatSell 2017' );
define( 'CHILD_THEME_URL', 'http://webpagesthatsell.com/' );
define( 'CHILD_THEME_VERSION', '2.3.0' );

// Enqueue Scripts and Styles.
add_action( 'wp_enqueue_scripts', 'wptsv2_enqueue_scripts_styles' );
function wptsv2_enqueue_scripts_styles() {

	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Cookie|Josefin+Sans:400,600,700|Josefin+Slab:400,600,700', array(), CHILD_THEME_VERSION );

	wp_enqueue_style( 'dashicons' );

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	wp_enqueue_script( 'wptsv2-responsive-menu', get_stylesheet_directory_uri() . "/js/responsive-menus{$suffix}.js", array( 'jquery' ), CHILD_THEME_VERSION, true );
	wp_localize_script(
		'wptsv2-responsive-menu',
		'genesis_responsive_menu',
		wptsv2_responsive_menu_settings()
	);

}

// Define our responsive menu settings.
function wptsv2_responsive_menu_settings() {

	$settings = array(
		'mainMenu'          => __( 'Menu', 'wptsv2' ),
		'menuIconClass'     => 'dashicons-before dashicons-menu',
		'subMenu'           => __( 'Submenu', 'wptsv2' ),
		'subMenuIconsClass' => 'dashicons-before dashicons-arrow-down-alt2',
		'menuClasses'       => array(
			'combine' => array(
				'.nav-primary',
				'.nav-header',
			),
			'others'  => array(),
		),
	);

	return $settings;

}

// Add HTML5 markup structure.
add_theme_support( 'html5', array( 'caption', 'comment-form', 'comment-list', 'gallery', 'search-form' ) );

// Add Accessibility support.
add_theme_support( 'genesis-accessibility', array( '404-page', 'drop-down-menu', 'headings', 'rems', 'search-form', 'skip-links' ) );

// Add viewport meta tag for mobile browsers.
add_theme_support( 'genesis-responsive-viewport' );

// Add support for custom header.
add_theme_support( 'custom-header', array(
	'width'           => 200,
	'height'          => 80,
	'header-selector' => '.site-title a',
	'header-text'     => false,
	'flex-height'     => true,
	'default-image'		=> get_stylesheet_directory_uri() . '/images/logo.png'
) );

// Add support for custom background.
add_theme_support( 'custom-background' );

// Add support for after entry widget.
add_theme_support( 'genesis-after-entry-widget-area' );

// Add support for 3-column footer widgets.
add_theme_support( 'genesis-footer-widgets', 3 );

// Add Image Sizes.
add_image_size( 'featured-image', 720, 400, TRUE );
add_image_size( 'project-image',500, 600, TRUE );
add_image_size( 'blog-featured-image',240, 240, TRUE );

// Rename primary and secondary navigation menus.
add_theme_support( 'genesis-menus', array( 'primary' => __( 'Header Menu', 'wptsv2' ), 'secondary' => __( 'Footer Menu', 'wptsv2' ) ) );

// Reposition the secondary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header_right', 'genesis_do_nav', 5 );
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_before_footer', 'genesis_do_subnav', 11);

// Reduce the secondary navigation menu to one level depth.
add_filter( 'wp_nav_menu_args', 'wptsv2_secondary_menu_args' );
function wptsv2_secondary_menu_args( $args ) {

	if ( 'secondary' != $args['theme_location'] ) {
		return $args;
	}

	$args['depth'] = 1;

	return $args;

}

// Modify size of the Gravatar in the author box.
add_filter( 'genesis_author_box_gravatar_size', 'wptsv2_author_box_gravatar' );
function wptsv2_author_box_gravatar( $size ) {
	return 90;
}

// Modify size of the Gravatar in the entry comments.
add_filter( 'genesis_comment_list_args', 'wptsv2_comments_gravatar' );
function wptsv2_comments_gravatar( $args ) {

	$args['avatar_size'] = 60;

	return $args;

}


// Unregister sidebar/content layout setting
genesis_unregister_layout( 'sidebar-content' );

// Unregister content/sidebar/sidebar layout setting
genesis_unregister_layout( 'content-sidebar-sidebar' );

// Unregister sidebar/sidebar/content layout setting
genesis_unregister_layout( 'sidebar-sidebar-content' );

// Unregister sidebar/content/sidebar layout setting
genesis_unregister_layout( 'sidebar-content-sidebar' );

// Unregister secondary sidebar
unregister_sidebar( 'sidebar-alt' );

// Remove the header right widget area
unregister_sidebar( 'header-right' );

function wptsv2_top() {

	$wpts_phone = esc_attr( genesis_get_option('wpts-phone', 'wpts-theme-settings') );

	?>
	<div class="before-header">
		<div class="wrap">
			<p><span class="bh-label"><?php echo __('Call Us!','wptsv2'); ?></span> <span class="bh-text"><?php if ( !empty($wpts_phone) ) { echo $wpts_phone; } else { echo __('Enter your phone number on theme setting.','wptsv2'); } ?></span></p>
		</div>
	</div>
	<?php
}
add_action('genesis_before_header','wptsv2_top');

// Register front-marketing widget area
genesis_register_widget_area(
	array(
		'id'          => 'front-marketing',
		'name'        => __( 'Front - Marketing', 'wptsv2' ),
		'description' => __( 'Display widget on front marketing.', 'wptsv2' ),
	)
);
genesis_register_widget_area(
	array(
		'id'          => 'front-newsletter',
		'name'        => __( 'Front - Newsletter', 'wptsv2' ),
		'description' => __( 'Display widget on front newsletter.', 'wptsv2' ),
	)
);
genesis_register_widget_area(
	array(
		'id'          => 'front-about',
		'name'        => __( 'Front - About', 'wptsv2' ),
		'description' => __( 'Display widget on front about.', 'wptsv2' ),
	)
);
genesis_register_widget_area(
	array(
		'id'          => 'front-services',
		'name'        => __( 'Front - Services', 'wptsv2' ),
		'description' => __( 'Display widget on front services.', 'wptsv2' ),
	)
);
genesis_register_widget_area(
	array(
		'id'          => 'front-featured-projects',
		'name'        => __( 'Front - Featured Projects', 'wptsv2' ),
		'description' => __( 'Display widget on front featured projects.', 'wptsv2' ),
	)
);

genesis_register_widget_area(
	array(
		'id'          => 'front-featured-posts',
		'name'        => __( 'Front - Featured Posts', 'wptsv2' ),
		'description' => __( 'Display widget on front featured posts.', 'wptsv2' ),
	)
);

genesis_register_widget_area(
	array(
		'id'          => 'front-affiliates',
		'name'        => __( 'Front - Affiliates', 'wptsv2' ),
		'description' => __( 'Display widget on front affiliates.', 'wptsv2' ),
	)
);

genesis_register_widget_area(
	array(
		'id'          => 'front-social-media',
		'name'        => __( 'Front - Social Media', 'wptsv2' ),
		'description' => __( 'Display widget on front social.', 'wptsv2' ),
	)
);

function wpts_before_footer() {

	genesis_widget_area( 'front-affiliates', array(
		'before'	=> '<div class="front-affiliates widget-area"><div class="wrap">',
		'after'		=> '</div></div>',
	) );

	genesis_widget_area( 'front-social-media', array(
		'before'	=> '<div class="front-social-media widget-area"><div class="wrap">',
		'after'		=> '</div></div>',
	) );
}
add_action('genesis_before_footer','wpts_before_footer', 5);

// Temp remove footer widget area to speed up codin
remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );

// div opening tag
function wpts_div_shortcode( $atts ) {

	$atts = shortcode_atts( array(
		'class' => '',
		'id'    => '',
	), $atts, 'div-shortcode' );

	$return = '<div';
	if ( !empty( $atts['class'] ) )
		$return .= ' class="'. esc_attr( $atts['class'] ) .'"';
	if ( !empty( $atts['id'] ) )
		$return .= ' id="'. esc_attr( $atts['id'] ) .'"';
	$return .= '>';
	return $return;
}
add_shortcode( 'div', 'wpts_div_shortcode' );


// div closing tag
function wpts_end_div_shortcode( $atts ) {
	return '</div>';
}
add_shortcode( 'end-div', 'wpts_end_div_shortcode' );

// clearfix
function wpts_clearfix_shortcode( $atts ) {
	return '<div class="clearfix"></div>';
}
add_shortcode( 'clearfix', 'wpts_clearfix_shortcode' );

// contact shortcode
function wpts_social_contact_details( $atts ) {

	$wpts_phone = genesis_get_option('wpts-phone', 'wpts-theme-settings');
	$wpts_email = genesis_get_option('wpts-email', 'wpts-theme-settings');

	$wpts_social_fb = esc_url( genesis_get_option('wpts-fb', 'wpts-theme-settings') );
	$wpts_social_tw = esc_url( genesis_get_option('wpts-tw', 'wpts-theme-settings') );
	$wpts_social_li = esc_url( genesis_get_option('wpts-li', 'wpts-theme-settings') );
	$wpts_social_yt = esc_url( genesis_get_option('wpts-yt', 'wpts-theme-settings') );
	$wpts_social_gp = esc_url( genesis_get_option('wpts-gp', 'wpts-theme-settings') );

	if ( !empty($wpts_phone) ) {
		$inner_phone = '<p><span class="span-label">'.__('Call Us!','wptsv2').'</span> '.$wpts_phone.'</p>';
	}

	if ( !empty($wpts_phone) ) {
		$inner_email = '<p>'.$wpts_email.'</p>';
	}

	if ( !empty($wpts_social_fb) || !empty($wpts_social_tw) || !empty($wpts_social_li) || !empty($wpts_social_yt) || !empty($wpts_social_gp) ) {
		$social_inner = '<div class="wpts-social-media"><ul>';

			if ( !empty($wpts_social_fb) ) :
				$social_inner .= '<li><a href="'.$wpts_social_fb.'" title="Facebook" target="_blank"><span class="icon-facebook"></span></a></li>';
			endif;

			if ( !empty($wpts_social_tw) ) :
				$social_inner .= '<li><a href="'.$wpts_social_tw.'" title="Twitter" target="_blank"><span class="icon-twitter"></span></a></li>';
			endif;

			if ( !empty($wpts_social_li) ) :
				$social_inner .= '<li><a href="'.$wpts_social_li.'" title="Linkedin" target="_blank"><span class="icon-linkedin"></span></a></li>';
			endif;

			if ( !empty($wpts_social_yt) ) :
				$social_inner .= '<li><a href="'.$wpts_social_yt.'" title="Youtube" target="_blank"><span class="icon-youtube"></span></a></li>';
			endif;

			if ( !empty($wpts_social_gp) ) :
				$social_inner .= '<li><a href="'.$wpts_social_gp.'" title="Google+" target="_blank"><span class="icon-gplus"></span></a></li>';
			endif;

		$social_inner .= '</ul></div>';
	}

	$inner = $inner_phone . $inner_email . $social_inner;

	$output = sprintf('<div class="wpts-company-details">%s</div>', $inner);

	return $output;

}
add_shortcode( 'wpts_company', 'wpts_social_contact_details' );
