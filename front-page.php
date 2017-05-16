<?php

// Force full width content
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

add_filter( 'body_class', 'wptsv2_front_body_class' );
function wptsv2_front_body_class( $classes ) {
	$classes[] = 'front-page';
	return $classes;
}

wp_enqueue_script( 'wptsv2-match-height', get_stylesheet_directory_uri() . '/js/jquery.matchHeight.min.js', array( 'jquery' ), CHILD_THEME_VERSION, true );
wp_add_inline_script( 'wptsv2-match-height', "jQuery(document).ready( function() { jQuery( '.front-services>.wrap>.widget').matchHeight(); });" );

wp_enqueue_style( 'slick-slider', '//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css', array(), CHILD_THEME_VERSION, true );
wp_enqueue_script( 'slick-slider', '//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js', array('jquery'), CHILD_THEME_VERSION, true );
wp_add_inline_script( 'slick-slider', "jQuery(document).ready( function() { jQuery('.project-wrapper').slick( {cssEase:'linear',slidesToShow: 2, slidesToScroll: 1, autoplay: true, autoplaySpeed: 1, speed: 18000, arrows: false, pauseOnHover: true }); jQuery('.project-wrapper-2').slick( {cssEase:'linear',slidesToShow: 2, slidesToScroll: -1, autoplay: true, autoplaySpeed: 1, speed: 18000, arrows: false, pauseOnHover: true }); });" );

remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'wptsv2_do_loop' );
function wptsv2_do_loop() {

	genesis_widget_area( 'front-marketing', array(
		'before'	=> '<div class="front-marketing widget-area"><div class="wrap">',
		'after'		=> '</div></div>',
	) );

	genesis_widget_area( 'front-newsletter', array(
		'before'	=> '<div class="front-newsletter widget-area"><div class="wrap">',
		'after'		=> '</div></div>',
	) );

	genesis_widget_area( 'front-about', array(
		'before'	=> '<div class="front-about widget-area"><div class="wrap">',
		'after'		=> '</div></div>',
	) );

	genesis_widget_area( 'front-services', array(
		'before'	=> '<div class="front-services widget-area"><div class="wrap">',
		'after'		=> '</div></div>',
	) );

	if ( is_active_sidebar('front-featured-projects') ) :
		echo '<div class="front-featured-project">';
		genesis_widget_area( 'front-featured-projects', array(
			'before'	=> '<div class="front-featured-projects widget-area"><div class="wrap">',
			'after'		=> '</div></div>',
		) );
		get_template_part( 'front','projects' );
		echo '</div>';
	endif;

	genesis_widget_area( 'front-featured-posts', array(
		'before'	=> '<div class="front-featured-posts widget-area"><div class="wrap">',
		'after'		=> '</div></div>',
	) );

}

genesis();
